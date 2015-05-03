var app=angular.module('app',[]);
var SERVICE_URL='http://localhost/aiko/index.php/services/';
var IMAGE='http://localhost/aiko/image/items/';

app.directive('ngEnter', function () {
    return function (scope, element, attrs) {
        element.bind("keydown keypress", function (event) {
            if(event.which === 13||event.which === 9) {
                scope.$apply(function (){
                    scope.$eval(attrs.ngEnter);
                });
				if(event.which === 13)
                event.preventDefault();
            }
        });
    };
});


app.directive('doNumeric', function() {
  return {
    require: 'ngModel',
    link: function (scope, element, attr, ngModelCtrl) {
      function fromUser(text) {
        var transformedInput = text.replace(/[^0-9]/g, '');
       if(transformedInput !== text) {
            ngModelCtrl.$setViewValue(transformedInput);
            ngModelCtrl.$render();
        }
        return transformedInput;  // or return Number(transformedInput)
      }
      ngModelCtrl.$parsers.push(fromUser);
    }
  }; 
});


app.directive('doDecimal', function() {
  return {
    require: 'ngModel',
    link: function (scope, element, attr, ngModelCtrl) {
      function fromUser(text) {
        var transformedInput = text.replace(/[^0-9.]/g, '');
        if(transformedInput !== text) {
            ngModelCtrl.$setViewValue(transformedInput);
            ngModelCtrl.$render();
        }
        return transformedInput;  // or return Number(transformedInput)
      }
      ngModelCtrl.$parsers.push(fromUser);
    }
  }; 
});

app.config(function($httpProvider) {

});

app.factory('Base64', function() {
    var keyStr = 'ABCDEFGHIJKLMNOP' +
            'QRSTUVWXYZabcdef' +
            'ghijklmnopqrstuv' +
            'wxyz0123456789+/' +
            '=';
    return {
        encode: function (input) {
            var output = "";
            var chr1, chr2, chr3 = "";
            var enc1, enc2, enc3, enc4 = "";
            var i = 0;

            do {
                chr1 = input.charCodeAt(i++);
                chr2 = input.charCodeAt(i++);
                chr3 = input.charCodeAt(i++);

                enc1 = chr1 >> 2;
                enc2 = ((chr1 & 3) << 4) | (chr2 >> 4);
                enc3 = ((chr2 & 15) << 2) | (chr3 >> 6);
                enc4 = chr3 & 63;

                if (isNaN(chr2)) {
                    enc3 = enc4 = 64;
                } else if (isNaN(chr3)) {
                    enc4 = 64;
                }

                output = output +
                        keyStr.charAt(enc1) +
                        keyStr.charAt(enc2) +
                        keyStr.charAt(enc3) +
                        keyStr.charAt(enc4);
                chr1 = chr2 = chr3 = "";
                enc1 = enc2 = enc3 = enc4 = "";
            } while (i < input.length);

            return output;
        },

        decode: function (input) {
            var output = "";
            var chr1, chr2, chr3 = "";
            var enc1, enc2, enc3, enc4 = "";
            var i = 0;

            // remove all characters that are not A-Z, a-z, 0-9, +, /, or =
            var base64test = /[^A-Za-z0-9\+\/\=]/g;
            if (base64test.exec(input)) {
                alert("There were invalid base64 characters in the input text.\n" +
                        "Valid base64 characters are A-Z, a-z, 0-9, '+', '/',and '='\n" +
                        "Expect errors in decoding.");
            }
            input = input.replace(/[^A-Za-z0-9\+\/\=]/g, "");

            do {
                enc1 = keyStr.indexOf(input.charAt(i++));
                enc2 = keyStr.indexOf(input.charAt(i++));
                enc3 = keyStr.indexOf(input.charAt(i++));
                enc4 = keyStr.indexOf(input.charAt(i++));

                chr1 = (enc1 << 2) | (enc2 >> 4);
                chr2 = ((enc2 & 15) << 4) | (enc3 >> 2);
                chr3 = ((enc3 & 3) << 6) | enc4;

                output = output + String.fromCharCode(chr1);

                if (enc3 != 64) {
                    output = output + String.fromCharCode(chr2);
                }
                if (enc4 != 64) {
                    output = output + String.fromCharCode(chr3);
                }

                chr1 = chr2 = chr3 = "";
                enc1 = enc2 = enc3 = enc4 = "";

            } while (i < input.length);

            return output;
        }
    };
});


