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
                @foreach ($coba1[$key] as $keyy => $itemm)
                <tr>
                    <td>{{ $no++ }}</td>
                    <td>{{ $itemm->name }}</td>
                    <td>{{ $item->name }}</td>
                    <td>{{ $item->nama_kelas }}</td>
                    @foreach ($coba[$keyy] as $keycoba => $p)
                    <td>{{ $p->points }}</td>
                    @endforeach
                </tr>
                @endforeach
                @endforeach
            </tbody>
        </table>