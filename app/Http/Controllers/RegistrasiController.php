<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\Datatables\Datatables;
use App\Models\Registrasi;
use App\Models\RegistrasiDetail;
use App\Models\RegistrasiDetailPayment;
use App\Models\Payment;
use App\Models\Outlet;
use App\Models\Dokter;
use App\Models\JenisRapid;
use App\Models\Harga;
use App\Models\Mitra;
use Illuminate\Support\Facades\Validator;
use DB;
use App\Exports\RegistrasiReport;
use Excel;
use PDF;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Carbon;
use \Illuminate\Filesystem\Filesystem;
use File;
use App\Mail\TaishanalkesEmail;
use Illuminate\Support\Facades\Mail;
use Response;

class RegistrasiController extends Controller
{
    public function index(Request $req)
    {
        $outletid = $req->session()->get('outlet');
        $today = RegistrasiDetail::leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id')
                ->where('registrasi.outlet_id', $outletid)
                ->whereRaw("DATE(docdate) >= CURRENT_DATE")->count();

        $dokter = Dokter::where('active', 'Y')->orderBy('name','asc')->pluck('name','id');

        return view('registrasi.index', compact('today','dokter'));
    }

    public function getData(Datatables $datatables, Request $req) {
        $outletid = $req->session()->get('outlet');
        $search = $req->docno;
        $tglawal = Carbon::parse($req->tglawal)->format('Y-m-d');
        $tglakhir = Carbon::parse($req->tglakhir)->format('Y-m-d');

        $filter = "";
        if ($search){
            $filter = "AND A.docno LIKE '%".$search."%'";
        }

        $params = [
            'outletid' => $outletid,
            'tglawal' => $tglawal,
            'tglakhir' => $tglakhir
        ];
        $query = "
            SELECT
                A.id, A.docno, (SELECT sf_formatTanggal(A.docdate)) AS docdate,
                A.type, A.print, (SELECT sf_formatTanggal(A.print_at)) AS print_at, U.name AS paid_by,
                GROUP_CONCAT(B.paid SEPARATOR ',') AS paymentstatus,
                (SELECT sf_formatTanggal(A.status_at)) AS status_at, S.name AS status_by,
                GROUP_CONCAT(DISTINCT B.name SEPARATOR ',') AS pasien,
                (
                    SELECT COUNT(*) FROM registrasidetail WHERE registrasiid = A.id
                ) AS jumlah,
                GROUP_CONCAT(CONCAT(B.status, ' ', IFNULL(B.detailstatus, '')) SEPARATOR '|') AS hasil,
                (
                    SELECT COUNT(*) FROM registrasidetailpayment C WHERE C.registrasiid = A.id
                ) AS paid
            FROM registrasi A
            INNER JOIN registrasidetail B ON B.registrasiid = A.id
            LEFT JOIN users U ON A.paid_by = U.id
            LEFT JOIN users S ON A.status_by = S.id
            WHERE A.outlet_id = :outletid
            AND DATE(A.docdate) BETWEEN :tglawal AND :tglakhir
            ".$filter."
            GROUP BY A.id, A.docno, A.docdate, A.type, A.print, A.print_at, U.name, A.status_at, S.name
            ORDER BY A.docdate DESC 
        ";

        $data = DB::SELECT($query,$params);

        return Datatables::of($data)
        ->addColumn("action", function($data){
            $action = "";
            if ($data->paid <= 0){
                if (Gate::allows('isKasir') || Gate::allows('isSuperAdmin')) {
                    $action .= '<div onclick="detail('.$data->id.')" class="btn btn-xs btn-info no-margin-action" title="Detail" style="margin-right:5px;"><i class="fa fa-eye"></i></div>';
                }
            } else{
                if (Gate::allows('isNakes') || Gate::allows('isSuperAdmin')) {
                    $action .= '<div onclick="ubahStatus('.$data->id.', this)" data-type="'.$data->type.'" data-paid="'.$data->paid.'" data-status_at="'.$data->status_at.'" class="btn btn-xs btn-success no-margin-action" title="Ubah Status / Hasil Pemeriksaan Lab" style="margin-right:5px;"><i class="fas fa-check"></i></div>';
                }

                if (Gate::allows('isAdmin') || Gate::allows('isSuperAdmin')) {
                    $action .= '<div onclick="print('.$data->id.')" class="btn btn-xs btn-danger no-margin-action" title="Print" style="margin-right:5px;"><i class="fas fa-print"></i></div>';
                }

                if (Gate::allows('isKasir') || Gate::allows('isSuperAdmin')) {
                    $action .= '<div onclick="editPayment('.$data->id.')" class="btn btn-xs btn-primary no-margin-action" title="Edit Pembayaran" style="margin-right:5px;"><i class="far fa-credit-card"></i></div>';
                }
            }

            if (Gate::allows('isAdmin') || Gate::allows('isSuperAdmin')) {
                $action .= '<div onclick="edit('.$data->id.')" class="btn btn-xs btn-secondary no-margin-action" title="Edit Data Pasien" style="margin-right:5px;"><i class="fa fa-edit"></i></div>';
                if ($data->status_at)
                {
                    $action .= '<div onclick="email('.$data->id.')" class="btn btn-xs btn-info no-margin-action" title="Email" style="margin-right:5px;"><i class="fa fa-mail-bulk"></i></div>';   
                }
            }

            return $action;
        })
        ->make(true);
    }

