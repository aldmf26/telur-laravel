<link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous" />
<link rel="stylesheet" type="text/css" href="//fonts.googleapis.com/css?family=Quicksand" />
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

<style>
    table,
    th,
    td {
        border: 1px solid #50A7BC;
        border-collapse: collapse;
        text-align: center;
        white-space: nowrap;
        font-size: 10px;
        font-family: Arial, Helvetica, sans-serif;
    }


    th,
    td {
        padding: 10px 4px 10px 10px;
        color: #787878;

    }
</style>
<div class="row">
    <div class="col-lg-12">
        <h2 style="text-align: center; color: #787878;">Laporan Layer</h2>
        <div class="table-responsive">
            <table style="white-space: nowrap;" width="100%" style="font-size: 14px; background-color: #fff; border: 2px solid #50A7BC">
                <thead>
                    <tr>
                        <th style="background-color: #BDEED9;" colspan="25">
                            <center>Tanggal : {{date('d.M.y', strtotime($tgl))}}</center>
                        </th>
                    </tr>
                    <tr>
                        <th style="background-color: #BDEED9;" rowspan="2">
                            <center>Kandang </center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>UMUR</center>
                        </th>
                        <th style="background-color: #BDEED9;" colspan="2">
                            <center>POPULASI</center>
                        </th>
                        <th style="background-color: #BDEED9;" colspan="3">
                            <center>PAKAN</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>BERAT BADAN</center>
                        </th>
                        <th style="background-color: #BDEED9;" colspan="8">
                            <center>DATA TELUR</center>
                        </th>
                        <th style="background-color: #BDEED9;" colspan="7">
                            <center>KUML</center>
                        </th>
                    </tr>
                    <tr>
                        <!-- umur -->
                        <th style="background-color: #BDEED9;" align="center">
                            <center>mgg / hari <br> (Afkir 80 minggu)</center>
                        </th>
                        <!-- umur -->
                        <!-- populasi -->
                        <th style="background-color: #BDEED9;">
                            <center>pop awal / pop akhir / %</center>
                        </th>


                        <th style="background-color: #BDEED9;">
                            <center>D/C <br> (>2)</center>
                        </th>
                        <!-- populasi -->
                        <!-- pakan -->
                        <th style="background-color: #BDEED9;">
                            <center>kg</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>gr / p <br> (day)</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>gr (week) / gr (past) </center>
                        </th>

                        <!-- berat badan -->
                        <th style="background-color: #BDEED9; white-space: nowrap;">
                            <center>real/performa</center>
                        </th>
                        <!-- berat badan -->
                        <!-- data telur -->
                        <th style="background-color: #BDEED9;">
                            <center>butir / today - yesterday</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>hh pcs / hh kum <br> (330)</center>
                        </th>

                        <th style="background-color: #BDEED9;">
                            <center>kg / today - yesterday</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>hh kg / hh kg kum <br> (20)</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>gr / p <br>(butir)</center>
                        </th>


                        <th style="background-color: #BDEED9;">
                            <center>hd perday / p <br>(%)</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>hd week / hd past <br>(%)</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>FCR / FCR+ <br> (week)</center>
                        </th>
                        <!-- data telur -->
                        <!-- kuml -->
                        <th style="background-color: #BDEED9;">
                            <center>pakan(kg) </center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>telur(kg)</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>fcr k / fcr k+ (7,676)</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>obat/vit</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>vaksin</center>
                        </th>
                        <th style="background-color: #BDEED9;">
                            <center>Listrik PDAM</center>
                        </th>
                        <!-- kuml -->
                    </tr>
                </thead>
                <tbody>
                    @php
                        $ttlAyamAwal = 0;
                        $ttlAyamPopulasi = 0;
                        $ttlAyamPersen = 0;
                        $ttlD = 0;
                        $ttlC = 0;
                        $ttlKg = 0;
                        $ttlGrWeak = 0;
                        $ttlGrWeak3 = 0;
                        $ttlButir = 0;
                        $ttlKgToday = 0;
                        $tot10 = 0;
                        $ttlPweek2 = 0;
                        $ttlRak = 0;
                        $ttlKu = 0;
                    @endphp
                    @foreach ($layer as $h)
                    @php
                        if($h->mgg < 21) {
                            $jumlah = 0;
                            $ku = 0;
                            $ku1 = 0;
                            $rak = 0;
                        } else {
                            $rak = $h->fcr5 - ($h->fcr6 / 180);
                            $ku = round($h->pweek2, 2) / round($rak, 2);
                            // $ku1 = number_format(, 2);

                            $jumlah = empty($h->tPcsSeminggu) ? 0 : number_format($h->pweek / ($h->tPcsSeminggu - ($h->tKgSeminggu / 180)),1);
                            
                        }
                        
                    @endphp
                        <tr>
                            <td align="center">{{ $h->nm_kandang }}</td>
                            <td align="center">{{ $h->mgg + 1 }} / {{ $h->hari + 1 }} / {{ (($h->mgg + 1) / 80) * 100 }} %</td>
                            @php
                                // $ayam_akhir = DB::selectOne("SELECT sum(populasi) as populasi FROM `tb_populasi` WHERE id_kandang = '$h->id_kandang' AND tgl = '$tgl' ORDER BY tgl DESC LIMIT 1;");
                                $ayam_akhir = DB::selectOne("SELECT dt.id_kandang, dt.death , dt.culling, sum(dt.populasi) as populasi FROM tb_populasi as dt
                                                LEFT JOIN (SELECT MAX(b.tgl) AS tgl_max, b.id_kandang FROM tb_populasi AS b WHERE b.id_kandang = '$h->id_kandang' GROUP BY b.id_kandang) AS mx ON mx.id_kandang = dt.id_kandang
                                                WHERE dt.tgl = mx.tgl_max");
                                $akhir = empty($h->ttlPopulasi) ? $ayam_akhir->populasi : $h->ttlPopulasi;
                                $persen = number_format(($ayam_akhir->populasi / $h->ayam_awal) * 100, 2);

                                $ttlAyamAwal += $h->ayam_awal;
                                $ttlAyamPopulasi += $ayam_akhir->populasi;
                                $ttlAyamPersen += $persen;
                                $ttlD += $h->death;
                                $ttlC += $h->culling;
                                $ttlKg += $h->total;
                                $ttlGrWeak += number_format((($h->pweek * 1000) / $ayam_akhir->populasi)  / 7,0);
                                $ttlGrWeak3 += number_format((($h->pweek3 * 1000) / $ayam_akhir->populasi)  / 7,0);
                                $ttlButir += $h->tHariIni;
                                $ttlKgToday += $h->kHariIni;
                                $tot10 += $h->kHariIni - ($h->tHariIni / 180);
                            @endphp
                            {{-- umur --}}
                            <td align="center">{{ $h->ayam_awal }} / {{ $ayam_akhir->populasi }} / {{ $persen }}</td>
                            {{-- end umur --}}

                            {{-- populasi --}}
                            <td align="center"
                            @if ((($h->death + $h->culling) > '2'))
                            style="background-color: red; color: white;"
                            @endif
                            >{{ $h->death }} / {{ $h->culling }}</td>
                            {{-- end ppulasi --}}

                            {{-- pakan --}}
                            <td>{{ empty($h->total) ? 0 : number_format($h->total,1) }}</td>
                            <td>{{ number_format(($h->total * 1000) / $ayam_akhir->populasi,0) }} / {{ $h->feed }}</td>
                            <td>{{ number_format((($h->pweek * 1000) / $ayam_akhir->populasi)  / 7,0)  }} / {{ number_format((($h->pweek3 * 1000) / $ayam_akhir->populasi)  / 7,0) }}</td>
                            {{-- end pakan --}}
                            <td>0 / {{ $h->berat }} / (28/07)</td>
                            
                            {{-- data telur --}}
                            <td>{{ $h->tHariIni }} / ({{ $h->tHariIni - $h->tHariKemarin }})</td>
                            
                            <td>belum</td>
                            <td>{{ $h->kHariIni }} / ({{ $h->kHariIni - $h->kHariKemarin }})</td>
                            @php
                                $persen = empty($h->kuml3) || empty($h->telpef) ? 0 : number_format(($h->kuml3 / $h->ayam_awal) / ($h->telpef / $h->ayam_awal), 2);
                            @endphp
                            <td>{{ number_format(($h->kHariIni - ($h->tHariIni / 180)) * $h->ayam_awal,2) }} / {{ number_format($h->telpef / $h->ayam_awal,1) }} ({{ number_format($persen * 100, 0) }}%) </td>
                            <td>
                                @if (empty($h->kHariIni))
                                    0 / {{ $h->berat_telur }}
                                @else
                                    {{ number_format(((($h->kHariIni - ($h->tHariIni / 180)) * 1000) / $h->tHariIni), 1) }}
                                    / 
                                    {{ $h->berat_telur }}
                                @endif
                            </td>
                            <td>{{ $ayam_akhir->populasi == 0 ? 0 : number_format(($h->tHariIni / $ayam_akhir->populasi) * 100,1) }} / {{ $h->telur }}</td>
                            <td>{{ empty($h->tPcsSeminggu) ? 0 : number_format((($h->tPcsSeminggu / 7) / $ayam_akhir->populasi) * 100, 1) }} / {{ empty($h->tPcsSeminggu2) ? 0 : number_format((($h->tPcsSeminggu2 / 7) / $ayam_akhir->populasi) * 100, 1) }}</td>
                            @if ($h->mgg < 21)
                                <td>0</td>
                            @else
                                <td align="center" 
                                @if ($jumlah > '2.1')
                                    style="background-color: red; color: white;"
                                @else
                                @endif
                                >
                                    {{ empty($h->tPcsSeminggu) ? 0 : number_format($h->pweek / ($h->tPcsSeminggu - ($h->tKgSeminggu / 180)),1) }} 
                                    / belum
                                </td>
                            @endif
                            {{-- end data telur --}}

                            {{-- kumulatif --}}
                            @php
                                $rak = $h->mgg < 21 ? 0 : $h->fcr5 - ($h->fcr6 / 180);
                                $ku = $h->mgg < 21 ? 0 : round($h->pweek2, 2) / round($rak, 2);
                                $ttlPweek2 += number_format($h->pweek2, 2);
                                $ttlRak += number_format($rak, 2);
                                $ttlKu += number_format($ku, 2);
                            @endphp
                            <td>{{ number_format($h->pweek2, 2) }}</td>
                            <td>{{ number_format($rak, 2) }}</td>
                            <td>{{ number_format($ku, 2) }}</td>
                            {{-- end kumulatif --}}
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <th colspan="2" align="center">
                        <dt>Total</dt>
                    </th>
                    <th>
                        <center>{{ $ttlAyamAwal }} / {{ $ttlAyamPopulasi }} / {{ $ttlAyamPersen }} </center>
                    </th>
                    <th>
                        <center>{{ $ttlD . ' / ' . $ttlC }}</center>
                    </th>
                    <th>
                        <center>{{ number_format($ttlKg, 1) }}</center>
                    </th>
                    <th>
                        <!--<center>431 / 422</center>-->
                    </th>
                    <th>

                        <center>{{ number_format($ttlGrWeak,0) }} / {{ number_format($ttlGrWeak3,0) }}</center>

                    </th>
                    <th>
                        <!--<center>0 / 7279</center>-->
                    </th>
                    <th>
                        <center>{{ $ttlButir }}</center>
                    </th>
                    <th>
                        <!--<center>184.85 / 376.22 (49.13%)</center>-->
                    </th>

                    <th>
                        <center>{{ number_format($ttlKgToday,1) }}</center>
                    </th>
                    <th>
                        <!--<center>12.51 / 22.61 (55.34)</center>-->
                    </th>
                    <th>
                        <!--<center>191.1 / 231.2</center>-->
                    </th>
                    <th>
                        <!--<center>66.2</center>-->
                    </th>
                    <th>
                        <!--<center>314.5 / 0.0 </center>-->

                    </th>

                    <th>
                        <center>{{ number_format($ttlKg ?? 0 / $tot10 ?? 0, 1) }}</center>
                    </th>
                    <th>
                        {{ $ttlPweek2 }}
                    <th>
                        <center>{{ $ttlRak }} </center>
                    </th>
                    <th>
                        <center>{{ $ttlKu }} / 4.5 </center>
                    </th>
                    <th>
                        <center>171,918,467</center>
                    </th>
                    <th>
                        <center>27,680,729 </center>
                    </th>
                    <th>
                        <center>7,480,095 </center>
                    </th>
                </tfoot>
            </table>
        </div>
        <br>
        <div class="row">
            <div class="col-lg-12 ml-2">
                <table style="white-space: nowrap;" style="font-size: 14px; background-color: #fff; border: 2px solid #50A7BC">
                    <thead>
                        <tr>
                            <th style="background-color: #BDEED9;">Nama Pakan</th>
                            <th style="background-color: #BDEED9;">Harga satuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $ttl_pakan = 0;
                        @endphp
                        @foreach ($h_pakan as $h)
                        @php
                            $h_satuan = $h->debit / $h->qty;
                            $ttl_pakan += $h_satuan;
                        @endphp
                            <tr>
                                <td>{{ $h->nm_barang }}</td>
                                <td>{{ number_format($h_satuan,0) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th>Total</th>
                        <th>{{ number_format($ttl_pakan,0) }}</th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>