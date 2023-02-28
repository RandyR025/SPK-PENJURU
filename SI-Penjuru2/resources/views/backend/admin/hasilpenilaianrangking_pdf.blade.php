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
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Total Nilai</th>
                    <th>Rangking</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jumlah_total as $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{$item->totals}}</td>
                    <td>{{ $no++ }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
 
</body>
</html>