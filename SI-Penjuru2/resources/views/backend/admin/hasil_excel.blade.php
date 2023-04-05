<table class="table table-bordered" id="datatable">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Nama</th>
                    @foreach($pengisian as $data)
                    <?php
                    $tes = json_decode($data->level);
                    ?>
                    @if (property_exists( $tes, 'guru'))
                    <th>{{$data->nama_pengisian}}</th>
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
        </table>