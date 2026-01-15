<!DOCTYPE html>
<html>
<head>
    <title>Lupa Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">Reset Password</div>
        <div class="card-body">
            
            @if (Session::has('message'))
                <div class="alert alert-success" role="alert">
                    {{ Session::get('message') }}
                </div>
            @endif

            <form action="{{ route('forget.password.post') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label>Alamat Email</label>
                    <input type="text" name="email" class="form-control" required autofocus>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
                <button type="submit" class="btn btn-primary">Kirim Link Reset Password</button>
            </form>
            
        </div>
    </div>
</div>
</body>
</html>