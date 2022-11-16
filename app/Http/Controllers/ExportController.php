<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class ExportController extends Controller
{
    public function exportObat(Request $r)
    {
        $jenis = $r->jenis == 'obat' ? '!=' : '=';
        $query = DB::select("SELECT a.id_barang,a.nm_barang,a.kegunaan,a.dosis,a.campuran, b.nm_jenis, c.nm_satuan as satuan1, d.nm_satuan as satuan2 FROM `tb_barang_pv` as a
        LEFT JOIN tb_jenis as b ON a.id_jenis = b.id_jenis
        LEFT JOIN tb_satuan as c ON c.id_satuan = a.id_satuan
        LEFT JOIN tb_satuan as d ON d.id_satuan = a.id_satuan_pakai
        WHERE a.id_jenis $jenis 1");
        
        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $style = array(
            'font' => array(
                'size' => 9
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                
            ),
        );

        $sheet->setCellValue('A1', 'ID')
              ->setCellValue('B1', 'Nama Barang')
              ->setCellValue('C1', 'Jenis')
              ->setCellValue('D1', 'Dosis')
              ->setCellValue('E1', 'Satuan')
              ->setCellValue('F1', 'Campuran')
              ->setCellValue('G1', 'Satuan')
              ->setCellValue('H1', 'Kegunaan');
    
        $kolom = 2;
        foreach($query as $q) {
            $sheet->setCellValue("A$kolom", $q->id_barang)
                ->setCellValue("B$kolom", $q->nm_barang)
                ->setCellValue("C$kolom", $q->nm_jenis)
                ->setCellValue("D$kolom", $q->dosis)
                ->setCellValue("E$kolom", $q->satuan1)
                ->setCellValue("F$kolom", $q->campuran)
                ->setCellValue("G$kolom", $q->satuan2)
                ->setCellValue("H$kolom", $q->kegunaan);
            $kolom++;
        }
        $batas = $kolom - 1;
        $sheet->getStyle('A1:H' . $batas)->applyFromArray($style);

        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data barang.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');

    }
    public function export()
    {
        $pakan = DB::select("SELECT * FROM `tb_pakan` as a
        LEFT JOIN tb_barang_pv as b ON b.id_barang = a.id_dt_pakan
        LEFT JOIN tb_kandang as c ON c.id_kandang = a.id_kandang
        GROUP By a.id_pakan");

        $obat_pakan = DB::select("SELECT *,a.dosis, a.campuran FROM `tb_obat_pakan` as a
        LEFT JOIN tb_barang_pv as b ON b.id_barang = a.id_obat
        LEFT JOIN tb_kandang as c ON c.id_kandang = a.id_kandang
        GROUP By a.id_obat_pakan");

        $obat_air = DB::select("SELECT *,a.dosis, a.campuran FROM `tb_obat_air` as a
        LEFT JOIN tb_barang_pv as b ON b.id_barang = a.id_obat
        LEFT JOIN tb_kandang as c ON c.id_kandang = a.id_kandang
        GROUP By a.id_obat_air");

        $obat_ayam = DB::select("SELECT *,a.dosis FROM `tb_obat_ayam` as a
        LEFT JOIN tb_barang_pv as b ON b.id_barang = a.id_obat
        LEFT JOIN tb_kandang as c ON c.id_kandang = a.id_kandang
        GROUP By a.id_obat_ayam");

        $spreadsheet = new Spreadsheet;

        $spreadsheet->setActiveSheetIndex(0);
        $sheet = $spreadsheet->getActiveSheet();

        $style = array(
            'font' => array(
                'size' => 9
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
        );

        // pakan
        $sheet->setCellValue('A1', 'Pakan')
              ->setCellValue('B1', 'ID')
              ->setCellValue('C1', 'Tanggal')
              ->setCellValue('D1', 'Nama Pakan')
              ->setCellValue('E1', 'Persen Pakan')
              ->setCellValue('F1', 'Gr Pakan')
              ->setCellValue('G1', 'Satuan')
              ->setCellValue('H1', 'Kandang');
        
            $kolomPakan = 2;
            foreach($pakan as $p) {
                $sheet->setCellValue("B$kolomPakan", $p->id_barang)
                    ->setCellValue("C$kolomPakan", $p->tgl)
                    ->setCellValue("D$kolomPakan", $p->nm_barang)
                    ->setCellValue("E$kolomPakan", $p->persen)
                    ->setCellValue("F$kolomPakan", $p->gr_pakan)
                    ->setCellValue("G$kolomPakan", 'Kg')
                    ->setCellValue("H$kolomPakan", $p->nm_kandang);
                $kolomPakan++;
            }
            $batas = $kolomPakan - 1;
            $sheet->getStyle("B1:H$batas")->applyFromArray($style);
        
        
        // obat pakan
        $sheet->setCellValue('J1', 'Obat Pakan')
              ->setCellValue('K1', 'ID')
              ->setCellValue('L1', 'Tanggal')
              ->setCellValue('M1', 'Nama Obat')
              ->setCellValue('N1', 'Dosis')
              ->setCellValue('O1', 'Satuan')
              ->setCellValue('P1', 'Campuran')
              ->setCellValue('Q1', 'Satuan')
              ->setCellValue('R1', 'Kandang');

              $kolomObatP = 2;
              foreach($obat_pakan as $d) {
                  $sheet->setCellValue("K$kolomObatP", $d->id_barang)
                      ->setCellValue("L$kolomObatP", $d->tgl)
                      ->setCellValue("M$kolomObatP", $d->nm_barang)
                      ->setCellValue("N$kolomObatP", $d->dosis)
                      ->setCellValue("O$kolomObatP", $d->satuan)
                      ->setCellValue("P$kolomObatP", $d->campuran)
                      ->setCellValue("Q$kolomObatP", $d->satuan2)
                      ->setCellValue("R$kolomObatP", $d->nm_kandang);
                  $kolomObatP++;
              }
              $batas = $kolomObatP - 1;
              $sheet->getStyle("K1:R$batas")->applyFromArray($style);
        // obat Air
        $sheet->setCellValue('T1', 'Obat Air')
              ->setCellValue('U1', 'ID')
              ->setCellValue('V1', 'Tanggal')
              ->setCellValue('W1', 'Nama Obat')
              ->setCellValue('X1', 'Dosis')
              ->setCellValue('Y1', 'Satuan')
              ->setCellValue('Z1', 'Campuran')
              ->setCellValue('AA1', 'Satuan')
              ->setCellValue('AB1', 'Waktu')
              ->setCellValue('AC1', 'Cara')
              ->setCellValue('AD1', 'Keterangan')
              ->setCellValue('AE1', 'Kandang');

              $kolomObatAir = 2;
              foreach($obat_air as $d) {
                  $sheet->setCellValue("U$kolomObatAir", $d->id_barang)
                      ->setCellValue("V$kolomObatAir", $d->tgl)
                      ->setCellValue("W$kolomObatAir", $d->nm_barang)
                      ->setCellValue("X$kolomObatAir", $d->dosis)
                      ->setCellValue("Y$kolomObatAir", $d->satuan)
                      ->setCellValue("Z$kolomObatAir", $d->campuran)
                      ->setCellValue("AA$kolomObatAir", $d->satuan2)
                      ->setCellValue("AB$kolomObatAir", $d->waktu)
                      ->setCellValue("AC$kolomObatAir", $d->cara)
                      ->setCellValue("AD$kolomObatAir", $d->ket)
                      ->setCellValue("AE$kolomObatAir", $d->nm_kandang);
                  $kolomObatAir++;
              }
              $batas = $kolomObatAir - 1;
              $sheet->getStyle("U1:AE$batas")->applyFromArray($style);

        // Obat Ayam
        $sheet->setCellValue('AG1', 'Obat Ayam')
              ->setCellValue('AH1', 'ID')
              ->setCellValue('AI1', 'Tanggal')
              ->setCellValue('AJ1', 'Nama Obat')
              ->setCellValue('AK1', 'Dosis / Ayam')
              ->setCellValue('AL1', 'Satuan')
              ->setCellValue('AM1', 'TTL Dosis')
              ->setCellValue('AN1', 'Satuan')
              ->setCellValue('AO1', 'Kandang');

              $kolomObatAyam = 2;
              foreach($obat_ayam as $d) {
                  $sheet->setCellValue("AH$kolomObatAyam", $d->id_barang)
                      ->setCellValue("AI$kolomObatAyam", $d->tgl)
                      ->setCellValue("AJ$kolomObatAyam", $d->nm_barang)
                      ->setCellValue("AK$kolomObatAyam", $d->dosis_awal)
                      ->setCellValue("AL$kolomObatAyam", 'Gr')
                      ->setCellValue("AM$kolomObatAyam", $d->dosis)
                      ->setCellValue("AN$kolomObatAyam", 'Gr')
                      ->setCellValue("AO$kolomObatAyam", $d->nm_kandang);
                  $kolomObatAyam++;
              }
              $batas = $kolomObatAyam - 1;
              $sheet->getStyle("AH1:AO$batas")->applyFromArray($style);
        

        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data export Perencanaan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }
    
    public function exportDaily(Request $r) 
    {
        $id_kandang = $r->id_kandang;

        $kandang = DB::selectOne("SELECT a.ayam_awal, a.nm_kandang, b.nm_strain FROM `tb_kandang` as a
        LEFT JOIN tb_strain as b ON a.id_strain = b.id_strain
        WHERE a.id_kandang = '$id_kandang'");

        $spreadsheet = new Spreadsheet;

        $style = array(
            'font' => array(
                'size' => 9
            ),
            'borders' => array(
                'allBorders' => array(
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ),
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                
            ),
        );
        $style2 = array(
            'font' => array(
                'size' => 18,
                'setBold' => true
            ),
            'alignment' => array(
                'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
                'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
            ),
            'fill' => array(
                'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
                'startColor' => array('argb' => 'ADD8E6')
            ),
        );
        $style3 = array(
            'font' => array(
                'size' => 9,
                'setBold' => true
            ),
        );
        // daily production
            $pullet = DB::select("SELECT a.tgl, c.populasi, SUM(a.gr_pakan) as kg_pakan, TIMESTAMPDIFF(WEEK, b.tgl_masuk , a.tgl) AS mgg,
                    c.death, c.culling, normal.normalPcs, normal.normalKg, abnormal.abnormalPcs, abnormal.abnormalKg, d.pcs,d.kg, sum(d.pcs) as ttl_pcs, SUM(d.kg) as ttl_kg, b.ayam_awal
                    
                    FROM tb_pakan as a
                    LEFT JOIN tb_kandang as b ON a.id_kandang = b.id_kandang
                    LEFT JOIN tb_populasi as c ON c.id_kandang = a.id_kandang AND c.tgl = a.tgl
                    LEFT JOIN tb_telur as d ON d.id_kandang = a.id_kandang AND d.tgl = a.tgl
                    LEFT JOIN (
                        SELECT a.tgl,a.id_kandang, sum(a.pcs) as normalPcs, sum(a.kg) as normalKg FROM tb_telur as a
                        WHERE a.id_jenis = 26 AND a.id_kandang = '$id_kandang'
                        GROUP BY a.tgl
                    ) as normal ON normal.id_kandang = a.id_kandang AND normal.tgl = a.tgl
                    LEFT JOIN (
                        SELECT a.tgl,a.id_kandang, sum(a.pcs) as abnormalPcs, sum(a.kg) as abnormalKg FROM tb_telur as a
                        WHERE a.id_jenis != 26 AND a.id_kandang = '$id_kandang'
                        GROUP BY a.tgl
                    ) as abnormal ON abnormal.id_kandang = a.id_kandang AND abnormal.tgl = a.tgl
                    WHERE a.id_kandang = '$id_kandang'
                    GROUP BY a.tgl
                    ORDER BY a.tgl ASC;");

            $spreadsheet->setActiveSheetIndex(0);
            $sheet1 = $spreadsheet->getActiveSheet();
            $sheet1->setTitle('DAILY PRODUCTION');
    
            $sheet1->setCellValue('A1', 'DAILY COMMERCIAL LAYER PRODUCTION')
                   ->setCellValue('A3', "HEN HOUSE/POPULATION : $kandang->ayam_awal")
                   ->setCellValue('A5', "HOUSE : $kandang->nm_kandang")
                   ->setCellValue('A7', "STRAIN : $kandang->nm_strain")
                   ->setCellValue('A9', 'DATE')
                   ->setCellValue('B9', 'AGE OF BIRD')
                   ->setCellValue('C9', 'CHICK AMOUNT')
                   ->setCellValue('D9', 'DEPLETION')
                   ->setCellValue('I9', 'FEED CONSUMTION')
                   ->setCellValue('K9', 'EGG PRODUCTION')
            
                   ->setCellValue('D10', 'BIRD DEATH')
                   ->setCellValue('E10', 'BIRD CULLING')
                   ->setCellValue('F10', 'BIRD TOTAL')
                   ->setCellValue('G10', '%')
                   ->setCellValue('H10', 'CUM')
                   ->setCellValue('I10', 'PER DAY (KG)')
                   ->setCellValue('J10', 'CUM')
                   ->setCellValue('K10', 'PERDAY')
    
                   ->setCellValue('K11', 'NORMAL')
                   ->setCellValue('L11', 'ABNORMAL')
                   ->setCellValue('M11', 'TOTAL')
                   ->setCellValue('N11', '%HD')
                   ->setCellValue('O11', '%HH')
                   ->setCellValue('P11', 'CUM (BUTIR)')
                   ->setCellValue('Q11', 'WIGHT (KG) ')
            ->setCellValue('R11', 'CUM (KG)');
    
            $kolom = 12;
            $kum = 0;
            $cum_kg = 0;
            $cum_ttlpcs = 0;
            $cum_ttlkg = 0;
    
            foreach($pullet as $d) {
                $kum += $d->death + $d->culling;
                $cum_kg += $d->kg_pakan;
                $cum_ttlpcs += $d->ttl_pcs;
                $cum_ttlkg += $d->ttl_kg;
                $sheet1->setCellValue("A$kolom", date('Y-m-d', strtotime($d->tgl)))
                       ->setCellValue("B$kolom", $d->mgg)
                       ->setCellValue("C$kolom", $d->populasi ?? 0)
                       ->setCellValue("D$kolom", $d->death ?? 0)
                       ->setCellValue("E$kolom", $d->culling ?? 0)
                       ->setCellValue("F$kolom", $d->death + $d->culling);
                $death = $d->death ?? 0;
                $culling = $d->culling ?? 0;
                $pop = $d->populasi  ?? 0;
                $sheet1->setCellValue("G$kolom", ($death + $culling) > 0 && $pop > 0 ? number_format((($death + $culling) / $pop) * 100, 2) : 0)
                       ->setCellValue("H$kolom", $kum)
                       ->setCellValue("I$kolom", $d->kg_pakan)
                       ->setCellValue("J$kolom", $cum_kg)
                       ->setCellValue("K$kolom", $d->normalPcs ?? 0)
                       ->setCellValue("L$kolom", $d->abnormalPcs ?? 0)
                       ->setCellValue("M$kolom", $d->abnormalPcs ?? 0 + $d->normalPcs ?? 0)
                       ->setCellValue("N$kolom", $pop > 0 ? number_format(($d->ttl_pcs / $pop) * 100, 2) : 0)
                       ->setCellValue("O$kolom", number_format(($d->ttl_pcs / $d->ayam_awal) * 100, 2))
                       ->setCellValue("P$kolom", $cum_ttlpcs);
                $ttlPcs = $d->normalPcs ?? 0 + $d->abnormalPcs ?? 0;
                $sheet1->setCellValue("Q$kolom", number_format($d->ttl_kg - ($ttlPcs / 180), 2))
                       ->setCellValue("R$kolom", number_format($cum_ttlkg - ($cum_ttlpcs /180), 2));
                $kolom++;
            }
    
            $batas = $kolom - 1;
            $spreadsheet->getActiveSheet()->getStyle('A12:R' . $batas)->applyFromArray($style);
    
            $sheet1->mergeCells("A1:R1")
                   ->mergeCells("A3:C3")
                   ->mergeCells("A5:C5")
                   ->mergeCells("A7:C7")
                   ->mergeCells("K10:R10")
    
                   ->mergeCells("A9:A11")
                   ->mergeCells("B9:B11")
                   ->mergeCells("C9:C11")
    
                   ->mergeCells("D10:D11")
                   ->mergeCells("E10:E11")
                   ->mergeCells("F10:F11")
                   ->mergeCells("G10:G11")
                   ->mergeCells("H10:H11")
    
                   ->mergeCells("I10:I11")
                   ->mergeCells("J10:J11")
    
    
                   ->mergeCells("D9:H9")
                   ->mergeCells("I9:J9")
            ->mergeCells("K9:R9");
    
            $sheet1->getStyle('A1:R1')->applyFromArray($style2);
            $sheet1->getStyle('A3:B3')->applyFromArray($style3);
            $sheet1->getStyle('A5:B5')->applyFromArray($style3);
            $sheet1->getStyle('A7:B7')->applyFromArray($style3);
            $sheet1->getStyle('A9:R11')->applyFromArray($style);
            $sheet1->getStyle('A9:R9')->getAlignment()->setWrapText(true);
            $sheet1->getColumnDimension('B')->setWidth(10.64);
            $sheet1->getColumnDimension('D')->setWidth(8.36);
            $sheet1->getColumnDimension('F')->setWidth(9.82);
        // end daily -----------------------------------------------
        
        // obat pakan -----------------
            $obat_pakan = DB::select("SELECT a.ttl_gr, b.nm_barang, a.tgl, a.dosis, a.satuan, a.satuan2, a.campuran, (a.dosis * c.ttl_pakan) as dosis_obat, d.debit, d.qty
                            FROM tb_obat_pakan as a
                            LEFT JOIN tb_barang_pv as b  ON a.id_obat = b.id_barang
                            LEFT JOIN (
                                SELECT a.id_kandang , a.tgl, SUM(a.gr_pakan) AS ttl_pakan
                                    FROM tb_pakan AS a
                                    GROUP BY a.tgl , a.id_kandang
                            )AS c ON c.id_kandang = a.id_kandang AND c.tgl = a.tgl
                            LEFT JOIN (
                                SELECT a.id_barang,SUM(b.debit) as debit, sum(b.qty) as qty FROM `tb_barang_pv` as a
                                LEFT JOIN tb_jurnal as b ON a.id_barang = b.id_barang_pv
                                WHERE a.id_jenis = 2 AND b.debit != 0
                                GROUP BY b.id_barang_pv
                            ) AS d ON d.id_barang = a.id_obat
                            WHERE a.id_kandang = '$id_kandang'");

            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(1);
            $sheet2 = $spreadsheet->getActiveSheet(1);
            $sheet2->setTitle('OBAT PAKAN');
            $sheet2->setCellValue('A1', 'Tanggal')
                ->setCellValue('B1', 'Nama Obat')
                ->setCellValue('C1', 'Dosis')
                ->setCellValue('D1', 'Satuan')
                ->setCellValue('E1', 'Campuran')
                ->setCellValue('F1', 'Satuan')
                ->setCellValue('G1', 'Ttl Dosis')
                ->setCellValue('H1', 'Cost')
                ->setCellValue('I1', 'Cost');

            $kolom = 2;
            foreach($obat_pakan as $d) {
                $cost = ($d->debit / $d->qty) * $d->dosis_obat;
                $sheet2->setCellValue("A$kolom", date('Y-m-d', strtotime($d->tgl)))
                    ->setCellValue("B$kolom", $d->nm_barang)
                    ->setCellValue("C$kolom", $d->dosis)
                    ->setCellValue("D$kolom", $d->satuan)
                    ->setCellValue("E$kolom", $d->campuran)
                    ->setCellValue("F$kolom", $d->satuan2)
                    ->setCellValue("G$kolom", $d->dosis_obat)
                    ->setCellValue("H$kolom", $cost)
                    ->setCellValue("I$kolom", "$d->debit / $d->qty * $d->dosis_obat");
                $kolom++;
            }

            $batas = $kolom - 1;
            $sheet2->getStyle('A1:H' . $batas)->applyFromArray($style);
        // end obat pakan ---------------------------------

        // obat air -------------------------
            $obat_air = DB::select("SELECT *,d.debit,d.qty, a.dosis as dosis1, a.campuran as campuran1 FROM `tb_obat_air` as a
                        LEFT JOIN tb_barang_pv as b  ON a.id_obat = b.id_barang
                        LEFT JOIN (
                            SELECT a.id_barang,SUM(b.debit) as debit, sum(b.qty) as qty FROM `tb_barang_pv` as a
                            LEFT JOIN tb_jurnal as b ON a.id_barang = b.id_barang_pv
                            WHERE a.id_jenis = 3 AND b.debit != 0
                            GROUP BY b.id_barang_pv
                        ) AS d ON d.id_barang = a.id_obat WHERE a.id_kandang = '$id_kandang' ORDER BY a.tgl DESC");

            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(2);
            $sheet3 = $spreadsheet->getActiveSheet(2);
            $sheet3->setTitle('OBAT AIR');
            $sheet3->setCellValue('A1', 'Tanggal')
                ->setCellValue('B1', 'Nama Obat')
                ->setCellValue('C1', 'Dosis')
                ->setCellValue('D1', 'Satuan')
                ->setCellValue('E1', 'Campuran')
                ->setCellValue('F1', 'Satuan')
                ->setCellValue('G1', 'Waktu')
                ->setCellValue('H1', 'Cara')
                ->setCellValue('I1', 'Cost');
            
            $kolom = 2;
            foreach($obat_air as $d) {
                $cost = ($d->debit / $d->qty) * $d->dosis1;
                $sheet3->setCellValue('A' . $kolom, date('Y-m-d', strtotime($d->tgl)))
                       ->setCellValue('B' . $kolom, $d->nm_barang)
                       ->setCellValue('C' . $kolom, $d->dosis1)
                       ->setCellValue('D' . $kolom, $d->satuan)
                       ->setCellValue('E' . $kolom, $d->campuran1)
                       ->setCellValue('F' . $kolom, $d->satuan2)
                       ->setCellValue('G' . $kolom, $d->waktu)
                       ->setCellValue('H' . $kolom, $d->cara)
                       ->setCellValue('I' . $kolom, round($cost,0));
                $kolom++;
            }
            $batas = $kolom - 1;
            $sheet3->getStyle('A1:I' . $batas)->applyFromArray($style);
        // end obat air --------------------------------------------

        
        // obat ayam -----------------------
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(3);
            $sheet4 = $spreadsheet->getActiveSheet(3);
            $sheet4->setTitle('OBAT AYAM');
            $sheet4->setCellValue('A1', 'Tanggal')
                ->setCellValue('B1', 'Nama Obat')
                ->setCellValue('C1', 'Dosis')
                ->setCellValue('D1', 'Satuan')
                ->setCellValue('E1', 'Dosis Perekor')
                ->setCellValue('F1', 'Satuan')
                ->setCellValue('G1', 'Cost');
            
            $obat_ayam = DB::select("SELECT *,d.debit,d.qty, a.dosis as dosis1 FROM `tb_obat_ayam` as a
                LEFT JOIN tb_barang_pv as b  ON a.id_obat = b.id_barang
                LEFT JOIN (
                    SELECT a.id_barang,SUM(b.debit) as debit, sum(b.qty) as qty FROM `tb_barang_pv` as a
                    LEFT JOIN tb_jurnal as b ON a.id_barang = b.id_barang_pv
                    WHERE a.id_jenis = 4 AND b.debit != 0
                    GROUP BY b.id_barang_pv
                ) AS d ON d.id_barang = a.id_obat WHERE a.id_kandang = '$id_kandang' ORDER BY a.tgl DESC");
            
            $kolom = 2;
            foreach($obat_ayam as $d) {
                $cost = ($d->debit / $d->qty) * $d->dosis1;
                $sheet4->setCellValue('A' . $kolom, date('Y-m-d', strtotime($d->tgl)))
                       ->setCellValue('B' . $kolom, $d->nm_barang)
                       ->setCellValue('C' . $kolom, $d->dosis1)
                       ->setCellValue('D' . $kolom, $d->satuan)
                       ->setCellValue('E' . $kolom, $d->dosis_awal)
                       ->setCellValue('F' . $kolom, $d->satuan)
                       ->setCellValue('G' . $kolom, round($cost,0));
                $kolom++;
            }

            $batas = $kolom - 1;
            $sheet4->getStyle('A1:G' . $batas)->applyFromArray($style);
        // end obat ayam -----------------------------------------
        
        // vaksin ------------------------
            $vaksin = DB::table('tb_vaksin')->where('id_kandang', $id_kandang)->get();
            $spreadsheet->createSheet();
            $spreadsheet->setActiveSheetIndex(4);
            $sheet5 = $spreadsheet->getActiveSheet(4);
            $sheet5->setTitle('VAKSIN');
            $sheet5->setCellValue('A1', 'Tanggal')
                ->setCellValue('B1', 'Nama Vaksin')
                ->setCellValue('C1', 'Dosis')
                ->setCellValue('D1', 'Cost');
            
            $kolom = 2;
            foreach($vaksin as $d) {
                $sheet5->setCellValue("A$kolom", date('Y-m-d', strtotime($d->tgl)))
                       ->setCellValue("B$kolom", $d->vaksin)
                       ->setCellValue("C$kolom", $d->dosis)
                       ->setCellValue("D$kolom", $d->cost);
                $kolom++;
            }
            $batas = $kolom - 1;
            $sheet5->getStyle('A1:D' . $batas)->applyFromArray($style);
        // end vaksin ---------------------------------------------
        
        $writer = new Xlsx($spreadsheet);
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="Data export Perencanaan.xlsx"');
        header('Cache-Control: max-age=0');

        $writer->save('php://output');
    }

    public function laporanLayer(Request $r)
    {
        $tgl = empty($r->tgl) ? date('Y-m-d', strtotime('-1 days', strtotime(date('Y-m-d')))) : $r->tgl;
        $tgl2 = date('Y-m-d', strtotime('-1 days', strtotime($tgl)));
        $tgl3 = date('Y-m-d', strtotime('-6 days', strtotime($tgl)));
        $tgl4 = date('Y-m-d', strtotime('-6 days', strtotime($tgl3)));
       
        $kandang = DB::select("SELECT * FROM tb_kandang WHERE selesai = 'T'");
        $h_pakan = DB::select("SELECT b.nm_barang,sum(a.qty) as qty, sum(a.debit) as debit FROM tb_jurnal as a 
                    LEFT JOIN tb_barang_pv as b ON a.id_barang_pv = b.id_barang
                    WHERE b.id_jenis = 1 GROUP BY a.id_barang_pv");
        $layer = DB::select("SELECT 
                        a.nm_kandang,a.id_kandang, pop.death, pop.culling,
                        sum(pop.populasi) as ttlPopulasi, a.ayam_awal,
                        pkn.total, per.feed, per.berat, per.berat_telur, per.telur, pef.telpef, pef.telkg, vtl.kuml1, vtl.kuml3,
                        paka.pweek, paka2.pweek2,paka3.pweek3,
                        tel1.fcr5, tel1.fcr6,
                        telurPs.tPcsSeminggu, telurPs.tKgSeminggu, telurPs2.tPcsSeminggu2,
                        telur.tHariIni, telurK.tHariKemarin, telur.kHariIni, telurK.kHariKemarin,
                        TIMESTAMPDIFF(WEEK, a.tgl_masuk , '$tgl') AS mgg,
                        TIMESTAMPDIFF(DAY, a.tgl_masuk , '$tgl') AS hari
                        FROM `tb_kandang` as a
                        LEFT JOIN tb_populasi as pop ON a.id_kandang = pop.id_kandang
                        LEFT JOIN 
                        ( 
                            SELECT *,sum(gr_pakan) as total FROM tb_pakan WHERE tgl = '$tgl' GROUP BY id_kandang 
                        ) pkn ON pkn.id_kandang = a.id_kandang
                        LEFT JOIN
                        (
                            SELECT k.id_kandang, pr.id_strain, pr.berat, pr.telur, pr.feed, pr.berat_telur
                            FROM tb_kandang k
                            LEFT JOIN tb_performa pr ON pr.id_strain = k.id_strain
                            WHERE pr.umur > TIMESTAMPDIFF(WEEK, k.tgl_masuk , '$tgl')
                            GROUP BY k.id_kandang
                        ) per ON per.id_kandang = a.id_kandang
                        LEFT JOIN
                        (
                            SELECT sum(a.gr_pakan) as pweek,a.id_kandang FROM tb_pakan as a
                            WHERE a.tgl BETWEEN '$tgl3' AND '$tgl' 
                            GROUP BY a.id_kandang
                        ) paka ON paka.id_kandang = a.id_kandang
                        LEFT JOIN
                        (
                            SELECT sum(a.gr_pakan) as pweek3,a.id_kandang FROM tb_pakan as a
                            WHERE a.tgl BETWEEN '$tgl4' AND '$tgl3' 
                            GROUP BY a.id_kandang
                        ) paka3 ON paka.id_kandang = a.id_kandang
                        LEFT JOIN
                        (
                            SELECT sum(a.gr_pakan) as pweek2,a.id_kandang FROM tb_pakan as a
                            WHERE a.tgl BETWEEN '2020-08-05' AND '$tgl' 
                            GROUP BY a.id_kandang
                        ) paka2 ON paka2.id_kandang = a.id_kandang
                        LEFT JOIN 
                        (
                            SELECT sum(t.pcs) as tHariIni,sum(t.kg) as kHariIni, t.id_kandang FROM `tb_telur` as t
                            WHERE t.tgl = '$tgl' GROUP BY t.id_kandang
                        ) telur ON telur.id_kandang = a.id_kandang
                        LEFT JOIN 
                        (
                            SELECT *,
                            SUM(t.pcs) AS fcr6,
                            SUM(t.kg) as fcr5
                            FROM `tb_telur` t
                            WHERE t.tgl BETWEEN '2020-10-31' AND '$tgl'
                            GROUP BY t.id_kandang
                        )  tel1 ON tel1.id_kandang = a.id_kandang
                        LEFT JOIN 
                        (
                            SELECT sum(pcs) as tHariKemarin,sum(kg) as kHariKemarin, a.id_kandang FROM `tb_telur` as a
                            WHERE a.tgl = '$tgl2' GROUP BY a.id_kandang
                        ) telurK ON telur.id_kandang = a.id_kandang
                        LEFT JOIN
                        (
                            SELECT a.id_kandang, SUM(pcs) as tPcsSeminggu,SUM(kg) as tKgSeminggu FROM `tb_telur` as a
                            WHERE a.tgl BETWEEN '$tgl3' AND '$tgl'
                            GROUP BY a.id_kandang
                        ) telurPs ON telurPs.id_kandang = a.id_kandang
                        LEFT JOIN
                        (
                            SELECT a.id_kandang, SUM(pcs) as tPcsSeminggu2 FROM `tb_telur` as a
                            WHERE a.tgl BETWEEN '$tgl4' AND '$tgl3'
                            GROUP BY a.id_kandang
                        ) telurPs2 ON telurPs.id_kandang = a.id_kandang
                        LEFT JOIN 
                        (
                            SELECT *,
                            SUM(t.pcs) AS tKumPcs,
                            SUM(t.kg) as tKumKg
                            FROM `tb_telur` t
                            WHERE t.tgl BETWEEN '2020-01-01' AND '$tgl'
                            GROUP BY t.id_kandang
                        ) as kum ON kum.id_kandang = a.id_kandang
                        LEFT JOIN 
                        (
                        SELECT *,
                            SUM(vt.kg) AS kuml1,
                            SUM(vt.pcs) AS kuml3
                            FROM tb_telur vt
                            WHERE vt.tgl BETWEEN '2020-01-01' AND '$tgl'
                            GROUP BY vt.id_kandang
                        )vtl ON vtl.id_kandang = a.id_kandang
                        LEFT JOIN 
                        (
                            SELECT kn.id_kandang,
                            SUM(((kn.ayam_awal * pe.telur)/100)*7) AS telpef,
                            SUM(((((kn.ayam_awal * pe.telur)/100)*7) * pe.berat_telur) / 1000) AS telkg
                            FROM tb_performa AS pe
                            LEFT JOIN tb_kandang AS kn ON kn.id_strain = pe.id_strain
                            WHERE pe.umur BETWEEN 18 AND (TIMESTAMPDIFF(WEEK, kn.tgl_masuk , '$tgl') + 1) 
                            GROUP BY kn.id_kandang
                        ) as pef ON pef.id_kandang = a.id_kandang
                        LEFT JOIN
                        (
                            SELECT cost as cost_vaksin,id_kandang FROM tb_vaksin
                            WHERE tgl = '$tgl'
                            GROUP BY id_kandang
                            ORDER BY id_kandang asc
                        ) as vaks ON vaks.id_kandang = a.id_kandang
                        WHERE a.selesai != 'Y' AND pop.tgl = '$tgl'
                        GROUP BY a.id_kandang
                        ORDER BY a.nm_kandang ASC");
        $data = [
            'tgl' => $tgl,
            'kandang' => $kandang,
            'h_pakan' => $h_pakan,
            'layer' => $layer
        ];
        return view('layer.laporan.laporanLayer', $data);
    }

}
