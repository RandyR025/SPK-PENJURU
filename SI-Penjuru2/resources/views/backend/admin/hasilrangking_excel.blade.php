<table class="table table-bordered" id="datatable">
            <thead>
                <tr>
                    <th>Nama</th>
                    <th>Totals</th>
                    <th>Rangking</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jumlah_total as  $item)
                <tr>
                    <td>{{ $item->name }}</td>
                    <td>{{$item->totals}}</td>
                    <td>{{$no ++}}</td>
                </tr>
                @endforeach
            </tbody>
        </table>