<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Validator;
use DB;

class RoleController extends Controller
{
    public function index(){
    	return view('role.index');
    }

    public function getData(Datatables $datatables, Request $req) {
        $query = "
            SELECT 
            	A.id, A.name, B.name AS createdby, C.name AS updatedby,
            	A.created_at, A.updated_at
            FROM roles A
            LEFT JOIN users B ON A.createdby = B.id
            LEFT JOIN users C ON A.updatedby = C.id
        ";

        $data = DB::SELECT($query);

        return Datatables::of($data)
        ->addColumn("action", function($data){
            return '<a href="'.url('security/role/user',$data->id).'" class="btn btn-xs btn-info no-margin-action" title="Role User"><i class="fas fa-eye"></i></a>';
        })
        ->make(true);
    }

    public function getRoleUser(Request $req) {
        $params = [
            'id' => $req->id
        ];
        $query = "
            SELECT A.*, B.role_id
            FROM users A
            INNER JOIN roleuser B ON B.user_id = A.id
            WHERE B.role_id = :id
        ";

        $data = DB::SELECT($query,$params);

        return view('role.user', compact('data'));
    }

    public function simpan(Request $req){
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
                $role = Role::find($id);
                if ($role == null){
                    throw new \Exception('Role not found');
                }
            } else{
                $role = new Role();
                $role->createdby = strtoupper($req->user()->id);
            }

            $role->name      = strip_tags($req->name);
            $role->updatedby = $req->user()->id;
            $role->save();

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

    public function hapusRoleUser(Request $req){
        DB::beginTransaction();
        try{
            $vali = Validator::make($req->all(),[ 
                'user_id'=>'required',
                'role_id'=>'required',
            ]);

            if ($vali->fails()) {
                throw new \Exception($vali->errors());   
            }

            $roleuser = RoleUser::where('user_id', $req->user_id)->where('role_id', $req->role_id);
            if ($roleuser != null){
                $roleuser->delete();
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
