<?php

use App\Models\Hasil;
use App\Models\Hasilpilihan;
use App\Models\Perbandingankriteria;
use App\Models\Perbandingansubkriteria;
use App\Models\Pvkriteria;
use App\Models\Pvsubkriteria;
use Illuminate\Support\Facades\DB;

function getKriteriaID($no_urut)
{
    $query = DB::table('kriteria')->select('kode_kriteria')->orderBy('kode_kriteria')->get();
    // $query = DB::select("SELECT kode_kriteria FROM kriteria ORDER BY kode_kriteria");
    foreach ($query as $row) {
        $listID[] = $row->kode_kriteria;
    }
    if (isset($listID[($no_urut)])) {
        # code...
        return $listID[($no_urut)];
    }else {
        return "Data Tidak Ada";
    }
}

function getSubkriteriaID($no_urut, $id)
{
    $query = DB::table('subkriteria')->select('kode_subkriteria')->where('kode_kriteria','=',$id)->orderBy('kode_kriteria')->get();
    // $query = DB::select("SELECT kode_kriteria FROM kriteria ORDER BY kode_kriteria");
    foreach ($query as $row) {
        $listID[] = $row->kode_subkriteria;
    }
    if (isset($listID[($no_urut)])) {
        # code...
        return $listID[($no_urut)];
    }else {
        return "Data Tidak Ada";
    }
}

function getKriteriaNama($no_urut)
{
    $query = DB::table('kriteria')->select('nama_kriteria')->orderBy('kode_kriteria')->get();
    // $query = DB::select("SELECT nama_kriteria FROM kriteria ORDER BY kode_kriteria");
    foreach ($query as $row) {
        $nama[] = $row->nama_kriteria;
    }
    return $nama[($no_urut)];
}

function getSubkriteriaNama($no_urut,$id)
{
    $query = DB::table('subkriteria')->select('nama_subkriteria')->where('kode_kriteria','=',$id)->orderBy('kode_kriteria')->get();
    // $query = DB::select("SELECT nama_kriteria FROM kriteria ORDER BY kode_kriteria");
    foreach ($query as $row) {
        $nama[] = $row->nama_subkriteria;
    }
    return $nama[($no_urut)];
}

function getKriteriaPv($id_kriteria)
{
    $query = DB::table('pv_kriteria')->select('nilai_kriteria')->where('id_kriteria','=',$id_kriteria)->get();
    foreach ($query as $row) {
        $pv = $row->nilai;
    }
    return $pv;
}

function getSubkriteriaPv($id_subkriteria, $id_kriteria)
{
    $query = DB::table('pv_subkriteria')->select('nilai_subkriteria')->where([['id_subkriteria','=',$id_subkriteria],['id_kriteria','=',$id_kriteria],])->get();
    foreach ($query as $row) {
        $pv = $row->nilai;
    }
    return $pv;
}

function inputKriteriaPv($id_kriteria,$pv)
{
    $query = Pvkriteria::where([
        ['id_kriteria','=',$id_kriteria],
    ])->count();
    
    if ($query == 0) {
        $queryy = new Pvkriteria;
        $queryy->id_kriteria = $id_kriteria;
        $queryy->nilai_kriteria = $pv;
        $queryy->save();
    }else {
        Pvkriteria::where([
            ['id_kriteria','=',$id_kriteria],
        ])->update(['nilai_kriteria'=> $pv]);
    }
}

function inputSubkriteriaPv($id_subkriteria,$pv,$id_kriteria)
{
    $query = Pvsubkriteria::where([
        ['id_subkriteria','=',$id_subkriteria],
        ['id_kriteria','=',$id_kriteria],
    ])->count();
    
    if ($query == 0) {
        $queryy = new Pvsubkriteria;
        $queryy->id_subkriteria = $id_subkriteria;
        $queryy->nilai_subkriteria = $pv;
        $queryy->id_kriteria = $id_kriteria;
        $queryy->save();
    }else {
        Pvsubkriteria::where([
            ['id_subkriteria','=',$id_subkriteria],
            ['id_kriteria','=',$id_kriteria],
        ])->update(['nilai_subkriteria'=> $pv]);
    }
}

