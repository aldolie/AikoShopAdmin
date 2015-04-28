<html>
	<head>
		<link href="<?php echo base_url('css\bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
		<style>
			form>input,form>select,form>textarea{
				margin-bottom:8px;
			}
		</style>
	</head>
	<body>
	
	<div class="container-fluid" style="margin:10px;">
		<div class="row">
			<div class="col-lg-12">
			<h2>Product</h2>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12">
				<button id="btn_back" class="btn btn-warning" style="margin:10px;">Back</button>
			</div>
		</div>
		<script type="text/javascript">
			document.getElementById("btn_back").onclick = function () {
				location.href = "<?php echo base_url('index.php/product/') ?>";
			};
		</script>
		<div class="row">
		<div class="col-lg-12">
			<form action="<?php echo base_url('index.php/product/insert_action'); ?>" method="post">
		
				<input type="text" class="form-control" placeholder="Product Name" name="name" />
				<select class="form-control" name="category">
					<?php
						for($i=0;$i<count($data);$i++){
					?>
						<option value="<?php echo $data[$i]->categoryid; ?>"><?php echo $data[$i]->categoryname; ?></option>
					<?php
						}
					?>
				</select>
				<input type="text" class="form-control" placeholder="Harga Grosir" name="grosir"/>
				<input type="text" class="form-control" placeholder="Harga Eceran"  name="eceran" />
				<input type="text" class="form-control" placeholder="Stock"  name="stock" />
				<textarea class="form-control" placeholder="Description"  name="description" ></textarea>
				<input type="submit" class="btn btn-primary" value="Insert" />
			</form>
		</div>
		</div>
		</div>
	
	</body>
</html>