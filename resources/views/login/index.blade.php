<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        @include('layouts.home-head')
        
        <title>Login - HD Collection</title>
    </head>

    <body class="hold-transition login-page">
        <div class="login-box">
            <div class="card card-outline card-primary">
                <div class="card-header text-center">
                    <a href="#" class="h1"><b>HD</b> - Collection</a>
                </div>

                <div class="card-body">
                    <p class="login-box-msg">Sign in to start your session</p>

                    @error('failed')
                        <div class="alert alert-danger alert-dismissible fade show errorAlert" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>

                            <p>{{ $message }}</p>
                        </div>
                    @enderror

                    <form method="post" action="{{ route('login.signin') }}">
                        @csrf
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" name="username" placeholder="Username or Email" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-user"></span>
                                </div>
                            </div>
                        </div>

                        <div class="input-group mb-3">
                            <input type="password" class="form-control" name="password" placeholder="Password" required>
                            <div class="input-group-append">
                                <div class="input-group-text">
                                    <span class="fas fa-lock"></span>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end">
                            <button type="submit" class="btn btn-sm btn-primary">Sign in</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @include('layouts.home-script')
        <script type="text/javascript" src="{{ asset('assets/js/global.js?nocache='.time()) }}"></script>
    </body>
</html>