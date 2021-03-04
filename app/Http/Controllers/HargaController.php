<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Harga;
use App\Models\HargaDetail;
use App\Models\JenisRapid;
use App\Models\Mitra;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use DB;

class HargaController extends Controller
{
    public function index()
    {
    	$jenisrapid = JenisRapid::where('active', 'Y')->orderBy('name','asc')->pluck('name','id');
        $mitra = Mitra::where('active', 'Y')->orderBy('name','asc')->pluck('name','id');
        $payment = Payment::where('active', 'Y')->orderBy('name','asc')->pluck('name','id');

    	return view('harga.index', compact('jenisrapid','mitra','payment'));
    }

    public function getData(Datatables $datatables, Request $req)
    {
        $query = "
            SELECT 
            	A.id, A.nominal, E.name AS mitra, D.name AS jenisrapid, 
                B.name AS createdby, C.name AS updatedby,
            	A.active, A.remark, A.created_at, A.updated_at, A.jenisrapidid, A.mitraid,
                (
                    SELECT GROUP_CONCAT(P.name SEPARATOR ',')
                    FROM hargadetail P
                    WHERE P.hargaid = A.id
                ) AS paymentlist
            FROM harga A
            LEFT JOIN users B ON A.createdby = B.id
            LEFT JOIN users C ON A.updatedby = C.id
            LEFT JOIN jenisrapid D ON A.jenisrapidid = D.id
            LEFT JOIN mitra E ON A.mitraid = E.id
        ";

        $data = DB::SELECT($query);

        return Datatables::of($data)
        ->addColumn("action", function($data){
            return '<div onclick="editHarga('.$data->id.', this)" data-mitraid="'.$data->mitraid.'" data-jenisrapid="'.$data->jenisrapidid.'" data-nominal="'.$data->nominal.'" data-active="'.$data->active.'" data-keterangan="'.$data->remark.'" data-paymentlist="'.$data->paymentlist.'" class="btn btn-xs btn-warning no-margin-action" title="Edit Harga"><i class="fas fa-edit"></i></div>';
        })
        ->make(true);
    }

    public function simpan(Request $req)
    {
    	DB::beginTransaction();
        try{
        	$vali = Validator::make($req->all(),[
        		'nominal' => 'required',
        		'mitraid' => 'required',
                'jenisrapid' => 'required',
                'paymentid' => 'required'
        	]);

        	if ($vali->fails()) {
          		throw new \Exception($vali->errors());   
        	}

        	$id = strip_tags($req->id);
        	if ($id){
                $harga = Harga::find($id);
                if ($harga == null){
                    throw new \Exception('Harga not found');
                }
            } else{
                $harga = new Harga();
                $harga->createdby = strtoupper($req->user()->id);
            }

            $active = strip_tags($req->active);
            $harga->mitraid   = strip_tags($req->mitraid);
            $harga->jenisrapidid   = strip_tags($req->jenisrapid);
            $harga->nominal   = strip_tags($req->nominal);
            $harga->active    = ($active == 'Y') ? $active : 'N';
            $harga->remark    = strip_tags($req->keterangan);
            $harga->updatedby = $req->user()->id;
            $harga->save();

            // Delete Insert
            if ($id)
            {
                $hargaDetail = HargaDetail::where('hargaid', $id);
                if ($hargaDetail != null)
                {
                    $hargaDetail->delete();
                }
            }
            
            foreach ($req->paymentid as $value)
            {
                $hargaDetail = new HargaDetail();
                $hargaDetail->hargaid   = $harga->id;
                $hargaDetail->name      = $value;
                $hargaDetail->createdby = strtoupper($req->user()->id);
                $hargaDetail->updatedby = $req->user()->id;
                $hargaDetail->save();
            }

        	DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan',
            ]);	
        } catch(\Exception $ex) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    public function getAmountByMitra(Request $req)
    {
        $harga = [];
        if ($req->jenisrapidid && $req->mitraid)
        {
            $jenisrapid = JenisRapid::where('name', $req->jenisrapidid)->first();
            $harga = Harga::where('active', 'Y')
                    ->where('jenisrapidid', $jenisrapid->id)
                    ->where('mitraid', $req->mitraid)
                    ->orderBy('nominal','asc')->pluck('nominal','id');
        }

        return json_encode($harga);
    }
}
