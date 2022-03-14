<?php

namespace App\Exports;

use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class ExampleExport implements FromCollection, WithStyles, WithColumnWidths
{
    private $json;

    public function __construct($json)
    {
        $this->json = $json;
    }
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $header = [['No', 'Achievement', 'Category', 'Description', 'Requirements', 'Type', 'Reward']];
        $data = new Collection($this->json);
        $body = [];
        foreach($data as $item) {
            array_push($body, [
                $i = (!isset($i) ? 1 : ++$i), $item->achievement, $item->category, $item->description, $item->requirements, $item->type === '' ? '-' : $item->type, $item->reward
            ]);
        }
        $array = array_merge($header, $body);

        return new Collection($array);
    }

    public function styles(Worksheet $sheet)
    {
        // $sheet->getStyle('A1:F1')->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM);
        // $sheet->getStyle('A2:F'.$this->totalData + 2)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);
        // $sheet->getStyle('1')->getFont()->setBold(true);
        // $sheet->getStyle('1:'.$this->totalData + 2)->getAlignment()->setHorizontal(\PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER);
        // $sheet->mergeCells('A'.($this->totalData + 2).':E'.$this->totalData + 2);
        // $sheet->getStyle($this->totalData + 2)->getFont()->setBold(true);
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