    public function formEdit(Request $req)
    {
        $id = $req->id;
        return view('registrasi.edit', compact('id'));
    }

    public function formDetail(Request $req)
    {
        $id = $req->id;
        $registrasi = Registrasi::find($id);

        $mitra = Mitra::where('active', 'Y')->orderBy('name','asc')->pluck('name','id');

        return view('registrasi.detail', compact('id','mitra'));
    }

    public function getDetail(Request $req) {
        $filterEdit = "";
        if (isset($req->tipe)){
            $filterEdit = "AND A.paid != 'C'";
        }

        $params = [
            'id' => $req->id
        ];
        $query = "
            SELECT 
                B.docno, B.type, B.status_at, A.*,
                (SELECT sf_formatTanggal(B.docdate)) AS newdocdate,
                (
                    SELECT GROUP_CONCAT(C.name SEPARATOR ',')
                    FROM registrasidetailpayment C
                    WHERE C.registrasidetailid = A.id
                ) AS paymentlist
            FROM registrasidetail A
            INNER JOIN registrasi B ON A.registrasiid = B.id
            WHERE B.id = :id
            ".$filterEdit."
        ";

        $data = DB::SELECT($query,$params);

        $node = [];
        foreach ($data as $key => $value) {
            $node[$key] = $value;

            $base64 = '';
            $image = $value->image;
            if ($image)
            {
                $path = storage_path('app/uploads/').$image;

                if(File::exists($path) && $image)
                {
                    $filetype = pathinfo($path,PATHINFO_EXTENSION);
                    $val = file_get_contents($path);
                    $base64 = 'data:image/'.$filetype.';base64,'.base64_encode($val);

                    $node[$key]->image = $base64;
                }
            }
        }

        return response()->json([
            'success' => true,
            'data'    => $node
        ]);
    }

    public function form()
    {
        $outlet = Outlet::where('active', 'Y')->orderBy('name','asc')->pluck('name','id');
        $jenisrapid = JenisRapid::where('active', 'Y')->orderBy('name','asc')->pluck('name','id');

        return view('registrasi.form', compact('outlet','jenisrapid'));
    }

