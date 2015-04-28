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
	<div class="container-fluid">
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
			<form action="<?php echo base_url('index.php/product/update_action/'.$data->productid); ?>" method="post">
		
				<input type="hidden" class="form-control" placeholder="Product Id" name="id" value="<?php echo $data->productid; ?>" />
				<input type="text" class="form-control" placeholder="Product Name" name="name" value="<?php echo $data->productname; ?>" />
				<select class="form-control" name="category">
					<?php
						for($i=0;$i<count($categories);$i++){
					?>
						<option value="<?php echo $categories[$i]->categoryid; ?>" <?php if($data->categoryid==$categories[$i]->categoryid){echo "selected=\"selected\"";} ?> >
						<?php echo $categories[$i]->categoryname; ?>
						</option>
					<?php
						}
					?>
				</select>
				<input type="text" class="form-control" placeholder="Harga Grosir" name="grosir" value="<?php echo $data->hargagrosir; ?>" />
				<input type="text" class="form-control" placeholder="Harga Eceran" name="eceran" value="<?php echo $data->hargaeceran; ?>" />
				<input type="text" class="form-control" placeholder="Stock" name="stock" value="<?php echo $data->stock; ?>" />
				<textarea  class="form-control" placeholder="Description" name="description"  ><?php echo $data->description; ?></textarea>
				<input type="submit" class="btn btn-primary" value="Update" />
			</form>
		</div>
		</div>
		</div>
	
	</body>
</html>