<?php

namespace App\Helpers;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Organization;
use App\Models\Employee;
use App\Jobs\CountOrganizationEmployees;

class EmployeesHelper
{
    protected const PASSED_ENCODING = 'UTF-8';

    /**
     * @var string $path
     * @return void
     *
     * @throws Exception
     * @throws FileNotFoundException
     */
    public static function loadFromCSV(string $path): void
    {
        static::checkEncoding($path);
        static::parseFile($path);
    }

    /**
     * @var string $path
     * @return void
     *
     * @throws FileNotFoundException
     * @throws Exception
     */
    protected static function checkEncoding(string $path): void
    {
        /**
         * Не делаю проверку на существование файла,
         * т.к. в методе $fs->get() это уже происходит
         */
        if (mb_detect_encoding((new Filesystem)->get($path, true)) !== static::PASSED_ENCODING) {
            throw new Exception(
                'Parser passes only files encoded by ' . static::PASSED_ENCODING
            );
        }
    }

    /**
     * @var string $path
     * @return void
     *
     * @throws Exception
     */
    protected static function parseFile(string $path): void
    {
        SimpleExcelReader::create($path)->getRows()
            ->each(function (array $row): void {
                if (empty($row['Название организации'])
                || empty($row['email']
                || empty($row['ФИО']))) {
                    throw new Exception(
                        'Parser passes only valid files'
                    );

                }

                $org = Organization::firstOrCreate([
                    'name' => $row['Название организации']
                ]);
                $employee = Employee::firstOrCreate(
                    ['email' => $row['email']],
                    [
                        'name' => $row['ФИО'],
                        'org_id' => $org->id,
                    ],
                );

                if ($org->id !== $employee->org_id) {
                    $employee->update(['org_id' => $org->id]);
                    $employee->save();
                }

                CountOrganizationEmployees::dispatch();
            });
    }
}
