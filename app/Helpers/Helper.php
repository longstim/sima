<?php
   
	function customTanggal($date, $date_format)
	{
	    return \Carbon\Carbon::createFromFormat('Y-m-d', $date)->format($date_format);    
	}

    function formatTanggalIndonesia($tanggal)
    {
        $bulan = array (1 =>   'Januari',
                    'Februari',
                    'Maret',
                    'April',
                    'Mei',
                    'Juni',
                    'Juli',
                    'Agustus',
                    'September',
                    'Oktober',
                    'November',
                    'Desember'
                );
        $split = explode(' ', $tanggal);
        $split = explode('-', $split[0]);
        return $split[2] . ' ' . $bulan[ (int)$split[1] ] . ' ' . $split[0];
    }

    function formatTanggalIndonesiaV2($date)
    {
        setlocale(LC_ALL, 'IND');
        $tanggal = \Carbon\Carbon::parse($date)->formatLocalized('%d-%m-%Y');

        return $tanggal;
    }

    function formatRupiah($angka)
    { 
    	$hasil = "Rp ".number_format($angka, 0, ',' , '.'); 

    	return $hasil; 
	}

    function formatMataUang($angka)
    { 
        $hasil = number_format($angka, 0, ',' , '.'); 

        return $hasil; 
    }

    function getNamaHariIni()
    {

        $hari = date ("D");

        switch($hari){
            case 'Sun':
                $hari_ini = "Minggu";
            break;

            case 'Mon':         
                $hari_ini = "Senin";
            break;

            case 'Tue':
                $hari_ini = "Selasa";
            break;

            case 'Wed':
                $hari_ini = "Rabu";
            break;

            case 'Thu':
                $hari_ini = "Kamis";
            break;

            case 'Fri':
                $hari_ini = "Jumat";
            break;

            case 'Sat':
                $hari_ini = "Sabtu";
            break;
            
            default:
                $hari_ini = "Tidak di ketahui";     
            break;
        }

        return $hari_ini;
    }

    function getRomawi($bulan)
    {
        if($bulan < 10){
            $bulan = "0".$bulan;
        }
        switch ($bulan){
            case 1: 
                return "I";
                break;
            case 2:
                return "II";
                break;
            case 3:
                return "III";
                break;
            case 4:
                return "IV";
                break;
            case 5:
                return "V";
                break;
            case 6:
                return "VI";
                break;
            case 7:
                return "VII";
                break;
            case 8:
                return "VIII";
                break;
            case 9:
                return "IX";
                break;
            case 10:
                return "X";
                break;
            case 11:
                return "XI";
                break;
            case 12:
                return "XII";
                break;
        }
    }

    function number($angka)
    {
        return sprintf("%04s", $angka);
    }

    function captcha()
    {
        $res = rand(1,9);

        return $res;
    }

    function totalNilaiAsetHargaPerolehan()
    {
        $totalnilai = DB::table('aset')
            ->sum('harga_perolehan');

        return $totalnilai;
    }

    function totalNilaiAsetHargaSekarang()
    {
        $totalnilai = DB::table('aset')
            ->sum('harga_sekarang');

        return $totalnilai;
    }

    function totalHargaPerolehan($id_subkelompok_aset)
    {
        $totalnilai = DB::table('aset')
            ->where('id_subkelompok_aset', '=', $id_subkelompok_aset)
            ->sum('harga_perolehan');

        return $totalnilai;
    }

    function totalHargaSekarang($id_subkelompok_aset)
    {
        $totalnilai = DB::table('aset')
            ->where('id_subkelompok_aset', '=', $id_subkelompok_aset)
            ->sum('harga_sekarang');

        return $totalnilai;
    }

?>
