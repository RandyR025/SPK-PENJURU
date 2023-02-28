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
		<h5>{{$data}}</h5>
	</center>
    @foreach($penilaian as $valkey => $val)
    <p>
        Penilaian {{$val->nama_penilaian}}
        Tanggal {{$val->tanggal}}
    </p> 
	<table class="table table-bordered" id="datatable">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Totals</th>
                    <th>Rangking</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $nomor = 1;
                ?>
                @foreach ($coba1[$valkey] as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->totals }}</td>
                    <td>{{ $nomor }}</td>
                    {{$nomor++}}
                </tr>
                @endforeach
                
            </tbody>
        </table>
    @endforeach
</body>
</html>