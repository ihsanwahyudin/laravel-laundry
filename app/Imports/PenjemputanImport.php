<?php

namespace App\Imports;

use App\Models\Penjemputan;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PenjemputanImport implements ToModel, WithHeadingRow
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
        return new Penjemputan([
            'transaksi_id' => $row['transaksi_id'],
            'petugas_penjemput' => $row['petugas_penjemput'],
            'status' => $row['status'],
        ]);
    }
}
