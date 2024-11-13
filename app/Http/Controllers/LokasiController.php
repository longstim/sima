<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;
use Crypt;

class LokasiController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftarlokasi()
    {
        $lokasi = DB::table('lokasi')
                    ->orderBy('id', 'asc')
                    ->get();

        return view('pages.lokasi.daftar_lokasi', compact('lokasi'));
    }

    public function tambahlokasi()
    {
        return view('pages.lokasi.form_tambah-lokasi');
    }

    public function prosestambahlokasi(Request $request)
    {
        DB::beginTransaction();

        try 
        {
            $id_user = Auth::user()->id;

            $data = array(
                'kode' => $request->input('kode'),
                'nama' => $request->input('nama'),
                'keterangan' => $request->input('keterangan'),
            );

            DB::table('lokasi')->insert($data);

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menyimpan data');
        }

        return Redirect::to('lokasi/daftar-lokasi')->with('message','Berhasil menyimpan data');
    }

    public function ubahlokasi($id_lokasi)
    {
        $id_lokasi = Crypt::decrypt($id_lokasi);

        $lokasi = DB::table('lokasi')
                ->where('id', '=', $id_lokasi)
                ->first();

        return view('pages.lokasi.form_ubah-lokasi', compact('lokasi'));
    }

    public function prosesubahlokasi(Request $request)
    {
        DB::beginTransaction();

        try 
        {
            $id_lokasi = $request->input('id');

            $data = array(
                'kode' => $request->input('kode'),
                'nama' => $request->input('nama'),
                'keterangan' => $request->input('keterangan'),
            );

            DB::table('lokasi')->where('id', '=', $id_lokasi)->update($data);

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menyimpan data');
        }

        return Redirect::to('lokasi/daftar-lokasi')->with('message','Berhasil menyimpan data');
    }

    public function hapuslokasi($id_lokasi)
    {
        DB::beginTransaction();

        try 
        {
            $id_lokasi = Crypt::decrypt($id_lokasi);

            DB::table('lokasi')->where('id', '=', $id_lokasi)->delete();

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menghapus data');
        }

        return Redirect::to('lokasi/daftar-lokasi')->with('message','Berhasil menghapus data');
    }
}
