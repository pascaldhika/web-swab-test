<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Outlet;
use App\Models\OutletUser;
use App\User;
use Illuminate\Support\Facades\Validator;
use DB;

class OutletController extends Controller
{
    public function index()
    {
    	return view('outlet.index');
    }

    public function getData(Datatables $datatables, Request $req)
    {
        $query = "
            SELECT 
            	A.id, A.code, A.name, B.name AS createdby, C.name AS updatedby,
            	A.active, A.created_at, A.updated_at
            FROM outlet A
            LEFT JOIN users B ON A.createdby = B.id
            LEFT JOIN users C ON A.updatedby = C.id
        ";

        $data = DB::SELECT($query);

        return Datatables::of($data)
        ->addColumn("action", function($data){
            return '<a href="'.url('master/outlet/user',$data->id).'" class="btn btn-xs btn-info no-margin-action" title="Outlet User"><i class="fas fa-eye"></i></a>';
        })
        ->make(true);
    }

    public function getOutletUser(Request $req)
    {
    	$outlet_id = $req->id;
        $params = [
            'id' => $outlet_id
        ];
        $query = "
            SELECT A.*, B.outlet_id
            FROM users A
            INNER JOIN outletuser B ON B.user_id = A.id
            INNER JOIN outlet C ON B.outlet_id = C.id
            WHERE B.outlet_id = :id
        ";

        $data = DB::SELECT($query,$params);

        $user = User::where('active', 'Y')->orderBy('name','asc')->pluck('name','id');

        return view('outlet.user', compact('data','user','outlet_id'));
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
                $outlet = Outlet::find($id);
                if ($outlet == null){
                    throw new \Exception('Outlet not found');
                }
            } else{
                $outlet = new Outlet();
                $outlet->createdby = strtoupper($req->user()->id);
            }

            $outlet->code      = strip_tags($req->code);
            $outlet->name      = strip_tags($req->name);
            $outlet->active    = 'Y';
            $outlet->updatedby = $req->user()->id;
            $outlet->save();

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

    public function addUser(Request $req)
    {
    	DB::beginTransaction();
        try{
        	$vali = Validator::make($req->all(),[
        		'outletid' => 'required',
        		'userid' => 'required',
        	]);

        	if ($vali->fails()) {
          		throw new \Exception($vali->errors());   
        	}

            $outletuser = OutletUser::where('user_id', $req->userid)->where('outlet_id', strip_tags($req->outletid))->first();
            if ($outletuser == null){
                $outletuser = new OutletUser();
                $outletuser->outlet_id = strip_tags($req->outletid);
                $outletuser->user_id = $req->userid;
                $outletuser->save();
            } else{
            	throw new \Exception('User already exist');
            }

        	DB::commit();
            return redirect()->back()->with('status',['success','Akses User berhasil ditambahkan']);	
        } catch(\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('status',['danger',$ex->getMessage()]);
        }
    }

    public function hapusOutletUser(Request $req)
    {
        DB::beginTransaction();
        try{
            $vali = Validator::make($req->all(),[ 
                'user_id'=>'required',
                'outlet_id'=>'required',
            ]);

            if ($vali->fails()) {
                throw new \Exception($vali->errors());   
            }

            $outletuser = OutletUser::where('user_id', $req->user_id)->where('outlet_id', $req->outlet_id);
            if ($outletuser != null){
                $outletuser->delete();
            }
            else
            {
            	throw new \Exception("Not found");
            }

            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data berhasil dihapus',
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
