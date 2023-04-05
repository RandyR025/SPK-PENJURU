<!DOCTYPE html>
<html>
<head>
	<title>Membuat Laporan PDF Dengan DOMPDF Laravel</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
</head>
<body>
	<style type="text/css">
		table tr td,
		table tr th{
			font-size: 9pt;
		}
	</style>
	<center>
		<h5>Membuat Laporan PDF Dengan DOMPDF Laravel</h4>
		<h6><a target="_blank" href="https://www.malasngoding.com/membuat-laporan-…n-dompdf-laravel/">www.malasngoding.com</a></h5>
	</center>
    @foreach($penilaian as $valkey => $val)
    @foreach ($coba1[$valkey] as $key => $item)
    @if(isset($coba1[$valkey]))
    <p>
        Penilaian {{$val->nama_penilaian}}
        Tanggal {{$val->tanggal}}
    </p> 
    @endif
    @endforeach
	<table class="table table-bordered" id="datatable">
    @foreach ($coba1[$valkey] as $key => $item)
    @if(isset($coba1[$valkey]))
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    @foreach($pengisian as $data)
                    <th>{{$data->nama_pengisian}}</th>
                    @endforeach
                </tr>
            </thead>
    @endif
    @endforeach
            <tbody>
                <?php
                $nomor = 1;
                ?>
                @foreach ($coba1[$valkey] as $key => $item)
                <tr>
                    <td>{{ $nomor }}</td>
                    <td>{{ $item->name }}</td>
                    @foreach ($coba[$key] as $keycoba => $p)
                    <td>{{$p->nama_pilihan}} ({{ $p->points }})</td>
                    @endforeach
                    {{$nomor++}}
                </tr>
                @endforeach
                
            </tbody>
        </table>
    @endforeach
</body>
</html>