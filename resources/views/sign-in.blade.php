<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
        <title>Sign in</title>
    </head>
        <body>
            <div class="container">
            <br><br>
            <div class="card shadow">
                <form action="{{ route('loginform') }}" method="POST" class="row g-3 needs-validation">
                    @csrf
                    <div class="card-body">
                        <h2 style="text-align: center;" class="card-tittle m-3">Log - In</h2>
                        <br>
                        <div class="m-2">
                            <input type="email" class="form-control border-primary" id="email" name="email" placeholder="Email kamu.....">
                            <br>
                            <input type="password" class="form-control border-primary" id="password" name="password" placeholder="Password kamu.....">
                            <br>
                            <input class="form-check-input border-primary" type="checkbox" id="showPassword" />
                            <label for="showPassword" >Show password</label>
                            <script>
                                document.getElementById('showPassword').onclick = function(){
                                    if ( this.checked ) {
                                        document.getElementById('password').type = "text";
                                    }else{
                                        document.getElementById('password').type = "password";
                                    }
                                }
                            </script>
                        </div>
                        <br>
                        <div class="d-md-flex justify-content-md-between">
                            <a class="btn btn-link fw-bold" href="{{ route('daftar') }}" role="button" style="text-decoration: none;" >Buat akun?</a>
                            <button class="btn btn-primary me-md-2 shadow-sm" onsubmit="alert('Mohon Tunggu Sebentar')" style="text-decoration: none;">Log - in</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </body>
</html>