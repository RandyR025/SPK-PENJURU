<table class="table table-bordered" id="datatable">
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
                    <td>{{ $p->points }}</td>
                    @endforeach
                </tr>
                @endforeach
            </tbody>
        </table>