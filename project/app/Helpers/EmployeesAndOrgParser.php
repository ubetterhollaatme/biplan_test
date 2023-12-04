<?php

namespace App\Helpers;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Organization;
use App\Models\Employee;
use App\Jobs\CountOrganizationEmployees;

class EmployeesAndOrgParser
{
    protected const PASSED_ENCODING = 'UTF-8';

    protected string $path;

    /**
     * @param string $path
     */
    public function __construct(string $path)
    {
        $this->path = $path;
    }

    /**
     * @return void
     *
     * @throws Exception
     * @throws FileNotFoundException
     */
    public function loadFromCSV(): void
    {
        $this->checkEncoding();
        $this->parseFile();
    }

    /**
     * @return void
     *
     * @throws FileNotFoundException
     * @throws Exception
     */
    protected function checkEncoding(): void
    {
        /**
         * Не делаю проверку на существование файла,
         * т.к. в методе $fs->get() это уже происходит
         */
        if (mb_detect_encoding((new Filesystem)->get($this->path, true)) !== static::PASSED_ENCODING) {
            throw new Exception(
                'Parser passes only files encoded by ' . static::PASSED_ENCODING
            );
        }
    }

    /**
     * @return void
     *
     * @throws Exception
     */
    protected function parseFile(): void
    {
        SimpleExcelReader::create($this->path)->getRows()
            ->each(function (array $row): void {
                if (empty($row['Название организации'])
                || empty($row['email']
                || empty($row['ФИО']))) {
                    throw new Exception(
                        'Invalid row, abort.' . PHP_EOL . 'Rowdata: ' . PHP_EOL . var_export($row, true)
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
