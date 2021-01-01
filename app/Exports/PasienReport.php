<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Illuminate\Support\Carbon;

class PasienReport implements FromView
{
    public function __construct(string $tglawal, string $tglakhir, string $name)
    {
        $this->tglawal = $tglawal;
        $this->tglakhir = $tglakhir;
        $this->name = $name;
    }

    public function view(): View
    {   
    	$params = [
            'tglawal' => $this->tglawal,
            'tglakhir' => $this->tglakhir,
            'name' => $this->name
        ];
        $query = "CALL rpt_get_data_pasien(:tglawal,:tglakhir,:name)";

        $data = DB::SELECT($query,$params);

        return view('report.pasien.excel', [
            'data' => $data,
            'tglawal' => Carbon::parse($this->tglawal)->isoFormat('D MMMM Y'),
            'tglakhir' => Carbon::parse($this->tglakhir)->isoFormat('D MMMM Y')
        ]);        
    }
}