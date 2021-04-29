<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;
use Illuminate\Support\Carbon;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;

class PembayaranReport implements FromView, WithColumnFormatting
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
    
    public function columnFormats(): array
    {
        return [
            'H' => NumberFormat::FORMAT_NUMBER
        ];
    }

    public function view(): View
    {   
    	$params = [
            'tglawal' => $this->tglawal,
            'tglakhir' => $this->tglakhir,
            'name' => $this->name,
            'outletid' => $this->outletid,
            'filter' => $this->filter
        ];
        $query = "CALL rpt_get_data_pembayaran(:tglawal,:tglakhir,:name,:outletid,:filter)";

        $data = DB::SELECT($query,$params);

        return view('report.pembayaran.excel', [
            'username' => $this->username,
            'data' => $data,
            'tglawal' => Carbon::parse($this->tglawal)->isoFormat('D MMMM Y'),
            'tglakhir' => Carbon::parse($this->tglakhir)->isoFormat('D MMMM Y')
        ]);        
    }
}