<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Illuminate\Support\Carbon;

class PasienReport implements FromView
{
    public function __construct(string $tglawal, string $tglakhir, string $name, int $outletid, string $username, string $filter)
    {
        $this->outletid = $outletid;
        $this->tglawal = $tglawal;
        $this->tglakhir = $tglakhir;
        $this->name = $name;
        $this->username = $username;
        $this->filter = $filter;
    }

    public function view(): View
    {   
    	$params = [
            'tglawal' => $this->tglawal,
            'tglakhir' => $this->tglakhir,
            'name' => $this->name,
            'outletid' => $this->outletid,
            'filter' => ''
        ];
        $query = "CALL rpt_get_data_pasien(:tglawal,:tglakhir,:name,:outletid,:filter)";

        $data = DB::SELECT($query,$params);

        return view('report.pasien.excel', [
            'username' => $this->username,
            'data' => $data,
            'tglawal' => Carbon::parse($this->tglawal)->isoFormat('D MMMM Y'),
            'tglakhir' => Carbon::parse($this->tglakhir)->isoFormat('D MMMM Y')
        ]);        
    }
}