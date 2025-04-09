<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\Employee;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use App\Models\EmployeeAdvanceSalary;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class EmployeeImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        if (empty($row['emp_code']) || empty($row['first_name']) || empty($row['emp_type'])) {
            return null;
        }

        $date_of_joining = !empty($row['date_of_joining']) ? Date::excelToDateTimeObject($row['date_of_joining'])->format('Y-m-d') : null;
        $date_of_birth = !empty($row['date_of_birth']) ? Date::excelToDateTimeObject($row['date_of_birth'])->format('Y-m-d') : null;
        // $advance_date = Date::excelToDateTimeObject($row['advance_date']);
        // $formattedadvance_date = $advance_date->format('Y-m-d');
        $employee = Employee::create([
            'emp_code'        => $row['emp_code'] ,
            'emp_post_id'     => $row['emp_post_id'] ,
            'date_of_joining' => $date_of_joining,
            'uan_no'          => $row['uan_no'] ,
            'first_name'      => $row['first_name'] ,
            'last_name'       => $row['last_name'] ,
            'father_name'     => $row['father_name'] ,
            'date_of_birth'   => $date_of_birth,
            'address'         => $row['address'] ,
            'city'            => $row['city'] ,
            'state'           => $row['state'] ,
            'postal_code'     => $row['postal_code'] ,
            'phone_no'        => $row['phone_no'] ,
            'adhar_no'        => $row['adhar_no'] ,
            'pan_no'          => $row['pan_no'] ,
            'bank_name'       => $row['bank_name'] ,
            'branch'          => $row['branch'] ,
            'ifsc_code'       => $row['ifsc_code'] ,
            'account_no'      => $row['account_no'] ,
            'company_id'      => $row['company_id'] ,
            'income_type'     => $row['income_type'] ,
            'income'          => $row['income'] ,
            'advance'         => $row['advance'] ?? '0.00',
            'emp_leave'       => $row['emp_leave'] ?? '25',
            'emp_type'        => $row['emp_type'] ,
            'days'            => $row['days'] ?? '28',
        ]);

        // Insert into employee_advance_salaries table
        // EmployeeAdvanceSalary::create([
        //     'emp_id'          => $employee->id, // assuming FK relation
        //     'advance_date'    => $formattedadvance_date,
        //     'advance_amount'  => $row['advance_amount'],
        // ]);
        return $employee;

    }
}
