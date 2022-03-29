<?php

namespace App\Exports;

use App\Models\Outlet;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Events\AfterSheet;

class OutletExport implements FromCollection, WithEvents, WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Outlet::select('nama', 'alamat', 'tlp')->get();
        $array = [];
        foreach($data as $key => $item) {
            array_push($array, [
                'no' => $key + 1,
                'nama' => $item->nama,
                'alamat' => $item->alamat,
                'tlp' => $item->tlp,
            ]);
        }
        return collect($array);
    }

    public function headings(): array
    {
        return [
            'No',
            'Nama',
            'Alamat',
            'Tlp'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function(AfterSheet $event) {
                foreach(range('A','D') as $alphabet){
                    $event->sheet->getDelegate()->getColumnDimension($alphabet)->setAutoSize(true);
                    $event->sheet->getDelegate()->getStyle($alphabet)->getAlignment()->setHorizontal('center');
                }
                // set index for column
                $event->sheet->getDelegate()->insertNewRowBefore(1, 1);
                $event->sheet->getDelegate()->insertNewRowBefore(2, 1);
                $event->sheet->getDelegate()->setCellValue('A1', 'Data Outlet');
                $event->sheet->getDelegate()->getStyle('A1')->getFont()->setBold(true);
                $event->sheet->getDelegate()->mergeCells("A1:D1");

                $cellRange = 'A1:D1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

                $event->sheet->getDelegate()->getStyle('A3:D'. $event->sheet->getDelegate()->getHighestDataRow())->applyFromArray([
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
