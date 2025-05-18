<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Limmo - Register, Reservation, Questionare, Reviews, Quotation form Multipurpose Wizard with SMTP and HTML email support">
    <meta name="author" content="Ansonika">
    <title>Peminjaman Ruangan Laboratorium Komputer Sekolah Vokasi IPB University</title>

     <!-- Favicons-->
     <link rel="shortcut icon" href="img/apple-touch-icon-114x114-precomposed.png" type="image/x-icon">
     <link rel="apple-touch-icon" type="image/x-icon" href="img/apple-touch-icon-57x57-precomposed.png">
     <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72" href="img/apple-touch-icon-72x72-precomposed.png">
     <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
         href="img/apple-touch-icon-114x114-precomposed.png">
     <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
         href="img/apple-touch-icon-144x144-precomposed.png">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/vendors.css" rel="stylesheet">
    
    <!-- YOUR CUSTOM CSS -->
    <link href="css/custom.css" rel="stylesheet">
</head>

<body>
    <div id="preloader">
        <img src="img/logo.png" height="40" width="40" alt="Loading...">
    </div><!-- /Preload -->
    <div id="loader_form">
        <img src="img/logo.png" height="40" width="40" alt="Loading...">
    </div><!-- /loader_form -->
    
    <header>
        <div class="container-fluid">
            <div class="row d-flex align-items-center">
                <div class="col-4">
                    <a data-bs-toggle="offcanvas" href="#offcanvasNav" role="button" class="btn_nav"><i class="bi bi-list"></i></a>
                </div>
                <div class="col-4 text-center">
                    <a href="index.html"><img src="img/Emblem-Utama-1.png" alt="" class="img-fluid" width="95" height="30"></a>
                </div>
                <div class="col-4">
                    <div id="social">
                        <ul>
                            <li><a href="#0"><i class="bi bi-facebook"></i></a></li>
                            <li><a href="#0"><i class="bi bi-twitter-x"></i></a></li>
                            <li><a href="#0"><i class="bi bi-instagram"></i></a></li>
                        </ul>
                    </div>
                    <!-- /social -->
                </div>
            </div>
        </div>
        <!-- /container -->
    </header>
    <!-- /header -->

    <div class="offcanvas offcanvas-start" tabindex="-1" id="offcanvasNav">
	    <div class="offcanvas-header">
	        <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
	    </div>
	    <div class="offcanvas-body">
            <ul>
            @auth
    <li><a href="#" class="animated_link">Hi, {{ implode(' ', array_slice(explode(' ', Auth::user()->name), 0, 2)) }}!</a></li>
@else
    <li><a href="{{ url('/login') }}" class="animated_link">Masuk/Daftar</a></li>
@endauth
            </ul>
            <hr>
	        <ul>
            <li><a href="{{ url('/index') }}" class="animated_link">Beranda</a></li>
                    <li><a href="https://drive.google.com/file/d/1Lc3HoaGEHCx_huejyJ2EM1ybRG6v0eai/view?usp=sharing" class="animated_link ">Template Surat</a></li>
                    <li><a href="{{ route('status.peminjaman') }}" class="animated_link ">Status Peminjaman</a></li>
                </ul>
                <hr>
                <ul>
                <li><a href="{{ url('/about') }}" class="animated_link">Ruangan</a></li>
                <li><a href="{{ url('/contact') }}" class="animated_link">Contacts</a></li>
	        </ul>
            <hr>
            <hr>
            <ul>
            @auth
    <!-- Tombol Logout -->
    <li class="logout-container">
        <form action="{{ url('/logout') }}" method="POST">
            @csrf
            <button type="submit" class="logout-button">
                Logout
            </button>
        </form>
    </li>
    @endauth
