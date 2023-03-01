<table class="table table-bordered" id="datatable">
    @foreach($penilaian as $valkey => $val)
    <thead>
        <tr>
            <th>
                Penilaian {{$val->nama_penilaian}}
            </th>
            <th>
                Tanggal {{$val->tanggal}}
            </th>
        </tr>
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
        <tr></tr>

    </tbody>
    @endforeach
    @if(isset($guru))
    <tbody>
        <tr>
            @if(isset($firstmonth) && isset($lastmonth) && isset($firstyear) && isset($lastyear))
            <td>
            Jumlah Total Penilaian Dari Bulan {{$firstmonth}}-{{$firstyear}}
            </td>
            <td>
            Sampai dengan Bulan {{$lastmonth}}-{{$lastyear}}
            </td>
            @elseif(isset($firstyear) && isset($lastyear))
            <td>
            Jumlah Total Penilaian Dari Tahun {{$firstyear}}
            </td>
            <td>
            Sampai dengan Tahun {{$lastyear}}
            </td>
            @elseif(isset($firstmonth) && isset($lastmonth))
            <td>
            Jumlah Total Penilaian Dari Bulan {{$firstmonth}}-{{$now}}
            </td>
            <td>
            Sampai dengan Bulan {{$lastmonth}}-{{$now}}
            </td>
            @elseif(isset($firstyear))
            <td>
                Jumlah Total Penilaian Dari Tahun {{$firstyear}}
            </td>
            @elseif(isset($lastyear))
            <td>
                Jumlah Total Penilaian Dari Tahun {{$lastyear}}
            </td>
        </tr>
        @endif
        <tr>
            <th>Nama</th>
            <th>Totals</th>
            <th>Rangking</th>
        </tr>
        <?php
        $nomor = 1;
        ?>
        @foreach ($guru as $item)
        <tr>
            <td>{{ $item->name }}</td>
            <td>{{ $item->jumlah_nilai }}</td>
            <td>{{ $nomor }}</td>
            {{$nomor++}}
        </tr>
        @endforeach
        @endif
    </tbody>
</table>