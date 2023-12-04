<?php
/*
 * Mental Space Project - Creative Commons License
 */
set_language(substr(str_replace("-", "_",$_SERVER['HTTP_ACCEPT_LANGUAGE']), 0, 5));
?>
<!DOCTYPE html>
<html class="loading" lang="<?php echo substr(str_replace("-", "_",$_SERVER['HTTP_ACCEPT_LANGUAGE']), 0, 2)?>" data-textdirection="ltr">
<base href="././">
<!-- BEGIN: Head-->

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1.0,user-scalable=0,minimal-ui">
    <title>Mental Space</title>
    <link rel="apple-touch-icon" href="/app-assets/images/ico/apple-icon-120.png">
    <link rel="shortcut icon" type="image/x-icon" href="/app-assets/images/ico/favicon.ico">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,300;0,400;0,500;0,600;1,400;1,500;1,600" rel="stylesheet">

    <!-- BEGIN: Vendor CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/vendors.min.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/charts/apexcharts.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/vendors/css/extensions/toastr.min.css">
    <!-- END: Vendor CSS-->

    <!-- BEGIN: Theme CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/bootstrap-extended.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/colors.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/components.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/dark-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/bordered-layout.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/themes/semi-dark-layout.css">

    <!-- BEGIN: Page CSS-->
    <link rel="stylesheet" type="text/css" href="/app-assets/css/core/menu/menu-types/vertical-menu.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/pages/dashboard-ecommerce.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/charts/chart-apex.css">
    <link rel="stylesheet" type="text/css" href="/app-assets/css/plugins/extensions/ext-component-toastr.css">
    <!-- END: Page CSS-->

    <!-- Custom styles for this template-->
    <?= $this->fetch('layout/css.php', ['assets' => $css ?? []]);?>

    <!-- BEGIN: Custom CSS-->
    <link rel="stylesheet" type="text/css" href="/assets/css/style.css">
    <!-- END: Custom CSS-->


</head>
<!-- END: Head-->

<!-- BEGIN: Body-->

<body class="vertical-layout vertical-menu-modern  navbar-floating footer-static  " data-open="click" data-menu="vertical-menu-modern" data-col="">

<!-- BEGIN: Header-->
<nav class="header-navbar navbar navbar-expand-lg align-items-center floating-nav navbar-light navbar-shadow container-xxl">
    <div class="navbar-container d-flex content">
        <div class="bookmark-wrapper d-flex align-items-center">
            <ul class="nav navbar-nav d-xl-none">
                <li class="nav-item"><a class="nav-link menu-toggle" href="#"><i class="ficon" data-feather="menu"></i></a></li>
            </ul>
            <ul class="nav navbar-nav bookmark-icons">
                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="/pages/messages" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Messages"><i class="ficon" data-feather="mail"></i></a></li>
                <li class="nav-item d-none d-lg-block"><a class="nav-link" href="/pages/calendar" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Calendar"><i class="ficon" data-feather="calendar"></i></a></li>
            </ul>
        </div>
        <ul class="nav navbar-nav align-items-center ms-auto">
            <!--<li class="nav-item dropdown dropdown-language"><a class="nav-link dropdown-toggle" id="dropdown-flag" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="flag-icon flag-icon-us"></i><span class="selected-language">English</span></a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-flag"><a class="dropdown-item" href="#" data-language="en"><i class="flag-icon flag-icon-us"></i> English</a><a class="dropdown-item" href="#" data-language="fr"><i class="flag-icon flag-icon-fr"></i> French</a><a class="dropdown-item" href="#" data-language="de"><i class="flag-icon flag-icon-de"></i> German</a><a class="dropdown-item" href="#" data-language="pt"><i class="flag-icon flag-icon-pt"></i> Portuguese</a></div>
            </li>-->
            <li class="nav-item d-none d-lg-block"><a class="nav-link nav-link-style"><i class="ficon" data-feather="moon"></i></a></li>
            <li class="nav-item nav-search"><a class="nav-link nav-link-search"><i class="ficon" data-feather="search"></i></a>
                <div class="search-input">
                    <div class="search-input-icon"><i data-feather="search"></i></div>
                    <input class="form-control input" id="searchBarPaz" oninput="searchPaz()" type="text" placeholder="Search Patient..." tabindex="-1" data-search="search">
                    <div class="search-input-close"><i data-feather="x"></i></div>
                    <ul class="search-list search-list-main"></ul>
                </div>
            </li>

            <li class="nav-item dropdown dropdown-user"><a class="nav-link dropdown-toggle dropdown-user-link" id="dropdown-user" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <div class="user-nav d-sm-flex d-none"><span class="user-name fw-bolder"><?php echo $_SESSION['fname'] . " " . $_SESSION['lname'];?></span><span class="user-status"><?php echo $_SESSION['email'];?></span></div><span class="avatar"><img class="round" src="<?php echo get_gravatar($_SESSION['email']);?>" alt="avatar" height="40" width="40"><span class="avatar-status-online"></span></span>
                </a>
                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdown-user">
                    <a class="dropdown-item" href="/pages/doctor_detail"><i class="me-50" data-feather="user"></i> Profile</a>
                    <!--<a class="dropdown-item" href="/pages/messages"><i class="me-50" data-feather="mail"></i> Messaggi</a>-->
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="/pages/doctor_detail"><i class="me-50" data-feather="settings"></i> Settings</a>
                    <a class="dropdown-item" href="/pages/prices"><i class="me-50" data-feather="credit-card"></i> Prices</a>
                    <a class="dropdown-item" href="/pages/faq"><i class="me-50" data-feather="help-circle"></i> FAQ</a>
                    <a class="dropdown-item" href="/logout"><i class="me-50" data-feather="power"></i> Logout</a>
                </div>
            </li>
        </ul>
    </div>
