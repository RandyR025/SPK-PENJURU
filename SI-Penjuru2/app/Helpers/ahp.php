<?php

use App\Models\Hasil;
use App\Models\HasilKepsek;
use App\Models\Hasilpilihan;
use App\Models\HasilPilihanKepsek;
use App\Models\HasilPilihanWali;
use App\Models\HasilWali;
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
    $data = DB::table('perbandingan_kriteria')->select('value')->where('kriteria_pertama','=',$id_kriteria1)->where('kriteria_kedua','=', $id_kriteria2)->get();
    // $query = DB::select("SELECT nilai FROM perbandingan_kriteria WHERE kriteria_pertama = $id_kriteria1 AND kriteria_kedua = $id_kriteria2")->count();
    
    if ($query == 0) {
        $nilai = 1;
    }else {
            foreach ($data as $row) {
                $nilai = $row->value;
                return $nilai;
            }
    }
}

function getNilaiPerbandinganSubkriteria($kriteria1,$kriteria2,$id_kriteria)
{
    $id_kriteria1 = getSubkriteriaID($kriteria1,$id_kriteria);
	$id_kriteria2 = getSubkriteriaID($kriteria2,$id_kriteria);

    $query = DB::table('perbandingan_subkriteria')->select('value')->where('subkriteria_pertama','=',$id_kriteria1)->where('subkriteria_kedua','=', $id_kriteria2)->where('id_kriteria','=',$id_kriteria)->get()->count();
    $data = DB::table('perbandingan_subkriteria')->select('value')->where('subkriteria_pertama','=',$id_kriteria1)->where('subkriteria_kedua','=', $id_kriteria2)->where('id_kriteria','=',$id_kriteria)->get();
    // $query = DB::select("SELECT nilai FROM perbandingan_kriteria WHERE kriteria_pertama = $id_kriteria1 AND kriteria_kedua = $id_kriteria2")->count();
    
    if ($query == 0) {
        $nilai = 1;
    }else {
            foreach ($data as $row) {
                $nilai = $row->value;
                return $nilai;
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
    <a type="button" class="bantuan mb-2" data-bs-toggle="modal" data-bs-target="#largeRightModalExample"><i class="fa-solid fa-circle-question fa-lg" style="color: #141010;"></i><span class="m-2" style="color: black;">Bantuan</span></a>
    <div class="modal modal-right large fade" id="largeRightModalExample" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Petunjukan Penilaian AHP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php guider(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>
    <form class="ui form" action="/perbandinganproses" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
    <div class="row">

        <div class="col comparison">
    
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
                        <td class="col-2">
                            <div class="field">
                    <?php
                    if ($kriteria == 'kriteria') {
                        $nilai = getNilaiPerbandinganKriteria($x,$y);
                    } else {
                        // $nilai = getNilaiPerbandinganAlternatif($x,$y,($jenis-1));
                    }
                
                    ?>
                                        <input type="text" name="bobot<?php echo $urut?>" class="form-control" value="<?php echo $nilai?>" required>
                                    </div>
                                </td>
                            </tr>
                            <?php
                }
            }
            ?>
                </tbody>
            </table>
        </div>
        <div class="col-5 guide">
            <?php guider(); ?>
        </div>
    </div>
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
    <a type="button" class="bantuan mb-2" data-bs-toggle="modal" data-bs-target="#largerRightModalExample"><i class="fa-solid fa-circle-question fa-lg" style="color: #141010;"></i><span class="m-2" style="color: black;">Bantuan</span></a>
    <div class="modal modal-right large fade" id="largerRightModalExample" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Petunjukan Penilaian AHP</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <?php guider(); ?>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Oke</button>
                </div>
            </div>
        </div>
    </div>
    <form class="ui form" action="/subperbandinganproses" method="post">
    <input type="hidden" name="_token" value="<?php echo csrf_token();?>">
    <div class="row">
        <div class="col comparison">
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
                        <td class="col-2">
                            <div class="field">
                    <?php
                    if ($kriteria == 'kriteria') {
                        $nilai = getNilaiPerbandinganSubkriteria($x,$y,$id);
                    } else {
                        // $nilai = getNilaiPerbandinganAlternatif($x,$y,($jenis-1));
                    }
                
                    ?>
                                        <input type="text" name="bobot<?php echo $urut?>" class="form-control" value="<?php echo $nilai?>" required>
                                    </div>
                                </td>
                            </tr>
                            <?php
                }
            }
            ?>
                </tbody>
            </table>
        </div>
        <div class="col-5 guide">
            <?php guider() ?>
        </div>
    </div>
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


