<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\JenisRapid;
use Illuminate\Support\Facades\Validator;
use DB;

class JenisRapidController extends Controller
{
    public function index()
    {
    	return view('jenisrapid.index');
    }

    public function getData(Datatables $datatables, Request $req)
    {
        $query = "
            SELECT 
            	A.id, A.code, A.name, B.name AS createdby, C.name AS updatedby,
            	A.active, A.created_at, A.updated_at
            FROM jenisrapid A
            LEFT JOIN users B ON A.createdby = B.id
            LEFT JOIN users C ON A.updatedby = C.id
        ";

        $data = DB::SELECT($query);

        return Datatables::of($data)
        ->addColumn("action", function($data){
            return '<div onclick="editJenisRapid('.$data->id.', this)" data-code="'.$data->code.'" data-name="'.$data->name.'" data-active="'.$data->active.'" class="btn btn-xs btn-warning no-margin-action" title="Edit Jenis Rapid"><i class="fas fa-edit"></i></div>';
        })
        ->make(true);
    }

    public function simpan(Request $req)
    {
    	DB::beginTransaction();
        try{
        	$vali = Validator::make($req->all(),[
        		'code' => 'required',
        		'name' => 'required',
        	]);

        	if ($vali->fails()) {
          		throw new \Exception($vali->errors());   
        	}

        	$id = strip_tags($req->id);
        	if ($id){
                $jenisrapid = JenisRapid::find($id);
                if ($jenisrapid == null){
                    throw new \Exception('Jenis Rapid not found');
                }
            } else{
                $jenisrapid = new JenisRapid();
                $jenisrapid->createdby = strtoupper($req->user()->id);
            }

            $active = strip_tags($req->active);
            $jenisrapid->code      = strip_tags($req->code);
            $jenisrapid->name      = strip_tags($req->name);
            $jenisrapid->active    = ($active == 'Y') ? $active : 'N';
            $jenisrapid->updatedby = $req->user()->id;
            $jenisrapid->save();

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
}
