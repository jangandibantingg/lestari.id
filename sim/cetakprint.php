<?php
include "root.php";
date_default_timezone_set("Asia/Jakarta");
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <link rel="stylesheet" type="text/css" href="assets/index.css">
    <link rel="stylesheet" type="text/css" href="assets/awesome/css/font-awesome.min.css">
    <!--<script type="text/javascript" src="assets/jquery.js"></script>-->
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/normalize/3.0.3/normalize.css">
<link rel="stylesheet" href="print/paper.css">
<style>
  @page { size: 80mm 100mm } /* output size */
  body.receipt .sheet { width: 80mm; } /* sheet size */
  @media print { body.receipt { width: 58mm } } /* fix for Chrome */
</style>
<style>
  body   { font-family: serif }
  h1     { font-family: 'Tangerine', cursive; font-size: 40pt; line-height: 18mm}
  h2, h3 { font-family: 'Tangerine', cursive; font-size: 24pt; line-height: 7mm }
  h4     { font-size: 32pt; line-height: 14mm }
  h2 + p { font-size: 18pt; line-height: 7mm }
  h3 + p { font-size: 14pt; line-height: 7mm }
  li     { font-size: 11pt; line-height: 5mm }
  table     { font-size: 9pt; line-height: 5mm }

  h1      { margin: 0 }
  h1 + ul { margin: 2mm 0 5mm }
  h2, h3  { margin: 0 3mm 3mm 0; float: left }
  h2 + p,
  h3 + p  { margin: 0 0 3mm 50mm }
  h4      { margin: 2mm 0 0 50mm; border-bottom: 2px solid black }
  h4 + ul { margin: 5mm 0 0 50mm }
  article { border: 4px double black; padding: 5mm 10mm; border-radius: 3mm }
</style>
<style>
  @page {
    size: auto;
    margin: 0;
  }
</style>
  </head>
  <body class="receipt">
     <section class="sheet padding-10mm">


      <img src="logo.jpeg" alt=""/ width="200px"> <br>



      <p align="center"> Jalan A. Yani 189 Nganjuk  </p>
      <p align="center"> Wa : 082140468989 </p>
      <p align="center"> @lestaringk </p>
      <!-- <span class="text-center">jalan ayani</span> <br> -->
      <small>

    ------------------------------------------
     <br>
      Invoice <?php echo "$_GET[no_invoice]"; ?><br>
      <p align="left"> Date <?php echo "".date('D-M, Y')." ".date('H:i').""; ?> </p>


            ------------------------------------------<br>
      	<table class="resposive">
        <thead>
          <tr>
            <td>jml</td>
            <td align="center">Name</td>
            <td align="center">Disc</td>
            <td align="center">Price</td>
          </tr>
        </thead>
        <tbody>


      <?php
    	$data=$root->con->query("select * from barang,sub_transaksi where barang.id_barang=sub_transaksi.id_barang and sub_transaksi.no_invoice='$_GET[no_invoice]'");
    	while ($r=$data->fetch_assoc()) {
        echo "<tr>
                  <td> $r[jumlah_beli]X</td>
                  <td align='center'><b> $r[nama_barang]</b></td>
                  <td align='center'> $r[diskon]%</td>
                  <td align='right'>".number_format($r['total_harga'])."</td>

              <tr>";
              $subtotal=$subtotal+$r['total_harga'];
      }

       ?>
     </tbody>
     </table>
       ------------------------------------------<br>
       <p align="right"> Subtotal Rp. <?php echo "".number_format($subtotal).""; ?></p>
       <p align="right"> Cash Rp. <?php echo "".number_format($_GET['tunai']).""; ?></p>
       <p align="right"> Kembali Rp. <?php echo "".number_format($_GET['kembali']).""; ?></p>



       ------------------------------------------<br>
       <p align="center"> Thank for Your Shoping </p>
       <p align="center"> Every Purchase Cannot </p>
       <p align="center"> Be Returned </p>


       <!-- <p align="center">http://lestaringanjuk.com/</p> -->


       <br>

     </small>


  </section>
  <script type="text/javascript">
<!--
window.print();
//-->
</script>
  </body>
</html>
