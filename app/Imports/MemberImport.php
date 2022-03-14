<?php

namespace App\Imports;

use App\Models\Member;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMappedCells;
use Maatwebsite\Excel\Concerns\WithStartRow;

class MemberImport implements ToModel, WithHeadingRow
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function headingRow(): int
    {
        return 3;
    }


    public function model(array $row)
    {
        return new Member([
            'nama' => $row['nama'],
            'alamat' => $row['alamat'],
            'jenis_kelamin' => $row['jenis_kelamin'],
            'tlp' => $row['tlp'],
        ]);
    }
}
