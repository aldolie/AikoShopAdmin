 <div class="container-fluid" ng-controller="ReportController">
                <div class="row">
                    <div class="col-lg-12" ng-cloak>
                        <h1>{{ heading }}</h1>
						
						
						<form  class="form-horizontal">
							<div class="form-group">
								<label for="name" class="col-sm-1">Date Form</label>
								<div class="col-sm-3">
									<input type="date" class="form-control" ng-model="datefrom"  />
								</div>
								
								<label for="name" class="col-sm-1">Date To</label>
								<div class="col-sm-3">
									<input type="date" class="form-control" ng-model="dateto"  />
								</div>
							</div>
							<input type="hidden" ng-model="userid" name="userid" />
								<div class="form-group" >
									<label for="username" class="col-sm-1">Username</label>
									<div class="col-sm-3 autocomplete_container" >
										<input type="text" ng-model="username"  class="form-control" placeholder="Username" name="username"  ng-change="onUsernameChange()" autocomplete="off" ng-enter="chooseUser()" />
										<div  class="autocomplete_content">
											<div ng-repeat="user in filteredUser track by $index"  class="autocomplete" ng-click="chooseUserClick($index)">
											{{user.username}}
											</div>
										</div>
									</div>
									
								</div>
							<div class="form-group" >
								<input type="submit" class="btn btn-primary " class="col-sm-1" value="Generate" ng-click="generate()"  />
							</div>
						</form>
						<div class="alert alert-info" role="alert" ng-hide="isAvailable()">There is no order</div>
						<table class="table" ng-show="isAvailable()">
							<thead>
								<tr>
									<th>Date</th>
									<th>Username</th>
									<th>Nama</th>
									<th>Alamat</th>
									<th>Telepon</th>
									<th>ProductID</th>
									<th>Nama Product</th>
									<th>Harga</th>
									<th>Stock</th>
									<th>Tipe</th>
									<th>Subtotal</th>
								</tr>
							</thead>
							<tbody>
								<tr ng-repeat="tr in transaction" ng-cloak>
									<td>{{tr.transactiondate}}</td>
									<td>{{tr.username}}</td>
									<td>{{tr.nama}}</td>
									<td>{{tr.alamat}}</td>
									<td>{{tr.telepon}}</td>
									<td>{{tr.productid}}</td>
									<td>{{tr.productname}}</td>
									<td>{{tr.harga |currency:"Rp."}}</td>
									<td>{{tr.quantity}}</td>
									<td>{{tr.type}}</td>
									<td>{{ tr.harga*tr.quantity |currency:"Rp."}}</td>
								</tr>
							</tbody>
						</table>
						<div>{{total() | currency:"Rp."}}</div>
						</div>
						
                </div>
            </div>