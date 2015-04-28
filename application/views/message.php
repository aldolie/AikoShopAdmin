 <div class="container-fluid" ng-controller="MessageController">
                <div class="row">
                    <div class="col-lg-12">
                        <h1 style="display:inline-block;vertical-align:top;">{{ heading }}</h1>
					<div>
						<form  class="form-horizontal" ng-submit="send()">
							<input type="hidden" ng-model="form.userid" name="userid" />
							<div class="form-group">
								<label for="username" class="col-sm-4">Username</label>
								<div class="col-sm-8 autocomplete_container" >
									<input type="text" ng-model="form.username"   class="form-control" placeholder="Username" name="username"  ng-change="onUsernameChange()" autocomplete="off" ng-enter="chooseUser()" />
									<div  class="autocomplete_content">
										<div ng-repeat="user in filteredUser track by $index"  class="autocomplete" ng-click="chooseUserClick($index)">
										{{user.username}}
										</div>
									</div>
								</div>
								
							</div>
								<div class="form-group">
								<label for="Caption" class="col-sm-4">Caption</label>
								<div class="col-sm-8">
									<input type="text" ng-model="form.caption"  class="form-control" placeholder="Caption" name="Caption"   />
								</div>
							</div>

							<div class="form-group">
								<label for="Message" class="col-sm-4">Message</label>
								<div class="col-sm-8">
									<textarea  class="form-control" ng-model="form.message" placeholder="Message" name="message"   ></textarea>
								</div>
							</div>


							
							<div class="alert alert-danger" role="alert" ng-show="isError()">{{error}}</div>
							<div class="form-group">
								<div class="col-sm-12 control-label">
									<input  type="submit" class="btn btn-info " value="Send" />
								</div>
							</div>
						</form>
					</div>
			</div>	
    </div>
</div>