 <div class="container-fluid" ng-controller="UserController">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 style="display:inline-block;vertical-align:top;">{{ heading }}</h1>
						<span style="vertical-align:top;margin-bottom:10px;margin-top:20px;margin-left:10px;background:#eee;cursor:pointer;padding:10px;border-radius:5px;" title="Insert User" ng-click="showInsert()" class="glyphicon glyphicon-plus" aria-hidden="true"></span>
									
						<form ng-show="insertFlag" class="form_product_update form-horizontal" ng-submit="insert()">
							<div class="form-group">
								<label for="username" class="col-sm-4">Username</label>
								<div class="col-sm-8">
									<input type="text" ng-model="form.username"  class="form-control" placeholder="Username" name="username"   />
								</div>
							</div>
							
							<div class="form-group">
								<label for="name" class="col-sm-4">Name</label>
								<div class="col-sm-8">
									<input type="text" ng-model="form.nama"  class="form-control" placeholder="Name" name="name"   />
								</div>
							</div>
							
							<div class="form-group">
								<label for="email" class="col-sm-4">Email</label>
								<div class="col-sm-8">
									<input type="email" ng-model="form.email"  class="form-control" placeholder="Email" name="email"   />
								</div>
							</div>
							
							<div class="form-group">
								<label for="telepon" class="col-sm-4" >Telephone</label>
								<div class="col-sm-8">
									<input type="text" ng-model="form.telepon" class="form-control" placeholder="Telephone" name="telepon"   />
								</div>
							</div>
							
							<div class="form-group">
								<label for="alamat" class="col-sm-4">Alamat</label>
								<div class="col-sm-8">
									<textarea  class="form-control" ng-model="form.alamat" placeholder="Alamat" name="alamat"  ></textarea>
								</div>
							</div>
							
							<div class="alert alert-danger" role="alert" ng-show="isError()">{{error}}</div>
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
									<input type="text" class="form-control" ng-model="filter" ng-change="filterUser()" />
								</div>
							</div>
						</form>
						<div class="alert alert-info" role="alert" ng-hide="isAvailable()">There is no user</div>
						<table class="table table-bordered" ng-show="isAvailable()">
							<thead>
								<tr>
									<th>#</th>
									<th>Username</th>
									<th>Nama</th>
									<th>Email</th>
									<th>Telepon</th>
									<th>BB</th>
									<th>Note</th>
									<th>Action</th>
								</tr>
							</thead>
							<tbody ng-repeat="user in filteredUsers" ng-controller="UserDetailController" >
								
								<tr>
									<td>{{ user.userid }}</td>
									<td>{{ user.username }}</td>
									<td>{{ user.nama }}</td>
									<td>{{ user.email }}</td>
									<td>{{ user.telepon }}</td>
									<td>{{ user.bb }}</td>
									<td>{{ user.note }}</td>
									<td>
										<button class="btn btn-warning" ng-hide="isActivate()" title="Activate User" ng-click="activate()">
											<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
										</button>
										<button class="btn btn-danger" ng-show="isActivate()" title="Deactivate User" ng-click="deactivate()">
											<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
										</button>
									<button class="btn btn-info" ng-click="showUpdate()" title="Update User">
										<span class="glyphicon glyphicon-pencil" aria-hidden="true"></span>
									</button>
									<button class="btn btn-danger" title="Delete User" ng-click="deleteUser()">
										<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
									</button>
									</td>
									
								</tr>
								
								
								<tr ng-init="user.update=false" ng-show="user.update">
									<td colspan="2"></td>
									<td colspan="8">
										<h4>Update User</h4>
										<form class="form_product_update form-horizontal" ng-submit="update(user)">
											
											<div class="form-group">
												<label for="nama" class="col-sm-4 control-label">Nama</label>
												<div class="col-sm-8">
													<input type="text" ng-model="formUpdate.nama" ng-init="formUpdate.nama=user.nama" class="form-control" placeholder="Nama" name="nama"  />
												</div>
											</div>
											<div class="form-group">
												<label for="telepon" class="col-sm-4 control-label">Telepon</label>
												<div class="col-sm-8">
													<input type="text" ng-model="formUpdate.telepon" ng-init="formUpdate.telepon=user.telepon" class="form-control" placeholder="Telepon" name="telepon" />
												</div>
											</div>
											<div class="form-group">
												<label for="email" class="col-sm-4 control-label">Email</label>
												<div class="col-sm-8">
													<input type="text" ng-model="formUpdate.email" ng-init="formUpdate.email=user.email" class="form-control" placeholder="Email" name="email" />
												</div>
											</div>
											<div class="form-group">
												<label for="note" class="col-sm-4 control-label">Note</label>
												<div class="col-sm-8">
													<input type="text" ng-model="formUpdate.note" ng-init="formUpdate.note=user.note" class="form-control" placeholder="Note" name="note" />
												</div>
											</div>
											
											<div class="form-group">
												<label for="bb" class="col-sm-4 control-label">PIN BB</label>
												<div class="col-sm-8">
													<input type="text" ng-model="formUpdate.bb" ng-init="formUpdate.bb=user.bb" class="form-control" placeholder="Pin BB" name="bb" />
												</div>
											</div>
											
											<div class="form-group">
												<label for="alamat" class="col-sm-4 control-label">Alamat</label>
												<div class="col-sm-8">
													<textarea ng-model="formUpdate.alamat" ng-init="formUpdate.alamat=user.alamat" class="form-control" placeholder="Alamat" name="alamat"  ></textarea>
												</div>
											</div>
											<div class="form-group">
												<div class="col-sm-12 control-label">
													<input  type="submit" class="btn btn-info " value="Update" />
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