</ul>
            </ul>
	    </div>
	</div>
	<!-- /offcanvas nav -->

    <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1986.9624859730822!2d106.8068977!3d-6.5903877!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69c5d2e602b501%3A0x25a12f0f97fac4ee!2sSchool%20of%20Vocational%20Studies%20-%20IPB%20University!5e0!3m2!1sen!2sid!4v1700000000000" width="600" height="450" allowfullscreen id="map_iframe"></iframe>
	<!-- end map-->

    <main>

	        <div class="container margin_60_35">
	            <div class="row justify-content-center">
	                <div class="col-lg-4">

	                	<div class="box_style_2">
						<h4 class="mb-2">Contacts info</h4>
						<p>
							School of Vocational Studies - IPB University, Bogor, ID 16128
						</p>
						<h5>Get directions</h5>
						<form action="http://maps.google.com/maps" method="get" target="_blank">
							<div class="mb-3 form-floating">
								<input type="text" name="saddr" id="saddr" placeholder="Enter your location" class="form-control">
								<input type="hidden" name="daddr" value="Bogor, ID 16128"><!-- Write here your end point -->
								<label for="saddr">Enter your location</label>
							</div>
							<input type="submit" value="Get directions" class="btn_1">
						</form>
		
					</div>
	                    
	                </div>
	                <div class="col-lg-4">

	                	<div class="box_style_2">
					
						<h4>Campus Information Center</h4>
						<ul class="contacts_info">
							<li><h6>Administration</h6>
								<a href="tel://003823932342">0038 23932342</a>
								<br><a href="tel://003823932342">admin@apps.ipb.ac.id</a>
								<br>
								<small>Monday to Friday 9am - 7pm</small>
							</li>
							<li><h6>General questions</h6>
								<a href="tel://003823932342">0038 23932342</a>
								<br><a href="tel://003823932342">questions@apps.ipb.ac.id</a>
								<br>
								<small>Monday to Friday 9am - 7pm</small>
							</li>
						</ul>
					</div>
	                    
	                    
	                </div>
	            </div>
	            <!-- End row -->
	        </div>
	</main>

    <footer>
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-sm-6">
                    <p>© 2025 Sekolah Vokasi IPB University</a></p>
                </div>
                <div class="col-sm-6 text-md-end">
                    <a class="btn_help btn" href="#modal-help" id="modal_h"><i class="bi bi-question-circle"> Help</i></a>
                </div>
            </div>
            <!-- /Row -->
        </div>
        <!-- /Container -->
    </footer>
    <!-- /Footer -->

    <!-- Help form Popup -->
    <div id="modal-help" class="custom-modal zoom-anim-dialog mfp-hide">
        <div class="small-dialog-header">
            <h3>Ask Us Anything</h3>
            <p class="mb-3">Please fill the form with your questions and<br>we will reply soon!</p>
        </div>
        <div id="message-help"></div>
        <form method="post" action="assets/help.php" id="helpform" autocomplete="off">
            <div class="modal-wrapper">
                <div class="mb-3 form-floating">
                    <input type="text" name="fullname" id="fullname" class="form-control" placeholder="Full Name">
                    <label for="fullname">Full Name</label>
                </div>
                <div class="mb-3 form-floating">
                    <input type="email" name="email_help" id="email_help" class="form-control" placeholder="Email Address">
                    <label for="email_help">Email Address</label>
                </div>
                <div class="mb-3 form-floating">
                    <textarea name="message_help" id="message_help" class="form-control" placeholder="Your Message"></textarea>
                    <label for="message_help">Your Message</label>
                </div>
                <div class="mb-5 form-floating">
                    <input class="form-control" type="text" name="verify_help" id="verify_help" placeholder="Are you human? 3 + 1 =">
                    <label for="verify_help">Are you human? 3 + 1 =</label>
                </div>
                <div class="text-center submit"><input type="submit" value="Submit" class="btn_1" id="submit-help"></div>
            </div>
        </form>
    </div>
    <!-- /Help form Popup -->
    <!-- COMMON SCRIPTS -->
    <script src="js/common_scripts.min.js"></script>
    <script src="js/common_functions.js"></script>
    <script src="assets/validate.js"></script>

</body>

</html>