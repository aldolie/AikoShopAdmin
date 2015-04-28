


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="shortcut icon" href="<?php echo base_url('image/favicon.ico');?>">

    <title>Aiko - Shop</title>

    <!-- Bootstrap Core CSS -->
    <link href="<?php echo base_url('css/bootstrap.min.css'); ?>" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="<?php echo base_url('css/style.css') ?>" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <style type="text/css">
        .panel,body{
            background-color: #dfdfdf;
        }
    </style>
</head>
<body>
<div id="form-login">
<div class="container-fluid">
    <div class="row">
        <div class="col-md-4 col-md-offset-4">
            <div class="heading-title center-align">AIKO Admin</div>
            <div class="panel">
                <div class="panel-body">
                <?php if(isset($error)){ ?>
                    <div class="alert alert-danger" role="alert"><?php echo $error; ?></div>
                <?php } ?>
        
            <form class="form-horizontal" ng-controller="StaffController" action="<?php echo base_url('signin/action'); ?>" method="post">
          
                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="text" class="form-control form-none"  ng-model="username" name="username"  placeholder="USERNAME">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="password" class="form-control form-none"  ng-model="password" name="password" placeholder="PASSWORD" >
                            </div>
                        </div>

                    

                        <div class="form-group">
                            <div class="col-md-12">
                                <input type="submit" class="btn btn-none large all" value="Sign in" />
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
</div>  
        <script src="<?php echo base_url('js/jquery-2.1.1.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('js/angular.min.js'); ?>"></script>
</body>
</html>

