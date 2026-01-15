<!DOCTYPE html>
<html>
<head>
    <title>Password Baru</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="card">
        <div class="card-header">Buat Password Baru</div>
        <div class="card-body">
  
            <form action="{{ route('reset.password.post') }}" method="POST">
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">
  
                <div class="form-group mb-3">
                    <label>Email</label>
                    <input type="text" name="email" class="form-control" required autofocus>
                    @if ($errors->has('email'))
                        <span class="text-danger">{{ $errors->first('email') }}</span>
                    @endif
                </div>
  
                <div class="form-group mb-3">
                    <label>Password Baru</label>
                    <input type="password" name="password" class="form-control" required>
                    @if ($errors->has('password'))
                        <span class="text-danger">{{ $errors->first('password') }}</span>
                    @endif
                </div>
  
                <div class="form-group mb-3">
                    <label>Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                </div>
  
                <button type="submit" class="btn btn-primary">Ubah Password</button>
            </form>
            
        </div>
    </div>
</div>
</body>
</html>