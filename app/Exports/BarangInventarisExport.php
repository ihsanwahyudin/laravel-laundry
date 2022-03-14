<?php

namespace App\Exports;

use App\Models\BarangInventaris;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class BarangInventarisExport implements FromCollection, WithHeadings, WithEvents
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = BarangInventaris::select('nama_barang', 'merk_barang', 'qty', 'kondisi', 'tanggal_pengadaan')->get();
        $array = [];
        foreach($data as $key => $item) {
            array_push($array, [
                'no' => $key + 1,
                'nama_barang' => $item->nama_barang,
                'merk_barang' => $item->merk_barang,
                'qty' => $item->qty,
                'kondisi' => $item->kondisi,
                'tanggal_pengadaan' => $item->tanggal_pengadaan,
            ]);
        }
        return collect($array);
    }

    public function headings(): array
    {
        return ['No', 'Nama Barang', 'Merk Barang', 'QTY', 'Kondisi', 'Tanggal Pengadaan'];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                foreach(range('A','F') as $alphabet){
                    $event->sheet->getDelegate()->getColumnDimension($alphabet)->setAutoSize(true);
                    $event->sheet->getDelegate()->getStyle($alphabet)->getAlignment()->setHorizontal('center');
                }
                $event->sheet->getDelegate()->insertNewRowBefore(1, 1);
                $event->sheet->getDelegate()->insertNewRowBefore(2, 1);
                $event->sheet->getDelegate()->setCellValue('A1', 'Data Barang Inventaris');
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->mergeCells("A1:F1");

                $cellRange = 'A1:F1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

                $event->sheet->getDelegate()->getStyle('A3:F'. $event->sheet->getDelegate()->getHighestDataRow())->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '000000'],
                        ],
                    ],
                ]);
            },
        ];
    }
}