function getNilaiIR($jmlKriteria)
{
    $query = DB::table('ir')->select('nilai')->where('jumlah','=',$jmlKriteria)->get();
    foreach ($query as $row) {
        $nilaiIR = $row->nilai;
    }
    return $nilaiIR;
}

function getEigenVector($matrik_a,$matrik_b,$n) {
	$eigenvektor = 0;
	for ($i=0; $i <= ($n-1) ; $i++) {
		$eigenvektor += ($matrik_a[$i] * (($matrik_b[$i]) / $n));
	}

	return $eigenvektor;
}

function getConsIndex($matrik_a,$matrik_b,$n) {
	$eigenvektor = getEigenVector($matrik_a,$matrik_b,$n);
	$consindex = ($eigenvektor - $n)/($n-1);

	return $consindex;
}

function getConsRatio($matrik_a,$matrik_b,$n) {
	$consindex = getConsIndex($matrik_a,$matrik_b,$n);
	$consratio = $consindex / getNilaiIR($n);

	return $consratio;
}

function getJumlahKriteria(){
    $query = DB::table('kriteria')->select(DB::raw('count(*) as jumlah'))->get();
    // $query = DB::select("SELECT count(*) FROM kriteria");
    foreach ($query as $row) {
        $jmlData = $row->jumlah;
    }
    return $jmlData;
}

function getJumlahSubkriteria($id){
    $query = DB::table('subkriteria')->select(DB::raw('count(*) as jumlah'))->where('kode_kriteria','=',$id)->get();
    // $query = DB::select("SELECT count(*) FROM kriteria");
    foreach ($query as $row) {
        $jmlData = $row->jumlah;
    }
    return $jmlData;
}

function inputDataPerbandinganKriteria($kriteria1, $kriteria2, $nilai)
{
    $id_kriteria1 = getKriteriaID($kriteria1);
	$id_kriteria2 = getKriteriaID($kriteria2);
    $query = Perbandingankriteria::where([
        ['kriteria_pertama','=',$id_kriteria1],
        ['kriteria_kedua','=',$id_kriteria2],
    ])->count();
    // $query = DB::select("SELECT * FROM perbandingan_kriteria WHERE kriteria_pertama = $id_kriteria1 AND kriteria_kedua = $id_kriteria2")->count();

    if ($query == 0) {
        $queryy = new Perbandingankriteria;
        $queryy->kriteria_pertama = $id_kriteria1;
        $queryy->kriteria_kedua = $id_kriteria2;
        $queryy->value = $nilai;
        $queryy->save();
        // $query = DB::insert("INSERT INTO perbandingan_kriteria (kriteria_pertama,kriteria_kedua,nilai) VALUES ($id_kriteria1,$id_kriteria2,$nilai)");
    }else {
        Perbandingankriteria::where([
            ['kriteria_pertama','=',$id_kriteria1],
            ['kriteria_kedua','=',$id_kriteria2],
        ])->update(['value'=> $nilai]);
        // $query = DB::update("UPDATE perbandingan_kriteria SET nilai=$nilai WHERE kriteria_pertama=$id_kriteria1 AND kriteria_kedua=$id_kriteria2");
    }
}

function inputDataPerbandinganSubkriteria($kriteria1, $kriteria2, $nilai, $id_kriteria)
{
    $id_kriteria1 = getSubkriteriaID($kriteria1, $id_kriteria);
	$id_kriteria2 = getSubkriteriaID($kriteria2, $id_kriteria);
    $query = Perbandingansubkriteria::where([
        ['subkriteria_pertama','=',$id_kriteria1],
        ['subkriteria_kedua','=',$id_kriteria2],
        ['id_kriteria','=',$id_kriteria],
    ])->count();
    // $query = DB::select("SELECT * FROM perbandingan_kriteria WHERE kriteria_pertama = $id_kriteria1 AND kriteria_kedua = $id_kriteria2")->count();

    if ($query == 0) {
        $queryy = new Perbandingansubkriteria;
        $queryy->subkriteria_pertama = $id_kriteria1;
        $queryy->subkriteria_kedua = $id_kriteria2;
        $queryy->id_kriteria = $id_kriteria;
        $queryy->value = $nilai;
        $queryy->save();
        // $query = DB::insert("INSERT INTO perbandingan_kriteria (kriteria_pertama,kriteria_kedua,nilai) VALUES ($id_kriteria1,$id_kriteria2,$nilai)");
    }else {
        Perbandingansubkriteria::where([
            ['subkriteria_pertama','=',$id_kriteria1],
            ['subkriteria_kedua','=',$id_kriteria2],
            ['id_kriteria','=',$id_kriteria],
        ])->update(['value'=> $nilai]);
        // $query = DB::update("UPDATE perbandingan_kriteria SET nilai=$nilai WHERE kriteria_pertama=$id_kriteria1 AND kriteria_kedua=$id_kriteria2");
    }
}

