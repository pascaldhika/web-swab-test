<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\User;
use App\Models\Role;
use App\Models\RoleUser;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use DB;

class UserController extends Controller
{
    public function index(){
    	$role = Role::orderBy('name','asc')->pluck('name','id');
    	return view('user.index', compact('role'));
    }
    
    public function register(){
    	return view('auth.register');
    }

    public function getData(Datatables $datatables, Request $req) {
        $query = "
            SELECT 
                A.id, A.name, A.email, A.active, A.created_at, A.updated_at,
                GROUP_CONCAT(C.name SEPARATOR ', ') AS role 
            FROM users A
            LEFT JOIN roleuser B ON B.user_id = A.id
            LEFT JOIN roles C ON B.role_id = C.id
            GROUP BY A.id, A.name, A.email, A.active, A.created_at, A.updated_at
        ";

        $data = DB::SELECT($query);

        return Datatables::of($data)
        ->addColumn("action", function($data){
            return '<div onclick="addRole('.$data->id.')" class="btn btn-xs btn-primary no-margin-action" title="Add Role"><i class="fa fa-plus"></i></div>
            		<div onclick="editUser('.$data->id.', this)" data-name="'.$data->name.'" data-email="'.$data->email.'" data-active="'.$data->active.'" class="btn btn-xs btn-warning no-margin-action" title="Edit User"><i class="fas fa-edit"></i></div>';
            		// <div onclick="hapusUser('.$data->id.')" class="btn btn-xs btn-danger no-margin-action" title="Hapus User"><i class="fa fa-trash"></i></div>';
        })
        ->make(true);
    }
    
    public function addUser(Request $req){
        DB::beginTransaction();
        try{
            
        	$vali = Validator::make($req->all(),[
        		'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
        	]);

        	if ($vali->fails()) {
          		throw new \Exception($vali->errors());   
        	}
            
            $data = [
                'name' => $req->name,
                'email' => $req->email,
                'password' => Hash::make($req->password),
                'active' => 'Y'
            ];
      
            User::create($data);
            
            DB::commit();
            
            $message = "Data berhasil disimpan";
            $role = Role::orderBy('name','asc')->pluck('name','id');
            
            return view('user.index', compact('message','role'));
        } catch(\Exception $ex) {
            DB::rollback();
            
            $message = $ex->getMessage();
            $role = Role::orderBy('name','asc')->pluck('name','id');
            
            return view('user.index', compact('message','role'));
        }
    }

    public function addRole(Request $req){
    	DB::beginTransaction();
        try{
        	$vali = Validator::make($req->all(),[
        		'role' => 'required',
        		'id' => 'required',
        	]);

        	if ($vali->fails()) {
          		throw new \Exception($vali->errors());   
        	}

        	$id = strip_tags($req->id);
        	$user = User::find($id);
            if ($user == null){
                throw new \Exception('User not found');
            }

            $roleuser = RoleUser::where('user_id', $id)->where('role_id', strip_tags($req->role))->first();
            if ($roleuser == null){
                $roleuser = new RoleUser();
                $roleuser->role_id = strip_tags($req->role);
                $roleuser->user_id = $id;
                $roleuser->save();
            } else{
            	throw new \Exception('Role already exist');
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
                $user = User::find($id);
                if ($user == null){
                    throw new \Exception('User not found');
                }
            } else{
                $user = new User();
            }

            $active = strip_tags($req->active);
            $user->name      = strip_tags($req->name);
            $user->active    = ($active == 'Y') ? $active : 'N';
            $user->save();

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

    public function hapus(Request $req){
    	DB::beginTransaction();
        try{
        	$vali = Validator::make($req->all(),[ 
            	'id'=>'required',
        	]);

        	if ($vali->fails()) {
          		throw new \Exception($vali->errors());   
        	}

        	$id = strip_tags($req->id);
        	$user = User::find($id);
            if ($user == null){
                throw new \Exception('User not found');
            }

            $roleuser = RoleUser::where('user_id', $id);
            if ($roleuser != null){
                $roleuser->delete();
            }

            $user->delete();

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

    public function changePassword()
    {
        return view('auth.passwords.change');
    }

    public function simpanPassword(Request $req)
    {
      $rules = [
          'password_current' => 'required',
          'password'     => 'min:5|confirmed|different:password_current',
          'password_confirmation' => 'required_with:password|min:5',
      ];

      // Validate
      $this->validate($req,$rules);

      // Update
      if(Hash::check($req->password_current,$req->user()->password)) {
        $user = User::find($req->user()->id);
        $user->password = bcrypt($req->password);
        $user->save();

        return redirect()->back()->with('status',['success','Password anda telah diperbarui!']);
      }else{
        return redirect()->back()->with('status',['danger','Password salah.']);
      }
    }
}
