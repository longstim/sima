<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;
use DateTime;
use DateInterval;
use DatePeriod;
use Crypt;

class AsetController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except("detailaset");
    }

    public function daftaraset()
    {
        $aset=DB::table('aset')
            ->leftjoin('subkelompok_aset AS t1', 'aset.id_subkelompok_aset', '=', 't1.id')
            ->leftjoin('lokasi AS t2', 'aset.id_lokasi', '=', 't2.id')
            ->select('aset.*', 't1.nama AS nama_aset', 't1.satuan AS satuan', 't2.kode AS kode_lokasi')
            ->orderBy('id', 'desc')
            ->get(); 

        return view('pages.aset.daftar_aset', compact('aset'));
    }

    public function tambahaset()
    {
        $subkelompokaset=DB::table('subkelompok_aset')
            ->leftjoin('kelompok_aset AS t1', 'subkelompok_aset.id_kelompok_aset', '=', 't1.id')
            ->select('subkelompok_aset.*', 't1.kode AS kode_kelompok')
            ->get();

        $lokasi = DB::table('lokasi')->get();
                 
        return view('pages.aset.form_tambah-aset', compact('subkelompokaset', 'lokasi'));
    }

    public function prosestambahaset(Request $request)
    {
        DB::beginTransaction();

        try
        {        
            $tanggal_perolehan = $request->input('tanggal_perolehan');
            $newTanggalPerolehan = Carbon::createFromFormat('d/m/Y', $tanggal_perolehan)->format('Y-m-d');

            $subkelompokaset = DB::table('subkelompok_aset')
                ->where('subkelompok_aset.id', '=', $request->input('id_subkelompok_aset'))
                ->leftjoin('kelompok_aset AS t1', 'subkelompok_aset.id_kelompok_aset', '=', 't1.id')
                ->select('subkelompok_aset.*', 't1.kode AS kode_kelompok')
                ->first();

            $kode_aset = $subkelompokaset->kode_kelompok.".".$subkelompokaset->kode;

            $jumlah = $request->input('jumlah');
            $max_nup = DB::table('aset')->where('id_subkelompok_aset','=',$request->input('id_subkelompok_aset'))->max('nup');

            $str_harga_perolehan = $request->input('harga_perolehan');
            $harga_perolehan = (int)str_replace('.', '', $str_harga_perolehan);

            $str_harga_sekarang= $request->input('harga_sekarang');
            $harga_sekarang = (int)str_replace('.', '', $str_harga_sekarang);

            for($i=0; $i<$jumlah; $i++)
            {
                $data = array(
                  'id_subkelompok_aset' => $request->input('id_subkelompok_aset'),
                  'id_lokasi' => $request->input('lokasi'),
                  'kode_aset' => $kode_aset,
                  'nup' => ++$max_nup,
                  'merk' => $request->input('merk'),
                  'harga_perolehan' => $harga_perolehan,
                  'tanggal_perolehan' => $newTanggalPerolehan,
                  'harga_sekarang' => $harga_sekarang,
                  'kondisi' => $request->input('kondisi'),
                  'keterangan' => $request->input('keterangan'),
                );

                $insertID = DB::table('aset')->insertGetId($data);
            }

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menyimpan data');
        }

        
        return Redirect::to('aset/daftar-aset')->with('message','Berhasil menyimpan data');
    }

    public function ubahaset($id_aset)
    {
        $id_aset= Crypt::decrypt($id_aset);

        $aset = DB::table('aset')->where('id', '=', $id_aset)->first();

        $subkelompokaset = DB::table('subkelompok_aset')
            ->leftjoin('kelompok_aset AS t1', 'subkelompok_aset.id_kelompok_aset', '=', 't1.id')
            ->select('subkelompok_aset.*', 't1.kode AS kode_kelompok')
            ->get();

        $lokasi = DB::table('lokasi')->get();
                 
        return view('pages.aset.form_ubah-aset',compact('aset', 'subkelompokaset', 'lokasi'));
    }

    public function prosesubahaset(Request $request)
    {
        DB::beginTransaction();

        try
        {        
            $tanggal_perolehan = $request->input('tanggal_perolehan');
            $newTanggalPerolehan = Carbon::createFromFormat('d/m/Y', $tanggal_perolehan)->format('Y-m-d');

            $namafile = "";

            $rowaset = DB::table('aset')->where('id', '=', $request->input('id'))->first();

            if(!empty($rowaset))
            {
                $namafile = $rowaset->foto;
            }

            if($request->hasFile('foto'))
            {
                $path = public_path(). '/image/aset/';

                $upload_foto = $request->file('foto');
                $extension = $upload_foto->getClientOriginalExtension();
                $size = $upload_foto->getSize();

                if($extension == "jpg" || $extension == "jpeg" || $extension == "png")
                {
                    
                }
                else
                {
                    return Redirect::back()->with('failed','Format file yang diupload tidak sesuai.');
                }

                if($size > 1572864)
                {
                    return Redirect::back()->with('failed','Ukuran file maksimal 1,5 MB.');
                }

                $namafile = "foto_aset_".$rowaset->id.".".$extension;
                $upload_foto->move($path, $namafile);
            } 

            $checknup = DB::table('aset')
                ->where('id_subkelompok_aset', '=', $request->input('id_subkelompok_aset'))
                ->where('nup', '=', $request->input('nup'))
                ->first();

            if(!empty($checknup) && $checknup->id != $request->input('id'))
            {
                return Redirect::back()->with('failed','NUP sudah digunakan.');
            }

            $subkelompokaset = DB::table('subkelompok_aset')
                ->where('subkelompok_aset.id', '=', $request->input('id_subkelompok_aset'))
                ->leftjoin('kelompok_aset AS t1', 'subkelompok_aset.id_kelompok_aset', '=', 't1.id')
                ->select('subkelompok_aset.*', 't1.kode AS kode_kelompok')
                ->first();

            $kode_aset = $subkelompokaset->kode_kelompok.".".$subkelompokaset->kode;

            $str_harga_perolehan = $request->input('harga_perolehan');
            $harga_perolehan = (int)str_replace('.', '', $str_harga_perolehan);

            $str_harga_sekarang= $request->input('harga_sekarang');
            $harga_sekarang = (int)str_replace('.', '', $str_harga_sekarang);

            $data = array(
              'id_subkelompok_aset' => $request->input('id_subkelompok_aset'),
              'id_lokasi' => $request->input('lokasi'),
              'kode_aset' => $kode_aset,
              'nup' => $request->input('nup'),
              'merk' => $request->input('merk'),
              'harga_perolehan' => $harga_perolehan,
              'tanggal_perolehan' => $newTanggalPerolehan,
              'harga_sekarang' => $harga_sekarang,
              'kondisi' => $request->input('kondisi'),
              'keterangan' => $request->input('keterangan'),
              'foto' => $namafile,
            );

            DB::table('aset')->where('id','=',$request->input('id'))->update($data);  

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menyimpan data');
        }  
        
        return Redirect::to('aset/daftar-aset')->with('message','Berhasil menyimpan data');
    }


    public function hapusaset($id_aset)
    {
        DB::beginTransaction();

        try 
        {
            $id_aset = Crypt::decrypt($id_aset);

            DB::table('aset')->where('id', '=', $id_aset)->delete();

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menghapus data');
        }

        return Redirect::to('aset/daftar-aset')->with('message','Berhasil menghapus data');
    }

    public function generateqrcode($id_aset)
    {
        $id_aset = Crypt::decrypt($id_aset);

        $aset = DB::table('aset')
            ->where('aset.id', '=', $id_aset)
            ->leftjoin('subkelompok_aset AS t1', 'aset.id_subkelompok_aset', '=', 't1.id')
            ->select('aset.*', 't1.nama AS nama_aset')
            ->first();

        $link = 'http://hkbppadangbulan.org/sima/public/detail-aset/';

        $qrcode = QrCode::size(100)
                ->generate($link.$aset->id);

        return view('pages.aset.qrcode_aset',compact('qrcode', 'aset'));
    }

    public function detailaset($id_aset)
    {
        $aset = DB::table('aset')->where('aset.id', '=', $id_aset)
                ->leftjoin('subkelompok_aset AS t1', 'aset.id_subkelompok_aset', '=', 't1.id')
                ->leftjoin('lokasi AS t2', 'aset.id_lokasi', '=', 't2.id')
                ->select('aset.*', 't1.nama AS nama_aset', 't1.satuan AS satuan', 't2.kode AS kode_lokasi', 't2.nama AS nama_lokasi')
                ->first();

        return view('pages.aset.detail_aset', compact('aset'));
    }
}
