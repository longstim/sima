<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;
use Crypt;

class KelompokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftarkelompokaset()
    {
        $kelompokaset = DB::table('kelompok_aset')
                    ->orderBy('id', 'asc')
                    ->get();

        return view('pages.kelompokaset.daftar_kelompok-aset', compact('kelompokaset'));
    }

    public function tambahkelompokaset()
    {
        return view('pages.kelompokaset.form_tambah-kelompok-aset');
    }

    public function prosestambahkelompokaset(Request $request)
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

            DB::table('kelompok_aset')->insert($data);

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menyimpan data');
        }

        return Redirect::to('kelompokaset/daftar-kelompok-aset')->with('message','Berhasil menyimpan data');
    }

    public function ubahkelompokaset($id_kelompok_aset)
    {
        $id_kelompok_aset = Crypt::decrypt($id_kelompok_aset);

        $kelompokaset = DB::table('kelompok_aset')
                ->where('id', '=', $id_kelompok_aset)
                ->first();

        return view('pages.kelompokaset.form_ubah-kelompok-aset', compact('kelompokaset'));
    }

    public function prosesubahkelompokaset(Request $request)
    {
        DB::beginTransaction();

        try 
        {
            $id_kelompok_aset = $request->input('id');

            $data = array(
                'kode' => $request->input('kode'),
                'nama' => $request->input('nama'),
                'keterangan' => $request->input('keterangan'),
            );

            DB::table('kelompok_aset')->where('id', '=', $id_kelompok_aset)->update($data);

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menyimpan data');
        }

        return Redirect::to('kelompokaset/daftar-kelompok-aset')->with('message','Berhasil menyimpan data');
    }

    public function hapuskelompokaset($id_kelompok_aset)
    {
        DB::beginTransaction();

        try 
        {
            $id_kelompok_aset = Crypt::decrypt($id_kelompok_aset);

            DB::table('kelompok_aset')->where('id', '=', $id_kelompok_aset)->delete();

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menghapus data');
        }

        return Redirect::to('kelompokaset/daftar-kelompok-aset')->with('message','Berhasil menghapus data');
    }
}
