<!doctype html>
<!--[if lte IE 9]> <html class="lte-ie9" lang="en"> <![endif]-->
<!--[if gt IE 9]><!--> <html lang="en"> <!--<![endif]-->

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="initial-scale=1.0,maximum-scale=1.0,user-scalable=no">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Remove Tap Highlight on Windows Phone IE -->
    <meta name="msapplication-tap-highlight" content="no"/>

    <link rel="icon" type="image/png" href="assets/img/favicon-16x16.png" sizes="16x16">
    <link rel="icon" type="image/png" href="assets/img/favicon-32x32.png" sizes="32x32">

    <title>Login Page</title>

    <link href='http://fonts.googleapis.com/css?family=Roboto:300,400,500' rel='stylesheet' type='text/css'>

    <!-- uikit -->
    <link rel="stylesheet" href="bower_components/uikit/css/uikit.almost-flat.min.css"/>

    <!-- altair admin login page -->
    <link rel="stylesheet" href="assets/css/login_page.min.css" />

</head>
<body class="login_page" style="background-image: url('assets/img/bg.jpg');background-position:center;background-repeat: no-repeat;background-size: cover">

    <div class="login_page_wrapper">
        <div class="md-card" id="login_card" style="background: rgba(255,255,255,0.8);margin-top: 100px;">
            <div class="md-card-content large-padding" id="login_form">
                <div class="login_heading">
                    <div class="user_avatar"></div>
                </div>
                <form action="user.login" method="post">
                    {{csrf_field()}}

                    @if(session()->has('message'))
                        <div class="alert alert-success">
                            <div class="uk-alert uk-alert-success" data-uk-alert="">
                                <a href="#" class="uk-alert-close uk-close"></a>
                                {{ session()->get('message') }}
                            </div>
                        </div>
                    @endif

                        @if(session()->has('invalid'))
                            <div class="alert alert-success">
                                <div class="uk-alert uk-alert-success" data-uk-alert="">
                                    <a href="#" class="uk-alert-close uk-close"></a>
                                    {{ session()->get('invalid') }}
                                </div>
                            </div>
                        @endif





                    @if(count($errors) > 0)
                        @foreach ($errors->all() as $error)
                                <div class="alert alert-success">
                                    <div class="uk-alert uk-alert-success" data-uk-alert="">
                                        <a href="#" class="uk-alert-close uk-close"></a>
                                        {{ $error }}
                                    </div>
                                </div>
                        @endforeach
                    @endif
                    <div class="uk-form-row">
                        <label for="login_username">Username</label>
                        <input class="md-input" type="text" id="name" name="name" />
                    </div>
                    <div class="uk-form-row">
                        <label for="login_password">Password</label>
                        <input class="md-input" type="password" id="password" name="password" />
                    </div>
                    <div class="uk-margin-medium-top">
                        <button  type="submit" class="md-btn md-btn-primary md-btn-block md-btn-large">Log In</button>
                    </div>

                    <div class="uk-margin-top">
                        <span class="icheck-inline">
                            <input type="checkbox" name="login_page_stay_signed" id="login_page_stay_signed" data-md-icheck />
                            <label for="login_page_stay_signed" class="inline-label">Stay signed in</label>
                        </span>
                    </div>
                </form>
            </div>

        </div>

    </div>

    <!-- common functions -->
    <script src="assets/js/common.min.js"></script>
    <!-- uikit functions -->
    <script src="assets/js/uikit_custom.min.js"></script>
    <!-- altair core functions -->
    <script src="assets/js/altair_admin_common.min.js"></script>

    <!-- altair login page functions -->
    <script src="assets/js/pages/login.min.js"></script>

</body>

</html>