</nav>
<!-- END: Header-->


<!-- BEGIN: Main Menu-->
<div class="main-menu menu-fixed menu-light menu-accordion menu-shadow" data-scroll-to-active="true">
    <div class="navbar-header">
        <ul class="nav navbar-nav flex-row">
            <li class="nav-item me-auto"><a class="navbar-brand" href="/pages/home_doctor">
                            <img src="/app-assets/images/mental-space-logo/png/logo-no-background.png" height="32px" width="auto">
                    <!--<h2 class="brand-text">Mental Space</h2>-->
                </a></li>
            <li class="nav-item nav-toggle"><a class="nav-link modern-nav-toggle pe-0" data-bs-toggle="collapse"><i class="d-block d-xl-none text-primary toggle-icon font-medium-4" data-feather="x"></i><i class="d-none d-xl-block collapse-toggle-icon font-medium-4  text-primary" data-feather="disc" data-ticon="disc"></i></a></li>
        </ul>
    </div>
    <div class="shadow-bottom"></div>
    <div class="main-menu-content">
        <ul class="navigation navigation-main" id="main-menu-navigation" data-menu="menu-navigation">
            <ul class="menu-content">
                    <li><a url="/pages/home_doctor" class="d-flex align-items-center" href="/pages/home_doctor"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Dashboard"><?php echo __("Dashboard"); ?></span></a>
                    </li>
                </ul>

            <li class=" navigation-header"><span data-i18n="Apps &amp; Pages">Apps &amp; Pages</span><i data-feather="more-horizontal"></i>
            </li>
            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="user"></i><span class="menu-title text-truncate" data-i18n="Pazienti"><?php echo __("Patients");?></span></a>
                <ul class="menu-content">
                    <li><a url="/pages/patients/add" class="d-flex align-items-center"  href="/pages/patients/add"><i data-feather="user-plus"></i><span class="menu-item text-truncate" data-i18n="Aggiungi"><?php echo __("Add");?></span></a>
                    </li>
                    <li><a url="/pages/reports" class="d-flex align-items-center"  href="/pages/reports"><i data-feather="bar-chart-2"></i><span class="menu-item text-truncate" data-i18n="Report"><?php echo __("Report");?></span></a>
                    </li>
                    <li><a url="/pages/calendar" class="d-flex align-items-center"  href="/pages/calendar"><i data-feather="calendar"></i><span class="menu-item text-truncate" data-i18n="Calendario"><?php echo __("Calendar");?></span></a>
                    </li>
                    <!--<li><a url="/pages/messages" class="d-flex align-items-center"  href="/pages/messages"><i data-feather="mail"></i><span class="menu-item text-truncate" data-i18n="Calendario"><?php echo __("Messages");?></span></a>
                    </li>-->
                </ul>
            </li>

            <li class=" nav-item"><a class="d-flex align-items-center" href="#"><i data-feather="settings"></i><span class="menu-title text-truncate" data-i18n="Account"><?php echo __("Account");?></span></a>
                <ul class="menu-content">
                    <li><a url="/pages/doctor_detail" class="d-flex align-items-center" href="/pages/doctor_detail"><i data-feather="circle"></i><span class="menu-item text-truncate" data-i18n="Dettagli"><?php echo __("Details &<br> Settings");?></span></a>
                    </li>
                </ul>
            </li>

            <li><a url="/pages/faq" class="d-flex align-items-center" href="/pages/faq"><i data-feather="help-circle"></i><span class="menu-item text-truncate" data-i18n="FAQ">FAQ</span></a>
            </li>
        </ul>
    </div>
</div>
<!-- END: Main Menu-->

<!-- BEGIN: Content-->
<?=$content ?>
<!-- END: Content-->

<div class="sidenav-overlay"></div>
<div class="drag-target"></div>

<!-- BEGIN: Footer-->
<footer class="footer footer-static footer-light">
    <p class="clearfix mb-0"><span class="float-md-start d-block d-md-inline-block mt-25">NO COPYRIGHT - Just CC BY-NC-SA License <a class="ms-25" href="#">The Community</a><span class="d-none d-sm-inline-block">, Feel free to help</span></span><span class="float-md-end d-none d-md-block">Hand-crafted & Made with<i data-feather="heart"></i> just for You</span></p>
</footer>
<button class="btn btn-primary btn-icon scroll-top" type="button"><i data-feather="arrow-up"></i></button>
<!-- END: Footer-->


<!-- BEGIN: Vendor JS-->
<script src="/app-assets/vendors/js/vendors.min.js"></script>
<!-- BEGIN Vendor JS-->

<!-- BEGIN: Page Vendor JS-->
<script src="/app-assets/vendors/js/charts/apexcharts.min.js"></script>
<script src="/app-assets/vendors/js/extensions/toastr.min.js"></script>
<!-- END: Page Vendor JS-->

<!-- BEGIN: Theme JS-->
<script src="/app-assets/js/core/app-menu.js"></script>
<script src="/app-assets/js/core/app.js"></script>
<!-- END: Theme JS-->

<?= $this->fetch('layout/js.php', ['assets' => $js ?? []]);?>

<script>
    $(window).on('load', function() {
        if (feather) {
            feather.replace({
                width: 14,
                height: 14
            });
        }
    })
</script>
</body>
<!-- END: Body-->

</html>
