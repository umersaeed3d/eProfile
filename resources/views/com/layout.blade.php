<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="/public_assets/assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="/public_assets/assets/img/favicon-32x32.png" sizes="32x32">

    <title>E-Profile</title>


    <link rel="stylesheet" href="/public_assets/bower_components/uikit/css/uikit.almost-flat.min.css" media="all">
    <link rel="stylesheet" href="/public_assets/assets/icons/flags/flags.min.css" media="all">
    <link rel="stylesheet" href="/public_assets/assets/css/style_switcher.min.css" media="all">
    <link rel="stylesheet" href="/public_assets/assets/css/main.min.css" media="all">
    <link rel="stylesheet" href="/public_assets/assets/css/themes/themes_combined.min.css" media="all">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <!--[if lte IE 9]>
    <script type="text/javascript" src="/public_assets/bower_components/matchMedia/matchMedia.js"></script>
    <script type="text/javascript" src="/public_assets/bower_components/matchMedia/matchMedia.addListener.js"></script>
    <link rel="stylesheet" href="/public_assets/assets/css/ie.css" media="all">
    <![endif]-->
    <!-- common functions -->
    <script src="/public_assets/assets/js/jquery.min.js"></script>

</head>
<body class="header_full sidebar_main_active " style="font-size: 15px;">
<!-- main header -->
@include('com.header')
<!-- main header end -->
<!-- main sidebar -->
@if(!Request::is('home'))
@include('com.sidebar')
@endif
<!-- main sidebar end -->

<div id="page_content">
    <div id="page_content_inner">

        @yield('body')

    </div>
</div>
<!-- google web fonts -->
<div id="modal-example" uk-modal>
    <div class="uk-modal-dialog uk-modal-body">
        <h2 class="uk-modal-title">Headline</h2>
        <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.</p>
        <p class="uk-text-right">
            <button class="uk-button uk-button-default uk-modal-close" type="button">Cancel</button>
            <button class="uk-button uk-button-primary" type="button">Save</button>
        </p>
    </div>
</div>

<!-- common functions -->
<script src="/public_assets/assets/js/common.min.js"></script>
<!-- uikit functions -->
<script src="/public_assets/assets/js/uikit_custom.min.js"></script>
<!-- altair common functions/helpers -->
<script src="/public_assets/assets/js/altair_admin_common.min.js"></script>

@yield('scripts')


</body>

<!-- Mirrored from altair_html.tzdthemes.com/page_blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Tue, 19 Jun 2018 09:13:40 GMT -->
</html>