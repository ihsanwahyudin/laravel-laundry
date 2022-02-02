<?php

namespace App\Exports;

use App\Models\Transaksi;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TransaksiExport implements FromCollection, WithStyles, WithColumnWidths
{
    private $totalData;
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $header = [['No', 'Kode Invoice', 'Nama Member', 'Tanggal Bayar', 'Batas Waktu', 'Metode Pembayaran', 'Status Transaksi', 'Status Pembayaran']];
        $data = Transaksi::with(['pembayaran', 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->latest()->get();
        $this->totalData = $data->count();
        $collection = new Collection($data->toArray());
        $body = [];
        foreach($collection as $key => $value) {
            array_push($body, [
                $key + 1, $value['kode_invoice'], $value['member']['nama'], $value['tgl_bayar'], $value['batas_waktu'], $value['metode_pembayaran'], $value['status_transaksi'], $value['status_pembayaran']
            ]);
        }
        // $footer = [['', '', '', '', 'Total', $total]];
        $array = array_merge($header, $body);

        return new Collection($array);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:H1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('A2:H'.$this->totalData + 1)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1:'.$this->totalData + 1)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
    }

    public function columnWidths(): array
    {
        return [
            'A' => 5,
            'B' => 20,
            'C' => 20,
            'D' => 20,
            'E' => 20,
            'F' => 25,
            'G' => 15,
            'H' => 20,
        ];
    }
}
