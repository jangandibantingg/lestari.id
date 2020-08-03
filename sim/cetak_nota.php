<?php
require('assets/lib/fpdf.php');
class PDF extends FPDF
{
function Header()
{
    $this->SetFont('Arial','B',30);
    $this->Cell(30,10,'Lestari');
//     Jl. A Yani 187 Nganjuk
// Whatsapp 082140468989
// Ig @lestaringk
    $this->Ln(10);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Jl. A Yani 187 Nganjuk');

    $this->cell(100);
    $this->SetFont('Arial','',10);
    $this->cell(40,10,'Nganjuk, '.base64_decode($_GET['uuid']).'');
    $this->Line(10,40,200,40);

    $this->Ln(5);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'Whatsapp 082140468989 / Ig @lestaringk');
    $this->Line(10,40,200,40);

    $this->Cell(100);
    $this->SetFont('Arial','u',12);
    $this->Cell(30,10,'Kepada : '.base64_decode($_GET['id-uid']).'',0,'C');

    $this->Ln(5);
    $this->SetFont('Arial','i',10);
    $this->cell(30,10,'No Invoice : '.base64_decode($_GET['inf']).'');
    $this->Line(10,40,200,40);
}
function LoadData(){
	include 'koneksites.php';
	$id=base64_decode($_GET['oid']);
	$data=mysqli_query($conn, "select sub_transaksi.jumlah_beli,sub_transaksi.diskon,barang.nama_barang,barang.harga_jual,sub_transaksi.total_harga from sub_transaksi inner join barang on barang.id_barang=sub_transaksi.id_barang where sub_transaksi.id_transaksi='$id'");

	while ($r=  mysqli_fetch_array($data))
		        {
		            $hasil[]=$r;
		        }
		        return $hasil;
}
function BasicTable($header, $data)
{

    $this->SetFont('Arial','B',12);
        $this->Cell(75,7,$header[0],1);
        $this->Cell(15,7,$header[1],1);
        $this->Cell(30,7,$header[2],1);
        $this->Cell(25,7,$header[3],1);
        $this->Cell(40,7,$header[4],1);
    $this->Ln();

    $this->SetFont('Arial','',12);
    foreach($data as $row)
    {
        $this->Cell(75,7,$row['nama_barang'],1);
        $this->Cell(15,7,$row['jumlah_beli'],1);
        $this->Cell(30,7,"Rp ".number_format($row['harga_jual']),1);
        $this->Cell(25,7,$row['diskon'],1);
        $this->Cell(40,7,"Rp ".number_format($row['total_harga']),1);
        $this->Ln();
    }


	$id=base64_decode($_GET['oid']);
  $getsum=mysqli_query($conn,"select sum(total_harga) as grand_total,sum(jumlah_beli) as jumlah_beli from sub_transaksi where id_transaksi='$id'");
	$getsum1=mysqli_fetch_array($getsum);

  $this->cell(75);
	$this->cell(15);
	$this->cell(30);
	$this->cell(25,7,'Sub total : ');
	$this->cell(40,7,'Rp. '.number_format($getsum1['grand_total']).'',1);

	$this->Ln(30);
  $this->SetFont('Arial','',15);
  session_start();
  $this->cell(30,-10,'Diterima Oleh : '.$_SESSION['username'].'');
  $this->Ln(10);
  $this->SetFont('Arial','',11);
  $this->cell(30,-10,'* Barang Yang Sudah Dibeli Tidak Bisa Dikembalikan.');
}
}

$pdf = new PDF();
$pdf->SetTitle('Invoice : '.base64_decode($_GET['inf']).'');
$pdf->AliasNbPages();
$header = array( 'Nama Barang','Qty','Harga' ,'Diskon (%)','Total Harga');
$data = $pdf->LoadData();
$pdf->AddPage();
$pdf->Ln(20);
$pdf->BasicTable($header,$data);
$filename=base64_decode($_GET['inf']);
$pdf->Output('','Lestari/'.$filename.'.pdf');
?>
