<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Bulan</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            color: #787878;
        }
       table , th, td {
            font-size: 10px;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12">
                <h5>Bulan : {{ date('F-Y',strtotime($tgl1)) }}</h5>
                <div class="table-responsive">
                    <table width="100%" class="table table-bordered">
                        <thead>
                            <tr>
                                <th style="position: sticky;z-index: 1;background: #BDEED9; color:#787878; left: 0">Kandang</th>
                                <th style="white-space:nowrap; position: sticky;z-index: 1;background: #BDEED9; color:#787878; left: 64px">Pop akhir D/C</th>
                                
                                @foreach ($tgl as $t)
                                    <th style="white-space: nowrap;">{{ date('d', strtotime($t->tgl)) }}</th>
                                @endforeach

                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($kandang as $k)
                                <tr>
                                    <td style="position: sticky;z-index: 1;background: #BDEED9; color:#787878; left: 0">{{ $k->nm_kandang }} ({{ $k->mgg +1 }})</td>
                                    <td style="white-space:nowrap; position: sticky;z-index: 1;background: #BDEED9; color:#787878; left: 64px">{{ $k->populasi }} / {{ $k->death }} / {{ $k->culling }}</td>
                                    @foreach ($tgl as $t)
                                        
                                        @php
                                            $tanggal = date('Y-m-d', strtotime('-1 day', strtotime($t->tgl)));
                                            $telur = DB::selectOne("SELECT a.tgl, b.nm_kandang,
                                                    TIMESTAMPDIFF(WEEK, b.tgl_masuk , a.tgl) AS mgg,
                                                    sum(a.pcs) AS total_pcs, total_pcs2
                                                    FROM tb_telur AS a
                                                    LEFT JOIN tb_kandang AS b ON b.id_kandang = a.id_kandang
                                                    LEFT JOIN (SELECT c.id_kandang, sum(pcs) AS total_pcs2
                                                    FROM tb_telur AS c 
                                                    WHERE c.tgl = '$tanggal' 
                                                    ) AS c ON c.id_kandang = a.id_kandang
                                                    WHERE b.selesai = 'T' and a.tgl = '$t->tgl' and a.id_kandang = '$k->id_kandang'")
                                        @endphp
                                        <td style="white-space: nowrap;">{{ empty($telur->total_pcs) ? '0' : $telur->total_pcs - $telur->total_pcs2 }} </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>