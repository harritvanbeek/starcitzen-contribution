<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="fragment" content="!">
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <!-- <base href="/"> -->
    <title>BOANN | Admin</title>    
    <link rel="shortcut icon" type="image/x-icon" href="../favicon.ico">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">
    <link href="<?php echo ADMIN_THEMES; ?>/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo ADMIN_THEMES; ?>/css/mdb.min.css" rel="stylesheet">
    <link href="<?php echo ADMIN_THEMES; ?>/css/boann.min.css?v=<?php echo $_SERVER["REQUEST_TIME"]; ?>" rel="stylesheet">
    <link href="<?php echo ADMIN_THEMES; ?>/js/jquery-ui-1.12.1/jquery-ui.css" rel="stylesheet">
    <style type="text/css">/* Chart.js */
@-webkit-keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}@keyframes chartjs-render-animation{from{opacity:0.99}to{opacity:1}}.chartjs-render-monitor{-webkit-animation:chartjs-render-animation 0.001s;animation:chartjs-render-animation 0.001s;}</style>
</head>
<body ng-app="BoannApp">
    <div class="application">
        
        <div ui-view="navbar"></div>        
        <div class="background_container">
            <div class="fullpage_container">
                <div class="background_assets"></div>
            </div>
        </div>
        <div class="scroll-container dark-scrollbar">
            <div class="fullpage_container">
                <div class="sidebarcontainer_sidebarcontainer">
                    <div ui-view="sidebar"></div>
                </div>

                <div class="Page-page Scroller-scroller Scroller-none">