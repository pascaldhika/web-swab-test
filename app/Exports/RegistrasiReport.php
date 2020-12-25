<?php

namespace App\Exports;

use App\Models\Registrasi;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use DB;

class RegistrasiReport implements FromView
{
    public function __construct(int $id)
    {
        $this->id = $id;
    }

    public function view(): View
    {   
    	$params = [
            'id' => $this->id
        ];
        $query = "CALL fn_get_detail_registrasi(:id)";

        $data = DB::SELECT($query,$params);

        return view('registrasi.excel', [
            'data' => $data
        ]);        
    }
}