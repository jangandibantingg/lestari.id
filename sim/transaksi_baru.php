<script type="text/javascript">
	document.title="Transaksi Baru";
	document.getElementById('transaksi').classList.add('active');
</script>
<script type="text/javascript">
		$(document).ready(function(){
			if ($.trim($('#contenth').text())=="") {
				$('#prosestran').attr("disabled","disabled");
				$('#prosestran').attr("title","tambahkan barang terlebih dahulu");
				$('#prosestran').css("background","#ccc");
				$('#prosestran').css("cursor","not-allowed");
			}
		})

</script>

<script type="text/javascript">
    //  $("#id_barang")..select2();
     $(document).ready(function() {
      $("#id_barang").select2();
      $(window).resize(function() {
    $('.select2').css('width', "20%");
});

    });
</script>
<div class="content">
	<!doctype html>
	<html>
	    <head>
	        <!-- <title>Select2 - harviacode.com</title> -->
	        <!-- <link rel="stylesheet" href="bootstrap.min.css"/>
	        <link rel="stylesheet" href="select2.min.css"/> -->
	    </head>
	</html>

	<div class="padding">
		<div class="bgwhite">
			<div class="padding">

				<h3 class="jdl">Entry  Transaksi Baru</h3>
				<form class="form-input" method="post" action="handler.php?action=tambah_tempo" style="padding-top: 30px;">
					<div style="padding: 15px">
	            <div class="form-group">
	                <label>Pilih Barang : </label><br>
	                <select  class="form-control" id="id_barang" name="id_barang">
	                    <option value=""> Pilih Barang</option>
											<?php
											$data=$root->con->query("SELECT * from barang where stok !='0' ");
											while ($f=$data->fetch_assoc()) {
												echo "<option value='$f[id_barang]'>$f[nama_barang] (stock : $f[stok] | Harga : ".number_format($f['harga_jual']).")</option>";
											}
											?>
	                </select>
	            </div>

	        </div>
					<!-- <label>Pilih Barang : </label> -->
					<!-- <select style="width: 372px;cursor: pointer;" required="required" name="id_barang">
						<option value=""></option>

					</select> -->
					<label>Jumlah Beli :</label>
					<input required="required" type="number" name="jumlah" value="1">
					<label>Diskon :</label>
					<input required="required" type="number" name="diskon" value="0">

					<input type="hidden" name="trx" value="<?php echo date("d")."/AF/".$_SESSION['id']."/".date("y") ?>">


					<button class="btnblue" type="submit"><i class="fa fa-save"></i> Simpan</button>
				</form>
				<!--<script src="assets/jquery-1.11.2.js"></script>-->
				<!--<script src="select2.min.js"></script>-->
				<!--<script>-->
				<!--		$(document).ready(function () {-->
				<!--				$("#id_barang").select2({-->
				<!--						placeholder: "Please Select"-->
				<!--				});-->

				<!--				$("#kota2").select2({-->
				<!--						placeholder: "Please Select"-->
				<!--				});-->
				<!--		});-->
				<!--</script>-->
			</div>
		</div>
		<br>
		<div class="bgwhite">
			<div class="padding">
				<h3 class="jdl">Data transaksi</h3>
				<table class="datatable" style="width: 100%;">
				<thead>
				<tr>
					<th width="35px">NO</th>
					<th>ID Barang</th>
					<th>Nama Barang</th>
					<th>Jumlah Beli</th>
					<th>Diskon</th>
					<th>Total Sebelum Diskon</th>
					<th>Total Harga</th>
					<th>Aksi</th>
				</tr>
			</thead>
			<tbody id="contenth">
				<?php
				$trx=date("d")."/AF/".$_SESSION['id']."/".date("y");
				$data=$root->con->query("select barang.nama_barang,tempo.id_subtransaksi,tempo.id_barang,tempo.jumlah_beli,tempo.diskon,tempo.total_sebelum_diskon,tempo.total_harga from tempo inner join barang on barang.id_barang=tempo.id_barang where trx='$trx'");
				$getsum=$root->con->query("select sum(total_harga) as grand_total from tempo where trx='$trx'");
				$getsum1=$getsum->fetch_assoc();
				$no=1;
				while ($f=$data->fetch_assoc()) {
					?><tr>
						<td><?= $no++ ?></td>
						<td><?= $f['id_barang'] ?></td>
						<td><?= $f['nama_barang'] ?></td>
						<td><?= $f['jumlah_beli'] ?></td>
						<td><?= $f['diskon'] ?> % </td>
						<td>Rp. <?= number_format($f['total_sebelum_diskon']) ?></td>
						<td>Rp. <?= number_format($f['total_harga']) ?></td>
						<td><a href="handler.php?action=hapus_tempo&id_tempo=<?= $f['id_subtransaksi'] ?>&id_barang=<?= $f['id_barang'] ?>&jumbel=<?= $f['jumlah_beli'] ?>&diskon=<?= $f['diskon']?>&total_sebelum_diskon=<?= $f['total_sebelum_diskon']?>" class="btn redtbl"><span class="btn-hapus-tooltip">Cancel</span><i class="fa fa-close"></i></a></td>
						</tr>
					<?php
				}
				?>
			</tbody>

				<tr>
					<?php if ($getsum1['grand_total']>0) { ?>
					<td colspan="3"></td><td>Grand Total :</td>
					<td> Rp. <?= number_format($getsum1['grand_total']) ?></td>
					<td></td>
					<?php }else{ ?>
					<td colspan="6">Data masih kosong</td>
					<?php } ?>
				</tr>

			</table>
			<br>
			<form class="form-input" action="handler.php?action=selesai_transaksi" method="post">
					<label>Nama Pembeli :</label>
					<input required="required" type="text" name="nama_pembeli" value="Pelanggan">
					<label>Tunai :</label><br>
					<!-- <button type="button" id="nominal0" class="btn btn-danger " onclick="myFunction(0)" name="button" value="<?php echo "".number_format($total).""; ?>">Uang Pas</button> -->
					<button class="btnblue" onclick="myFunction(1)" id="nominal1" value="<?= $getsum1['grand_total'] ?>" type="button">Uang Pas</button>
					<button class="btnblue" onclick="myFunction(2)" id="nominal2" value="50000"  type="button">50.000</button>
					<button class="btnblue" onclick="myFunction(3)" id="nominal3" value="100000" type="button">100.000</button>
					<button class="btnblue" onclick="myFunction(4)" id="nominal4" value="150000" type="button">150.000</button>
					<button class="btnblue" onclick="myFunction(5)" id="nominal5" value="200000" type="button">200.000</button>
					<input required="required" type="text" id="money" name="tunai" placeholder="isi nominal pembayaran">


					<br>


					<input type="hidden" name="total_bayar" value="<?= $getsum1['grand_total'] ?>">
					<button class="btnblue" id="prosestran" type="submit"><i class="fa fa-save"></i> Proses Transaksi</button>



			</form>

			</div>
		</div>


	</div>
</div>
<script>
function myFunction(id) {
	var nominal = document.getElementById("nominal"+id).value;
	document.getElementById("money").value = nominal;
}
</script>


<?php
include "foot.php";
?>
