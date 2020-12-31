<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\RegistrasiDetail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $pasien = RegistrasiDetail::all()->count();
        $antibodi = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id')->where('type', 'Antibodi Test')->count();
        $antigen = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id')->where('type', 'Antigen Test')->count();
        $today = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id')->whereRaw("DATE(docdate) >= CURRENT_DATE")->count();

        return view('home', compact('pasien','antibodi','antigen','today'));
    }
}
