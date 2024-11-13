@extends('layouts.dashboard')
@section('page_heading', 'Daftar Aset "'.$subkelompokaset->nama.'"')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('home')}}">Beranda</a></li>
  <li class="breadcrumb-item active">Daftar Aset</li>
</ol>
@endsection
@section('content')
<style>
  #dropdown-action-id
  {
    min-width: 5rem;
  }

  #dropdown-action-id .dropdown-item:hover
  {
    color:#007bff;
  }

  #dropdown-action-id .dropdown-item:active
  {
    color:#fff;
  }
</style>
<div class="row">
  <div class="col-md-12">
    <div>
      @if(Session::has('message'))
          <input type="hidden" name="txtMessage" id="idmessage" value="{{Session::has('message')}}"></input>
          <input type="hidden" name="txtMessage_text" id="idmessage_text" value="{{Session::get('message')}}"></input>
      @endif

      @if(Session::has('failed'))
          <input type="hidden" name="txtMessageFailed" id="idmessagefailed" value="{{Session::has('failed')}}"></input>
          <input type="hidden" name="txtMessageFailed_text" id="idmessagefailed_text" value="{{Session::get('failed')}}"></input>
      @endif
    </div>

    <div class="table-responsive">
      <table class="table">
        <tr>
          <th style="width:50%">Kode Aset</th>
          <td>{{$aset[0]->kode_aset}}</td>
        </tr>
        <tr>
          <th style="width:50%">Nama Aset</th>
          <td>{{$aset[0]->nama_aset}}</td>
        </tr>
        <tr>
          <th style="width:50%">Total Nilai Harga Perolehan</th>
          <th>{{formatRupiah(totalHargaPerolehan($aset[0]->id_subkelompok_aset))}}</th>
        </tr>
         <tr>
          <th style="width:50%">Total Nilai Harga Sekarang</th>
          <th>{{formatRupiah(totalHargaSekarang($aset[0]->id_subkelompok_aset))}}</th>
        </tr>
      </table>
    </div>

    <!-- Card -->
    <div class="card card-outline card-primary shadow-lg">
      <div class="card-body">
        <table id="datatable" class="table table-bordered table-hover">
          <thead>
            <tr style="color:#0056b3">
              <th>No</th>
              <th>Nama Aset</th>
              <th>Merk</th>
              <th>Haga Perolehan</th>
              <th>Haga Sekarang</th>
              <th>Satuan</th>
              <th>Kondisi</th>
              <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @php
            $no = 0
            @endphp
            @foreach($aset as $data)  
            <tr>
              <td>{{++$no}}</td>
              <td>{{$data->nama_aset}}<br><small>Kode: <b>{{$data->kode_aset."-".$data->nup}}</b></small></td>
              <td>{{$data->merk}}</td>
              <td>{{formatRupiah($data->harga_perolehan)}}<br>
              <small>{{customTanggal($data->tanggal_perolehan, "j M Y")}}</small></td>
              <td>{{formatRupiah($data->harga_sekarang)}}</td>
              <td>{{$data->satuan}}</td>
              <td>{{$data->kondisi}}</td>   
              <td>
                <a href="{{url('aset/detail-aset/'.$data->id)}}" class="btn btn-outline-primary"><i class="fa fa-folder-open"></i></a>
              </td>                  
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
    </div>
    <!-- Card -->
  </div>
</div>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
$( document ).ready(function () {
    //DataTable
    $("#datatable").DataTable({
      "responsive": true,
      "autoWidth": false,
    });

    //SweetAlert Success
    var message = $("#idmessage").val();
    var message_text = $("#idmessage_text").val();

    if(message=="1")
    {
      Swal.fire({     
         icon: 'success',
         title: 'Sukses!',
         text: message_text,
         confirmButtonClass: 'btn btn-success',
      })
    }

    //SweetAlert Failed
    var failed = $("#idmessagefailed").val();
    var messagefailed_text = $("#idmessagefailed_text").val();

    if(failed=="1")
    {
      Swal.fire({     
         icon: 'error',
         title: 'Gagal!',
         text: messagefailed_text,
         showConfirmButton: true,
         confirmButtonClass: 'btn bg-gradient-danger rounded-pill',
      })
    }

    //SweetAlert Delete
   $(document).on("click", ".swalDelete",function(event) {  
      event.preventDefault();
      const url = $(this).attr('href');

      Swal.fire({
        title: 'Apakah anda yakin menghapus data ini?',
        text: 'Anda tidak akan dapat mengembalikan data ini!',
        icon: 'error',
        showCancelButton: true,
        confirmButtonText: 'Ya, Hapus',
        cancelButtonText: 'Batal',
        confirmButtonClass: 'btn bg-gradient-danger rounded-pill',
        cancelButtonClass: 'btn bg-gradient-secondary rounded-pill',
      }).then((result) => {
      if (result.value) 
      {
          window.location.href = url;
      }
    });
  });
});
</script>
@endsection