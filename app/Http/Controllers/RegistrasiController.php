<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Registrasi;
use App\Models\RegistrasiDetail;
use App\Models\RegistrasiDetailPayment;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Exports\RegistrasiReport;
use Excel;
use PDF;
use Illuminate\Support\Facades\Gate;

class RegistrasiController extends Controller
{
    public function index()
    {
        return view('registrasi.index');
    }

    public function getData(Datatables $datatables, Request $req) {
        $query = "
            SELECT
                A.id, A.docno, DATE_FORMAT(A.docdate, '%d %M %Y') AS docdate,
                A.type, A.print, A.print_at, GROUP_CONCAT(B.name SEPARATOR ', ') AS pasien 
            FROM registrasi A
            INNER JOIN registrasidetail B ON B.registrasiid = A.id
            GROUP BY A.id, A.docno, A.docdate, A.type, A.print, A.print_at
            ORDER BY A.docno
        ";

        $data = DB::SELECT($query);

        return Datatables::of($data)
        ->addColumn("action", function($data){
            $params = [
                'id' => $data->id
            ];
            $queryPayment = "
                SELECT
                    COUNT(*) AS total
                FROM registrasidetail B 
                WHERE B.registrasiid = :id
                AND B.paymentid IS NULL
            ";

            $dataNotPayment = DB::SELECT($queryPayment, $params);
            $action = "";
            if ($dataNotPayment[0]->total > 0){
                $action = '<div onclick="detail('.$data->id.')" class="btn btn-xs btn-info no-margin-action" title="Detail"><i class="fa fa-eye"></i></div>';
            }

            if (Gate::allows('isNakes')) {
                $action .= '<div onclick="ubahStatus('.$data->id.', this)" data-type="'.$data->type.'" data-notpayment="'.$dataNotPayment[0]->total.'" class="btn btn-xs btn-warning no-margin-action" title="Ubah Status"><i class="fas fa-edit"></i></div>';
            }

            return $action;
        })
        ->make(true);
    }

    public function formDetail(Request $req)
    {
        $id = $req->id;
        return view('registrasi.detail', compact('id'));
    }

    public function getDetail(Request $req) {
        $params = [
            'id' => $req->id
        ];
        $query = "
            SELECT 
                B.docno, B.type, A.*,
                DATE_FORMAT(B.docdate, '%d %M %Y') AS newdocdate
            FROM registrasidetail A
            INNER JOIN registrasi B ON A.registrasiid = B.id
            WHERE B.id = :id
            AND A.paymentid IS NULL
        ";

        $data = DB::SELECT($query,$params);

        return response()->json([
            'success' => true,
            'data'    => $data
        ]);
    }

    public function form()
    {
        return view('registrasi.form');
    }

