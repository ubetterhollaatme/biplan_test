<?php

namespace App\Helpers;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Organization;
use App\Models\Employee;
use App\Jobs\CountOrganizationEmployees;

class EmployeesHelper
{
    protected const PASSED_ENCODING = 'UTF-8';

    public static function loadFromCSV(string $path): void
    {
        $fs = new Filesystem;

        /**
         * Не делаю проверку на существование файла,
         * т.к. в методе $fs->get() это уже происходит
         */
        if (mb_detect_encoding($fs->get($path, true)) !== static::PASSED_ENCODING) {
            throw new \Exception(
                'Парсер обрабатывает только файлы в кодировке ' . static::PASSED_ENCODING
            );
        }

        SimpleExcelReader::create($path)->getRows()
            ->each(function (array $row): void {
                if (empty($row['Название организации'])
                || empty($row['email']
                || empty($row['ФИО']))) {
                    throw new \Exception(
                        'Парсер обрабатывает только валидные файлы'
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
