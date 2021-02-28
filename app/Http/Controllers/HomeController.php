<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\RegistrasiDetail;
use App\Models\Outlet;

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
    public function index(Request $req)
    {
        $outletid = $req->session()->get('outlet');
        $pasien = 0;
        $antibodi = 0;
        $antigen = 0;
        $today = 0;
        
        if ($outletid)
        {
            $pasien = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id')
                    ->where('registrasi.outlet_id', $outletid)
                    ->count();

            $antibodi = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id')
                    ->where('registrasi.outlet_id', $outletid)
                    ->where('type', 'Antibodi Test')
                    ->count();

            $antigen = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id')
                    ->where('registrasi.outlet_id', $outletid)
                    ->where('type', 'Antigen Test')
                    ->count();

            $today = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id')
                    ->where('registrasi.outlet_id', $outletid)
                    ->whereRaw("DATE(docdate) >= CURRENT_DATE")->count();
        }

        return view('home', compact('pasien','antibodi','antigen','today'));
    }

    public function getData(Request $req)
    {
        $columns = array(
            0 => 'outlet.code',
            1 => 'outlet.name',
            2 => 'outlet.active',
            3 => 'outlet.id',
        );

        $outlet = Outlet::where("active", 'Y');

        $ors = [];
        foreach (auth()->user()->akses as $key => $value) {
            if($key == 0){
                if (!in_array($value->id, $ors)) $ors[] = $value->id;
            }else{
                if (!in_array($value->id, $ors)) $ors[] = $value->id;
            }
        }

        $outlet->whereIn("id", $ors);

        $total_data = $outlet->count();
        $outlet->orderBy('name','asc');
        $filtered_data = $total_data;
        $data = $outlet->get($columns);

        return response()->json([
            'draw'              => $req->draw,
            'recordsTotal'      => $total_data,
            'recordsFiltered'   => $filtered_data,
            'data'              => $data,
        ]);
    }

    public function setOutlet(Request $req)
    {
        $columns = array(
            0 => 'outlet.code',
            1 => 'outlet.name',
            2 => 'outlet.active',
        );
        $outlet = Outlet::find($req->id);
        $data = $outlet->get($columns)->toArray();
        $req->session()->put('outlet', $outlet->id);

        return response()->json([
            'success'   => true,
            'outlet' => $data[0]['code']

        ]);
    }

    public function cekOutlet($id)
    {
        return Outlet::find($id)->code;
    }

    public function switchc(Request $req) {
        $sess = session();
        $sess->forget('outlet');
        return redirect('/home');
    }
}