function getNilaiPerbandinganKriteria($kriteria1,$kriteria2)
{
    $id_kriteria1 = getKriteriaID($kriteria1);
	$id_kriteria2 = getKriteriaID($kriteria2);

    $query = DB::table('perbandingan_kriteria')->select('value')->where('kriteria_pertama','=',$id_kriteria1)->where('kriteria_kedua','=', $id_kriteria2)->get()->count();
    // $query = DB::select("SELECT nilai FROM perbandingan_kriteria WHERE kriteria_pertama = $id_kriteria1 AND kriteria_kedua = $id_kriteria2")->count();
    
    if ($query == 0) {
        $nilai = 1;
    }else {
        if (is_array($query)||is_object($query)) {
            foreach ($query as $row) {
                $nilai = $row->nilai;
                return $nilai;
            }
        }
    }
}

function getNilaiPerbandinganSubkriteria($kriteria1,$kriteria2,$id_kriteria)
{
    $id_kriteria1 = getSubkriteriaID($kriteria1,$id_kriteria);
	$id_kriteria2 = getSubkriteriaID($kriteria2,$id_kriteria);

    $query = DB::table('perbandingan_subkriteria')->select('value')->where('subkriteria_pertama','=',$id_kriteria1)->where('subkriteria_kedua','=', $id_kriteria2)->where('id_kriteria','=',$id_kriteria)->get()->count();
    // $query = DB::select("SELECT nilai FROM perbandingan_kriteria WHERE kriteria_pertama = $id_kriteria1 AND kriteria_kedua = $id_kriteria2")->count();
    
    if ($query == 0) {
        $nilai = 1;
    }else {
        if (is_array($query)||is_object($query)) {
            foreach ($query as $row) {
                $nilai = $row->nilai;
                return $nilai;
            }
        }
    }
}

function showTabelPerbandingan($jenis, $kriteria)
{
    if ($kriteria == 'kriteria') {
        $n = getJumlahKriteria();
    }else {
        $n = getJumlahKriteria();
    }
    $query = DB::table('kriteria')->select('nama_kriteria')->orderBy('kode_kriteria')->get();
    // $query = DB::select("SELECT nama_kriteria FROM $kriteria ORDER BY kode_kriteria");

    foreach ($query as $row) {
        $pilihan[] = $row->nama_kriteria;
    }
    ?>
    <form class="ui form" action="/perbandinganproses" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
	<table class="ui celled selectable collapsing table">
		<thead>
			<tr>
				<th colspan="2">Pilih Yang Lebih Penting</th>
				<th>Nilai Perbandingan</th>
			</tr>
		</thead>
		<tbody>
    <?php
    $urut = 0;

    for ($x=0; $x <= ($n-2) ; $x++) { 
        for ($y=($x+1); $y <= ($n-1) ; $y++) { 
            $urut++;
            ?>
            <tr>
				<td>
					<div class="field">
						<div class="ui radio checkbox">
							<input name="pilih<?php echo $urut?>" value="1" checked="" class="form-check-input" type="radio">
							<label><?php echo $pilihan[$x]; ?></label>
						</div>
					</div>
				</td>
				<td>
					<div class="field">
						<div class="ui radio checkbox">
							<input name="pilih<?php echo $urut?>" value="2" class="form-check-input" type="radio">
							<label><?php echo $pilihan[$y]; ?></label>
						</div>
					</div>
				</td>
				<td>
					<div class="field">
            <?php
            if ($kriteria == 'kriteria') {
                $nilai = getNilaiPerbandinganKriteria($x,$y);
            } else {
                // $nilai = getNilaiPerbandinganAlternatif($x,$y,($jenis-1));
            }
        
            ?>
                                <input type="text" name="bobot<?php echo $urut?>" class="form-control w-33" value="<?php echo $nilai?>" required>
                            </div>
                        </td>
                    </tr>
                    <?php
        }
    }
    ?>
		</tbody>
	</table>
	<input type="text" name="jenis" value="<?php echo $jenis; ?>" hidden>
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-outline-primary btn-icon btn-icon-end sw-25" type="submit" name="submit" value="SUBMIT">
                <span>Comparrisson</span>
                <i data-acorn-icon="check"></i>
            </button>
        </div>
    </div>
	</form>

	<?php
}

