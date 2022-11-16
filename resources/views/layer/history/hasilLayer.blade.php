<table style="width: 100%;" border="1" cel="10">
    <thead
        style="font-family: Helvetica; color: #78909C; background-color: #F4F8F9; text-transform: uppercase;">
        <tr>
            <th></th>
            <th class="ayam" style="font-size: 13px;">pop akhir/D/C</th>
            <th class="ayam" style="font-size: 13px;">
                @foreach ($jenis as $j)
                    {{ ($j->jenis) }} / 
                @endforeach
                Ttl Kg
            </th>
            <th class="ayam" style="font-size: 13px;">Pupuk</th>
        </tr>
    </thead>
    <tbody>
        
        <tr>
            <td class="td_ayam">
                @foreach ($kandangData as $d)
                    {{ $d->nm_kandang }} ({{ $d->mgg + 1 }})
                    <br>
                @endforeach
            </td>
            <td style="white-space: nowrap;"  class="td_ayam">
                @php
                    $ttlPop = 0;
                    $ttlDeath = 0;
                    $ttlCull = 0;
                @endphp
                @foreach ($kandangData as $d)
                @php
                    $populasi = DB::selectOne("SELECT sum(populasi) as populasi, sum(death) as death,sum(culling) as culling FROM tb_populasi 
                                WHERE id_kandang = '$d->id_kandang'and tgl = '$tglhariIni' GROUP BY id_kandang");
                    $pop = empty($populasi->populasi) ? 0 : $populasi->populasi;
                    $death = empty($populasi->death) ? 0 : $populasi->death;
                    $culling = empty($populasi->culling) ? 0 : $populasi->culling;

                    $ttlPop += $pop;
                    $ttlDeath += $death;
                    $ttlCull += $culling;
                @endphp
                    {{ $pop }} / <span
                            class="text-danger">{{ $death }} / {{ $culling }}</span><br>
                @endforeach
            </td>
            <td style="white-space: nowrap;" class="td_ayam">
                @foreach ($kandangData as $d)
                @php
                    $nota = DB::selectOne("SELECT nota FROM tb_telur WHERE id_kandang = '$d->id_kandang' and tgl = '$tglhariIni' GROUP BY id_kandang");
                    // dd($nota->nota);
                @endphp
                    
                    <a
                    @if (empty($nota->nota))
                    @else
                    href="#" data-toggle="modal" data-target="#modalEditLayer" nota="{{ $nota->nota }}" id="editLayer" 
                    @endif
                    >
                        @php
                            $ttlKg = 0;
                            
                        @endphp
                        @foreach ($jenis as $j)
                        
                            @php
                                $sumJenis = DB::selectOne("SELECT nota,sum(pcs) as tPcs, sum(kg) as tKg FROM tb_telur 
                                WHERE id_kandang = '$d->id_kandang' and id_jenis = '$j->id' and tgl = '$tglhariIni' GROUP BY id_kandang");

                                $sumKemarin = DB::selectOne("SELECT sum(pcs) as tPcs, sum(kg) as tKg FROM tb_telur 
                                WHERE id_kandang = '$d->id_kandang' and id_jenis = '$j->id' and tgl = '$tglKemarin' GROUP BY id_kandang");
                                $ttlKg += empty($sumJenis->tKg) ? 0 : $sumJenis->tKg;
                                $tPcs = empty($sumJenis->tPcs) ? 0 : $sumJenis->tPcs;
                             
                                
                            @endphp
                        
                            {{$tPcs}} /
                        @endforeach
                        {{ $ttlKg  }}
                        <span class="text-danger">({{ empty($sumKemarin->tPcs) ? $tPcs - 0 : $tPcs - $sumKemarin->tPcs }})</span> </a><br>
                @endforeach
             
            </td>
            <td style="white-space: nowrap;" class="td_ayam">
                @php
                    $ttlKarung = 0;
                @endphp
                @foreach ($kandangData as $d)
                @php
                    $karung = DB::selectOne("SELECT sum(jumlah) as jml FROM tb_pupuk 
                                WHERE id_kandang = '$d->id_kandang' and tgl = '$tglhariIni' GROUP BY id_kandang");
                    $karungJml = empty($karung->jml) ? 0 : $karung->jml;
                    $ttlKarung += $karungJml;
                @endphp
                    {{ $karungJml }} Karung <br>
                @endforeach
            </td>
        </tr>
        <tr>
            <td>
                Total
            </td>
            <td> {{$ttlPop}} / {{$ttlDeath}} / {{$ttlCull}}</td>
            <td>
                @php
                    $totalKg = 0;
                @endphp
                @foreach ($jenis as $jt)
                @php
                    $sumJenis = DB::selectOne("SELECT SUM(pcs) as tPcs,SUM(kg) as tKg FROM `tb_telur`
                                WHERE tgl = '$tglhariIni' AND id_jenis = '$jt->id'
                                GROUP BY tgl,id_jenis");
                            $tPcs = empty($sumJenis->tPcs) ? 0 : $sumJenis->tPcs;
                            $totalKg += empty($sumJenis->tKg) ? 0 : $sumJenis->tKg;
                @endphp
                    {{$tPcs}} /                    
                @endforeach
                {{ $totalKg }}
            </td>
            <td>{{$ttlKarung}} Karung</td>
        </tr>
    </tbody>

</table>