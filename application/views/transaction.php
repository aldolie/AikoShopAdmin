 <div class="container-fluid" ng-controller="TransactionController">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 style="display:inline-block;vertical-align:top;">{{ heading }}</h1>
						<span style="vertical-align:top;margin-bottom:10px;margin-top:20px;margin-left:10px;background:#eee;cursor:pointer;padding:10px;border-radius:5px;" title="Insert User" ng-click="showInsert()" class="glyphicon glyphicon-plus" aria-hidden="true"></span>
						<span style="vertical-align:top;margin-bottom:10px;margin-top:20px;margin-left:10px;background:#eee;cursor:pointer;padding:10px;border-radius:5px;" title="Insert User" ng-click="print()" class="glyphicon glyphicon-print" aria-hidden="true">Print</span>
						<div id="printContainer" ng-show="isPrint()">
						<div id="printContent" style="font-size:16px !important;" >
							<img src="<?php echo  base_url('image\icon.png'); ?>" width="50" height="50" />
							<p  style="margin-top:10px;margin-bottom:10px;" contenteditable="true">PGTA Blok B Tanah Abang lt.3A/G/62 (08159668993)</p>
							<table class="table table-striped" >
								<thead>
									<tr>
										<th>Nama Barang</th>
										<th>Harga Barang</th>
										<th>Qty</th>
										<th>Subtotal</th>
									</tr>
								</thead>
								<tbody>
									<tr ng-repeat="pr in elementChecked" ng-cloak>
										<td>{{pr.productname}}</td>
										<td>{{pr.harga | currency:"Rp."}}</td>
										<td>{{pr.quantity }}</td>
										<td>{{pr.harga*pr.quantity | currency:"Rp."}}</td>
									</tr>
								</tbody>
								
							</table>

								<table class="table" >
									<tr ng-cloak>
										<td  width="50px">Total<td>
										<td>&nbsp;:<td>
										<td colspan="2"><div>{{countTotal() | currency:"Rp."}}</div></td>
									</tr>
									<tr >
										<td width="50px">Ongkir<td>
										<td>&nbsp;:<td>
										<td colspan="2"><div >{{ongkir| currency:"Rp."}}</div></td>
									</tr>
									<tr >
										<td width="50px" colspan="1">Keseluruhan<td>
										<td>&nbsp;:<td>
										<td colspan="2">{{ totalAll()|currency:"Rp."}}</td>
									</tr>
									<tr >
										<td width="50px" colspan="1">Username<td>
										<td>&nbsp;:<td>
										<td colspan="2">{{username}}<td>
									</tr>
									<tr ng-show="showAddress">
										<td width="50px" colspan="1">Alamat<td>
										<td>&nbsp;:<td>
										<td colspan="2"><div contenteditable>{{alamat}}</div><td>
									</tr>
								</table>
								<div style="clear:both;" contenteditable></div>
								<div  ><span>From Aiko: </span><span contenteditable>08159668993</span></div>

						</div>	
						<div>Ongkir:<input type="numeric" ng-model="ongkir" /></div>
						<div><input type="checkbox" ng-model="showAddress" /> Show Address</div>
						<span style="vertical-align:top;margin-bottom:10px;margin-top:20px;margin-left:10px;background:#eee;cursor:pointer;padding:10px;border-radius:5px;" title="Insert User" ng-click="printOrder()" class="glyphicon glyphicon-print" aria-hidden="true">Print</span>
						
						</div>		
						<form ng-show="insertFlag" class="form_product_update form-horizontal" ng-submit="buy()">
							<input type="hidden" ng-model="form.userid" name="userid" />
							<div class="form-group">
								<label for="username" class="col-sm-4">Username</label>
								<div class="col-sm-8 autocomplete_container" >
									<input type="text" ng-model="form.username"  class="form-control" placeholder="Username" name="username"  ng-change="onUsernameChange()" autocomplete="off" ng-enter="chooseUser()" />
									<div  class="autocomplete_content">
										<div ng-repeat="user in filteredUser track by $index" ng-cloak  class="autocomplete" ng-click="chooseUserClick($index)">
										{{user.username}}
										</div>
									</div>
								</div>
								
							</div>
							<input type="hidden" ng-model="form.productid" name="productid" />
							
							<div class="form-group">
								<label for="productname" class="col-sm-4">Product</label>
								<div class="col-sm-8 autocomplete_container">
									<input type="text" ng-model="form.productname"  class="form-control" placeholder="Name" name="name" ng-change="onProductChange()" ng-enter="chooseProduct()" autocomplete="off" />
									<div  class="autocomplete_content">
									<div ng-repeat="product in filteredProducts track by $index" ng-cloak  class="autocomplete" ng-click="chooseProductClick($index)">
										{{product.productname}}
									</div>
								</div>
								</div>
								
							</div>
							
							<div class="form-group">
								<label for="Quantity" class="col-sm-4">Quantity</label>
								<div class="col-sm-8">
									<input type="quantity" ng-model="form.quantity"  class="form-control" placeholder="Quantity" name="email"   />
									<p style="margin-top:10px;" ng-cloak>Stock : {{productTemp.stock}}</p>
								</div>
							</div>
							
							<div class="alert alert-danger" role="alert" ng-show="isError()">{{error}}</div>
							<div class="form-group">
								<div class="col-sm-12 control-label">
									<input  type="submit" class="btn btn-info " value="Insert" />
								</div>
							</div>
						</form>
						
						<ul class="nav nav-tabs nav-justified" style="margin-bottom:10px;" ng-cloak>
						  <li role="presentation" ng-class="isActive('User')" ng-click="changeToMode('User')"><a href="#">User</a></li>
						  <li role="presentation"ng-class="isActive('Product')" ng-click="changeToMode('Product')"><a href="#">Product</a></li>
						</ul>
						<div ng-show="isShow('User')">
						<form  class="form-horizontal">
							<div class="form-group">
								<label for="name" class="col-sm-1">Search</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" ng-model="filter" ng-change="filterTransaction()" />
								</div>
							</div>
						</form>
						<div class="alert alert-info" role="alert" ng-hide="isAvailable()">There is no order</div>
						<table class="table" ng-show="isAvailable()">
							<thead>
								<tr>
									<th></th>
									<th>#</th>
									<th>Username</th>
									<th>Nama</th>
									<th>Email</th>
									<th>Telepon</th>
									<th>Alamat</th>
								</tr>
							</thead>
							<tbody ng-repeat="tr in filteredTransaction" ng-cloak ng-controller="TrDetailController" ng-show="isAvailable()">
								
								<tr>
									
									<td ng-init="detailStatus=false">
										<button class="btn" ng-hide="detailStatus" style="padding:0px;background:transparent;" title="Show Detail" ng-click="showDetail()">
											<span  class="glyphicon glyphicon-menu-down" aria-hidden="true" ></span>
										</button>
										<button class="btn"  ng-show="detailStatus" style="padding:0px;background:transparent;" title="Hide Detail" ng-click="hideDetail()">
										
											<span  class="glyphicon glyphicon-menu-up" aria-hidden="true"></span>
										</button>
									</td>
									<td>{{ tr.userid }}</td>
									<td>{{ tr.username }}</td>
									<td>{{ tr.nama }}</td>
									<td>{{ tr.email }}</td>
									<td>{{ tr.telepon }}</td>
									<td>{{ tr.alamat }}</td>
									
									
								</tr>
								
								
								<tr  ng-show="detailStatus">
									<td colspan="2"></td>
									<td colspan="8">
										<table class="table">
											<thead>
												<tr>
													<td>#</td>
													<td>Id</td>
													<td>Date</td>
													<td>Product</td>
													<td>Price</td>
													<td>Quantity</td>
													<td>Subtotal</td>
													<td>Berat</td>
													<td>Action</td>
												</tr>
											</thead>
											<tbody>
												<tr  ng-repeat="dt in tr.detail track by $index" ng-cloak ng-controller="TransactionDetailController">
													<td><input type="checkbox" ng-model="dt.checked" ng-init="dt.checked=false"/> </td>
													<td>{{dt.transactionid}} </td>
													<td>{{dt.created_at}}</td>
													<td>{{dt.productname}}</td>
													<td>{{dt.harga | currency:"Rp."}}</td>
													<td>{{dt.quantity+' '+dt.type}}</td>
													<td>{{dt.quantity*dt.harga | currency:"Rp."}}</td>
													
													<td>{{dt.berat*dt.quantity+' '+'Kg'}}</td>
													<td>
														<button class="btn btn-primary"  ng-show="showReady()" ng-click="ready()" title="Product Ready">
																<span  class="glyphicon glyphicon-download" aria-hidden="true"></span>
															</button>

														<button class="btn btn-primary"  ng-show="showPaid()" ng-click="paid()" title="Pay Product">
																<span  class="glyphicon glyphicon-usd" aria-hidden="true"></span>
															</button>
														<button class="btn btn-primary"  ng-show="showDelivered()" ng-click="deliver()" title="Deliver Product">
															<span  class="glyphicon glyphicon-ok" aria-hidden="true"></span>
														</button>
														<button class="btn btn-danger"  ng-show="detailStatus"  ng-click="reject()" title="Reject Order">
															<span  class="glyphicon glyphicon-remove" aria-hidden="true"></span>
														</button>
													</td>
												</tr>
											</tbody>
										</table>
										<div class="col-sm-3 control-label">
											Total : {{getTotal() | currency:"Rp."}}
										</div>
										<div class="col-sm-3 control-label">
											Total : {{getTotalWeight() + 'Kg'}}
										</div>
									</td>
								</tr>
								
							</tbody>
						</table>
						</div>
						<!-- Product -->
						<div ng-show="isShow('Product')">
							<form  class="form-horizontal">
								<div class="form-group">
									<label for="name" class="col-sm-1">Search</label>
									<div class="col-sm-3">
										<input type="text" class="form-control" ng-model="filterProduct" ng-change="filterTransactionProduct()" />
									</div>
								</div>
							</form>
							<div class="alert alert-info" role="alert" ng-hide="isAvailableProduct()">There is no order</div>
							<table class="table" ng-show="isAvailableProduct()">
								<thead>
									<tr>
										<th></th>
										<th>#</th>
										<th>Product Name</th>
										<th>Product Type</th>
										<th>Jumlah</th>
									</tr>
								</thead>
								<tbody ng-repeat="tr in filteredProductTransaction" ng-controller="TrProductDetailController" ng-show="isAvailable()">
									
									<tr>
										
										<td ng-init="detailStatus=false">
											<button class="btn" ng-hide="detailStatus" style="padding:0px;background:transparent;" title="Show Detail" ng-click="showDetail()">
												<span  class="glyphicon glyphicon-menu-down" aria-hidden="true" ></span>
											</button>
											<button class="btn"  ng-show="detailStatus" style="padding:0px;background:transparent;" title="Hide Detail" ng-click="hideDetail()">
											
												<span  class="glyphicon glyphicon-menu-up" aria-hidden="true"></span>
											</button>
										</td>
										<td>{{ tr.productid }}</td>
										<td>{{ tr.productname }}</td>
										<td>{{ tr.r_type }}</td>
										<td>{{ tr.jml +' '+tr.type }}</td>
										
										
									</tr>
									
									
									<tr  ng-show="detailStatus">
										<td colspan="2"></td>
										<td colspan="8">
											<table class="table">
												<thead>
													<tr>
														<td>#</td>
														<td>Date</td>
														<td>Userid</td>
														<td>Username</td>
														<td>Price</td>
														<td>Quantity</td>
														<td>Subtotal</td>
														<td>Action</td>
													</tr>
												</thead>
												<tbody>
													<tr  ng-repeat="dt in tr.detail track by $index" ng-controller="TransactionDetailController">
														<td>{{dt.transactionid}} </td>
														<td>{{dt.created_at}}</td>
														<td>{{dt.userid}}</td>
														<td>{{dt.username}}</td>
														<td>{{dt.harga | currency:"Rp."}}</td>
														<td>{{dt.quantity+' '+dt.type}}</td>
														<td>{{dt.quantity*dt.harga | currency:"Rp."}}</td>
														<td>
															<button class="btn btn-primary"  ng-show="showReady()" ng-click="ready()" title="Product Ready">
																<span  class="glyphicon glyphicon-download" aria-hidden="true"></span>
															</button>

															<button class="btn btn-primary"  ng-show="showPaid()" ng-click="paid()" title="Pay Product">
																<span  class="glyphicon glyphicon-usd" aria-hidden="true"></span>
															</button>
															<button class="btn btn-primary"  ng-show="showDelivered()" ng-click="deliver()" title="Deliver Product">
																<span  class="glyphicon glyphicon-ok" aria-hidden="true"></span>
															</button>
															<button class="btn btn-danger"  ng-show="detailStatus" ng-hide="doNotShow()" ng-click="reject()" title="Reject Order">
																<span  class="glyphicon glyphicon-remove" aria-hidden="true"></span>
															</button>
														</td>
													</tr>
												</tbody>
											</table>
											<div class="col-sm-3 control-label">
												Total : {{getTotal() | currency:"Rp."}}
											</div>
											<div class="col-sm-3 control-label">
												Total : {{getTotalPiece() }} Pieces
											</div>
										</td>
									</tr>
									
								</tbody>
							</table>
						</div>
						</div>
						
                </div>
            </div>