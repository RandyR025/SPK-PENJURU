<table class="table table-bordered" id="datatable">
    @foreach($penilaian as $valkey => $val)
    @foreach ($coba1[$valkey] as $key => $item)
    @if(isset($coba1[$valkey]))
    <thead>
        <tr>
            <th>Laporan:</th>
            <th>{{$val->nama_penilaian}}</th>
        </tr>
        <tr>
            <th>Tanggal:</th>
            <th>{{$val->tanggal}}</th>
        </tr>
        <tr>
        <th>No</th>
        <th>Nama</th>
        @foreach($pengisian[$valkey] as $data)
        <?php
        $tes = json_decode($data->level);
        ?>
        @if (property_exists( $tes, 'guru'))
        <th>{{$data->nama_subkriteria}}</th>
        @endif
        @endforeach
        </tr>
    </thead>
    @endif
    @endforeach
    <tbody>
        <?php
        $nomor =1;
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
    @endforeach
</table>