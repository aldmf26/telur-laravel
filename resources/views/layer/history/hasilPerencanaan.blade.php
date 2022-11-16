<style>
    .freeze {
        position: sticky;
        top: 0px;
        z-index: 100;

    }

    .end {
        z-index: 20;
    }
</style>
<div class="row">
    <div class="col-lg-12 freeze">
        <div class="card">
            <div class="card-body">
                <h5 style="color: #787878; font-weight: bold;">Perencanaan : {{ $kandang->nm_kandang }} ({{ date('d-m-Y', strtotime($tgl_per)) }})</h5>
                <h4 style="color: #787878; font-weight: bold;">Populasi : {{ empty($populasi->populasi) ? 0 : $populasi->populasi }} | Pakan/Gr : {{ empty($pakan->total) && empty($populasi->populasi) ? 0 :  number_format(($pakan->total / $populasi->populasi) * 1000, 0) }} | {{ $umur->mgg + 1 }} Minggu</h4>
                <a href="" data-target="#edit_perencanaan" id_kandang="<?= $id_kandang ?>" tgl="<?= $tgl_per ?>" data-toggle="modal" class="btn btn-sm btn-primary float-right " id="edit_per">Edit</a>
            </div>
        </div>
    </div>
    <div class="col-lg-12 end"></div>
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h4 style="color: #787878;">
                    <?php if (empty($pakan1->gr)) : ?>
                    <?php else : ?>
                        <?= $pakan1->gr ?> Karung <?= $pakan1->karung ?> Kg
                    <?php endif ?>

                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table border="1">
                        <thead style="font-family: Helvetica; color: #78909C; text-transform: uppercase;">
                            <tr>
                                <th style="font-size: 12px;background-color: #BDEED9">Pakan</th>
                                <th style="font-size: 12px;background-color: #BDEED9">Qty</th>
                                <th style="font-size: 12px;background-color: #BDEED9">Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pakan2 as $p)
                                <tr>
                                    <td style="font-size: 12px;">{{ $p->nm_pakan }} <br></td>
                                    <td style="font-size: 12px;">{{ number_format((($p->persen / 100) * $pakan1->karung), 2)  }} </td>
                                    <td style="font-size: 12px;">Kg</td>
                                </tr>
                            @endforeach
                        </tbody>
                        <thead style="font-family: Helvetica; color: #78909C; text-transform: uppercase;">
                            <tr>
                                <th style="font-size: 12px;background-color: #BDEED9">Obat</th>
                                <th style="font-size: 12px;background-color: #BDEED9">Qty</th>
                                <th style="font-size: 12px;background-color: #BDEED9">Satuan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($obat1 as $o)
                                <tr>
                                    <td style="font-size: 12px;">{{ $o->nm_obat }} <br></td>
                                    <td style="font-size: 12px;">{{ number_format(($o->dosis * $pakan1->karung) / $o->campuran, 2)  }} </td>
                                    <td style="font-size: 12px;">Kg</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4 end">
        <div class="card">
            <div class="card-header">
                @if (empty($pakan1->gr2))
                @else
                    <h4 style="color: #787878;">1 Karung <?= $pakan1->gr2 ?> Kg</h4>
                @endif
            </div>
            <div class="card-body">
                <table border="1">
                    <thead style="font-family: Helvetica; color: #78909C; background-color: #BDEED9; font-weight: 700; box-shadow: 0px 1px 3px 0px #cccccc;text-transform: uppercase;">
                        <tr>
                            <th style="font-size: 12px;background-color: #BDEED9">Pakan</th>
                            <th style="font-size: 12px;background-color: #BDEED9">Qty</th>
                            <th style="font-size: 12px;background-color: #BDEED9">Satuan</th>
                        </tr>
                    </thead>
                    @php
                        $ttl = 0;
                    @endphp
                    <tbody>
                        @foreach ($pakan2 as $k)
                            @php
                                $ttl += $p->gr_pakan;
                            @endphp
                            <tr>
                                <td style="font-size: 12px;"><?= $p->nm_pakan ?></td>
                                <td style="font-size: 12px;"><?= number_format($p->gr_pakan, 2)  ?></td>
                                <td style="font-size: 12px;">Kg</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <thead style="font-family: Helvetica; color: #78909C; background-color: #F4F8F9; font-weight: 700; box-shadow: 0px 1px 3px 0px #cccccc;text-transform: uppercase;">
                        <tr>
                            <th style="font-size: 12px; background-color: #BDEED9; ">Obat</th>
                            <th style="font-size: 12px;background-color: #BDEED9; ">Qty</th>
                            <th style="font-size: 12px;background-color: #BDEED9; ">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($obat1 as $o) : ?>
                            <tr>
                                <td style="font-size: 12px;"><?= $o->nm_obat ?></td>
                                <td style="font-size: 12px;"><?= number_format($o->dosis * $ttl, 1) ?> </td>
                                <td style="font-size: 12px;"><?= $o->satuan ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <div class="col-lg-4 end">
        <div class="card">
            <div class="card-header">
                @if (empty($pakan1->gr2))
                @else
                <h4 style="color: #787878;">Total Pakan</h4>
                @endif
            </div>
            <div class="card-body">
                <table border="1">
                    <thead style="font-family: Helvetica; color: #78909C; background-color: #BDEED9; font-weight: 700; box-shadow: 0px 1px 3px 0px #cccccc;text-transform: uppercase;">
                        <tr>
                            <th style="font-size: 12px;background-color: #BDEED9">Pakan</th>
                            <th style="font-size: 12px;background-color: #BDEED9">Qty</th>
                            <th style="font-size: 12px;background-color: #BDEED9">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $ttl = 0;
                        @endphp
                        @foreach ($pakan2 as $p)
                            @php
                                $ttl += $p->gr_pakan;
                            @endphp
                            <tr>
                                <td style="font-size: 12px;"><?= $p->nm_pakan ?></td>
                                <td style="font-size: 12px;"><?= number_format($p->gr_pakan, 2)  ?></td>
                                <td style="font-size: 12px;">Kg</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <thead style="font-family: Helvetica; color: #78909C; background-color: #F4F8F9; font-weight: 700; box-shadow: 0px 1px 3px 0px #cccccc;text-transform: uppercase;">
                        <tr>
                            <th style="font-size: 12px; background-color: #BDEED9; ">Obat</th>
                            <th style="font-size: 12px;background-color: #BDEED9; ">Qty</th>
                            <th style="font-size: 12px;background-color: #BDEED9; ">Satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($obat1 as $o)
                            <tr>
                                <td style="font-size: 12px;">{{ $o->nm_obat }}</td>
                                <td style="font-size: 12px;">{{ number_format($o->dosis * $ttl, 1) }} </td>
                                <td style="font-size: 12px;">{{ $o->satuan }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                
            </div>
        </div>
    </div>

    <div class="col-lg-4 end">
        <div class="table-responsive">
            <table border="1">
                <thead style="font-family: Helvetica; color: #78909C; background-color: #F4F8F9; font-weight: 700; box-shadow: 0px 1px 3px 0px #cccccc;text-transform: uppercase;">
                    <tr>
                        <th colspan="7" style="color: red;">obat/ayam</th>
                    </tr>
                    <tr>
                        <th style="font-size: 12px;background-color: #F5B4C5; color: white;">Obat</th>
                        <th style="font-size: 12px;background-color: #F5B4C5; color: white;">Dosis</th>
                        <th style="font-size: 12px;background-color: #F5B4C5; color: white;">Satuan</th>
                    </tr>
                </thead>
                <tbody style="color: #787878; font-family:  Helvetica;">
                    @if (empty($obat_ayam))
                        <tr>
                            <td style="font-size: 12px; text-align: center;" colspan="7">Data tidak ada</td>
                        </tr>
                    @else
                        @foreach ($obat_ayam as $o)
                            <tr>
                                <td style="font-size: 12px;">{{ $o->nm_obat }}</td>
                                <td style="font-size: 12px;">{{ number_format($o->dosis, 0) }}</td>
                                <td style="font-size: 12px;">{{ $o->satuan }}</td>
                            </tr>
                        @endforeach
                    @endif
                    
                </tbody>
            </table>
        </div>
    </div>
    
    <div class="col-lg-12 mt-3 end">
        <div class="table-responsive">
            <table border="1">
                <thead style="font-family: Helvetica; color: #78909C; background-color: #F4F8F9; font-weight: 700; box-shadow: 0px 1px 3px 0px #cccccc;text-transform: uppercase;">
                    <tr>
                        <th colspan="8" style="color: red;">obat/vit dengan campuran air</th>
                    </tr>
                    <tr>
                        <th style="font-size: 12px;background-color: #F5B4C5; color: white;">Obat</th>
                        <th style="font-size: 12px;background-color: #F5B4C5; color: white;">Dosis</th>
                        <th style="font-size: 12px;background-color: #F5B4C5; color: white;">Satuan</th>
                        <th style="font-size: 12px;background-color: #F5B4C5; color: white;">Campuran</th>
                        <th style="font-size: 12px;background-color: #F5B4C5; color: white;">Satuan</th>
                        <th style="font-size: 12px;background-color: #F5B4C5; color: white;">Waktu</th>
                        <th style="font-size: 12px;background-color: #F5B4C5; color: white;">Ket</th>
                        <th style="font-size: 12px;background-color: #F5B4C5; color: white;">Cara Pemakaian</th>
                    </tr>
                </thead>
                <tbody style="color: #787878; font-family:  Helvetica;">
                    @if (empty($obt_air))
                        <tr>
                            <td style="font-size: 12px; text-align: center;" colspan="8">Data tidak ada</td>
                        </tr>
                    @else
                        @foreach ($obat_air as $o)
                            <tr>
                                <td style="font-size: 12px;">{{ $o->nm_obat }}</td>
                                <td style="font-size: 12px;">{{ $o->dosis }}</td>
                                <td style="font-size: 12px;">{{ $o->satuan }}</td>
                                <td style="font-size: 12px;">{{ $o->campuran }}</td>
                                <td style="font-size: 12px;">{{ $o->satuan2 }}</td>
                                <td style="font-size: 12px;">{{ $o->waktu }}</td>
                                <td style="font-size: 12px;">{{ $o->ket }}</td>
                                <td style="font-size: 12px;">{{ $o->cara }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>

</div>