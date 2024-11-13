@extends('layouts.dashboard')
@section('page_heading','Tambah Kelompok Aset')
@section('breadcrumb')
 <b><a href="{{url('kelompokaset/daftar-kelompok-aset')}}" class="btn float-right text-primary"><i class="fas fa-chevron-left"></i>&nbsp; Kembali</a></b>
@endsection
@section('content')
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
		<div class="card card-outline card-primary shadow">
			<form role="form" id="tambahkelompokaset" method="post" action="{{url('kelompokaset/proses-tambah-kelompok-aset')}}" >
		  	{{ csrf_field() }}

		  	
			<div class="card-body">
				<div class="row col-md-12 mb-2">
					<small><i class="text-muted">Silahkan tambah data Kelompok Aset! (<span class="text-danger">*Wajib diisi</span>)</i></small>
				</div>
				<!-- Card -->
				<div class="card">
					<div class="card-header">
						<div class="col-md-12">
							<h3 class="card-title" style="color:#0056b3;"><b>Kelompok Aset</b></h3>
						</div>	
					</div>
					<div class="card-body">
				      	<div class="form-group col-md-12">
				        	<label>Kode<a style="color:red;">&#42;</a></label>
				        	<input type="text" name="kode" class="form-control" id="txtKode" placeholder="Kode" required>
				      	</div>
				      	<div class="form-group col-md-12">
				        	<label>Nama<a style="color:red;">&#42;</a></label>
				        	<input type="text" name="nama" class="form-control" id="txtNama" placeholder="Nama" required>
				      	</div>
				      	<div class="form-group col-md-12">
				        	<label>Keterangan</label>
				        	<textarea name="keterangan" id="txtKeterangan" class="form-control" placeholder="Keterangan" rows="2"></textarea>
				      	</div>
			     	</div>	
			 	</div>
			 	<!-- Card -->
			</div>
			<div class="card-footer text-right">
				<div class="col-md-12">
	      			<button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> &nbsp;Simpan</button>
	    		</div>
  			</div>
  			</form>
		</div>
		<!-- Card -->
	</div>
</div>

<script src="{{asset('js/jquery.min.js')}}"></script>
<script>
	$(document).ready(function () {
	  	$('#tambahkelompokaset').validate({
	  		rules: {
	      		kode: {
	        		required: true
	      		},
	      		nama: {
	        		required: true
	      		},
	    	},
	   		messages: {
	   			kode: {
		        	required: "Kode harus diisi."
		      	},
		     	nama: {
		        	required: "Nama harus diisi."
		      	},
		    },
		    errorElement: 'p',
		    errorPlacement: function (error, element) {
		      error.addClass('invalid-feedback');
		      element.closest('.form-group').append(error);
		    },
		    highlight: function (element, errorClass, validClass) {
		      $(element).addClass('is-invalid');
		    },
		    unhighlight: function (element, errorClass, validClass) {
		      $(element).removeClass('is-invalid');
		    }
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
	         confirmButtonClass: 'btn btn-danger',
	      })
	    }

	  	//datepicker
	  	$('#datepicker').datepicker({
	      format: 'dd/mm/yyyy',
	      autoclose: true
		})

	});

</script>
@endsection