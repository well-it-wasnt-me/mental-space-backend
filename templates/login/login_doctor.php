<?php
/*
 * Mental Space Project - Creative Commons License
 */
set_language(substr(str_replace("-", "_",$_SERVER['HTTP_ACCEPT_LANGUAGE']), 0, 5));
//set_language('en_US');
?>
<!DOCTYPE html>
<html class="loading" lang="en" data-textdirection="ltr">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">

    <title>Login Page - Mental Space 1.0</title>
    <link rel="apple-touch-icon" href="../app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="../app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/vendors/css/vendors.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="../app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/plugins/forms/form-validation.css">
    <link rel="stylesheet" type="text/css" href="../app-assets/css/pages/authentication.css">
    <!-- END: Page CSS-->

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="../assets/css/style.css">
    <!-- END: Custom CSS-->
</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern blank-page navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="blank-page">
<!-- BEGIN: Content-->
<div class="app-content content ">
    <div class="content-overlay"></div>
    <div class="header-navbar-shadow"></div>
    <div class="content-wrapper">
        <div class="content-header row">
        </div>
        <div class="content-body">
            <div class="auth-wrapper auth-cover">
                <div class="auth-inner row m-0">
                    <!-- Brand logo--><a class="brand-logo" href="/pages/home">
                        <img src="/app-assets/images/mental-space-logo/png/logo-no-background.png" height="32px" width="auto">
                    </a>
                    <!-- /Brand logo-->
                    <!-- Left Text-->
                    <div class="d-none d-lg-flex col-lg-8 align-items-center p-5">
                        <div class="w-100 d-lg-flex align-items-center justify-content-center px-5"><img class="img-fluid" src="../app-assets/images/pages/login-v2.svg" alt="Login V2" /></div>
                    </div>
                    <!-- /Left Text-->
                    <!-- Login-->
                    <div class="d-flex col-lg-4 align-items-center auth-bg px-2 p-lg-5">
                        <div class="col-12 col-sm-8 col-md-6 col-lg-12 px-xl-2 mx-auto">
                            <h2 class="card-title fw-bold mb-1"><?php echo __('Welcome !');?> 👋</h2>
                            <p class="card-text mb-2"><?php echo __('Please, insert your credentials');?></p>
                            <div class="login-box-msg"></div>
                            <form class="auth-login-form mt-2" id="frm_login" action="#" method="POST">
                                <div class="mb-1">
                                    <label class="form-label" for="login-email">Email</label>
                                    <input class="form-control" id="login-email" type="text" name="login-email" placeholder="john@example.com" aria-describedby="login-email" autofocus="" tabindex="1" />
                                </div>
                                <div class="mb-1">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label" for="login-password">Password</label><a href="#"><small><?php echo __("Forgot your password ?");?></small></a> - <a href="/public/register_doc"><small><?php echo __("Create Account"); ?></small></a>
                                    </div>
                                    <div class="input-group input-group-merge form-password-toggle">
                                        <input class="form-control form-control-merge" id="login-password" type="password" name="login-password" placeholder="············" aria-describedby="login-password" tabindex="2" /><span class="input-group-text cursor-pointer"><i data-feather="eye"></i></span>
                                    </div>
                                </div>
                                <button onclick="do_login();" class="btn btn-primary w-100" tabindex="4">Log In</button><hr>
                                <a href="/public/register_doc" class="btn btn-secondary w-100" tabindex="4"><?php echo __("Create Account"); ?></a>
                            </form>
                        </div>
                    </div>
                    <!-- /Login-->
                </div>
            </div>
        </div>
    </div>
</div>
<!-- END: Content-->


<!-- BEGIN: Vendor JS-->
<script src="../app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="../app-assets/vendors/js/forms/validation/jquery.validate.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="../app-assets/js/core/app-menu.js"></script>
<script src="../app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<!-- BEGIN: Page JS-->
<script src="../app-assets/js/scripts/pages/auth-login.js"></script>
<!-- END: Page JS-->

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })

    $("#frm_login").submit(function(e){
        return false;
    });


    function do_login(){
        $.post('/doc_login', {
            username:$("#login-email").val(),
            password:$("#login-password").val(),
            role: 'doctor'
        }, function(resp){
            if ( resp.status == 'success' ){
                $(".login-box-msg").html("<?php echo __('Login Succesful, going to the Dashboard');?>");
                window.location = "/pages/home_doctor";
            } else {
                $(".login-box-msg").html("<b><?php echo __('Email or Password not valid');?></b>");
            }
        }).fail(function(){
            $(".login-box-msg").html("<b><?php echo __('Something went wrong, if persist contact us!');?></b>");
        });
    }
</script>
</body>
<!-- END: Body-->

</html>
