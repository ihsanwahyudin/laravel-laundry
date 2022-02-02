<?php

namespace App\Http\Controllers;

use App\Services\ExportService;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    private $exportService;

    public function __construct(ExportService $exportService)
    {
        $this->exportService = $exportService;
    }

    public function exportPDF()
    {
        return $this->exportService->exportPDF();
    }

    public function exportExcel()
    {
        return $this->exportService->exportExcel();
    }
}
