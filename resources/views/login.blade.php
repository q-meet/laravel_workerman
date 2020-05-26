<!DOCTYPE html>
<html lang="zxx">

<head>
    <title>Merged Forms Page Responsive Widget Template :: xmoban.cn</title>
    <!-- Meta tag Keywords -->
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="UTF-8"/>
    <meta name="keywords" content=""/>
    <script src="https://cdn.staticfile.org/jquery/3.2.1/jquery.min.js"></script>
    <!-- //Meta tag Keywords -->
    <link rel="stylesheet" href="css/login.css" type="text/css" media="all"/><!-- Style-CSS -->
</head>
<body>
<!-- /form-26-section -->
<section class="form-26">
    <div class="form-26-mian">
        <div class="layer">
            <div class="wrapper">
                <div class="form-inner-cont">
                    <div class="forms-26-info">
                        <h2>Login</h2>
                        <p>Etiam sit amet iaculis nunc, et feugiat enim. Aenean lorem dui, mattis et neque ac, viverra
                            dignissim elit. Nunc quis finibus lorem.</p>
                    </div>
                    <div class="form-right-inf">
                        <form class="signin-form" id="fm">
                            <div class="forms-gds">
                                <div class="form-input">
                                    <input type="text" id="name" name="name" placeholder="account" required/>
                                </div>
                                <div class="form-input">
                                    <input type="password" id="pwd" name="pwd" placeholder="Password" required/>
                                </div>
                            </div>
                            <div class="form-input">
                                <button class="btn">Login</button>
                            </div>
                            <p class="hint" style="color: #d22a2a";></p>
                            <h6 class="already"> Dont have an account? <a
                                        href="/register"><span>Register Here<span></span></span></a></h6>
                        </form>

                    </div>
                    <div class="copyright text-center">
                        <p>© 2019 Merged Forms. All rights reserved | Design by <a href="http://xmoban.cn/"
                                                                                   target="_blank">xmoban.cn</a></p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
<script>
    $('#fm').submit(function () {
        data = {name: $('#name').val(), pwd: $('#pwd').val()};
        $.ajax({
            url: '',
            data: data,
            type: 'POST',
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function (res) {
                if (res.status == 1) {
                    location.href = '/index';
                }
                $('.hint').html(res.msg);
            },
            error: function (res) {
            }
        });
        return false;
    });
</script>
<!-- //form-26-section -->
</body>
</html>