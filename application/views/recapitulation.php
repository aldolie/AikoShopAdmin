 <div class="container-fluid" ng-controller="RecapitulationController">
                <div class="row">
                    <div class="col-lg-12">
                        <h1>{{ heading }}</h1>
						
						
						<form  class="form-horizontal">
							<div class="form-group">
								<label for="name" class="col-sm-1">Search</label>
								<div class="col-sm-3">
									<input type="text" class="form-control" ng-model="filter" ng-change="filterTransaction()" />
								</div>
							</div>
							<div class="form-group">
								<label for="name" class="col-sm-1">Tipe</label>
								<div class="col-sm-3">
									<select ng-model="filterTr" ng-init="filterTr='Delivered'" class="form-control">
										<option selected="selected" value="Delivered" >Delivered</option>
										<option value="Reject">Reject</option>
									</select>
								</div>
							</div>
						</form>
						
						<div class="alert alert-info" role="alert" ng-hide="isAvailable()">There is no transaction</div>
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
							<tbody ng-repeat="tr in filteredTransaction" ng-controller="RecapDetailController" ng-show="isAvailable()">
								
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
													<td>Date</td>
													<td>Product</td>
													<td>Price</td>
													<td>Quantity</td>
													<td>Subtotal</td>
													<td>Status</td>
												</tr>
											</thead>
											<tbody>
												<tr  ng-repeat="dt in tr.detail track by $index" ng-controller="TransactionDetailController">
													<td>{{dt.transactionid}} </td>
													<td>{{dt.created_at}}</td>
													<td>{{dt.productname}}</td>
													<td>{{dt.harga | currency:"Rp."}}</td>
													<td>{{dt.quantity+' '+dt.type}}</td>
													<td>{{dt.quantity*dt.harga | currency:"Rp."}}</td>
													<td>
														{{dt.status}}
													</td>
												</tr>
											</tbody>
										</table>
										<div class="col-sm-3 control-label">
											Total : {{getTotal() | currency:"Rp."}}
										</div>
									</td>
								</tr>
								
							</tbody>
						</table>
						</div>
						
                </div>
            </div>