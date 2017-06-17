<?php include '../Cores/template/header.php' ?>

<?php
    $db = Settings::database();
?>


<div id="page-container" class="sidebar-l side-scroll header-navbar-fixed">
    <!-- Header -->
    <header id="header-navbar">
        <div class="content-mini content-mini-full content-boxed">
            <!-- Header Navigation Right -->
            <ul class="nav-header pull-right">
                <li><a class="h5" href="?logout">
                        <button class="btn btn-default" type="button">Logout</button>
                    </a>
                </li>
            </ul>
            <!-- END Header Navigation Right -->

            <!-- Header Navigation Left -->
            <ul class="nav-header pull-left">
                <li class="header-content">
                    <a class="h4" href="main.php">
                        Thailand Grand Sale Panel
                    </a>
                </li>
            </ul>
            <!-- END Header Navigation Left -->
        </div>
    </header>
    <!-- END Header -->

    <!-- Main Container -->
    <main id="main-container">
        <!-- Sub Header -->
        <div class="bg-gray-lighter visible-xs">
            <div class="content-mini content-boxed">
                <button class="btn btn-block btn-default visible-xs push" data-toggle="collapse" data-target="#sub-header-nav">
                    <i class="fa fa-navicon push-5-r"></i>Menu
                </button>
            </div>
        </div>
        <div class="bg-primary-lighter collapse navbar-collapse remove-padding" id="sub-header-nav">
            <div class="content-mini content-boxed">
                <ul class="nav nav-pills nav-sub-header push">
                <li>
                        <a href="main.php">
                            <i class="fa fa-gift push-5-r" style="font-size: 1.33em;"></i>Gift List
                        </a>
                    </li>
                    <li>
                        <a href="history-redeem.php">
                            <i class="fa fa-gift push-5-r" style="font-size: 1.33em;"></i>Redeem Gift
                        </a>
                    </li>
                    <li>
                        <a href="welcomepack-list.php">
                            <i class="fa fa-users push-5-r"></i>WelcomePack List
                        </a>
                    </li>
                    <li>
                        <a href="history-welcomepack.php">
                            <i class="fa fa-users push-5-r"></i>WelcomePack
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <!-- END Sub Header -->
