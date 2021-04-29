<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Registrasi;
use App\Models\RegistrasiDetail;
use App\Models\Outlet;
use DB;
use Illuminate\Support\Facades\Gate;

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
        
        // if ($outletid)
        // {
            $antibodi = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id');
            
            if (!Gate::allows('isSuperAdmin'))
            {
                $antibodi->where('registrasi.outlet_id', $outletid);    
            }
            
            $antibodi->whereRaw("DATE(docdate) >= CURRENT_DATE");
            $antibodi->whereRaw("LEFT(docno,2) = 'AB'");
            $antibodi->where('paid', 'Y');
            $antibodi = $antibodi->count();

            $antigen = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id');
            
            if (!Gate::allows('isSuperAdmin'))
            {
                $antigen->where('registrasi.outlet_id', $outletid);
            }
            
            $antigen->whereRaw("DATE(docdate) >= CURRENT_DATE");
            $antigen->whereRaw("LEFT(docno,2) = 'AG'");
            $antigen->where('paid', 'Y');
            $antigen = $antigen->count();

            $total = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id');
            
            if (!Gate::allows('isSuperAdmin'))
            {
                $total->where('registrasi.outlet_id', $outletid);
            }
            
            $total->whereRaw("DATE(docdate) >= CURRENT_DATE");
            $total->where('paid', 'Y');
            $total = $total->count();

            $pasien = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id');
            
            if (!Gate::allows('isSuperAdmin'))
            {
                $pasien->where('registrasi.outlet_id', $outletid);
            }
            
            $pasien->whereRaw("DATE(docdate) >= CURRENT_DATE");
            $pasien = $pasien->count();
        // }

        return view('home', compact('antibodi','antigen','total','pasien'));
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
            if (!in_array($value->id, $ors)) $ors[] = $value->id;
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
        $outlet = Outlet::select(DB::raw("CONCAT(code,' - ', name) AS code"))->where('id',$id)->first();
        return $outlet->code;
    }

    public function switchc(Request $req) {
        $sess = session();
        $sess->forget('outlet');
        return redirect('/home');
    }
}
