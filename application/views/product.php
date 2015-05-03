 <div class="container-fluid" ng-controller="ProductController">
			
			
			<div class="row">
                    <div class="col-lg-12" ng-cloak>
                        <h1 style="display:inline-block;vertical-align:top;" >{{ heading }}</h1>
						<span style="vertical-align:top;margin-bottom:10px;margin-top:20px;margin-left:10px;background:#eee;cursor:pointer;padding:10px;border-radius:5px;" title="Insert Product" ng-click="showInsert()" class="glyphicon glyphicon-plus" aria-hidden="true"></span>
									
						<form ng-show="insertFlag" class="form_product_update form-horizontal" ng-submit="insert()">
							<div class="form-group">
								<label for="name" class="col-sm-4">Nama Produk</label>
								<div class="col-sm-8">
									<input type="text" ng-model="form.productname"  class="form-control" placeholder="Product Name" name="name"   />
								</div>
							</div>
							
							<div class="form-group">
								<label for="category" class="col-sm-4">Category</label>
								<div class="col-sm-8">
									<select class="form-control" ng-model="form.categoryid" name="category" ng-init="form.categoryid=1">
										<option  ng-repeat="category in categories" value="{{::category.categoryid}}">{{category.categoryname}}</option>
									</select>
								</div>
							</div>
							
							
							<div class="form-group">
								<label for="r_type" class="col-sm-4">Ready</label>
								<div class="col-sm-8">
									<select class="form-control" ng-model="form.r_type" ng-init="form.r_type=0" name="r_type" >
										<option value="0" selected="selected">Ready</option>
										<option value="1">PO</option>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label for="grosir" class="col-sm-4" >Harga Grosir</label>
								<div class="col-sm-8">
									
									<input type="text" do-numeric ng-model="form.hargagrosir" class="form-control" placeholder="Harga Grosir" name="grosir"   />
								</div>
							</div>
							<div class="form-group">
								<label for="eceran" class="col-sm-4">Harga Eceran</label>
								<div class="col-sm-8">
									<input type="text" do-numeric  ng-model="form.hargaeceran" class="form-control" placeholder="Harga Eceran" name="eceran"  />
								</div>
							</div>
							
							<div class="form-group">
								<label for="type" class="col-sm-4">Type</label>
								<div class="col-sm-8"><select ng-model="form.type" ng-init="form.type='piece'" class="form-control" name="type" >
										<option value="piece">Piece</option>
										<option value="series">Series</option>
									</select>
								</div>
							</div>

							<div class="form-group">
								<label for="eceran" class="col-sm-4">Berat</label>
								<div class="col-sm-8">
									<input type="text"  ng-model="form.berat" class="form-control" placeholder="Berat" name="berat"  />
								</div>
							</div>
							
							
							<div class="form-group">
								<label for="description" class="col-sm-4">Deskripsi</label>
								<div class="col-sm-8">
									<textarea  class="form-control" ng-model="form.description" placeholder="Description" name="description"  ></textarea>
								</div>
							</div>
							<div class="alert alert-danger" ng-show="isError()">{{error}}</div>
							<div class="form-group">
								<div class="col-sm-12 control-label">
									<input  type="submit" class="btn btn-info " value="Insert" />
								</div>
							</div>
						</form>
						
						<form  class="form-horizontal">
							<div class="form-group">
								<label for="name" class="col-sm-1">Search</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" ng-model="filter" ng-change="filterProduct()" />
								</div>
							</div>
						</form>
						
						<div ng-cloak class="alert alert-info" role="alert" ng-hide="isAvailable()">There is no product</div>
						<table class="table table-bordered" ng-show="isAvailable()">
							<thead>
								<tr>
									<th>#</th>
									<th>Name</th>
									<th>Type</th>
									<th>Category</th>
									<th>Grosir</th>
									<th>Eceran</th>
									<th>Berat</th>
									<th>Stock</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody ng-repeat="product in filteredProducts track by $index" ng-controller="ProductDetailController">
								
								<tr ng-cloak>
									<td >{{ product.productid }}</td>
									<td style="max-width:120px;">{{ product.productname }}</td>
									<td>{{ product.r_type }}</td>
									<td>{{ product.categoryname }}</td>
									<td style="max-width:120px;">{{ product.hargagrosir | currency:"Rp." }}</td>
									<td style="max-width:120px;">{{ product.hargaeceran | currency:"Rp."}}</td>
									<td style="max-width:30px;">{{ product.berat+' Kg' }}</td>
									<td style="max-width:30px;">{{ product.stock+' '+product.type }}</td>
									<td>
										<button class="btn btn-primary" title="Upload Image" ng-click="showUpload()">
											<span class="glyphicon glyphicon-upload" aria-hidden="true"></span>
										</button>
									
										<button class="btn btn-info" title="Push Notification" ng-click="showPush()" ng-hide="isNull(product.published_at)" >
											<span class="glyphicon glyphicon-comment" aria-hidden="true"></span>
										</button>
										<button class="btn btn-warning" title="Publish Product" ng-click="publish()" ng-show="isNull(product.published_at)" >
											<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
										</button>
									
										<button class="btn btn-primary" title="Add/Remove Stock" ng-click="showInventory()">
											<span class="glyphicon glyphicon-transfer" aria-hidden="true"></span>
										</button>
										
										
										<button class="btn btn-info" title="Update Product" ng-click="showUpdate()">
											<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
										</button>
									
										<button class="btn btn-danger" title="Delete Product" ng-click="deleteProduct()">
											<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
										</button>
										<button ng-show="isPO()" class="btn btn-primary" title="PO Ready" ng-click="po_ready()">
											<span class="glyphicon glyphicon-download" aria-hidden="true"></span>
										</button>
										
									</td>
									
								</tr>
								
								
								<tr ng-init="product.update=false" ng-show="product.update" ng-cloak >
									<td colspan="2"></td>
									<td colspan="8">
										<h4>Update Product</h4>
										<form class="form_product_update form-horizontal" ng-submit="update()">
											<div class="form-group">
												<label for="name" class="col-sm-4 control-label">Nama Produk</label>
												<div class="col-sm-8">
													<input type="text" ng-model="product.productname"  class="form-control" placeholder="Product Name" name="name"   />
												</div>
											</div>
											
											<div class="form-group">
												<label for="grosir" class="col-sm-4 control-label">Harga Grosir</label>
												<div class="col-sm-8">
													<input type="text" do-numeric ng-model="product.hargagrosir"  class="form-control" placeholder="Harga Grosir" name="grosir"  />
												</div>
											</div>
											<div class="form-group">
												<label for="name" class="col-sm-4 control-label">Harga Eceran</label>
												<div class="col-sm-8">
													<input type="numeric" do-numeric ng-model="product.hargaeceran"  class="form-control" placeholder="Harga Eceran" name="eceran"  />
												</div>
											</div>

											<div class="form-group">
												<label for="name" class="col-sm-4 control-label">Berat</label>
												<div class="col-sm-8">
													<input type="text" do-decimal ng-model="product.berat"  class="form-control" placeholder="Berat" name="berat"  />
												</div>
											</div>
										
											<div class="form-group">
												<label for="description" class="col-sm-4 control-label">Deskripsi</label>
												<div class="col-sm-8">
													<textarea ng-model="product.description"   class="form-control" placeholder="Description" name="description"></textarea>
												</div>
											</div>
											<div ng-show="isErrorUpdate()" class="alert alert-danger">
												{{errorUpdate}}
											</div>

											<div class="form-group">
												<div class="col-sm-12 control-label">
													<input  type="submit" class="btn btn-info " value="Update" />
												</div>
											</div>
										</form>
									</td>
								</tr>
								
								
								<tr ng-init="product.upload=false" ng-show="product.upload" ng-cloak >
									<td colspan="2"></td>
									<td colspan="8">

									<h4>Upload Image</h4>
									<form class="form_upload form-horizontal">
											<div class="form-group">
												<img width="100" height="100"  class="image_upload" src="{{image}}" />
											</div>
											<div class="form-group">
												<div class="col-sm-12">
													<input  class="url_upload form-control" type="file" name="userfile"  onchange="angular.element(this).scope().readUrl(this)"  />
												</div>
											</div>
											<div ng-show="isErrorUpload()" class="alert alert-danger">
												{{errorUpload}}
											</div>
											<div class="form-group">
												<div class="col-sm-12 control-label">
													<input type="button" ng-click="upload()" class="submit_upload btn btn-primary" value="Upload" />
												</div>
											</div>
									</form>
										
									</td>
								</tr>
								
								
								<tr ng-init="product.push=false" ng-show="product.push" ng-cloak  >
									<td colspan="2"></td>
									<td colspan="8">

									<h4>Push Notification Product</h4>
									<form class="form_upload form-horizontal" ng-submit="pushProduct()">
											<div class="form-group">
												<label for="caption" class="col-sm-4 control-label">Caption</label>
												<div class="col-sm-8">
													<input type="text"  class="form-control" placeholder="Caption" name="caption"  ng-model="caption" />
													
												</div>
											</div>
											<div class="form-group">
												<label for="description" class="col-sm-4 control-label">Deskripsi</label>
												<div class="col-sm-8">
													<textarea   class="form-control" placeholder="Description" name="description" ng-model="message"  ></textarea>
												</div>
											</div>
										
											<div class="form-group">
												<div class="col-sm-12 control-label">
													<input  type="submit" class="btn btn-info " value="Push" />
												</div>
											</div>
										</form>
										
									</td>
								</tr>
								
								
								<tr ng-init="product.inventory=false" ng-cloak ng-show="product.inventory" ng-controller="InventoryController" >
									<td colspan="2"></td>
									<td colspan="8">
										<h4>Add / Remove Stock</h4>
									
										<table class="table">
										<thead ng-init="product.inventoryList=[]" ng-show="isShow()">
											<tr>
												<th>Type</th>
												<th>Quantity</th>
												<th>Date</th>
											</tr>
										</thead>
										<tbody >
											<tr ng-repeat="ivt in product.inventoryList">
												<td>{{ivt.typeKata}}</td>
												<td>{{ivt.quantity}}</td>
												<td>{{ivt.created_at}}</td>
											</tr>
										</tbody>
										</table>
										<form class="form_product_update form-horizontal" ng-submit="update(product)">
											<div class="form-group">
												 <label for="qty"  class="col-sm-4 control-label">Quantity</label>
												<div class="col-sm-8">
													<input type="text" do-numeric ng-model="quantity" class="form-control" placeholder="Quantity" name="qty"  />
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-12 control-label">
													<input  type="button" ng-click="addStock()" class="btn btn-info " value="Add" />
													<input  type="button" ng-click="removeStock()" class="btn btn-info " value="Remove" />
												</div>
											</div>
										</form>
									</td>
								</tr>
								
							</tbody>
						</table>
						</div>
						
                </div>
            </div>