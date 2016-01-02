<?php $this->load->view("template/script_hitungTotal");?>
<div class="message" style="background-color: white; padding:3px;"> INFO : Jika barang yang dipilih tidak lengkap harap hubungi kantor pusat. </div>
<table width="100%" id="data"  align="center">
		
		<tr>
			<td width="116">Silahkan ketik</td>
			<td width="367">Nama Barang</td>
		</tr>
		<tr id="formAddBrg">
			<td>Pilih Barang </td>
			<td><input type="text" name="" class="nameBarang"  style="width:100%;" /></td>
			<td><div id="resultPilihBarang"></div><div id="resultPilihBarangFree"></div></td>
		</tr>
</table>
<div>
<style type="text/css">
table .scroll {
	padding: 2px 2px 2px 2px;
}
/*membuat warna untuk striped*/
.scroll tbody tr:nth-child(odd) {
   background-color: #fff;
}
.scroll tbody tr:nth-child(even) {
   background-color: #ccc;
}

</style>
<div id="listBarang" style="width:100%;">
 	<table class= "scroll" width="100%" border="1">
 		<thead>
 			<tr>
 				<th>Nama Barang</th>
 				<th>Action</th>
 			</tr>
 		</thead>
 		<tbody id="addTbarang">
 			
 		</tbody>
 	</table>
 </div>
 
<?php 
$this->load->view("template/script/form_add_brg");
?>