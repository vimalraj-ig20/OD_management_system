<?php

namespace App\Imports;

use App\Models\staff_data;
use Maatwebsite\Excel\Concerns\ToModel;

class Staff_import implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new staff_data([

            'staff_id'=> $row[0],
            'firstname' => $row[1],
            'lastname' => $row[2],
            'dob' => $row[3],
            'email' => $row[4],
            'phone_number' => $row[5],
        ]);
    }
}
