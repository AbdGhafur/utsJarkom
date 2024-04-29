<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <title>Sign up</title>
    </head>
    <body>
        <div class="container">
            <br><br>
            <div class="card shadow">
                <form action="{{ route('user.store') }}" class="row g-3" method="POST">
                    @csrf
                    <div class="card-body">
                        <h2 style="text-align: center;" class="card-tittle m-3">Sign Up</h2>
                        <br>
                        <div class="m-2">
                            <input type="text" class="form-control @error('name') is-invalid @enderror border-primary" id="name" name="name" placeholder="nama kamu....." >
                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <br>
                            <input type="email" class="form-control @error('email') is-invalid @enderror border-primary" id="email" name="email" placeholder="email kamu....." >
                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <br>
                            <select class="form-select" name="role" id="role">
                                <option value="admin">Admin</option>
                                <option value="pimpinan">Pimpinan</option>
                            </select>
                            <br>
                            <input type="password" class="form-control @error('password') is-invalid @enderror border-primary" id="password" name="password" placeholder="Password kamu.....">
                            @error('password')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <br>
                            <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror border-primary" id="password_confirmation" name="password_confirmation" placeholder="Tulis ulang password kamu.....">
                            @error('password_confirmation')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            <br>
                            <input class="form-check-input  border-primary" type="checkbox" id="showPassword" />
                            <label for="password">Show password</label>
                            <script>
                                document.getElementById('showPassword').onclick = function(){
                                    if ( this.checked ) {
                                        document.getElementById('password').type = "text";
                                        document.getElementById('password_confirmation').type = "text";
                                    }else{
                                        document.getElementById('password').type = "password";
                                        document.getElementById('password_confirmation').type = "password";
                                    }
                                }
                            </script>
                        </div>
                        <br>
                        <div class="d-flex justify-content-between">
                            <a class="btn btn-link fw-bold" href="{{ route('login') }}" role="button" style="text-decoration: none;" id="alreadyHaveAccount">Sudah punya akun?</a>
                            <script>
                            document.getElementById('alreadyHaveAccount').addEventListener('click', function() {
                                alert('Daftarkan diri anda jika belum punya akun');
                            });
                            </script>
                            <button class="btn btn-primary me-md-2 shadow-sm" onclick="alert('Selamat! Akun anda sudah terdaftar')" style="text-decoration: none;">Sign up</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
    <br><br>
    <footer>
        <div class="footer fw-bold">
            &copy; Copyright
        </div>
        <style>
            .footer{
                position:relative;
                bottom:0;
                width:100%;
                height:60px;
                text-align: center;
            }
        </style>
    </footer>
</html>