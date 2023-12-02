<?php

namespace App\Helpers;

use Spatie\SimpleExcel\SimpleExcelReader;
use App\Models\Organization;
use App\Models\Employee;

class EmployeesHelper
{
    public static function loadFromCSV(string $path)
    {
        SimpleExcelReader::create($path)->getRows()
            ->each(function(array $row) {
                $org = Organization::find($row['Название организации']);

                if (empty($org)) {
                    $org = new Organization(['name' => $row['Название организации']]);
                    $org->save();
                }
                
                $employee = Employee::find($row['email']);

                if (empty($employee)) {
                    $employee = new Employee([
                        'email' => $row['email'],
                        'name' => $row['ФИО'],
                        'org_id' => $org->id,
                    ]);
                }
                if ($org->id !== $employee->org_id) {
                    $employee->update(['org_id' => $org->id]);
                }

                $employee->save();
            });

            dd(Employee::all());
    }
}
