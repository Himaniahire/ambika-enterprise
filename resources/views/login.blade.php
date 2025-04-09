<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Ambika - Login Admin</title>
    <link href="admin_assets/css/styles.css" rel="stylesheet" />
    <link rel="icon" type="image/x-icon" href="assets/images/logo.png" />
    <script data-search-pseudo-elements="" defer=""
        src="admin_assets/cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/js/all.min.js" crossorigin="anonymous"></script>
    <script src="admin_assets/cdnjs.cloudflare.com/ajax/libs/feather-icons/4.29.0/feather.min.js" crossorigin="anonymous">
    </script>
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <img src="{{asset('logo.png')}}" alt="" style="width: 6%;margin: auto;margin-bottom: 0;margin-top: 0;">
            <main>

                <div class="container-xl px-4">
                    <div class="row justify-content-center">
                        <div class="col-xl-5 col-lg-6 col-md-8 col-sm-11">
                            <!-- Social login form-->
                            <div class="card my-5">
                                <div class="card-body p-5 text-center">
                                    <div class="h3 fw-light">Sign In</div>
                                </div>
                                <hr class="my-0" />
                                <div class="card-body p-5">
                                    <!-- Login form-->
                                    <form method="POST" action="{{ route('post-login') }}">
                                        @csrf
                                        <!-- Form Group (email address)-->
                                        <div class="mb-3">
                                            <label class="text-gray-600 small" for="emailExample">Username or Email</label>
                                            <input class="form-control form-control-solid" type="text" name="username"
                                                placeholder="Enter Your Username Or Email" aria-label="Email Address"
                                                aria-describedby="emailExample" />
                                        </div>
                                        <!-- Form Group (password)-->
                                        <div class="mb-3">
                                            <label class="text-gray-600 small" for="passwordExample">Password</label>
                                            <input class="form-control form-control-solid" type="password"
                                                name="password" placeholder="......." aria-label="Password"
                                                aria-describedby="passwordExample" />
                                        </div>
                                        <!-- Form Group (login box)-->
                                        <div class="d-flex align-items-center justify-content-between mb-0">
                                            <div class="form-check">
                                                <input class="form-check-input" id="checkRememberPassword"
                                                    type="checkbox" value="" />
                                                <label class="form-check-label" for="checkRememberPassword">Remember
                                                    password</label>
                                            </div>
                                            <button class="btn" style="background-color: #eda3a5; color:white; " type="submit">Login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
        <div id="layoutAuthentication_footer">
            <footer class="footer-admin mt-auto footer-dark">
                <div class="container-xl px-4">
                    <div class="row">
                        <div class="col-md-6 small">&copy; Copyright <span class="dynamic-year"></span> Ambika
                    All Rights Reserved. Designed and Devloped by <a href="https://techomaxsolution.com/" target="_blank" style="color:white;">Techomax Solution.</a>
                </div>
                        <div class="col-md-6 text-md-end small">
                        </div>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="admin_assets/cdn.jsdelivr.net/npm/bootstrap%405.2.3/dist/js/bootstrap.bundle.min.js"
        crossorigin="anonymous"></script>
    <script src="admin_assets/js/scripts.js"></script>

    <script src="admin_assets/assets.startbootstrap.com/js/sb-customizer.js"></script>
    <script>
        (function() {
            var js =
                "window['__CF$cv$params']={r:'83fa9d64c9220336',t:'MTcwNDI3ODMzNC41NDIwMDA='};_cpo=document.createElement('script');_cpo.nonce='',_cpo.src='cdn-cgi/challenge-platform/h/g/scripts/jsd/74bd6362/main.js',document.getElementsByTagName('head')[0].appendChild(_cpo);";
            var _0xh = document.createElement('iframe');
            _0xh.height = 1;
            _0xh.width = 1;
            _0xh.style.position = 'absolute';
            _0xh.style.top = 0;
            _0xh.style.left = 0;
            _0xh.style.border = 'none';
            _0xh.style.visibility = 'hidden';
            document.body.appendChild(_0xh);

            function handler() {
                var _0xi = _0xh.contentDocument || _0xh.contentWindow.document;
                if (_0xi) {
                    var _0xj = _0xi.createElement('script');
                    _0xj.innerHTML = js;
                    _0xi.getElementsByTagName('head')[0].appendChild(_0xj);
                }
            }
            if (document.readyState !== 'loading') {
                handler();
            } else if (window.addEventListener) {
                document.addEventListener('DOMContentLoaded', handler);
            } else {
                var prev = document.onreadystatechange || function() {};
                document.onreadystatechange = function(e) {
                    prev(e);
                    if (document.readyState !== 'loading') {
                        document.onreadystatechange = prev;
                        handler();
                    }
                };
            }
        })();
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/v84a3a4012de94ce1a686ba8c167c359c1696973893317"
        integrity="sha512-euoFGowhlaLqXsPWQ48qSkBSCFs3DPRyiwVu3FjR96cMPx+Fr+gpWRhIafcHwqwCqWS42RZhIudOvEI+Ckf6MA=="
        data-cf-beacon='{"rayId":"83fa9d64c9220336","b":1,"version":"2023.10.0","token":"6e2c2575ac8f44ed824cef7899ba8463"}'
        crossorigin="anonymous"></script>
</body>


</html>
