<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;
use Crypt;

class SubkelompokController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function daftarsubkelompokaset()
    {
        $subkelompokaset = DB::table('subkelompok_aset')
                    ->leftjoin('kelompok_aset AS t1', 'subkelompok_aset.id_kelompok_aset', '=', 't1.id')
                    ->select('subkelompok_aset.*', 't1.kode AS kode_kelompok')
                    ->orderBy('id', 'asc')
                    ->get();

        return view('pages.subkelompokaset.daftar_subkelompok-aset', compact('subkelompokaset'));
    }

    public function tambahsubkelompokaset()
    {
        $kelompokaset = DB::table('kelompok_aset')
                    ->orderBy('id', 'asc')
                    ->get();

        return view('pages.subkelompokaset.form_tambah-subkelompok-aset', compact('kelompokaset'));
    }

    public function prosestambahsubkelompokaset(Request $request)
    {
        DB::beginTransaction();

        try 
        {
            $id_user = Auth::user()->id;

            $data = array(
                'id_kelompok_aset' => $request->input('kelompokaset'),
                'kode' => $request->input('kode'),
                'nama' => $request->input('nama'),
                'satuan' => $request->input('satuan'),
                'keterangan' => $request->input('keterangan'),
            );

            DB::table('subkelompok_aset')->insert($data);

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menyimpan data');
        }

        return Redirect::to('subkelompokaset/daftar-subkelompok-aset')->with('message','Berhasil menyimpan data');
    }

    public function ubahsubkelompokaset($id_subkelompok_aset)
    {
        $id_subkelompok_aset = Crypt::decrypt($id_subkelompok_aset);

        $kelompokaset = DB::table('kelompok_aset')
                    ->orderBy('id', 'asc')
                    ->get();

        $subkelompokaset = DB::table('subkelompok_aset')
                ->where('id', '=', $id_subkelompok_aset)
                ->first();

        return view('pages.subkelompokaset.form_ubah-subkelompok-aset', compact('kelompokaset', 'subkelompokaset'));
    }

    public function prosesubahsubkelompokaset(Request $request)
    {
        DB::beginTransaction();

        try 
        {
            $id_subkelompok_aset = $request->input('id');

            $data = array(
                'id_kelompok_aset' => $request->input('kelompokaset'),
                'kode' => $request->input('kode'),
                'nama' => $request->input('nama'),
                'satuan' => $request->input('satuan'),
                'keterangan' => $request->input('keterangan'),
            );

            DB::table('subkelompok_aset')->where('id', '=', $id_subkelompok_aset)->update($data);

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menyimpan data');
        }

        return Redirect::to('subkelompokaset/daftar-subkelompok-aset')->with('message','Berhasil menyimpan data');
    }

    public function hapussubkelompokaset($id_subkelompok_aset)
    {
        DB::beginTransaction();

        try 
        {
            $id_subkelompok_aset = Crypt::decrypt($id_subkelompok_aset);

            DB::table('subkelompok_aset')->where('id', '=', $id_subkelompok_aset)->delete();

            DB::commit();

        } 
        catch (\Exception $e) 
        {
            DB::rollback();

            return Redirect::back()->with('failed','Gagal menghapus data');
        }

        return Redirect::to('subkelompokaset/daftar-subkelompok-aset')->with('message','Berhasil menghapus data');
    }

    public function jsondatakelompokaset($id_kelompok_aset)
    {
        $kelompokaset=DB::table('kelompok_aset')
            ->where('id','=',$id_kelompok_aset)
            ->first(); 

        $hasil = array(
            "kode_kelompok" => $kelompokaset->kode,
        );

        return json_encode($hasil);
    }
}
