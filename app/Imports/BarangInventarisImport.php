<?php

namespace App\Imports;

use App\Models\BarangInventaris;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangInventarisImport implements ToModel, WithHeadingRow
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
        return new BarangInventaris([
            'nama_barang' => $row['nama_barang'],
            'merk_barang' => $row['merk_barang'],
            'qty' => $row['qty'],
            'kondisi' => $row['kondisi'],
            'tanggal_pengadaan' => $row['tanggal_pengadaan'],
        ]);
    }
}
