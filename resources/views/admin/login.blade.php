<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Biolink System</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="hold-transition login-page" style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);">
    <div class="login-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <h1 class="h3"><b>Biolink</b> Admin</h1>
            </div>
            <div class="card-body">
                <p class="login-box-msg">Sign in to start your session</p>
                
                @if($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    {{ $errors->first() }}
                </div>
                @endif
                
                <form action="{{ route('admin.login') }}" method="POST">
                    @csrf
                    <div class="input-group mb-3">
                        <input type="email" name="email" class="form-control" placeholder="Email" required autofocus>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" name="password" class="form-control" placeholder="Password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary btn-block">
                                <i class="fas fa-sign-in-alt mr-2"></i> Sign In
                            </button>
                        </div>
                    </div>
                </form>
                
                <hr>
                <div class="alert alert-info mt-3">
                    <strong><i class="fas fa-info-circle"></i> Test Credentials:</strong><br>
                    <small>
                        <strong>Email:</strong> admin@biolink.com<br>
                        <strong>Password:</strong> admin123<br><br>
                        <strong>Email:</strong> manager@biolink.com<br>
                        <strong>Password:</strong> manager123<br><br>
                        <strong>Email:</strong> staff@biolink.com<br>
                        <strong>Password:</strong> staff123
                    </small>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
</body>
</html>
