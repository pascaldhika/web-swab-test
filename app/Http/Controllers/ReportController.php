<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\PasienReport;
use App\Exports\PembayaranReport;
use Excel;

class ReportController extends Controller
{
    public function indexPasien()
    {
        return view('report.pasien.index');
    }

    public function printPasien(Request $req){
        
        $title = "Report Pasien";
        $namasheet    = str_slug($title);
        $namafile     = $namasheet."-".uniqid().".xls";

        $outletid = $req->session()->get('outlet');
        $tglawal = $req->tglawal;
        $tglakhir = $req->tglakhir;
        $name = ($req->name) ? $req->name : '';
        $username = $req->user()->name;

        return Excel::download(new PasienReport($tglawal,$tglakhir,$name,$outletid,$username), $namafile);
    }

    public function indexPembayaran()
    {
        return view('report.pembayaran.index');
    }

    public function printPembayaran(Request $req){
        
        $title = "Report Pembayaran";
        $namasheet    = str_slug($title);
        $namafile     = $namasheet."-".uniqid().".xls";

        $outletid = $req->session()->get('outlet');
        $tglawal = $req->tglawal;
        $tglakhir = $req->tglakhir;
        $name = ($req->name) ? $req->name : '';
        $username = $req->user()->name;

        return Excel::download(new PembayaranReport($tglawal,$tglakhir,$name,$outletid,$username), $namafile);
    }
}
