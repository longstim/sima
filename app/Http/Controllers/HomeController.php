<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use DB;
Use Redirect;
use Auth;
use Crypt;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
        $kelompokaset = DB::table('kelompok_aset')->get();
        
        return view('home', compact('kelompokaset'));
    }

    public function subkelompokaset($id_kelompok_aset)
    {
        $id_kelompok_aset = Crypt::decrypt($id_kelompok_aset);

        $subkelompokaset = DB::select("SELECT id_subkelompok_aset, t1.*, COUNT(id_subkelompok_aset) AS jumlah_aset, t2.kode AS kode_kelompok 
            FROM aset 
            LEFT JOIN subkelompok_aset AS t1 ON aset.id_subkelompok_aset = t1.id
            LEFT JOIN kelompok_aset AS t2 ON t1.id_kelompok_aset = t2.id
            WHERE t2.id = '".$id_kelompok_aset."' GROUP BY id_subkelompok_aset");

        return view('pages.aset.daftar_subkelompok-aset', compact('subkelompokaset'));
    }

    public function daftarasetpersubkelompok($id_subkelompok_aset)
    {
        $id_subkelompok_aset = Crypt::decrypt($id_subkelompok_aset);

        $subkelompokaset = DB::table('subkelompok_aset')
                ->where('id','=', $id_subkelompok_aset)
                ->first();

        $aset = DB::table('aset')
                ->where('aset.id_subkelompok_aset','=', $id_subkelompok_aset)
                ->leftjoin('subkelompok_aset AS t1', 'aset.id_subkelompok_aset', '=', 't1.id')
                ->leftjoin('lokasi AS t2', 'aset.id_lokasi', '=', 't2.id')
                ->select('aset.*', 't1.nama AS nama_aset', 't1.satuan AS satuan', 't2.kode AS kode_lokasi', 't2.nama AS nama_lokasi')
                ->get();

        return view('pages.aset.daftar_aset-per-subkelompok', compact('aset', 'subkelompokaset'));
    }
}
