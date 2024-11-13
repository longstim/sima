@extends('layouts.dashboard')
@section('page_heading','Tambah Aset')
@section('breadcrumb')
 <b><a href="{{url('aset/daftar-aset')}}" class="btn float-right text-primary"><i class="fas fa-chevron-left"></i>&nbsp; Kembali</a></b>
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
			<form role="form" id="tambahaset" method="post" action="{{url('aset/proses-tambah-aset')}}" >
		  	{{ csrf_field() }}

		  	
			<div class="card-body">
				<div class="row col-md-12 mb-2">
					<small><i class="text-muted">Silahkan tambah data Aset! (<span class="text-danger">*Wajib diisi</span>)</i></small>
				</div>
				<!-- Card -->
				<div class="card">
					<div class="card-header">
						<div class="col-md-12">
							<h3 class="card-title" style="color:#0056b3;"><b>Aset</b></h3>
						</div>	
					</div>
					<div class="card-body">
						<div class="row">
				    	  <div class="col-md-6">
					      	<div class="form-group col-md-12">
					        	<label>Kelompok Aset<a style="color:red;">&#42;</a></label>
					        	<select name="id_subkelompok_aset" id="slcSubkelompokAset" class="form-control select2bs4" style="width: 100%;" required>
			                        <option value="" selected="selected">-- Pilih Satu --</option>
			                        @foreach($subkelompokaset as $data)
			                            <option value="{{$data->id}}">{{"[".$data->kode_kelompok.".".$data->kode."] ".$data->nama}}</option>
			                        @endforeach
			                    </select>
					      	</div>
					      	<div class="form-group col-md-12">
					        	<label>Lokasi<a style="color:red;">&#42;</a></label>
					        	 <select name="lokasi" id="slcLokasi" class="form-control select2bs4" style="width: 100%;" required>
			                        <option value="" selected="selected">-- Pilih Satu --</option>
			                        @foreach($lokasi as $data)
			                            <option value="{{$data->id}}">{{"[".$data->kode."] ".$data->nama}}</option>
			                        @endforeach
			                    </select>
					      	</div>
					      	  <div class="form-group col-md-12">
						        <label>Merk<a style="color:red;">&#42;</a></label>
						        <input type="text" name="merk" class="form-control" id="txtMerk" value="{{old('merk')}}" placeholder="Merk" required>
						      </div>
						      <div class="form-group col-md-12">
							        <label>Kondisi</label>
								         <select name="kondisi" id="slcKondisi" class="form-control select2bs4" style="width: 100%;" required>
					                    <option value="" selected="selected">-- Pilih Satu --</option>
					                    <option value="Baik">Baik</option>
					                    <option value="Rusak Ringan">Rusak Ringan</option>
					                    <option value="Rusak Berat">Rusak Berat</option>
					                </select>
							    </div>
						      	<div class="form-group col-md-12">
						        	<label>Jumlah</label>
						        	<input type="number" name="jumlah" class="form-control{{ $errors->has('jumlah') ? ' is-invalid' : '' }}" id="txtJumlah" value="{{old('jumlah')}}" placeholder="Jumlah" required>
						      	</div>
					      </div>

					      <div class="col-md-6">
					      	<div class="form-group col-md-12">
					        	<label>Harga Perolehan<a style="color:red;">&#42;</a></label>
				        		<input type="text" name="harga_perolehan" class="form-control" id="txtHargaPerolehan" value="{{old('harga_perolehan') }}" placeholder="Harga Perolehan" required>
					      	</div>
					      	<div class="form-group col-md-12">
						        <label>Tanggal Perolehan<a style="color:red;">&#42;</a></label>
						        <div class="input-group date">
				                  <input type="text" name="tanggal_perolehan" class="form-control" id="datepicker" placeholder="dd/mm/yyyy" required>
				                  <div class="input-group-prepend">
				                      <span class="input-group-text"><i class="far fa-calendar-alt"></i></span>
				                  </div>
				               </div>
					      	</div>
					      	<div class="form-group col-md-12">
					        	<label>Harga Sekarang<a style="color:red;">&#42;</a></label>
				        		<input type="text" name="harga_sekarang" class="form-control" id="txtHargaSekarang" value="{{old('harga_sekarang') }}" placeholder="Harga Sekarang" required>
					      	</div>
						    <div class="form-group col-md-12">
					        	<label>Keterangan</label>
					        	<textarea name="keterangan" id="txtKeterangan" class="form-control" placeholder="Keterangan" rows="2"></textarea>
					      	  </div>
					      </div>
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
		$("#txtHargaPerolehan").keyup(function(){
	     $("#txtHargaPerolehan").val(formatRupiah($(this).val()));
	  	});

	  	$("#txtHargaSekarang").keyup(function(){
	     $("#txtHargaSekarang").val(formatRupiah($(this).val()));
	  	});

	  	$('#tambahaset').validate({
	  		rules: {
	      		kode_aset: {
	        		required: true
	      		},
	      		lokasi: {
	        		required: true
	      		},
	      		merk: {
	        		required: true
	      		},
	      		kondisi: {
	        		required: true
	      		},
	      		jumlah: {
	        		required: true
	      		},
	      		harga_perolehan: {
	        		required: true
	      		},
	      		tanggal_perolehan: {
	        		required: true
	      		},
	      		harga_sekarang: {
	        		required: true
	      		},
	    	},
	   		messages: {
	   			kode_aset: {
		        	required: "Kode Aset harus diisi."
		      	},
		     	lokasi: {
		        	required: "Lokasi harus diisi."
		      	},
		      	merk: {
	        		required: "Merk harus diisi."
	      		},
	      		kondisi: {
	        		required: "Kondisi harus diisi."
	      		},
	      		jumlah: {
	        		required: "Jumlah harus diisi."
	      		},
	      		harga_perolehan: {
	        		required: "Harga Perolehan harus diisi."
	      		},
	      		tanggal_perolehan: {
	        		required: "Tanggal Perolehan harus diisi."
	      		},
	      		harga_sekarang: {
	        		required: "Harga Sekarang harus diisi."
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

	function formatRupiah(angka)
	{
		var number_string = angka.replace(/[^,\d]/g, '').toString(),
		split   		= number_string.split(','),
		sisa     		= split[0].length % 3,
		rupiah     		= split[0].substr(0, sisa),
		ribuan     		= split[0].substr(sisa).match(/\d{3}/gi);
	 
		// tambahkan titik jika yang di input sudah menjadi angka ribuan
		if(ribuan){
			separator = sisa ? '.' : '';
			rupiah += separator + ribuan.join('.');
		}
	 
		rupiah = split[1] != undefined ? rupiah + ',' + split[1] : rupiah;
		return rupiah;
	}

</script>
@endsection