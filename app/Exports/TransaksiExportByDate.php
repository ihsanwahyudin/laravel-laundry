<?php

namespace App\Exports;

use App\Models\Transaksi;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class TransaksiExportByDate implements FromCollection, WithStyles, WithColumnWidths
{
    private $totalData, $startDate, $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $header = [['No', 'Kode Invoice', 'Nama Member', 'Tanggal Transaksi', 'Status Pembayaran', 'Pemasukan']];
        $data = Transaksi::with(['pembayaran', 'member', 'detailTransaksi' => function($q) {
            $q->with('paket')->get();
        }])->whereBetween('created_at', [$this->startDate, $this->endDate])->get();
        $this->totalData = $data->count();
        $collection = new Collection($data->toArray());
        $body = [];
        $totalPembayaran = 0;
        foreach($collection as $key => $value) {
            $totalPembayaran += $value['status_pembayaran'] === 'lunas' ? $value['pembayaran']['total_pembayaran'] : 0;
            array_push($body, [
                $key + 1, $value['kode_invoice'], $value['member']['nama'], date('d F Y', strtotime($value['created_at'])), $value['status_pembayaran'], $value['status_pembayaran'] === 'lunas' ? $value['pembayaran']['total_pembayaran'] : '0'
            ]);
        }
        $footer = [['Total Pemasukan', '', '', '', '', $totalPembayaran]];
        $array = array_merge($header, $body, $footer);

        return new Collection($array);
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        $sheet->getStyle('A2:F'.$this->totalData + 2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        $sheet->getStyle('1')->getFont()->setBold(true);
        $sheet->getStyle('1:'.$this->totalData + 2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        $sheet->mergeCells('A'.($this->totalData + 2).':E'.$this->totalData + 2);
        $sheet->getStyle($this->totalData + 2)->getFont()->setBold(true);
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
        ];
    }
}
