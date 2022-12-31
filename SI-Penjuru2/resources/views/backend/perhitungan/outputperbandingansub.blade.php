@extends('backend/layouts.template')
@section('titlepage')
Perbandingan Kriteria
@endsection
@section('title')
Perhitungan
@endsection
@section('content')

@if(session()->has('success'))
<div class="alert alert-primary" role="alert">{{ session('success')}}</div>
@endif

@if(session()->has('loginError'))
<div class="alert alert-danger" role="alert">{{ session('loginError')}}</div>
@endif
<div id="success_message"></div>
<!-- Content End -->
<div class="container">
    <div class="row">
        <h3 class="ui header">Matriks Perbandingan Sub Kriteria Berpasangan</h3>
        <table class="ui collapsing celled blue table">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <?php
                    $n = getJumlahSubkriteria($id);
                    for ($i = 0; $i <= ($n - 1); $i++) {
                        echo "<th>" . getSubkriteriaNama($i,$id) . "</th>";
                    }
                    ?>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($x = 0; $x <= ($n - 1); $x++) {
                    echo "<tr>";
                    echo "<td>" . getSubkriteriaNama($x,$id) . "</td>";
                    for ($y = 0; $y <= ($n - 1); $y++) {
                        echo "<td>" . round($matrik[$x][$y], 5) . "</td>";
                    }

                    echo "</tr>";
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <th>Jumlah</th>
                    <?php
                    for ($i = 0; $i <= ($n - 1); $i++) {
                        echo "<th>" . round($jmlmpb[$i], 5) . "</th>";
                    }
                    ?>
                </tr>
            </tfoot>

        </table>

        <br>


        <h3 class="ui header mt-4">Matriks Nilai Kriteria</h3>
        <table class="ui celled red table">
            <thead>
                <tr>
                    <th>Kriteria</th>
                    <?php
                    for ($i = 0; $i <= ($n - 1); $i++) {
                        echo "<th>" . getSubkriteriaNama($i,$id) . "</th>";
                    }
                    ?>
                    <th>Jumlah</th>
                    <th>Priority Vector</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($x = 0; $x <= ($n - 1); $x++) {
                    echo "<tr>";
                    echo "<td>" . getSubkriteriaNama($x,$id) . "</td>";
                    for ($y = 0; $y <= ($n - 1); $y++) {
                        echo "<td>" . round($matrikb[$x][$y], 5) . "</td>";
                    }

                    echo "<td>" . round($jmlmnk[$x], 5) . "</td>";
                    echo "<td>" . round($pv[$x], 5) . "</td>";

                    echo "</tr>";
                }
                ?>

            </tbody>
            <tfoot>
                <tr>
                    <th colspan="<?php echo ($n + 2) ?>">Principe Eigen Vector (λ maks)</th>
                    <th><?php echo (round($eigenvektor, 5)) ?></th>
                </tr>
                <tr>
                    <th colspan="<?php echo ($n + 2) ?>">Consistency Index</th>
                    <th><?php echo (round($consIndex, 5)) ?></th>
                </tr>
                <tr>
                    <th colspan="<?php echo ($n + 2) ?>">Consistency Ratio</th>
                    <th><?php echo (round(($consRatio * 100), 2)) ?> %</th>
                </tr>
            </tfoot>
        </table>

        <?php
        if ($consRatio > 0.1) {
            ?>
            <section class="scroll-section" id="dismissing">
                <h2 class="small-title">Peringatan</h2>
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                            <strong>Nilai Consistency Ratio melebihi 10% !!!</strong> &nbsp;
                            Mohon input kembali tabel perbandingan...
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </section>

            <br>

            <a href='javascript:history.back()'>
                <div class="row">
                    <div class="col-12 text-center">
                        <button class="btn btn-outline-primary btn-icon btn-icon-end sw-25">
                            <span>Kembali</span>
                            <i data-acorn-icon="check"></i>
                        </button>
                    </div>
                </div>
            </a>

        <?php
        } else {

            ?>
            <br>
            <section class="scroll-section" id="dismissing">
                <div class="card">
                    <div class="card-body">
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <strong>Nilai Consistency Ratio Tidak Melebihi 10% !!!</strong> &nbsp;
                            Silahkan Lanjutkan Proses Perhitungan...
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                </div>
            </section>
            <a href="bobot.php?c=1">
                <div class="col-12 text-center">
                    <button class="btn btn-outline-primary btn-icon btn-icon-end sw-25">
                        <span>Lanjut</span>
                        <i data-acorn-icon="check"></i>
                    </button>
                </div>
            </a>

        <?php
        }
        ?>
    </div>
</div>

<!-- <script src="https://code.jquery.com/jquery-3.5.1.js"></script> -->
<!-- <script src="{{asset('backend/js/vendor/jquery-3.5.1.min.js')}}"></script> -->
<!-- <script src="cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js"></script> -->
<!-- <script src="{{asset('js/Guru.js')}}"></script> -->
<!-- <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->

<script type="text/javascript">
    function sum(no) {
        var txtkriteriavalue = document.getElementById('hkriteria' + no).value;
        var result = 1 / parseFloat(txtkriteriavalue);
        if (!isNaN(result)) {
            document.getElementById('hkriteriaterbalik' + no).value = result.toFixed(2);
        }
    }
</script>

@endsection