    public function cekNoIdentitas(Request $req)
    {
        try
        {
            $columns = array(
                0 => 'registrasi.outlet_id',
                1 => 'registrasidetail.name',
                2 => 'registrasidetail.address',
                3 => 'registrasidetail.identityno',
                4 => 'registrasidetail.birthplace',
                5 => 'registrasidetail.birthdate',
                6 => 'registrasidetail.gender',
                7 => 'registrasidetail.job',
                8 => 'registrasidetail.country',
                9 => 'registrasidetail.email',
                10 => 'registrasidetail.image',
                11 => 'registrasidetail.id',
            );

            $registrasi = RegistrasiDetail::selectRaw(collect($columns)->implode(', '))
                        ->leftJoin('registrasi', 'registrasidetail.registrasiid', '=', 'registrasi.id')
                        ->where('identityno', $req->identityno)
                        ->orderBy('registrasidetail.updated_at', 'desc')->first();

            $base64 = '';
            if ($registrasi)
            {
                $image = $registrasi->image;
                $path = storage_path('app/uploads/').$image;

                if(File::exists($path) && $image)
                {
                    $filetype = pathinfo($path,PATHINFO_EXTENSION);
                    $val = file_get_contents($path);
                    $base64 = 'data:image/'.$filetype.';base64,'.base64_encode($val);
                }
            }
            
            return response()->json([
                'success' => true,
                'message' => 'No error detected',
                'data'    => $registrasi,
                'image'   => $base64
            ]); 
        }
        catch(\Exception $ex) 
        {
            return response()->json([
                'success' => false,
                'message' => $ex->getMessage(),
            ]);
        }
    }

    public function storeImage($file,$identityno)
    {
        // menyimpan data file yang diupload ke variabel $file
        $nama_file = uniqid()."_".$identityno.".png";

        // isi dengan nama folder tempat kemana file diupload
        $tujuan_upload = storage_path().'/app/uploads';
        $file->move($tujuan_upload,$nama_file);

        return $nama_file;
    }

