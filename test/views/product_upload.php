<html>
	<head>
		<link href="<?php echo base_url('css\bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url('js\jquery-2.1.1.min.js'); ?>"></script>
		<script>
			var URL="<?php echo base_url('index.php/services/').'/'; ?>";
			var URL_IMAGE="<?php echo base_url('image/items/').'/'; ?>";
			var files;
		
			function readURL(input) {
				if (input.files && input.files[0]) {
					var reader = new FileReader();

					reader.onload = function (e) {
						$('#image_upload').attr('src', e.target.result);
						
					}
					files=input.files[0];
					reader.readAsDataURL(input.files[0]);
				}
			}


			$(document).ready(function(){
				$("#submit_upload").click(function(){
					var data=new FormData();
					data.append("productid", productid_upload.value);
					data.append("userfile", files);
					$.ajax({
						"url":URL+"product_image_upload/",
						"type":"POST",
						"contentType":false,
						"dataType":"JSON",
						"data":data,
						"cache":false,
						"processData":false
						}).success(function(result){
							$("#error_upload").html(result['status']);
					});
					
					return false;
				});
				$("#url_upload").change(function(){
					readURL(this);
				});
			});
			
		</script>
		<style>
			form>input{
				margin-bottom:8px;
			}
		</style>
		
	</head>
	<body>
	<h2>Product</h2>
	<button id="btn_back" class="btn btn-warning">Back</button>
	<script type="text/javascript">
			document.getElementById("btn_back").onclick = function () {
				location.href = "<?php echo base_url('index.php/product/') ?>";
			};
		</script>
	<div class="container-fluid">
		<div class="row">
		<div class="col-lg-12">
			<form id="form_upload" method="post" enctype="multipart/form-data" >
				<img id="image_upload" src="<?php echo base_url("image/items/".(($data->gambar==null)?"no_image_thumb.jpg":$data->gambar)); ?>" />
				<input id="productid_upload" type="hidden" name="productid" class="form-control"  value="<?php echo $data->productid; ?>" />
				<input id="url_upload" type="file" name="userfile" class="form-control"   />
				
				
			</form>
			<input id="submit_upload" type="button" class="btn btn-primary" value="Upload" />
			<div id="error_upload"></div>
		</div>
		</div>
		</div>
	
	</body>
</html>