function showTabelSubPerbandingan($jenis, $kriteria, $id)
{
    if ($kriteria == 'kriteria') {
        $n = getJumlahSubkriteria($id);
    }else {
        $n = getJumlahSubkriteria($id);
    }
    $query = DB::table('subkriteria')->select('nama_subkriteria')->where('kode_kriteria','=',$id)->orderBy('kode_subkriteria')->get();
    // $query = DB::select("SELECT nama_kriteria FROM $kriteria ORDER BY kode_kriteria");

    foreach ($query as $row) {
        $pilihan[] = $row->nama_subkriteria;
    }
    ?>
    <form class="ui form" action="/subperbandinganproses" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
	<table class="ui celled selectable collapsing table">
		<thead>
			<tr>
				<th colspan="2">Pilih Yang Lebih Penting</th>
				<th>Nilai Perbandingan</th>
			</tr>
		</thead>
		<tbody>
    <?php
    $urut = 0;

    for ($x=0; $x <= ($n-2) ; $x++) { 
        for ($y=($x+1); $y <= ($n-1) ; $y++) { 
            $urut++;
            ?>
            <tr>
				<td>
					<div class="field">
						<div class="ui radio checkbox">
							<input name="pilih<?php echo $urut?>" value="1" checked="" class="form-check-input" type="radio">
							<label><?php echo $pilihan[$x]; ?></label>
						</div>
					</div>
				</td>
				<td>
					<div class="field">
						<div class="ui radio checkbox">
							<input name="pilih<?php echo $urut?>" value="2" class="form-check-input" type="radio">
							<label><?php echo $pilihan[$y]; ?></label>
						</div>
					</div>
				</td>
				<td>
					<div class="field">
            <?php
            if ($kriteria == 'kriteria') {
                $nilai = getNilaiPerbandinganSubkriteria($x,$y,$id);
            } else {
                // $nilai = getNilaiPerbandinganAlternatif($x,$y,($jenis-1));
            }
        
            ?>
                                <input type="text" name="bobot<?php echo $urut?>" class="form-control w-33" value="<?php echo $nilai?>" required>
                            </div>
                        </td>
                    </tr>
                    <?php
        }
    }
    ?>
		</tbody>
	</table>
    <input type="text" name="id" value="<?php echo $id; ?>" hidden>
	<input type="text" name="jenis" value="<?php echo $jenis; ?>" hidden>
    <div class="row">
        <div class="col-12 text-center">
            <button class="btn btn-outline-primary btn-icon btn-icon-end sw-25" type="submit" name="submit" value="SUBMIT">
                <span>Comparrisson</span>
                <i data-acorn-icon="check"></i>
            </button>
        </div>
    </div>
	</form>

	<?php
}

function bantuan($matrik)
{
    // $n = getJumlahKriteria();
    // for ($x=0; $x <= ($n-1); $x++) { 
    //     echo "<tr>";
    //     echo "<td>".getKriteriaNama($x)."</td>";
    //     for ($y=0; $y <= ($n-1); $y++) { 
    //         $tampil = "<td>{{round($matrik[$x][$y],5).}}</td>";
    //         echo $tampil;
    //     }
    // }

    // return $tampil;
}


function hasilPilihan($pilihan,$user){
    $query = Hasilpilihan::where([
        ['user_id','=',$user],
        ['kode_pilihan','=',$pilihan],
    ])->count();
    if ($query == 1) {
        return true;
    }else {
        return false;
    }
}


function cekPenilaian($penilaian, $user){
    $query = Hasil::where([
        ['user_id','=',$user],
        ['id_penilaian','=',$penilaian],
    ])->count();
    if ($query == 1) {
        return true;
    }else {
        return false;
    }
}