<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use DB;

class PaymentController extends Controller
{
    public function index()
    {
    	return view('payment.index');
    }

    public function getData(Datatables $datatables, Request $req)
    {
        $query = "
            SELECT 
            	A.id, A.name, B.name AS createdby, C.name AS updatedby,
            	A.active, A.created_at, A.updated_at
            FROM payment A
            LEFT JOIN users B ON A.createdby = B.id
            LEFT JOIN users C ON A.updatedby = C.id
        ";

        $data = DB::SELECT($query);

        return Datatables::of($data)
        ->addColumn("action", function($data){
            return '<div onclick="editPayment('.$data->id.', this)" data-name="'.$data->name.'" data-active="'.$data->active.'" class="btn btn-xs btn-warning no-margin-action" title="Edit Payment"><i class="fas fa-edit"></i></div>';
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
                $payment = Payment::find($id);
                if ($payment == null){
                    throw new \Exception('Payment not found');
                }
            } else{
                $payment = new Payment();
                $payment->createdby = strtoupper($req->user()->id);
            }

            $active = strip_tags($req->active);
            $payment->name      = strip_tags($req->name);
            $payment->active    = ($active == 'Y') ? $active : 'N';
            $payment->updatedby = $req->user()->id;
            $payment->save();

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
