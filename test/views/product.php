<html>
	<head>
		<link href="<?php echo base_url('css\bootstrap.min.css'); ?>" rel="stylesheet" type="text/css" />
		<script src="<?php echo base_url('js\jquery-2.1.1.min.js'); ?>"></script>
		<script type="text/javascript">
		var URL="<?php echo SERVICES; ?>";
		var URL_IMAGE="<?php echo SERVICES_IMAGE; ?>";
		var offset=0;
		var limit=5;
		var cat='productname';
		var search='';
		
		function loadImage(url, fn) {
			var newImg = new Image;
			newImg.src = url
			newImg.onload = fn;
		}

		function createDOM(name,attr,child){
			var dom=document.createElement(name);
			if(attr!=null){
				if(typeof(attr)!='undefined'){
					for (var k in attr){
						if (attr.hasOwnProperty(k)) {
							 dom.setAttribute(k,attr[k]);
						}
					}
				}
			}

			if(typeof(attr)!='undefined'){
				for (var k in child){
					if (child.hasOwnProperty(k)) {
						 dom.appendChild(child[k]);
					}
				}
			}
			return dom;
		}

		function appendText(text){
			var newContent = document.createTextNode(text); 
			return newContent
		}

		function isNumber(n) {
			return !isNaN(parseFloat(n)) && isFinite(n);
		}
		
		function upload_action(id){
			location.href = "<?php echo base_url('index.php/product/upload/'); ?>"+'/'+id;
		}
		
		function delete_action(id,btn){
			
			$.ajax({"type":"GET",
			"url":URL+"product_delete/i/"+id,
			dataType:"JSON"}).done(function(result){
				if(result['status']=="success"){
					btn.parentNode.parentNode.remove();
					offset-=1;
				}
				else{
					
				}
			});
		}
		
		function update_action(id){
			location.href = "<?php echo base_url('index.php/product/update/') ?>"+'/'+id;
		}
		
		function loadData(result){
				
				for (var k in result["result"]){
					$("#table_content_product").append
					(
						createDOM("tr",null,
							{
							
								"tr":createDOM('td',null,{"text":appendText(result['result'][k]['productid'])}),
								"tr2":createDOM('td',null,{"text":appendText(result['result'][k]['productname'])}),
								"tr3":createDOM('td',null,{"text":appendText(result['result'][k]['categoryname'])}),
								"tr4":createDOM('td',null,{"text":appendText(result['result'][k]['hargagrosir'])}),
								"tr5":createDOM('td',null,{"text":appendText(result['result'][k]['hargaeceran'])}),
								"tr6":createDOM('td',null,{"text":appendText(result['result'][k]['stock'])}),
								"tr7":createDOM('td',null,{"img":createDOM('img',{width:'50',height:'50','src':URL_IMAGE+((result['result'][k]['gambar']==null)?"no_image_thumb.jpg":result['result'][k]['gambar'])})}),
								"tr8":createDOM('td',null,{"text":appendText(result['result'][k]['description'].substring(0,10)+'. . .')}),
								"tr9":createDOM('td',null,
									{
										"btnUpload":createDOM
										(
											'button',
											{
											'onclick':"upload_action("+result['result'][k]['productid']+")",
											'class':'btn btn-warning btn-upload'
											
											},
											{'text':appendText('Upload')}
										)
									}
								),
								"tr10":createDOM('td',null,(result['result'][k]['published_at']!=null)?{"text":appendText("")}:
									{
										"btn":createDOM
										(
											'button',
											{
											'onclick':"published_action("+result['result'][k]['productid']+",this)",
											'class':'btn btn-primary btn-publihed'
											
											},
											{'text':appendText('Published')}
										)
									}
								),
								"tr11":createDOM('td',null,
									{
										"btn":createDOM
										(
											'button',
											{
											'onclick':"update_action("+result['result'][k]['productid']+")",
											'class':'btn btn-info btn-update'
											
											},
											{'text':appendText('Update')}
										)
									}
								),
								"tr12":createDOM('td',null,
									{
										"btnUpload":createDOM
										(
											'button',
											{
											'onclick':"delete_action("+result['result'][k]['productid']+",this)",
											'class':'btn btn-danger btn-upload'
											
											},
											{'text':appendText('Delete')}
										)
									}
								)
							}
						)
					);
					
				};
		}
		
		function loadMore(){
			$("#load_content").html("");
			$.ajax({
				url:URL+"products/o/"+offset+"/l/"+limit+"/method/admin/cat/"+cat+"/search/"+search,
				type:"GET",
				dataType:"JSON",
			}).done(function(result){
			
				offset+=result['result'].length;
				loadData(result);
				$("#load_content").html("");
				if(result['next']>0){
				
					$("#load_content").append(
						createDOM(
							'button',{
								'class':'btn btn-primary','style':'text-align:center;','onclick':'loadMore()'
							},
							{'text':appendText('Load More...')}
						)
					);
				}
				
			});
		}
		
		function search_action(){
			offset=0;
			$.ajax({
				url:URL+"products/o/"+offset+"/l/"+limit+"/method/admin/cat/"+cat+"/search/"+search,
				type:"GET",
				dataType:"JSON",
			}).done(function(result){
				
				$("#table_content_product").html("");
				$("#load_content").html("");
				offset+=result['result'].length;

				loadData(result);
				if(result['next']>0){
				
					$("#load_content").append(
						createDOM(
							'button',{
								'class':'btn btn-primary','style':'text-align:center;','onclick':'loadMore()'
							},
							{'text':appendText('Load More...')}
						)
					);
				}
				
			});
		}
		
		function published_action(id,btn){
			$.ajax({"type":"GET",
			"url":URL+"product_publish/i/"+id,
			dataType:"JSON"}).done(function(result){
				if(result['status']=="success"){
					btn.remove();
				}
				else{
				
				}
			});
		}
		
		$(document).ready(function(){
			
			$("#btn_insert").click(function(){
				location.href = "<?php echo base_url('index.php/product/insert/') ?>";
			});
			
			$.ajax({
				url:URL+"products/o/"+offset+"/l/"+limit+"/method/admin",
				type:"GET",
				dataType:"JSON",
			}).done(function(result){
				$("#table_content_product").html("");
				offset+=result['result'].length;
				loadData(result);
				$("#load_content").html("");
				if(result['next']>0){
				
					$("#load_content").append(
						createDOM(
							'button',{
								'class':'btn btn-primary','style':'text-align:center;','onclick':'loadMore()'
							},
							{'text':appendText('Load More...')}
						)
					);
				}
				
			});
			
			$("#btn_search").click(function(){
				cat="productname";
				search=txt_search.value;
				search_action();
			});
		});
			
			
			
			
	</script>
	</head>
	<body>
	
	
	<div class="container-fluid" >
		<div class="row">
			<div class="col-lg-12">
			<h2>Product</h2>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<button id="btn_insert" class="btn btn-warning" style="margin:10px 0px;">Insert</button>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<input type="text" id="txt_search" class="form-control" />
				<button id="btn_search" class="btn btn-info" style="margin:10px 0px;">Search</button>
			</div>
		</div>
	
		<div class="row">
			<div class="col-lg-12">
			
			<table class="table" id="table_product">
				<thead>
					<tr>
						<th>Product Id</th>
						<th>Product Name</th>
						<th>Category</th>
						<th>Harga Grosir</th>
						<th>Harga Eceran</th>
						<th>Stock</th>
						<th>Gambar</th>
						<th>Description</th>
						<th>Upload</th>
						<th>Published</th>
						<th>Update</th>
						<th>Delete</th>
					</tr>
				</thead>
				<tbody id="table_content_product">
				</tbody>
			</table>
			</div>
		</div>
		
		<div class="row">
			<div class="col-lg-12" id="load_content">
			</div>
		</div>
	</div>
		
		
	
	</body>
</html>