    public function simpan(Request $req){
    	DB::beginTransaction();
        try{
        	$type = $req->input('type');
        	$jumlah = (int) $req->input('jumlah');
        	$rules = [];
        	
        	for ($i=1; $i <= $jumlah ; $i++) {
        		$rules['name' . $i] = 'required';
        		$rules['address' . $i] = 'required';
                $rules['identityno' . $i] = 'required';
                $rules['birthplace' . $i] = 'required';
                $rules['birthdate' . $i] = 'required';
                $rules['gender' . $i] = 'required';
                $rules['job' . $i] = 'required';
                $rules['country' . $i] = 'required';
        	}
        	
        	$vali = Validator::make($req->all(),$rules);

        	if ($vali->fails()) {
          		throw new \Exception($vali->errors());   
        	}

            $month = date('m');
            $romawi =  DB::select("CALL f_gen_romawi(:angka)", ['angka' => (int) $month]);
        	$autoNum = DB::select("CALL f_gen_autonum(:prefix,:datatype,:romawi)", [
                'prefix' => 'SWAB',
                'datatype' => 'SwabTest',
                'romawi' => $romawi[0]->romawi
            ]);
            $docNo = $autoNum[0]->docno;

            $registrasi = new Registrasi();
            $registrasi->docno     = $docNo;
            $registrasi->docdate   = date('Y-m-d H:i:s');
            $registrasi->type      = strip_tags($req->input('type'));
            $registrasi->print     = 0;
            $registrasi->createdby = -1;
            $registrasi->updatedby = -1;
            $registrasi->save();

        	for ($i=1; $i <= $jumlah ; $i++) {
                $gender = strip_tags($req->input('gender'.$i));
                if ($gender == 'Laki-laki'){
                    $name = 'Tn. ' . strip_tags($req->input('name'.$i));
                } else{
                    $name = 'Ny. ' . strip_tags($req->input('name'.$i));
                }

                $registrasiDetail = new RegistrasiDetail();
                $registrasiDetail->registrasiid = $registrasi->id;
                $registrasiDetail->name      = $name;
                $registrasiDetail->address   = strip_tags($req->input('address'.$i));
                $registrasiDetail->identityno= strip_tags($req->input('identityno'.$i));
                $registrasiDetail->birthplace= strip_tags($req->input('birthplace'.$i));
                $registrasiDetail->birthdate = strip_tags($req->input('birthdate'.$i));
                $registrasiDetail->gender    = $gender;
                $registrasiDetail->amount    = 0;
                $registrasiDetail->job       = strip_tags($req->input('job'.$i));
                $registrasiDetail->country   = strip_tags($req->input('country'.$i));
                $registrasiDetail->createdby = -1;
	            $registrasiDetail->updatedby = -1;
	            $registrasiDetail->save();
            }

        	DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Data berhasil disimpan dengan No. Booking : ' . $docNo,
                'id'      => $registrasi->id
            ]);	
        } catch(\Exception $ex) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    public function simpanStatus(Request $req){
        DB::beginTransaction();
        try{
            foreach ($req->data as $value) {
                $registrasiDetail = RegistrasiDetail::find($value['id']);
                if ($registrasiDetail == null){
                    throw new \Exception('Registrasi detail not found');
                }

                $registrasiDetail->status = $value['status'];
                $registrasiDetail->status_at = date('Y-m-d H:i:s');
                $registrasiDetail->updatedby = $req->user()->id;
                $registrasiDetail->save();
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

    public function simpanPayment(Request $req){
        DB::beginTransaction();
        try{
            $jumlah = (int) $req->input('jumlah');
            $rules = [];
            
            for ($i=1; $i <= $jumlah ; $i++) {
                $rules['id' . $i] = 'required';
                $rules['branch' . $i] = 'required';
                $rules['paid' . $i] = 'required';
                $rules['payment' . $i] = 'required';
                $rules['amount' . $i] = 'required';
            }
            
            $vali = Validator::make($req->all(),$rules);

            if ($vali->fails()) {
                throw new \Exception($vali->errors());   
            }

            for ($i=1; $i <= $jumlah ; $i++) {
                $gender = strip_tags($req->input('gender'.$i));
                if ($gender == 'Laki-laki'){
                    $name = 'Tn. ' . strip_tags($req->input('name'.$i));
                } else{
                    $name = 'Ny. ' . strip_tags($req->input('name'.$i));
                }

                $id = strip_tags($req->input('id'.$i));
                $registrasiDetail = RegistrasiDetail::find($id);
                if ($registrasiDetail == null){
                    throw new \Exception('Registrasi Detail with ID '.$id.' not found');
                }

                $firstPayment = strip_tags($req->input('payment'.$i));

                $registrasiDetail->branch = strip_tags($req->input('branch'.$i));
                $registrasiDetail->paid = (strip_tags($req->input('paid'.$i)) == 'Paid') ? 'Y' : 'N';
                $registrasiDetail->paid_at = date('Y-m-d H:i:s');
                $registrasiDetail->paymentid = $firstPayment;
                $registrasiDetail->amount = strip_tags($req->input('amount'.$i));
                $registrasiDetail->updatedby = $req->user()->id;
                $registrasiDetail->save();

                $secondPayment = strip_tags($req->input('secondpayment'.$i));
                $thirdPayment = strip_tags($req->input('thirdpayment'.$i));
                $fourPayment = strip_tags($req->input('fourpayment'.$i));

                if ($secondPayment != 'undefined'){
                    $registrasiDetailPayment = new RegistrasiDetailPayment();
                    $registrasiDetailPayment->paymentid = $firstPayment;
                    $registrasiDetailPayment->name = $secondPayment;
                    $registrasiDetailPayment->createdby = $req->user()->id;
                    $registrasiDetailPayment->updatedby = $req->user()->id;
                    $registrasiDetailPayment->save();    
                }

                if ($thirdPayment != 'undefined'){
                    $registrasiDetailPayment = new RegistrasiDetailPayment();
                    $registrasiDetailPayment->paymentid = $firstPayment;
                    $registrasiDetailPayment->name = $thirdPayment;
                    $registrasiDetailPayment->createdby = $req->user()->id;
                    $registrasiDetailPayment->updatedby = $req->user()->id;
                    $registrasiDetailPayment->save();    
                }

                if ($fourPayment != 'undefined'){
                    $registrasiDetailPayment = new RegistrasiDetailPayment();
                    $registrasiDetailPayment->paymentid = $firstPayment;
                    $registrasiDetailPayment->name = $fourPayment;
                    $registrasiDetailPayment->createdby = $req->user()->id;
                    $registrasiDetailPayment->updatedby = $req->user()->id;
                    $registrasiDetailPayment->save();    
                }
                
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
                'message' => $ex->getMessage().$ex->getLine(),
            ]);
        }
    }

    public function printExcel(Request $req){
        
        $title = "SWAB Visit";
        $namasheet    = str_slug($title);
        $namafile     = $namasheet."-".uniqid().".xls";

        $id = strip_tags($req->id);
        $registrasi = Registrasi::find($id);
        $registrasi->print     = $registrasi->print + 1;
        $registrasi->updatedby = $req->user()->id;
        $registrasi->save();

        return Excel::download(new RegistrasiReport($id), $namafile);
    }

    public function printPdf(Request $req){

        $title = "SWAB Visit";
        $namasheet    = str_slug($title);
        $namafile     = $namasheet."-".uniqid().".pdf";
        
        $params = [
            'id' => $req->id
        ];
        $query = "CALL fn_get_detail_registrasi(:id)";

        $data = DB::SELECT($query,$params);

        $id = strip_tags($req->id);
        $registrasi = Registrasi::find($id);
        $registrasi->print     = $registrasi->print + 1;
        $registrasi->updatedby = $req->user()->id;
        $registrasi->save();

        $pdf = PDF::loadview('registrasi.pdf',['data'=>$data])->setPaper('a4', 'portrait');
        return $pdf->download($namafile);
    }

    public function printBook(Request $req){
        $params = [
            'id' => $req->id
        ];
        $query = "CALL fn_get_detail_registrasi(:id)";

        $data = DB::SELECT($query,$params);

        $pdf = PDF::loadview('registrasi.book',['data'=>$data])->setPaper('a5', 'landscape');
        return $pdf->stream($data[0]->docno.".pdf");
    }
}
