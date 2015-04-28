<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
	<link rel="shortcut icon" href="<?php echo base_url('image/favicon.ico'); ?>">

    <title>Aiko - Shop</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url('css/simple-sidebar.css'); ?>" rel="stylesheet">
	<link href="<?php echo base_url('css/style.css') ?>" rel="stylesheet">
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        [ng\:cloak], [ng-cloak], [data-ng-cloak], [x-ng-cloak], .ng-cloak, .x-ng-cloak {
          display: none !important;
        }
    </style>
</head>

<body ng-app="app">
	<nav class="navbar navbar-inverse navbar-fixed-top" style="margin:0px;">
		  <div class="container-fluid">
			<div class="navbar-header" >
				
			  <a class="navbar-brand" id="menu-toggle" style="padding:5px;padding-left:15px;">
				<img alt="Brand" src="<?php echo base_url('image/icon.png'); ?>">
			  </a>
			 <button class="btn" id="nbr-toogle" style="float:right;margin-right:20px;margin-top:10px;">
				<span  class="glyphicon glyphicon-th-list" aria-hidden="true"></span>
		     </button>
			</div>
			
			 <div id="nbr" class="navbar-right">
				<p class="navbar-text">
					Signed in as <b style="font-size:16px;"><?php echo $user->username; ?></b>
				</p>
				<a href="<?php echo base_url('signin/deaction'); ?>" class="navbar-text" style="color:white;">Sign Out</a>
			</div>
		  </div>
	</nav>
    <div id="wrapper">

        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <ul class="sidebar-nav">
                <li class="sidebar-brand">
                    <a href="#">
                        Divine
                    </a>
                </li>
                <li>
                    <a href="<?php echo base_url('home/product/') ?>"><span class="glyphicon glyphicon-folder-close" style="margin-right:10px;" aria-hidden="true"></span>Products</a>
                </li>
                <li>
                    <a href="<?php echo base_url('home/user/') ?>"><span class="glyphicon glyphicon-user" style="margin-right:10px;" aria-hidden="true"></span>User</a>
                </li>
                <li>
                    <a href="<?php echo base_url('home/order/') ?>"><span class="glyphicon glyphicon-unchecked" style="margin-right:10px;" aria-hidden="true"></span>Order</a>
                </li>
               <li>
                    <a href="<?php echo base_url('home/recapitulation/') ?>"><span class="glyphicon glyphicon-check" style="margin-right:10px;" aria-hidden="true"></span>Recapitulation</a>
                </li>
				
				<li>
                    <a href="<?php echo base_url('home/report/') ?>"><span class="glyphicon glyphicon-book" style="margin-right:10px;" aria-hidden="true"></span>Report</a>
                </li>
                <li>
                    <a href="<?php echo base_url('home/message/') ?>"><span class="glyphicon glyphicon-book" style="margin-right:10px;" aria-hidden="true"></span>Message</a>
                </li>
            </ul>
        </div>
        <!-- /#sidebar-wrapper -->

        <!-- Page Content -->
        <div id="page-content-wrapper" style="padding-top:50px;" >
			
		
           <?php  echo isset($view_child)?$view_child:''; ?>
        </div>
        <!-- /#page-content-wrapper -->

    </div>
	
	<div class="modal fade bs-example-modal-sm" id="modal" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true" >
	  <div class="modal-dialog modal-sm" style="margin-top:300px;">
		<div class="modal-content" style="height:20px !important;" >
		  <div class="progress">
			  <div class="progress-bar progress-bar-striped active" role="progressbar"
			   aria-valuemin="0" aria-valuemax="100"  style="width:100%">
				Loading...
			  </div>
			</div>
		</div>
	  </div>
	</div>
    <!-- /#wrapper -->

    <!-- jQuery -->
    <script src="<?php echo base_url('js/jquery-2.1.1.min.js'); ?>"></script>
	

    <!-- Bootstrap Core JavaScript -->
    <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular.min.js'); ?>"></script>
	<script src="<?php echo base_url('js/angular-route.min.js'); ?>"></script>
	
    <!-- Menu Toggle Script -->
    <script>
    $("#menu-toggle").click(function(e) {
        e.preventDefault();
        $("#wrapper").toggleClass("toggled");
    });
	
	 $("#nbr-toogle").click(function(e) {
		 if($("#nbr").is(":visible"))
			$("#nbr").css('display','none');
		 else
			$("#nbr").css('display','block');
        e.preventDefault();
    });
    </script>
	<script src="<?php echo base_url('js/app.js'); ?>"></script>

</body>

</html>