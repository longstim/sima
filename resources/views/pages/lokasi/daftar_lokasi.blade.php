@extends('layouts.dashboard')
@section('page_heading', 'Daftar Lokasi')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
  <li class="breadcrumb-item"><a href="{{url('home')}}">Beranda</a></li>
  <li class="breadcrumb-item active">Daftar Lokasi</li>
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

    <!-- Card -->
    <div class="card card-outline card-primary shadow-lg">
      <div class="card-body">

        <a href="{{url('lokasi/tambah-lokasi')}}" class="btn btn-primary"><i class="fas fa-plus-circle"></i> &nbsp;Tambah Data</a>
        <br><br>

        <table id="datatable" class="table table-bordered table-hover">
          <thead>
            <tr style="color:#0056b3">
              <th>No</th>
              <th>Kode</th>
              <th>Lokasi</th>
              <th>Keterangan</th>
              <th>Aksi</th>
            </tr>
            </thead>
            <tbody>
            @php
            $no = 0
            @endphp
            @foreach($lokasi as $data)  
            <tr>
              <td>{{++$no}}</td>
              <td>{{$data->kode}}</td>
              <td>{{$data->nama}}</td>
              <td>{{$data->keterangan}}</td>
              <td style="width:85px;">
                <div class="btn-group">
                  <button class="btn bg-gradient-primary btn-sm rounded-pill dropdown-toggle" type="button" data-toggle="dropdown"><i class="fas fa-check nav-icon"></i>
                  <span class="caret"></span>
                  </button>
                  <div class="dropdown-menu" id="dropdown-action-id">
                    <a class="dropdown-item" href="{{url('lokasi/ubah-lokasi/'.Crypt::encrypt($data->id))}}">Edit Data</a>
                    <a class="dropdown-item swalDelete" href="{{url('lokasi/hapus-lokasi/'.Crypt::encrypt($data->id))}}">Hapus Data</a>
                 </div>
                </div>
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