<?php

namespace App\Http\Controllers;

use App\Imports\BarangInventarisImport;
use App\Imports\MemberImport;
use App\Imports\OutletImport;
use App\Imports\PaketImport;
use App\Imports\PenjemputanImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ImportController extends Controller
{
    public function importMemberExcel(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        Excel::import(new MemberImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully.');
    }

    public function importOutletExcel(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        Excel::import(new OutletImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully.');
    }

    public function importPaketExcel(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        Excel::import(new PaketImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully.');
    }

    public function importBarangInventarisExcel(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        Excel::import(new BarangInventarisImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully.');
    }

    public function importPenjemputanExcel(Request $request)
    {
        $validated = $request->validate([
            'file' => 'required|mimes:xls,xlsx'
        ]);
        Excel::import(new PenjemputanImport, $request->file('file'));

        return back()->with('success', 'Data imported successfully.');
    }
}
