<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Responsive Admin Dashboard Template">
    <meta name="keywords" content="admin,dashboard">
    <meta name="author" content="stacks">
    <!-- The above 6 meta tags *must* come first in the head; any other head content must come *after* these tags -->

    <!-- Title -->
    <title>Peminjaman Ruangan Laboratorium Komputer Sekolah Vokasi IPB University</title>

    <!-- Styles -->
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,500,700,800&display=swap" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/all.min.css" rel="stylesheet">
    <link href="css/perfect-scrollbar.css" rel="stylesheet">


    <!-- Theme Styles -->
    <link href="css/main.min.css" rel="stylesheet">
    <link href="css/custom.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
</head>

<body class="login-page">
    <div class='loader'>
        <div class='spinner-grow text-primary' role='status'>
            <span class='sr-only'>Loading...</span>
        </div>
    </div>
    <div class="container">
        <div class="row justify-content-md-center">
            <div class="col-md-12 col-lg-4">
                <div class="card login-box-container">
                    <div class="card-body">
                        <div class="authent-logo">
                            <img src="img/logo.png" height="40" width="40" alt="">
                        </div>
                        <div class="authent-text">
                            <p>Selamat Datang</p>
                            <p>Masukkan detail Anda untuk membuat akun Anda.</p>
                        </div>

                        <form action="{{ url('/register') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="text" class="form-control @error('name') is-invalid @enderror"
                                        name="name" required placeholder="Fullname" value="{{ old('name') }}">
                                    <label for="floatingInput">Nama Panjang</label>
                                </div>
                                @error('name')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                        name="email" required placeholder="name@example.com"
                                        value="{{ old('email') }}">
                                    <label for="floatingInput">Alamat Email</label>
                                </div>
                                @error('email')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- Input Password -->
                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password" name="password" required
                                        placeholder="Password">
                                    <label for="password">Kata Sandi</label>
                                    <small id="passwordHelp" class="text-danger d-none">Minimal 8 karakter, mengandung
                                        huruf besar, huruf kecil, dan angka.</small>
                                    <small id="passwordSuccess" class="text-success d-none">✅ Password sudah
                                        sesuai!</small>
                                </div>
                            </div>

                            <div class="mb-3">
                                <div class="form-floating">
                                    <input type="password" class="form-control" id="password_confirmation"
                                        name="password_confirmation" required placeholder="Confirm Password">
                                    <label for="password_confirmation">Ulang Kata Sandi</label>
                                </div>
                            </div>

                            <!-- Checkbox untuk menampilkan password -->
                            <div class="mb-3 d-flex align-items-center">
                                <input class="form-check-input me-2" type="checkbox" id="showPassword">
                                <label class="form-check-label" for="showPassword">
                                    Tampilkan Password
                                </label>
                            </div>



                            <div class="d-grid">
                                <button type="submit" class="btn btn-primary m-b-xs">Daftar</button>
                            </div>
                        </form>

                        <script>
                            document.addEventListener("DOMContentLoaded", function() {
                                const form = document.querySelector("form");
                                const emailInput = document.querySelector('input[name="email"]');

                                form.addEventListener("submit", function(event) {
                                    const email = emailInput.value;

                                    // Validasi email harus menggunakan domain @apps.ipb.ac.id
                                    if (!email.endsWith("@apps.ipb.ac.id")) {
                                        event.preventDefault();
                                        alert("Email harus menggunakan domain @apps.ipb.ac.id.");
                                    }
                                });
                            });
                        </script>
                        <div class="authent-login">
                            <p>Sudah Memiliki Akun? <a href="{{ url('/login') }}">Masuk</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Javascripts -->
    <script src="js/jquery-3.4.1.min.js"></script>
    <script src="https://unpkg.com/@popperjs/core@2"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="js/perfect-scrollbar.min.js"></script>
    <script src="js/main.min.js"></script>
</body>

</html>