app.factory('inventoryService',['$http','$rootScope','$q','Base64',function($http,$rootScope,$q,Base64){
	
	
	(function authentication(){
		  $http.defaults.headers.common['Authorization'] = 'Basic ' + Base64.encode('administrator' + ':' + 'KJHASDF89.ajHFAHF$');
	})();
	
	function InventoryService(){
		this.inventory=[];
	}
	
	InventoryService.prototype={
		constructor:InventoryService,
		loadInventory:function(id){
			var deferred=$q.defer();
			var url=SERVICE_URL+'inventory/i/'+id;
			$http.get(url).success(function(data){
				deferred.resolve(data.result);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		addStock:function(id,qty){
			var deferred=$q.defer();
			var url=SERVICE_URL+'add_stock/';
			$http.post(url,
				{
				'i':id,
				'q':qty
				}
			).success(function(data){
				deferred.resolve(data);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		removeStock:function(id,qty){
			var deferred=$q.defer();
			var url=SERVICE_URL+'remove_stock/';
			$http.post(url,
				{
				'i':id,
				'q':qty
				}
			).success(function(data){
				deferred.resolve(data);
				$rootScope.$phase;
			});
			return deferred.promise;
		}
	}
	var instance=new InventoryService();
	return instance;
}]);

app.factory('productService',['$http','$rootScope','$q','Base64',function($http,$rootScope,$q,Base64){
	
	(function authentication(){
		  $http.defaults.headers.common['Authorization'] = 'Basic ' + Base64.encode('administrator' + ':' + 'KJHASDF89.ajHFAHF$');
	})();
	
	function ProductService(){
		this.products=[];
	}
	ProductService.prototype={
		constructor:ProductService,
		loadProducts:function(o,l,search){
			var deferred = $q.defer();
			var url=SERVICE_URL+'products/o/'+o+'/l/'+l+'/method/admin/cat/productname/search/'+search;
			$http.get(url).success(function(data){
				deferred.resolve(data.result);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		loadCategories:function(){
			var deferred = $q.defer();
			var url=SERVICE_URL+'categories/';
			$http.get(url).success(function(data){
				deferred.resolve(data.result);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		uploadPhoto:function(productid,files){
			var deferred = $q.defer();
			var url=SERVICE_URL+'product_image_upload/';
			var formData=new FormData();
					formData.append("productid", productid);
					formData.append("userfile", files);
			$http({
				'method': "POST",
				'url': url,
				'dataType"':"JSON",
				'data': formData,
				"cache":false,
				'processData':false,
				'headers': {'Content-Type': undefined}
			}).success(function(data){
					deferred.resolve(data);
				
			});
			return deferred.promise;
		},
		updateProduct:function(product){
			var deferred=$q.defer();
			var url=SERVICE_URL+'products_master_update/';
			$http.post(url,{
				'productid':product.productid,
				'productname':product.productname,
				'categoryid':-1,
				'hargaeceran':product.hargaeceran,
				'hargagrosir':product.hargagrosir,
				'description':product.description,
				'berat':product.berat
			}).success(function(data){
				deferred.resolve(data);
			});
			return deferred.promise;
		},
		insertProduct:function(product){
			var deferred=$q.defer();
			var url=SERVICE_URL+'products_master_add/';
			$http.post(url,{
				'productname':product.productname,
				'categoryid':product.categoryid,
				'hargaeceran':product.hargaeceran,
				'hargagrosir':product.hargagrosir,
				'description':product.description,
				'type':product.type,
				'r_type':product.r_type,
				'berat':product.berat
			
			}).success(function(data){
				deferred.resolve(data);
			});
			
			return deferred.promise;
		},
		pushProduct:function(id,caption,desc){
			var deferred=$q.defer();
			var url=SERVICE_URL+'push/';
			$http.post(url,{
				'i':id,
				'cap':caption,
				'mes':desc
			
			}).success(function(data){
				deferred.resolve(data);
			});
			
			return deferred.promise;
		},
		publishProduct:function(productid){
			var deferred=$q.defer();
			var url=SERVICE_URL+'product_publish/i/'+productid;
			$http.get(url).success(function(data){
				deferred.resolve(data);
			});
			return deferred.promise;
		
		},
		deleteProduct:function(productid){
			var deferred=$q.defer();
			var url=SERVICE_URL+'product_delete';
			$http.post(url,{
				'i':productid
			}).success(function(data){
				deferred.resolve(data);
				
			});
			return deferred.promise;
		},
		productReady:function(productid){
			var deferred=$q.defer();
			var url=SERVICE_URL+'tr_po_ready';
			$http.post(url,{
				'i':productid
			}).success(function(data){
				deferred.resolve(data);
				
			});
			return deferred.promise;
		}
		
	};
	var instance=new ProductService();
	return instance;
}]);

app.factory('userService',['$http','$rootScope','$q','Base64',function($http,$rootScope,$q,Base64){
	
	
	(function authentication(){
		  $http.defaults.headers.common['Authorization'] = 'Basic ' + Base64.encode('administrator' + ':' + 'KJHASDF89.ajHFAHF$');
	})();
	function UserService(){
		this.users=[];
	}
	UserService.prototype={
		constructor:UserService,
		loadUsers:function(){
			var deferred = $q.defer();
			var url=SERVICE_URL+'users/';
			$http.get(url).success(function(data){
				deferred.resolve(data.result);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		updateUser:function(user){
			var deferred=$q.defer();
			var url=SERVICE_URL+'user_update/';
			$http.post(url,{
				'userid':user.userid,
				'nama':user.nama,
				'telepon':user.telepon,
				'email':user.email,
				'alamat':user.alamat,
				'note':user.note,
				'bb':user.bb
			}).success(function(data){
				deferred.resolve(data);
			});
			return deferred.promise;
		},
		insertUser:function(user){
			var deferred=$q.defer();
			var url=SERVICE_URL+'users_register';
			$http.post(url,{
				'username':user.username,
				'nama':user.nama,
				'alamat':user.alamat,
				'telepon':user.telepon,
				'email':user.email,
				'password':user.username
			}).success(function(data){
				deferred.resolve(data);
			});
			return deferred.promise;
		},
		getUser:function(userid){
			var deferred=$q.defer();
			var url=SERVICE_URL+'user/id/'+userid;
			$http.get(url).success(function(data){
				deferred.resolve(data);
			});
			return deferred.promise;
		},
		isValidUsername:function(username){
			var deferred=$q.defer();
			var url=SERVICE_URL+'users_check_username/username/'+username;
			$http.get(url).success(function(data){
				deferred.resolve(data);
			});
			return deferred.promise;
		},
		updateStatusUser:function(user,status){
			
			var deferred=$q.defer();
			var url=SERVICE_URL+'user_update_status/';
			$http.post(url,{
				'userid':user.userid,
				'status':status
			}).success(function(data){
				deferred.resolve(data);
			});
			return deferred.promise;
		},
		deleteUser:function(userid){
			var deferred=$q.defer();
			var url=SERVICE_URL+'user_update_status/';
			$http.post(url,{
				'i':userid
			}).success(function(data){
				deferred.resolve(data);
			});
			return deferred.promise;
		},
		removeUser:function(userid){
			var deferred=$q.defer();
			var url=SERVICE_URL+'user_delete/format/json';
			$http.post(url,{
				'id':userid,
				'key':'VASUDH12309SDBDAAHDA'
			}).success(function(data){
				deferred.resolve(data);
			});
			return deferred.promise;
		},
		sendMessage:function(form){
			var deferred=$q.defer();
			var url=SERVICE_URL+'message_user';
			$http.post(url,{
				'i':form.userid,
				'cap':form.caption,
				'mes':form.message
			}).success(function(data){
				deferred.resolve(data);
			});
			return deferred.promise;
		}
		
		
	};
	var instance=new UserService();
	return instance;
}]);

app.factory('transactionService',['$http','$rootScope','$q','Base64',function($http,$rootScope,$q,Base64){


	(function authentication(){
		  $http.defaults.headers.common['Authorization'] = 'Basic ' + Base64.encode('administrator' + ':' + 'KJHASDF89.ajHFAHF$');
	})();
	
	
	function TransactionService(){
	
		this.transaction=[];
	}
	
	TransactionService.prototype={
		constructor:TransactionService,
		loadTransaction:function(){
			var deferred=$q.defer();
			var url=SERVICE_URL+'order/';
			$http.get(url).success(function(data){
				deferred.resolve(data['result']);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		loadTransactionByProduct:function(){
			
			var deferred=$q.defer();
			var url=SERVICE_URL+'order_product/';
			$http.get(url).success(function(data){
				deferred.resolve(data['result']);
			});
			return deferred.promise;
		},
		loadRecapitulation:function(){
			var deferred=$q.defer();
			var url=SERVICE_URL+'recapitulation/';
			$http.get(url).success(function(data){
				deferred.resolve(data['result']);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		loadRecapitulationDetail:function(id){
			var deferred=$q.defer();
			var url=SERVICE_URL+'recapitulation_user/id/'+id;
			$http.get(url).success(function(data){
				deferred.resolve(data['result']);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		loadTransactionDetail:function(id){
			var deferred=$q.defer();
			var url=SERVICE_URL+'order_user_m/id/'+id;
			$http.get(url).success(function(data){
				deferred.resolve(data['result']);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		loadTransactionProductDetail:function(id){
			var deferred=$q.defer();
			var url=SERVICE_URL+'order_product_detail/id/'+id;
			$http.get(url).success(function(data){
				deferred.resolve(data['result']);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		changeStatus:function(id,status){
			var deferred=$q.defer();
			var url=SERVICE_URL+'update_tr';
			$http.post(url,{
				's':status,
				'id':id
			}).success(function(data){
				deferred.resolve(data);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		loadReport:function(from,to,userid){
			var deferred=$q.defer();
			var url=SERVICE_URL+'report';
			if(userid=='undefined')
			$http.post(url,{
				'from':from,
				'to':to
			}).success(function(data){
				deferred.resolve(data['result']);
				$rootScope.$phase;
			});
			else
				$http.post(url,{
				'from':from,
				'to':to,
				'userid':userid
			}).success(function(data){
				deferred.resolve(data['result']);
				$rootScope.$phase;
			});
			return deferred.promise;
		},
		buy:function(form){
			var deferred=$q.defer();
			var url=SERVICE_URL+'transaction_undef_buy';
			$http.post(url,{
				'userid':form.userid,
				'productid':form.productid,
				'quantity':form.quantity
			}).success(function(data){
				deferred.resolve(data);
			});
			return deferred.promise;
			
			
		}
	}
	
	var instance=new TransactionService();
	return instance;
}]);

app.controller('ProductController',['$scope','productService','inventoryService','filterFilter',function($scope,ps,is,filterFilter){
	
	
	$scope.heading='Product';
	$scope.key=null;
	$scope.products=[];
	$scope.filteredProducts=[];
	$scope.categories=[];
	$scope.filter='';
	$scope.insertFlag=false;
	$scope.error='';
	$scope.form={
		productname:'',
		hargagrosir:'',
		hargaeceran:'',
		berat:'',
		description:''
	};

	$scope.isError=function(){
		if($scope.error=='')
			return false;
		return true;
	};
	
	$scope.isAvailable=function(){
		if($scope.filteredProducts.length>0){
			return true;
		}
		return false;
	}
	
	$scope.showInsert=function(){
		$scope.insertFlag=!$scope.insertFlag;
	}
	
	
	
	$scope.isNull=function(value){
		return value===null;
	}
	
	$scope.getProducts=function(o,l,search){
		$("#modal").modal('show');
		ps.loadProducts(o,l,search).then(function(products){
			if(products==0){
				$scope.products=[];
			}
			else{
				$scope.products=products;
			}
			$scope.filterProduct();
			$("#modal").modal('hide');
		},function(){
			$scope.products=[];
			$("#modal").modal('hide');
		});
	};
	
	$scope.getCategories=function(){
		ps.loadCategories().then(function(categories){
			$scope.categories=categories;
		},function(){
			$scope.categories=[];
		});
	};
	
	$scope.insert=function(){
		if($scope.form.productname==''){
			$scope.error='Nama Produk harus diisi';
		}
		else if($scope.form.hargagrosir==''){
			$scope.error='Harga Grosir harus diisi';
		}
		else if($scope.form.hargaeceran==''){
			$scope.error='Harga Eceran harus diisi';
		}
		else if($scope.form.berat==''){
			$scope.error='Berat harus diisi';
		}
		else{
			$("#modal").modal('show');
			ps.insertProduct($scope.form).then(function(data){
				if(data.status=='success'){
					var productInsert=data.data;
					productInsert.categoryname=$scope.getCategoryName(productInsert.categoryid);
					$scope.products.push(productInsert);
					$scope.filterProduct();
					$("#modal").modal('hide');
				}
				else if(data.status=='failed'){
					$scope.error=data.reason;
					$("#modal").modal('hide');
				}
			},function(){
				$("#modal").modal('hide');
			});
		}
		
	}
	
	$scope.getCategoryName=function(id){
		for(var i=0;i<$scope.categories.length;i++)
			if($scope.categories[i].categoryid==id)
				return $scope.categories[i].categoryname;
		return '';
	}
	
	$scope.filterProduct=function(){
		$scope.filteredProducts=filterFilter($scope.products,{'productname':$scope.filter});
	}
	
	$scope.getCategories();
	$scope.getProducts(0,100000,'');
	
	
}]);

app.controller('ProductDetailController',['$scope','productService','inventoryService',function($scope,ps,is,filterFilter){
	
	$scope.errorUpload='';
	$scope.errorUpdate='';
	$scope.isErrorUpload=function(){
		if($scope.errorUpload=='')
			return false;
		return true;
	};

	$scope.isErrorUpdate=function(){
		if($scope.errorUpdate=='')
			return false;
		return true;
	};
	
	$scope.readUrl=function (input) {
		if (input.files && input.files[0]) {
			
			$scope.files=input.files[0];
		}
	};

	$scope.po_ready=function(){


	$("#modal").modal('show');
		ps.productReady($scope.product.productid).then(function(data){
			if(data.status=='success'){
				$("#modal").modal('hide');
			}
			else{
				$("#modal").modal('hide');
			}
		},function(){
			$("#modal").modal('hide');
		});
	}
	
	$scope.upload=function(){
		
		
		if(typeof $scope.files==='undefined' || $scope.files==null){
			$scope.errorUpload='Gambar harus di pilih';
		}
		else{
		$("#modal").modal('show');
			ps.uploadPhoto($scope.product.productid,$scope.files).then(function(data){
				if(data.status=='success'){
					
					$scope.product.gambar=data.result.file_name;
					$scope.image='http://localhost/aiko/image/items/'+$scope.product.gambar;
					$("#modal").modal('hide');
					$scope.errorUpload='Success';
					$scope.files=null;
				}
				else if(data.status=='failed'){
					$scope.errorUpload='Gagal Upload Gambar';
					$("#modal").modal('hide');
					$scope.files=null;
				}

			},function(){
				$("#modal").modal('hide');
				$scope.errorUpload='Unknown Error';
				$scope.files=null;
			});
		}
	
	};
	
	$scope.showUpdate=function(){
		$scope.product.update=!$scope.product.update;
		
	}
	
	$scope.showUpload=function(){
	
		$scope.product.upload=!$scope.product.upload;
		$scope.image=IMAGE+$scope.product.gambar;
		
	}
	
	$scope.showInventory=function(){
		$scope.product.inventory=!$scope.product.inventory;
		if($scope.product.inventory){
			$scope.loadInventory();
		}
	}
	
	$scope.showPush=function(){
		$scope.product.push=!$scope.product.push;
		
	}
	
	$scope.isPO=function(){
		if($scope.product.r_type=='Ready')
			return false;
		else if($scope.product.r_type='PO')
			return true;
	}
	
	$scope.deleteProduct=function(){
			
			$("#modal").modal('show');
			ps.deleteProduct($scope.product.productid).then(function(data){
				if(data['status']=='success'){
					for(var i=0;i<$scope.products.length;i++){
					if($scope.products[i].productid==$scope.product.productid)
							$scope.products.splice(i,1);
					}
					$scope.filteredProducts.splice($scope.$index,1);
					$("#modal").modal('hide');
				}
			},function(){
				$("#modal").modal('hide');
			});
	}
	
	$scope.loadInventory=function(){
		is.loadInventory($scope.product.productid).then(function(data){
				$scope.product.inventoryList=data;
				
			},function(){
				$scope.product.inventoryList=[];
			}
		);
	}
	
	$scope.update=function(){
		if($scope.product.productname=='')
		{	
			$scope.errorUpdate='Nama Produk harus diisi';

		}
		else if($scope.product.hargagrosir==''){

			$scope.errorUpdate='Harga Grosir harus diisi';
		}
		else if($scope.product.hargaeceran==''){

			$scope.errorUpdate='Harga Eceran harus diisi';
		}
		else if($scope.product.berat==''){

			$scope.errorUpdate='Berat harus diisi';
		}
		else{

			$("#modal").modal('show');
			ps.updateProduct($scope.product).then(function(data){
				if(data.status=='success'){
					$("#modal").modal('hide');
					$scope.product.update=false;
					$scope.errorUpdate='Success';
				}
				else if(data.status=='failed'){
					$scope.errorUpdate=data.reason;
					$("#modal").modal('hide');
				}
				
			},function(){
				$("#modal").modal('hide');
				$scope.errorUpdate='Unknown Error';
			});
		}
	}
	
	$scope.publish=function(product){
		$("#modal").modal('show');
		ps.publishProduct($scope.product.productid).then(function(data){
			if(data.status=='success'){
				$scope.product.published_at='';
				$("#modal").modal('hide');
			}
		},function(){
			$("#modal").modal('hide');
		});
	
	}
	
	$scope.pushProduct=function(){
		$("#modal").modal('show');
		ps.pushProduct($scope.product.productid,$scope.caption,$scope.message).then(function(data){
			if(data['status']=='success'){
				$scope.caption='';$scope.message='';
				$("#modal").modal('hide');
				$scope.showPush();
				
			}
			else{
				$("#modal").modal('hide');
			}
		},function(){
			$("#modal").modal('hide');
		
		});
	}

}]);

app.controller('InventoryController',['$scope','inventoryService',function($scope,is){
	
	$scope.quantity=0;
	$scope.isShow=function(){

		if(typeof $scope.product.inventoryList==='undefined')
			return false;
		if($scope.product.inventoryList.length>0)
			return true;
		else
			return false;
	}
	
	$scope.addStock=function(){
		if($scope.quantity==0)
			return;
		is.addStock($scope.product.productid,$scope.quantity).then(function(data){
			if(data['status']=='success'){
				$scope.product.inventoryList.push(data['result'][0]);
				$scope.product.stock=data['result'][1];
			}
			else{
			
			}
		},
		function(){
			
		});
	}
	
	$scope.removeStock=function(){
		if($scope.quantity==0)
			return;
		is.removeStock($scope.product.productid,$scope.quantity).then(function(data){
			if(data['status']=='success'){
				$scope.product.inventoryList.push(data['result'][0]);
				$scope.product.stock=data['result'][1];
				
			}
			else{
			
			}
		},
		function(){
			
		});
	}
}]);



app.controller('UserController',['$scope','userService','filterFilter',function($scope,us,filterFilter){
	$scope.heading='User';
	$scope.users=[];
	$scope.filteredUsers=[];
	$scope.filter='';
	$scope.insertFlag=false;
	$scope.error='';
	$scope.isError=function(){
		if($scope.error.length>0) 
			return true;
		else
			return false;
	}
	
	$scope.isAvailable=function(){
		if($scope.filteredUsers.length>0){
			return true;
		}
		return false;
	}
	
	$scope.getUsers=function(o,l,search){

		us.loadUsers().then(function(users){
			$scope.users=users;
			$scope.filterUser();
		},function(){
			$scope.users=[];
		});
	};
	
	$scope.filterUser=function(){
		$scope.filteredUsers=filterFilter($scope.users,$scope.filter);
	}

	$scope.showInsert=function(){
		$scope.insertFlag=!$scope.insertFlag;
	}
	
	$scope.deleteUser=function(id){
		for(var i=0;i<$scope.users.length;i++){
			if($scope.users[i].userid==id)
			{
				$scope.users.splice(i,1);
				$scope.filterUser();
				break;

			}
		}
	}
	
	$scope.insert=function(){
		
		$("#modal").modal("show");
		us.insertUser($scope.form).then(function(data){
			if(data['status']=='success')
			{
				var userid=data['result'];
				us.getUser(userid).then(function(data_user){
					var user=data_user['result'];
					$scope.users.push(user);
					$scope.filterUser();
					$scope.error='';
					$("#modal").modal("hide");
				},function(){
					$scope.error='Failed to Get inserted user data';
					$("#modal").modal("hide");
				});
				
			}
			else{
				$scope.error=data['reason'];
				$("#modal").modal("hide");
			}
			
			
		},function(){
			$scope.error='Failure';
			$("#modal").modal("hide");
		});
	}
	
	$scope.getUsers();
	
}]);

app.controller('UserDetailController',['$scope','userService',function($scope,us){
	
	$scope.activate=function(){
		$("#modal").modal('show');
		us.updateStatusUser($scope.user,1).then(function(data){
			if(data.status=='success'){
				$scope.user.status=1;
				$scope.user.statusKata='Active';
				
			}
			$("#modal").modal('hide');
		},function(){
			$("#modal").modal('hide');
		});
	}
	
	$scope.deactivate=function(){
		$("#modal").modal('show');
		us.updateStatusUser($scope.user,-1).then(function(data){
			if(data.status=='success'){
				$scope.user.status=-1;
				$scope.user.statusKata='Deactive';
			}
			$("#modal").modal('hide');
		},function(){
			$("#modal").modal('hide');
		});
	}

	$scope.deleteUser=function(){

		$("#modal").modal('show');
		us.removeUser($scope.user.userid).then(function(data){
			if(data.status=='success'){
				$scope.$parent.deleteUser($scope.user.userid);
			}
			$("#modal").modal('hide');
		},function(){
			$("#modal").modal('hide');
		});
	}
	
	$scope.update=function(){
		$("#modal").modal('show');
		$scope.formUpdate.userid=$scope.user.userid;
		us.updateUser($scope.formUpdate).then(function(data){
			if(data.status=='success'){
				$scope.user.update=false;
				$scope.user.nama=$scope.formUpdate.nama;
				$scope.user.telepon=$scope.formUpdate.telepon;
				$scope.user.email=$scope.formUpdate.email;
				$scope.user.alamat=$scope.formUpdate.alamat;
				$scope.user.note=$scope.formUpdate.note;
				$scope.user.bb=$scope.formUpdate.bb;
			}
			$("#modal").modal('hide');
		},function(){
			$("#modal").modal('hide');
		});
	}
	$scope.showUpdate=function(){
		$scope.user.update=!$scope.user.update;
	}
	$scope.isActivate=function(){
		if($scope.user.status==1)
			return true;
		else
			return false;
	}
}]);

app.controller('TransactionController',['$scope','transactionService','userService','productService','filterFilter','orderByFilter',function($scope,ts,us,ps,filterFilter,orderByFilter){
	$scope.heading='Order';
	$scope.transaction=[];
	$scope.filteredTransaction=[];
	$scope.showAddress=true;
	$scope.transactionProduct=[];
	$scope.filteredProductTransaction=[];
	$scope.filter='';
	$scope.filterProduct='';
	$scope.insertFlag=false;
	$scope.users=[];
	$scope.filteredUser=[];
	$scope.products=[];
	$scope.productTemp;
	$scope.filteredProducts=[];
	$scope.error='';
	$scope.mode='Product';
	$scope.printElement=null;
	$scope.elementChecked=[];
	$scope.printShow=false;
	$scope.username;
	$scope.form={
		userid:0,
		productid:0,
		quantity:''
	}
	$scope.isActive=function(action){
		if(action===$scope.mode)
			return 'active';
		return '';
	}
	$scope.isPrint=function(){
		return $scope.printShow;
	}
	$scope.passPrintElement=function(detail,tr){
		$scope.printElement=detail;
		$scope.username=tr.username;
		$scope.alamat=tr.alamat;
		
	}

	$scope.ongkir=0;
	$scope.totalPrint=0;
	$scope.username=''
	$scope.countTotal=function(){
		$scope.totalPrint=0;
		if($scope.elementChecked!=null){
		
		for(var i=0;i<$scope.elementChecked.length;i++)
			$scope.totalPrint+=$scope.elementChecked[i].quantity*$scope.elementChecked[i].harga;
		}	
		return $scope.totalPrint;
	}

	$scope.totalAll=function(){
		return parseInt($scope.ongkir)+parseInt($scope.totalPrint);
	}

	$scope.print=function(){
		if($scope.printElement!=null&&$scope.printElement.length>0){
		  $scope.elementChecked=filterFilter($scope.printElement,{'checked':true});
		  $scope.printShow=!$scope.printShow;
		}
		
	}

	$scope.printOrder=function(){
		var printContents = document.getElementById("printContent").innerHTML;
		var head=document.getElementsByTagName("head")[0].innerHTML;
		//console.log(head);
		var documentString='<html><head>'+head+'</head><body onload="window.print()">';
		documentString+=printContents;
		documentString+='</html>';
		var popupWin = window.open('', '_blank', 'width=800,height=800');
		popupWin.document.open();
		popupWin.document.write(documentString );
		popupWin.document.close();
	}
	
	$scope.isShow=function(action){
		if(action===$scope.mode)
			return true;
		return false;
	}
	
	$scope.changeToMode=function(mode){
		$scope.mode=mode;
		if(mode=='User')
			$scope.getTransaction();
		else if(mode=='Product')
			$scope.getTransactionByProduct();
	}
	
	$scope.isError=function(){
		if ($scope.error.length>0)return true; else return false;
	}
	
	$scope.onUsernameChange=function(){
		if($scope.form.username===''){
			$scope.filteredUser=[];
			return;
		}
		$scope.filteredUser=filterFilter($scope.users,{'username':$scope.form.username});
		$scope.filteredUser=orderByFilter($scope.filteredUser,'+username');
		
	}
	
	$scope.onProductChange=function(){
		if($scope.form.productname===''){
			$scope.filteredProducts=[];
			return;
		}
		$scope.filteredProducts=filterFilter($scope.products,{'productname':$scope.form.productname});
		$scope.filteredProducts=orderByFilter($scope.filteredProducts,'+productname');
		
	}
	
	$scope.chooseProduct=function(){
		if($scope.filteredProducts.length==0)
		{
			$scope.form.productname='';
			$scope.form.productid='';
			return;
		}
		
		$scope.form.productname=$scope.filteredProducts[0].productname;
		$scope.form.productid=$scope.filteredProducts[0].productid;
		$scope.productTemp=$scope.filteredProducts[0];
		$scope.filteredProducts=[];
	}
	
	$scope.chooseProductClick=function(index){
		$scope.form.productname=$scope.filteredProducts[index].productname;
		$scope.form.productid=$scope.filteredProducts[index].productid;
		$scope.productTemp=$scope.filteredProducts[index];
		$scope.filteredProducts=[];
	}
	
	$scope.chooseUser=function(){
		if($scope.filteredUser.length==0)
		{
			$scope.form.username='';
			$scope.form.userid='';
			
			return;
		}
		
		$scope.form.username=$scope.filteredUser[0].username;
		$scope.form.userid=$scope.filteredUser[0].userid;
		$scope.filteredUser=[];
	}
	
	$scope.chooseUserClick=function(index){
		$scope.form.username=$scope.filteredUser[index].username;
		$scope.form.userid=$scope.filteredUser[index].userid;
		$scope.filteredUser=[];
	}
	
	$scope.showInsert=function(){
		$scope.insertFlag=!$scope.insertFlag;
		if($scope.insertFlag){
			$("#modal").modal("show");
			us.loadUsers().then(function(data){
				$scope.users=data;
				ps.loadProducts(0,100000,'').then(function(pr){
					$scope.products=pr;
					$("#modal").modal("hide");
				},function(){
					
					$("#modal").modal("hide");
				})
			},function(){
				$("#modal").modal("hide");
			});
		}
	}
	
	$scope.buy=function(){
		
		if($scope.form.userid==''||$scope.form.userid==0){
			$scope.error='User Belum dipilih';
		}
		else if($scope.form.productid==''||$scope.form.productid==0){
			$scope.error='Produk Belum dipilih';
		}
		else if($scope.form.quantity==''||$scope.form.productid==0)
		{
			$scope.error='Jumlah barang belum di isi';
		}
		else if(parseInt($scope.form.quantity)>parseInt($scope.productTemp.stock)){
			$scope.error='Jumlah Stock kurang';
		}
		else{
			$("#modal").modal('show');
			ts.buy($scope.form).then(function(data){
				if(data['status']==='success')
				{
					$scope.productTemp.stock-=$scope.form.quantity;
					$scope.error="Success";
					$("#modal").modal('hide');
					$scope.getTransaction();
				}
				else{
					$scope.error=data['error'];
					$("#modal").modal('hide');
				}
			},function(){
				$scope.error="Gagal";
				$("#modal").modal('hide');
			});
		}
	}
	
	$scope.getTransaction=function(){
		$("#modal").modal('show');
		ts.loadTransaction().then(function(transaction){
			$scope.transaction=transaction;
			$scope.filterTransaction();
			$("#modal").modal('hide');
		},function(){
			$scope.transaction=[];
			$("#modal").modal('hide');
		});
	};
		
	$scope.getTransactionByProduct=function(){

		ts.loadTransactionByProduct().then(function(transaction){
			$scope.transactionProduct=transaction;
			$scope.filterTransactionProduct();
			console.log($scope.transactionProduct);
		},function(){
			$scope.transactionProduct=[];
		});
	};
	
	$scope.filterTransaction=function(){
		
		$scope.filteredTransaction=filterFilter($scope.transaction,$scope.filter);
	}
	
	$scope.filterTransactionProduct=function(){
		
		$scope.filteredProductTransaction=filterFilter($scope.transactionProduct,$scope.filterProduct);
	}
	
	
	$scope.isAvailable=function(){
		if($scope.filteredTransaction.length>0){
			return true;
		}
		return false;
	}
	
	$scope.isAvailableProduct=function(){
		if($scope.filteredProductTransaction.length>0){
			return true;
		}
		return false;
	}
	$scope.changeToMode('User');
	
	
}]);

app.controller('RecapitulationController',['$scope','transactionService','filterFilter',function($scope,ts,filterFilter){
	$scope.heading='Recapitulation';
	$scope.transaction=[];
	$scope.filteredTransaction=[];
	$scope.filter='';
	
	$scope.getTransaction=function(){

		ts.loadRecapitulation().then(function(transaction){
			$scope.transaction=transaction;
			$scope.filterTransaction();
		},function(){
			$scope.transaction=[];
		});
	};
	$scope.filterTransaction=function(){
		$scope.filteredTransaction=filterFilter($scope.transaction,$scope.filter);
	}
	
	$scope.isAvailable=function(){
		if($scope.filteredTransaction.length>0){
			return true;
		}
		return false;
	}
	
	$scope.getTransaction();
	
}]);


app.controller('RecapDetailController',['$scope','transactionService','filterFilter',function($scope,ts,filterFilter){
	


	$scope.showDetail=function(){
		
		$scope.detailStatus=true;
		ts.loadRecapitulationDetail($scope.tr.userid).then(function(detail){
			
			$scope.tr.detail=filterFilter(detail,{'status':$scope.$parent.filterTr});
			
		},function(){
		
		});
		
	}
	
	$scope.isAvailable=function(){
		if(!$scope.tr.detail)
			return true;
		
		if($scope.tr.detail.length>0){
			return true;
		}
		return false;
	}
	
	$scope.getTotal=function(){
		var total=0;
		if($scope.tr.detail)
		for(var i=0;i<$scope.tr.detail.length;i++){
			total+=$scope.tr.detail[i].harga*$scope.tr.detail[i].quantity;
		}
		return total;
	}
	
	


	$scope.hideDetail=function(){
	
		$scope.detailStatus=false;
	}
	
}]);

app.controller('TrDetailController',['$scope','transactionService',function($scope,ts,filterFilter){
	
	$scope.showDetail=function(){
		
		$scope.detailStatus=true;
		$("#modal").modal('show');
		ts.loadTransactionDetail($scope.tr.userid).then(function(detail){
			$scope.tr.detail=detail;
			$scope.passPrintElement(detail,$scope.tr);

			$("#modal").modal('hide');
		},function(){
			$("#modal").modal('hide');
		});
		
	}
	
	
	$scope.isAvailable=function(){
		if(!$scope.tr.detail)
			return true;
		
		if($scope.tr.detail.length>0){
			return true;
		}
		return false;
	}
	
	$scope.getTotal=function(){
		var total=0;
		if($scope.tr.detail)
		for(var i=0;i<$scope.tr.detail.length;i++){
			total+=$scope.tr.detail[i].harga*$scope.tr.detail[i].quantity;
		}
		return total;
	}

	$scope.getTotalWeight=function(){
		var total=0;
		if($scope.tr.detail)
		for(var i=0;i<$scope.tr.detail.length;i++){
			total+=$scope.tr.detail[i].berat*$scope.tr.detail[i].quantity;
		}
		return total;
	}
	
	$scope.hideDetail=function(){
	
		$scope.detailStatus=false;
	}
	
}]);


app.controller('TrProductDetailController',['$scope','transactionService',function($scope,ts,filterFilter){
	
	$scope.showDetail=function(){
		
		$scope.detailStatus=true;
		$("#modal").modal('show');
		ts.loadTransactionProductDetail($scope.tr.productid).then(function(detail){
			$scope.tr.detail=detail;
			$("#modal").modal('hide');
		},function(){
			$("#modal").modal('hide');
		});
		
	}
	
	
	$scope.isAvailable=function(){
		if(!$scope.tr.detail)
			return true;
		
		if($scope.tr.detail.length>0){
			return true;
		}
		return false;
	}
	
	$scope.getTotal=function(){
		var total=0;
		if($scope.tr.detail)
		for(var i=0;i<$scope.tr.detail.length;i++){
			total+=$scope.tr.detail[i].harga*$scope.tr.detail[i].quantity;
		}
		return total;
	}

	$scope.getTotalPiece=function(){
		var total=0;
		if($scope.tr.detail)
		for(var i=0;i<$scope.tr.detail.length;i++){
			total+=parseInt($scope.tr.detail[i].quantity);
		}
		return total;
	}
	
	$scope.hideDetail=function(){
	
		$scope.detailStatus=false;
	}
	
}]);


app.controller('TransactionDetailController',['$scope','transactionService',function($scope,ts,filterFilter){
	
	$scope.deliver=function(){
		$("#modal").modal('show');
	ts.changeStatus($scope.dt.transactionid,'Delivered').then(function(data){
			if(data['status']=='success'){
				//$scope.tr.detail.splice($scope.$index,1);
				$scope.dt.status='Delivered';
			}
			$("#modal").modal('hide');
		},function(){
			$("#modal").modal('hide');
		
		});
		
	}
	
	
	$scope.showReady=function(){
		if($scope.dt.status=='PO')
			return true;
		return false;
			
	}

	$scope.showPaid=function(){
		if($scope.dt.status=='Pending')
			return true;
		return false;
			
	}
	
	$scope.showDelivered=function(){
		if($scope.dt.status=='Paid')
			return true;
		return false;
			
	}
	

	$scope.doNotShow=function(){
		if($scope.dt.status=='Delivered')
			return true;
		return false;
	}
	
	$scope.paid=function(){
		$("#modal").modal('show');
	ts.changeStatus($scope.dt.transactionid,'Paid').then(function(data){
			if(data['status']=='success')
				$scope.dt.status='Paid'
			$("#modal").modal('hide');
		},function(){
			$("#modal").modal('hide');
		
		});
		
	}

	$scope.ready=function(){
		$("#modal").modal('show');
	ts.changeStatus($scope.dt.transactionid,'Pending').then(function(data){
			if(data['status']=='success')
				$scope.dt.status='Pending'
			$("#modal").modal('hide');
		},function(){
			$("#modal").modal('hide');
		
		});
		
	}
	
	
	$scope.reject=function(){
		$("#modal").modal('show');
		ts.changeStatus($scope.dt.transactionid,'Reject').then(function(data){
			if(data['status']=='success')
				$scope.tr.detail.splice($scope.$index,1);
			$("#modal").modal('hide');
		},function(){
			$("#modal").modal('hide');
		})
		
	}
	
	
}]);

app.controller('ReportController',['$scope','transactionService','userService','filterFilter','orderByFilter',function($scope,ts,us,filterFilter,orderByFilter){
	
	$scope.users=[];
	$scope.filteredUser=[];

	$scope.transaction=[];
	$scope.isAvailable=function(){
		return ($scope.transaction.length>0)?true:false;
	}
	
	$scope.getUser=function(){
		$("#modal").modal("show");
		us.loadUsers().then(function(data){
			$scope.users=data;
			$("#modal").modal("hide");
				
		},function(){
				$("#modal").modal("hide");
		});
		
	}
	
	$scope.onUsernameChange=function(){
		if($scope.username===''){
			$scope.filteredUser=[];
			return;
		}
		$scope.filteredUser=filterFilter($scope.users,{'username':$scope.username});
		$scope.filteredUser=orderByFilter($scope.filteredUser,'+username');
		
	}
	
	$scope.chooseUser=function(){
		if($scope.filteredUser.length==0)
		{
			$scope.username='';
			$scope.userid='';
			
			return;
		}
		
		$scope.username=$scope.filteredUser[0].username;
		$scope.userid=$scope.filteredUser[0].userid;
		$scope.filteredUser=[];
	}
	
	$scope.chooseUserClick=function(index){
		$scope.username=$scope.filteredUser[index].username;
		$scope.userid=$scope.filteredUser[index].userid;
		$scope.filteredUser=[];
	}
	
	
	$scope.generate=function(){
		var from=$scope.datefrom.getFullYear()+'-'+($scope.datefrom.getMonth()+1)+'-'+$scope.datefrom.getDate();
		var to=$scope.dateto.getFullYear()+'-'+($scope.dateto.getMonth()+1)+'-'+$scope.dateto.getDate();
		$("#modal").modal("show");
		if($scope.userid=='')
			ts.loadReport(from,to).then(function(data){
					$scope.transaction=data;
					$("#modal").modal("hide");
			},function(){
				$("#modal").modal("hide");
			
			});
		else
			ts.loadReport(from,to,$scope.userid).then(function(data){
				$scope.transaction=data;
				$("#modal").modal("hide");
			},function(){
				$("#modal").modal("hide");
			
			});
		}
	
	$scope.getUser();
}]);



app.controller('MessageController',['$scope','userService','productService','filterFilter','orderByFilter',function($scope,us,ps,filterFilter,orderByFilter){
	$scope.heading="Message";
	$scope.filteredUser=[];
	$scope.form={
		username:'',
		userid:0,
		caption:'',
		message:''
	}
	$scope.chooseUser=function(){
		if($scope.filteredUser.length==0)
		{
			$scope.form.username='';
			$scope.form.userid='';
			
			return;
		}
		
		$scope.form.username=$scope.filteredUser[0].username;
		$scope.form.userid=$scope.filteredUser[0].userid;
		$scope.filteredUser=[];
	}
	
	$scope.chooseUserClick=function(index){
		$scope.form.username=$scope.filteredUser[index].username;
		$scope.form.userid=$scope.filteredUser[index].userid;
		$scope.filteredUser=[];
	}

	$scope.onUsernameChange=function(){
		if($scope.form.username===''){
			$scope.filteredUser=[];
			return;
		}
		$scope.filteredUser=filterFilter($scope.users,{'username':$scope.form.username});
		$scope.filteredUser=orderByFilter($scope.filteredUser,'+username');
		$scope.filteredUser.push({'username':'ALL USER','userid':0});
		
	}

	us.loadUsers().then(function(data){
		$scope.users=data;
	},function(){
	});

	$scope.send=function(){
		$("#modal").modal("show");
		us.sendMessage($scope.form).then(function(data){
			$("#modal").modal("hide");
		},function(){})
	}


}]);
