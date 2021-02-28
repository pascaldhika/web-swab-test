<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Mitra;
use App\User;
use Illuminate\Support\Facades\Validator;
use DB;

class MitraController extends Controller
{
    public function index()
    {
    	return view('mitra.index');
    }

    public function getData(Datatables $datatables, Request $req)
    {
        $query = "
            SELECT 
            	A.id, A.name, B.name AS createdby, C.name AS updatedby,
            	A.active, A.created_at, A.updated_at
            FROM mitra A
            LEFT JOIN users B ON A.createdby = B.id
            LEFT JOIN users C ON A.updatedby = C.id
        ";

        $data = DB::SELECT($query);

        return Datatables::of($data)
        ->addColumn("action", function($data){
            return '<div onclick="editMitra('.$data->id.', this)" data-name="'.$data->name.'" data-active="'.$data->active.'" class="btn btn-xs btn-warning no-margin-action" title="Edit Mitra"><i class="fas fa-edit"></i></div>';
        })
        ->make(true);
    }

    public function simpan(Request $req)
    {
    	DB::beginTransaction();
        try{
        	$vali = Validator::make($req->all(),[
        		'name' => 'required',
        	]);

        	if ($vali->fails()) {
          		throw new \Exception($vali->errors());   
        	}

        	$id = strip_tags($req->id);
        	if ($id){
                $mitra = Mitra::find($id);
                if ($mitra == null){
                    throw new \Exception('Mitra not found');
                }
            } else{
                $mitra = new Mitra();
                $mitra->createdby = strtoupper($req->user()->id);
            }

            $active = strip_tags($req->active);
            $mitra->name      = strip_tags($req->name);
            $mitra->active    = ($active == 'Y') ? $active : 'N';
            $mitra->updatedby = $req->user()->id;
            $mitra->save();

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
