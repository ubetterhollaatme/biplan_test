<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;
use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Organization;
use App\Models\Employee;
use App\Jobs\CountOrganizationEmployees;

class EmployeesHelper
{
    public static function loadFromCSV(string $path)
    {
        SimpleExcelReader::create($path)->getRows()
            ->each(function (array $row) {
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
                }

                $employee->save();

                dispatch(new CountOrganizationEmployees);
            });
    }
}
