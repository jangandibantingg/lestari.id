<?php
require('assets/lib/fpdf.php');
class PDF extends FPDF
{
    function Header()
    {
        $this->SetFont('Arial','B',30);
        $this->Cell(30,10,'Lestari');

        $this->Ln(10);
        $this->SetFont('Arial','i',10);
        $this->cell(30,10,'JJl. A Yani 187 Nganjuk');


        $this->Ln(5);
        $this->SetFont('Arial','i',10);
        $this->cell(30,10,'Whatsapp 082140468989 / Ig @lestaringk');


        $this->Ln(5);
        $this->SetFont('Arial','i',10);
        $this->cell(30,10,'Data Laporan Tanggal : '.$_POST['tgl_laporan'].'');

        $this->Ln(5);
        $this->SetFont('Arial','i',10);
        $this->cell(30,10,'Jenis : '.$_POST['jenis_laporan'].'');

        $this->cell(130);
        $this->SetFont('Arial','',10);
        $this->cell(30,10,'Nganjuk, '.date("d-m-Y").'');

        $this->Line(10,45,200,45);
    }
    function data_barang(){
        mysql_connect("localhost","lestarin_root","Nganjuklestar1");
        mysql_select_db("lestarin_imk");
        $tanggal=$_POST['tgl_laporan'];
        if ($_POST['jenis_laporan']=="perhari") {
            $split1=explode('-',$tanggal);
            $tanggal=$split1[2]."-".$split1[1]."-".$split1[0];
            $query=mysql_query("select transaksi.id_transaksi,transaksi.tgl_transaksi,transaksi.no_invoice,transaksi.total_bayar,transaksi.nama_pembeli,user.username from transaksi inner join user on transaksi.kode_kasir=user.id where transaksi.tgl_transaksi like '%$tanggal%' order by transaksi.id_transaksi desc");
        }else{
            $split1=explode('-',$tanggal);
            $tanggal=$split1[1]."-".$split1[0];
            $query=mysql_query("select transaksi.id_transaksi,transaksi.tgl_transaksi,transaksi.no_invoice,transaksi.total_bayar,transaksi.nama_pembeli,user.username from transaksi inner join user on transaksi.kode_kasir=user.id where transaksi.tgl_transaksi like '%$tanggal%' order by transaksi.id_transaksi desc");
        }
        while ($r=  mysql_fetch_array($query))
                {
                    $hasil[]=$r;
                }
                return $hasil;

    }
    function set_table($data){
        $this->SetFont('Arial','B',9);
        $this->Cell(10,7,"No",1);
        $this->Cell(40,7,"No Invoice",1);
        $this->Cell(20,7,"Kasir",1);
        $this->Cell(40,7,"Nama Pembeli",1);
        $this->Cell(40,7,"Tanggal Transaksi",1);
        $this->Cell(40,7,"Total Bayar",1);
        $this->Ln();

        $this->SetFont('Arial','',9);
        $no=1;
        foreach($data as $row)
        {
            $this->Cell(10,7,$no++,1);
            $this->Cell(40,7,$row['no_invoice'],1);
            $this->Cell(20,7,$row['username'],1);
            $this->Cell(40,7,$row['nama_pembeli'],1);
            $this->Cell(40,7,date("d-m-Y h:i:s",strtotime($row['tgl_transaksi'])),1);
            $this->Cell(40,7,"Rp. ".number_format($row['total_bayar']),1);
            $this->Ln();
        }
    }
}

$pdf = new PDF();
$pdf->SetTitle('Cetak Data Barang');

$data = $pdf->data_barang();

$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->Ln(20);
$pdf->set_table($data);
$pdf->Output('','JUALO/Barang/'.date("d-m-Y").'.pdf');
?>