    public function simpan(Request $req){
        $this->simpleLogger($this, __FUNCTION__, $req->all(), __LINE__);
    	DB::beginTransaction();
        try{
        	$type = $req->input('type');
            $outlet = strip_tags($req->input('outlet'));
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
                $rules['email' . $i] = 'required|email';
                $rules['image' . $i] = 'required|mimes:jpeg,png,jpg|max:3048';
        	}
        	
        	$vali = Validator::make($req->all(),$rules);

        	if ($vali->fails()) {
                $err = [];
                $errors = $vali->messages()->get('*');
                foreach ($errors as $key => $value) {
                    $err[] = $value[0];
                }
          		throw new \Exception(json_encode($err));   
        	}

            $month = date('m');
            $type = strip_tags($req->input('type'));
            $prefix = JenisRapid::where('active', 'Y')->where('name', $type)->first();
            if ($prefix == null)
            {
                throw new \Exception('Code untuk jenis: '.$type.' tidak ditemukan'); 
            }
            $romawi =  DB::select("CALL f_gen_romawi(:angka)", ['angka' => (int) $month]);
        	$autoNum = DB::select("CALL f_gen_autonum(:prefix,:datatype,:romawi)", [
                'prefix' => $prefix->code,
                'datatype' => $type,
                'romawi' => $romawi[0]->romawi
            ]);
            $docNo = $autoNum[0]->docno;

            $registrasi = new Registrasi();
            $registrasi->outlet_id = $outlet;
            $registrasi->docno     = $docNo;
            $registrasi->docdate   = date('Y-m-d H:i:s');
            $registrasi->type      = $type;
            $registrasi->print     = 0;
            $registrasi->createdby = -1;
            $registrasi->updatedby = -1;
            $registrasi->save();

        	for ($i=1; $i <= $jumlah ; $i++) {
        	    $identityno = strip_tags($req->input('identityno'.$i));
                $registrasiDetail = new RegistrasiDetail();
                $registrasiDetail->registrasiid = $registrasi->id;
                $registrasiDetail->name      = strip_tags($req->input('name'.$i));
                $registrasiDetail->address   = strip_tags($req->input('address'.$i));
                $registrasiDetail->identityno= $identityno;
                $registrasiDetail->birthplace= strip_tags($req->input('birthplace'.$i));
                $registrasiDetail->birthdate = strip_tags($req->input('birthdate'.$i));
                $registrasiDetail->gender    = strip_tags($req->input('gender'.$i));
                $registrasiDetail->amount    = 0;
                $registrasiDetail->paid      = 'N';
                $registrasiDetail->job       = strip_tags($req->input('job'.$i));
                $registrasiDetail->country   = strip_tags($req->input('country'.$i));
                $registrasiDetail->email     = strip_tags($req->input('email'.$i));
                $registrasiDetail->image     = $this->storeImage($req->file('image'.$i),$identityno);
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
        $this->simpleLogger($this, __FUNCTION__, $req->all(), __LINE__);
        DB::beginTransaction();
        try{
            $jumlah = (int) $req->input('jumlah');
            $rules = [];
            
            for ($i=1; $i <= $jumlah ; $i++) {
                $rules['id' . $i] = 'required';
                $rules['doctor' . $i] = 'required';
                $rules['status' . $i] = 'required';
                
                if ($req->input('status'.$i) == "Reaktif"){
                    $rules['jenisreaktif' . $i] = 'required';
                }
            }
            
            $vali = Validator::make($req->all(),$rules);

            if ($vali->fails()) {
                $err = [];
                $errors = $vali->messages()->get('*');
                foreach ($errors as $key => $value) {
                    $err[] = $value[0];
                }
                throw new \Exception(json_encode($err));   
            }

            for ($i=1; $i <= $jumlah ; $i++) {
                $id = strip_tags($req->input('id'.$i));
                $registrasiDetail = RegistrasiDetail::find($id);
                if ($registrasiDetail == null){
                    throw new \Exception('Registrasi detail not found');
                }

                $registrasi = Registrasi::find($registrasiDetail->registrasiid);
                if ($registrasi->status_at == null)
                {
                    $registrasi->status_at = date('Y-m-d H:i:s');
                    $registrasi->status_by = $req->user()->id;
                    $registrasi->save();   
                }

                $registrasiDetail->doctor = strip_tags($req->input('doctor'.$i));
                $registrasiDetail->status = strip_tags($req->input('status'.$i));
                
                if (strip_tags($req->input('status'.$i)) != 'Non Reaktif'){
                    $detailStatus = strip_tags($req->input('jenisreaktif'.$i));
                    if ($detailStatus != 'undefined'){
                        $registrasiDetail->detailstatus = $detailStatus;
                    }   
                } else{
                    $registrasiDetail->detailstatus = NULL;
                }
                
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
        $this->simpleLogger($this, __FUNCTION__, $req->all(), __LINE__);
        DB::beginTransaction();
        try{
            $jumlah = (int) $req->input('jumlah');
            $rules = [];
            
            for ($i=1; $i <= $jumlah ; $i++) {
                $rules['id' . $i] = 'required';
                // $rules['branch' . $i] = 'required';
                $rules['paid' . $i] = 'required';
                
                if ($req->input('paid'.$i) == "Paid"){
                    $rules['mitra' . $i] = 'required|not_in:Pilih Mitra';
                    $rules['amount' . $i] = 'required|numeric|gt:0|not_in:Pilih Amount';
                    $rules['payment' . $i] = 'required|not_in:Pilih Payment Method';
                }
            }
            
            $vali = Validator::make($req->all(),$rules);

            if ($vali->fails()) {
                $err = [];
                $errors = $vali->messages()->get('*');
                foreach ($errors as $key => $value) {
                    $err[] = $value[0];
                }
                throw new \Exception(json_encode($err));   
            }

            for ($i=1; $i <= $jumlah ; $i++) {
                $id = strip_tags($req->input('id'.$i));
                $registrasiDetail = RegistrasiDetail::find($id);
                if ($registrasiDetail == null){
                    throw new \Exception('Registrasi Detail with ID '.$id.' not found');
                }

                $registrasi = Registrasi::find($registrasiDetail->registrasiid);
                $registrasi->paid_at = date('Y-m-d H:i:s');
                $registrasi->paid_by = $req->user()->id;
                $registrasi->save();

                // $registrasiDetail->branch = strip_tags($req->input('branch'.$i));

                $paid = "N";
                if (strip_tags($req->input('paid'.$i)) == 'Paid'){
                    $paid = "Y";
                    $registrasiDetail->amount = strip_tags($req->input('amount'.$i));
                } else{
                    $paid = "C";
                }

                $registrasiDetail->paid = $paid;
                $registrasiDetail->updatedby = $req->user()->id;
                $registrasiDetail->save();

                $mitra = strip_tags($req->input('mitra'.$i));
                $paymentMethod = strip_tags($req->input('payment'.$i));
                // $secondPayment = strip_tags($req->input('secondpayment'.$i));
                // $thirdPayment = strip_tags($req->input('thirdpayment'.$i));
                // $fourPayment = strip_tags($req->input('fourpayment'.$i));

                // Delete Insert
                $checkRegistrasiDetailPayment = RegistrasiDetailPayment::where('registrasidetailid', $id);
                if ($checkRegistrasiDetailPayment != null){
                    $checkRegistrasiDetailPayment->delete();
                }

                if ($mitra != 'undefined' && $mitra != '' && $mitra != null){
                    $registrasiDetailPayment = new RegistrasiDetailPayment();
                    $registrasiDetailPayment->registrasiid = $registrasiDetail->registrasiid;
                    $registrasiDetailPayment->registrasidetailid = $id;
                    $registrasiDetailPayment->name = $mitra;
                    $registrasiDetailPayment->createdby = $req->user()->id;
                    $registrasiDetailPayment->updatedby = $req->user()->id;
                    $registrasiDetailPayment->save();    
                }

                if ($paymentMethod != 'undefined' && $paymentMethod != '' && $paymentMethod != null){
                    $registrasiDetailPayment = new RegistrasiDetailPayment();
                    $registrasiDetailPayment->registrasiid = $registrasiDetail->registrasiid;
                    $registrasiDetailPayment->registrasidetailid = $id;
                    $registrasiDetailPayment->name = $paymentMethod;
                    $registrasiDetailPayment->createdby = $req->user()->id;
                    $registrasiDetailPayment->updatedby = $req->user()->id;
                    $registrasiDetailPayment->save();    
                }

                // if ($thirdPayment != 'undefined' && $thirdPayment != '' && $thirdPayment != null){
                //     $registrasiDetailPayment = new RegistrasiDetailPayment();
                //     $registrasiDetailPayment->registrasiid = $registrasiDetail->registrasiid;
                //     $registrasiDetailPayment->registrasidetailid = $id;
                //     $registrasiDetailPayment->name = $thirdPayment;
                //     $registrasiDetailPayment->createdby = $req->user()->id;
                //     $registrasiDetailPayment->updatedby = $req->user()->id;
                //     $registrasiDetailPayment->save();    
                // }

                // if ($fourPayment != 'undefined' && $fourPayment != '' && $fourPayment != null){
                //     $registrasiDetailPayment = new RegistrasiDetailPayment();
                //     $registrasiDetailPayment->registrasiid = $registrasiDetail->registrasiid;
                //     $registrasiDetailPayment->registrasidetailid = $id;
                //     $registrasiDetailPayment->name = $fourPayment;
                //     $registrasiDetailPayment->createdby = $req->user()->id;
                //     $registrasiDetailPayment->updatedby = $req->user()->id;
                //     $registrasiDetailPayment->save();    
                // }
                
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

    public function simpanEdit(Request $req){
        $this->simpleLogger($this, __FUNCTION__, $req->all(), __LINE__);
        DB::beginTransaction();
        try{
            $jumlah = (int) $req->input('jumlah');
            $rules = [];
            
            for ($i=1; $i <= $jumlah ; $i++) {
                $rules['id' . $i] = 'required';
                $rules['name' . $i] = 'required';
                $rules['address' . $i] = 'required';
                $rules['identityno' . $i] = 'required';
                $rules['birthplace' . $i] = 'required';
                $rules['birthdate' . $i] = 'required';
                $rules['gender' . $i] = 'required';
                $rules['job' . $i] = 'required';
                $rules['country' . $i] = 'required';
                $rules['email' . $i] = 'required|email';
                $rules['image' . $i] = 'required|mimes:jpeg,png,jpg|max:3048';
            }
            
            $vali = Validator::make($req->all(),$rules);

            if ($vali->fails()) {
                $err = [];
                $errors = $vali->messages()->get('*');
                foreach ($errors as $key => $value) {
                    $err[] = $value[0];
                }
                throw new \Exception(json_encode($err));
            }

            for ($i=1; $i <= $jumlah ; $i++) {
                $id = strip_tags($req->input('id'.$i));
                $registrasiDetail = RegistrasiDetail::find($id);
                if ($registrasiDetail == null){
                    throw new \Exception('Registrasi Detail with ID '.$id.' not found');
                }
                
                $identityno = strip_tags($req->input('identityno'.$i));
                $registrasiDetail->name = strip_tags($req->input('name'.$i));
                $registrasiDetail->address = strip_tags($req->input('address'.$i));
                $registrasiDetail->identityno = $identityno;
                $registrasiDetail->birthplace = strip_tags($req->input('birthplace'.$i));
                $registrasiDetail->birthdate = strip_tags($req->input('birthdate'.$i));
                $registrasiDetail->gender = strip_tags($req->input('gender'.$i));
                $registrasiDetail->job = strip_tags($req->input('job'.$i));
                $registrasiDetail->country = strip_tags($req->input('country'.$i));
                $registrasiDetail->email = strip_tags($req->input('email'.$i));
                $registrasiDetail->image = $this->storeImage($req->file('image'.$i),$identityno);
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

    public function printExcel(Request $req){
        
        $title = "SWAB Visit";
        $namasheet    = str_slug($title);
        $namafile     = $namasheet."-".uniqid().".xls";

        $id = strip_tags($req->id);
        $registrasi = Registrasi::find($id);
        $registrasi->print     = $registrasi->print + 1;
        $registrasi->print_at  = date('Y-m-d H:i:s');
        $registrasi->updatedby = $req->user()->id;
        $registrasi->save();

        return Excel::download(new RegistrasiReport($id), $namafile);
    }

    public function printPdf(Request $req){
        $id = strip_tags($req->id);
        $registrasi = Registrasi::find($id);
        $registrasi->print     = $registrasi->print + 1;
        $registrasi->print_at  = date('Y-m-d H:i:s');
        $registrasi->updatedby = $req->user()->id;
        $registrasi->save();

        $title = $registrasi->docno;
        $namasheet    = str_slug($title);
        $namafile     = $namasheet."-".uniqid().".pdf";

        $view = 'registrasi.pdfswab';
        if (substr($registrasi->docno,0,2) == 'AB'){
            $view = 'registrasi.pdfrapid';
        }
        
        $params = [
            'id' => $req->id
        ];
        $query = "CALL fn_get_detail_registrasi(:id)";

        $data = DB::SELECT($query,$params);

        $pdf = PDF::loadview($view, ['data'=>$data])->setPaper('a4', 'portrait');
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

    public function preview(Request $req)
    {
        $id = strip_tags($req->id);
        $registrasi = Registrasi::find($id);

        if ($registrasi)
        {
            $title = $registrasi->docno;
            $namasheet    = str_slug($title);
            $namafile     = $namasheet."-".uniqid().".pdf";

            $view = 'registrasi.pdfswab';
            if (substr($registrasi->docno,0,2) == 'AB'){
                $view = 'registrasi.pdfrapid';
            }
            
            $params = [
                'id' => $req->id
            ];
            $query = "CALL fn_get_detail_registrasi(:id)";

            $data = DB::SELECT($query,$params);

            $pdf = PDF::loadview($view, ['data'=>$data])->setPaper('a4', 'portrait');
            $pdf->save(storage_path('excel/exports') . '/'.$namafile);

            return view('registrasi.preview',compact('id','data','namafile'));
        }
        else
        {
            return redirect('/transaction/registrasi')->with('message', 'Data tidak ditemukan');
        }
    }

    public function email(Request $req)
    {
        $id = strip_tags($req->id);
        $registrasiDetail = RegistrasiDetail::where('registrasiid',$id)->get();

        $text = 'Berikut hasil rapid test Anda:';
        $recipients  = [];
        foreach ($registrasiDetail as $key => $value)
        {
            if ($value->email && $value->status)
            {
                $recipients[$value->email] = $value->name;
            }
        }
        $this->simpleLogger($this, __FUNCTION__, $recipients, __LINE__);

        $subject = 'Hasil Pemeriksaan';
        $send = $this->sendEmail($recipients,$subject,$text,$req->namafile);

        return redirect('/transaction/registrasi')->with('message', $send);
    }
}
