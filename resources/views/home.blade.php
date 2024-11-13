@extends('layouts.dashboard')
@section('page_heading','Dashboard Aset HKBP Padang Bulan')
@section('content')
<div class="row">
  <div class="col-md-12">
    <div class="card card-outline card-primary">
      <div class="card-body">
          <div class="row">
            <div class="col-lg-6">
              <h4 style="font-weight:normal;">Total Nilai Harga Perolehan: </h4><h1><b class="text-primary">{{formatRupiah(totalNilaiAsetHargaPerolehan())}}</b></h1><br>
            </div>
            <div class="col-lg-6">
              <h4 style="font-weight:normal;">Total Nilai Harga Sekarang: </h4><h1><b class="text-primary">{{formatRupiah(totalNilaiAsetHargaSekarang())}}</b></h1><br>
            </div>
          </div>
      </div>
    </div>
    <div class="card">
      <div class="card-body">
        <div class="row">
          @foreach($kelompokaset as $data)
          <div class="col-lg-6 text-center">
            <a href="{{url('home/subkelompok-aset/'.Crypt::encrypt($data->id))}}">
            <div class="small-box bg-info">
              <div class="inner">
                <h3>{{$data->nama}}</h3>
                <h4>{{$data->kode}}</h4>
              </div>
              <div class="icon">
                <i class="ion ion-checkmark-circled"></i>
              </div>
            </div>
            </a>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>

<!-- ChartJS -->
<script src="{{asset('assets/plugins/chart.js/Chart.min.js')}}"></script>
<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
  $( document ).ready(function () {
 


  })
</script>
@endsection
