<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PasienReport;
use Excel;

class ReportController extends Controller
{
    public function indexPasien()
    {
        return view('report.pasien.index');
    }

    public function printExcelPasien(Request $req){
        
        $title = "Report Pasien";
        $namasheet    = str_slug($title);
        $namafile     = $namasheet."-".uniqid().".xls";

        $tglawal = $req->tglawal;
        $tglakhir = $req->tglakhir;
        $name = ($req->name) ? $req->name : '';

        return Excel::download(new PasienReport($tglawal,$tglakhir,$name), $namafile);
    }
}
