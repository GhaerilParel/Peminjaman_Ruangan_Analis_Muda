<header>
    <div class="container-fluid">
        <div class="row d-flex align-items-center">
            <div class="col-4">
                <a data-bs-toggle="offcanvas" href="#offcanvasNav" role="button" class="btn_nav"><i
                        class="bi bi-list"></i></a>
            </div>
            <div class="col-4 text-center">
                <a href="{{ route('index') }}"><img src="{{ asset('img/Emblem-Utama-1.png') }}" alt=""
                        class="img-fluid" width="115" height="50"></a>
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
                <li><a href="#" class="animated_link">Hi,
                        {{ implode(' ', array_slice(explode(' ', Auth::user()->name ?? ''), 0, 2)) }}!</a></li>
            @else
                <li><a href="{{ route('login') }}" class="animated_link">Masuk/Daftar</a></li>
            @endauth
        </ul>
        <hr>
        <ul>
            <li><a href="{{ route('index') }}" class="animated_link">Beranda</a></li>
            <li><a href="https://drive.google.com/file/d/1Lc3HoaGEHCx_huejyJ2EM1ybRG6v0eai/view?usp=sharing" class="animated_link">Template Surat</a></li>
            <li><a href="{{ route('status.peminjaman') }}" class="animated_link">Status Peminjaman</a></li>
        </ul>
        <hr>
        <ul>
            <li><a href="{{ route('about') }}" class="animated_link">About</a></li>
            <li><a href="{{ route('contact') }}" class="animated_link">Contacts</a></li>
        </ul>
        <hr>
        @auth
            <ul>
                <li class="logout-container">
                    <form action="{{ route('logout') }}" method="POST" id="logout-form">
                        @csrf
                        <button type="submit" class="logout-button btn btn-danger">
                            Logout
                        </button>
                    </form>
                </li>
            </ul>
        @endauth
    </div>
</div>
<!-- /offcanvas nav -->
