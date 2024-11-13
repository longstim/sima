<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SIMA HKBP Padang Bulan</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
        <style>
            body {
                font-family: 'Arial';
            }

            .table td, .table th
            {
                vertical-align: middle;
            }
        </style>
    </head>
    <body>
        <div class="container" >
            <div class="table-responsive" style="margin-top: 50px;">
                <table class="table" style="border: solid black 2px; width:450px">
                    <tr>
                        <td align="center" colspan="2"><img src="{{asset('image/logo_text_hkbp.png')}}" style="width:200px"></td>
                    </tr>
                    <tr>
                        <td style="width:300px; border: solid black 1px;">
                            <b>{{$aset->nama_aset}}</b><br>
                            Merk : {{$aset->merk}}<br><br>
                            Kode :  {{$aset->kode_aset}}-{{$aset->nup}}</td>
                        <td style="text-align: center; border: solid black 1px;"> <small>QR Code</small> <br>{!! $qrcode !!}</td>
                    </tr>
                </table>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
    </body>
</html>