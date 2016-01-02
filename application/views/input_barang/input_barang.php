<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title></title>
	<!-- Latest compiled and minified CSS -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

	<!-- Optional theme -->
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

	<!-- Latest compiled and minified JavaScript -->
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
	<style>
		body{
			margin:25px;
		}
	</style>
</head>
<body>
	<div class="container">
		<div class="well">
			<div class="row">
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-6">
							<label>Jenis Promo :</label>
							<select class="form-control">
								<option>A</option>
								<option>B</option>
								<option>C</option>
							</select>
							<input type="text" id="kdpencarian" class="form-control" placeholder="Pencarian">
						</div>
						
					</div>
				</div>

				<div class="col-md-4">
					<div class="row">
						<div class="col-md-6">
							<label>Qty Bayar: </label><input type="text" id="kdpencarian" class="form-control">
						</div>
						<div class="col-md-6">
							<label>Qty Free: </label><input type="text" id="kdpencarian" class="form-control">
						</div>
						
					</div>
				</div>
			</div>
		</div>
		<div class="well">
			<label>Nama Barang: </label><input type="text" id="nmbrg" >
		</div>
		<div class="well">
			<label><input type="checkbox" id="hrgcustom"> Harga Custom</label>
			<div class="row">
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-6">
							<label>Harga Jawa</label>
							</div>
						<div class="col-md-6">
						<input type="text" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>PV Jawa</label>
						</div>
						<div class="col-md-6">
								<input type="text" class="form-control">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-6">
							<label>Harga Luar Jawa</label>
							</div>
						<div class="col-md-6">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>PV Luar Jawa</label>
							</div>
						<div class="col-md-6">
							<input type="text" class="form-control">
						</div>
					</div>
				</div>
				<div class="col-md-4">
					<div class="row">
						<div class="col-md-6">
							<label>Harga Luar Kualalumpur</label>
							</div>
						<div class="col-md-6">
							<input type="text" class="form-control">
						</div>
					</div>
					<div class="row">
						<div class="col-md-6">
							<label>PV Luar Kualalumpur</label>
							</div>
						<div class="col-md-6">
							<input type="text" class="form-control">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="container">
		<table class="table">
			<thead>
				<tr>
					<th>Nama Barang Bayar</th>
					<th>Nama Barang Free</th>
					<th>Qty Bayar</th>
					<th>Qty Free</th>
					<th>Harga Jawa</th>
					<th>Harga Luar Jawa</th>
					<th>Harga Luar Kualalumpur</th>
					<th>PV Jawa</th>
					<th>PV Luar Jawa</th>
					<th>PV Luar Kualalumpur</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td>
						<input type="text" name="intid_barang">
					</td>
					<td>
						<input type="text" name="intid_barang_free">
					</td>
					<td>data</td>
					<td>data</td>
					<td>data</td>
					<td>data</td>
					<td>data</td>
					<td>data</td>
					<td>data</td>
					<td>data</td>
				</tr>
			</tbody>
		</table>
	</div>
</body>
</html>