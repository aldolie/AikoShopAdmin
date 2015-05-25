 <div class="container-fluid" ng-controller="ReportController">
                <div class="row" >
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
								<label for="name" class="col-sm-1">Type</label>
								<div class="col-sm-3">
									<select ng-model="type" class="form-control" ng-init="type='Delivered'">
										<option value="Delivered">Delivered</option>
										<option value="Reject">Reject</option>
									</select>
								</div>
							</div>
							<input type="hidden" ng-model="userid" name="userid" />
								<div class="form-group" >
									<label for="username" class="col-sm-1">Username</label>
									<div class="col-sm-3 autocomplete_container" >
										<input type="text" ng-model="username"  class="form-control" placeholder="Username" name="username"  ng-change="onUsernameChange()" autocomplete="off" ng-enter="chooseUser()" />
										<div  class="autocomplete_content">
											<div ng-repeat="user in filteredUser track by $index"  class="autocomplete" ng-click="chooseUserClick($index)" >
											{{user.username}}
											</div>
										</div>
									</div>
									
								</div>
							<div class="form-group" >
								<input type="submit" class="btn btn-primary " class="col-sm-1" value="Generate" ng-click="generateChart()"  />
							</div>
						</form>
						<!--<div class="alert alert-info" role="alert" ng-hide="isAvailable()">There is no order</div>-->
							<div id="mychart" class="ct-chart ct-perfect-fourth" ></div>
						</div>
						
                </div>
            </div>

           	<link href="<?php echo base_url('js/chartist/chartist.min.css'); ?>" rel="stylesheet">
			<style>
			.ct-label{
				color:black !important;
				font-size: 12px !important;
			}

			</style>
			<script src="<?php echo base_url('js/chartist/chartist.min.js'); ?>"></script>
			