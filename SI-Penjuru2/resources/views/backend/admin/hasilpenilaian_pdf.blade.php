<!DOCTYPE html>
<html>
<head>
	<title>{{$data}}</title>
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
 
	<table class="table table-bordered" id="datatable">
        @if($cek == "guru")
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    @foreach($pengisian as $data)
                    <?php
                    $tes = json_decode($data->level);
                    ?>
                    @if (property_exists( $tes, 'guru'))
                    <th>{{$data->nama_subkriteria}}</th>
                    @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($coba1 as $key => $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->name }}</td>
                    @foreach ($coba[$key] as $keycoba => $p)
                    <td>{{$p->nama_pilihan}} ({{ $p->points }})</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
            @endif
            @if($cek == "kepsek")
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    @foreach($pengisian as $data)
                    <?php
                    $tes = json_decode($data->level);
                    ?>
                    @if (property_exists( $tes, 'kepalasekolah'))
                    <th>{{$data->nama_subkriteria}}</th>
                    @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($coba1 as $key => $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->name }}</td>
                    @foreach ($coba[$key] as $keycoba => $p)
                    <td>{{$p->nama_pilihan}} ({{ $p->points }})</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
            @endif
            @if($cek == "wali")
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    <th>Nama Guru</th>
                    <th>Kelas</th>
                    @foreach($pengisian as $data)
                    <?php
                    $tes = json_decode($data->level);
                    ?>
                    @if (property_exists( $tes, 'wali'))
                    <th>{{$data->nama_pengisian}}</th>
                    @endif
                    @endforeach
                </tr>
            </thead>
            <tbody>
                @foreach ($wali_kelas as $key => $item)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $item->wali }}</td>
                    <td>{{ $item->guru }}</td>
                    <td>{{ $item->nama_kelas }}</td>
                    @foreach ($coba[$key] as $keycoba => $p)
                    <td>{{$p->nama_pilihan}} ({{ $p->points }})</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
            @endif
        </table>
 
</body>
</html>