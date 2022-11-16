<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                <table class="table">
                    <tr class="table table-secondary text-dark">
                        <th>Produk</th>
                        <th></th>
                        <th>Stok</th>
                        <th>Harga</th>
                    </tr>
                    <tr>
                        <td>
                            @foreach ($obat as $o)
                                {{ $o->nm_barang }} <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($obat as $o)
                                : <br>
                            @endforeach
                        </td>
                        <td>
                            @foreach ($obat as $o)
                                @php
                                    $stok = DB::selectOne("SELECT SUM(a.debit - a.kredit) as stok FROM `tb_asset_pv` as a
                                                    WHERE a.id_barang = '$o->id_barang'")
                                @endphp
                                {{ empty($stok->stok) ? 0 : number_format($stok->stok,1) . ' ' . $o->nm_satuan }}
                              
                            @endforeach
                        </td>
                        <td>
                            @foreach ($obat as $o)
                            @php
                                $harga = DB::selectOne("SELECT qty, debit FROM tb_jurnal WHERE id_barang_pv = '$o->id_barang'");
                                $stok = DB::selectOne("SELECT SUM(a.debit - a.kredit) as stok FROM `tb_asset_pv` as a
                                                WHERE a.id_barang = '$o->id_barang'")
                            @endphp
                            {{ ($harga->debit / ($harga->debit * 1000)) * $stok->stok }}
                            @endforeach
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>