function hasilPilihan($pilihan,$user,$tanggal){
    $query = Hasilpilihan::where([
        ['user_id','=',$user],
        ['kode_pilihan','=',$pilihan],
        ['tanggal_id','=',$tanggal],
    ])->count();
    if ($query == 1) {
        return true;
    }else {
        return false;
    }
}

function hasilPilihanWali($pilihan,$guru,$wali,$tanggal){
    $query = HasilPilihanWali::where([
        ['user_id_guru','=',$guru],
        ['user_id_wali','=',$wali],
        ['kode_pilihan','=',$pilihan],
        ['tanggal_id','=',$tanggal],
    ])->count();
    if ($query == 1) {
        return true;
    }else {
        return false;
    }
}
function hasilPilihanKepsek($pilihan,$guru,$kepsek,$tanggal){
    $query = HasilPilihanKepsek::where([
        ['user_id_guru','=',$guru],
        ['user_id_kepsek','=',$kepsek],
        ['kode_pilihan','=',$pilihan],
        ['tanggal_id','=',$tanggal],
    ])->count();
    if ($query == 1) {
        return true;
    }else {
        return false;
    }
}


function cekPenilaian($penilaian, $user, $tgl){
    $query = Hasil::where([
        ['user_id','=',$user],
        ['id_penilaian','=',$penilaian],
        ['tanggal_id','=',$tgl],
    ])->count();
    if ($query == 1) {
        return true;
    }else {
        return false;
    }
}

function cekPenilaianWali($penilaian, $wali, $guru, $tgl){
    $query = HasilWali::where([
        ['user_id_wali','=',$wali],
        ['user_id_guru','=',$guru],
        ['id_penilaian','=',$penilaian],
        ['tanggal_id','=',$tgl],
    ])->count();
    if ($query == 1) {
        return true;
    }else {
        return false;
    }
}

function cekPenilaianKepsek($penilaian, $kepsek, $guru, $tgl){
    $query = HasilKepsek::where([
        ['user_id_kepsek','=',$kepsek],
        ['user_id_guru','=',$guru],
        ['id_penilaian','=',$penilaian],
        ['tanggal_id','=',$tgl],
    ])->count();
    if ($query == 1) {
        return true;
    }else {
        return false;
    }
}

function manipulasiTanggal($tgl,$jumlah=1,$format='days'){
	$currentDate = $tgl;
	return date('Y-m-d', strtotime($jumlah.' '.$format, strtotime($currentDate)));
}
function guider(){
    ?>
    <table class="table table-bordered border-4" style="border-style: solid; border-color: black; ">
            <thead>
                <tr>
                    <th style="text-align: center;" colspan="2">Petunjuk Penilaian AHP</th>
                </tr>
                <tr style="text-align: center;">
                    <th>Nilai Perbandingan</th>
                    <th>Penjelasan</th>
                </tr>
            </thead>
            <tbody>
                <tr style="text-align: center;">
                    <td>1</td>
                    <td>Kedua elemen sama pentingnya</td>
                </tr>
                <tr style="text-align: center;">
                    <td>3</td>
                    <td>Elemen yang satu agak lebih penting (sedikit lebih penting) daripada elemen yang lain.</td>
                </tr>
                <tr style="text-align: center;">
                    <td>5</td>
                    <td>Elemen yang satu lebih penting (cukup penting) daripada elemen yang lain</td>
                </tr>
                <tr style="text-align: center;">
                    <td>7</td>
                    <td>Satu elemen lebih jelas mutlak penting (sangat penting) daripada elemen lainnya</td>
                </tr>
                <tr style="text-align: center;">
                    <td>9</td>
                    <td>Satu elemen ekstrim penting  (mutlak penting) daripada elemen yang lainnya</td>
                </tr>
                <tr style="text-align: center;">
                    <td>2, 4, 6, 8</td>
                    <td>Nilai tengah diantara dua nilai pertimbangan yang saling berdekatan</td>
                </tr>
            </tbody>
          </table>
          <?php
}
?>