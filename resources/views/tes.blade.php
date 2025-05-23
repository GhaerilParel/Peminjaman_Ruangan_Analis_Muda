@extends('partials.app')

@section('title', 'status')

@section('content')

<div class="container-fluid d-flex flex-column my-auto">

    <div id="wizard_container">

        <div id="top-wizard">
            <div id="progressbar"></div>
        </div>
        <!-- /top-wizard -->

        <form action="{{ route('booking.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input id="website" name="website" type="text" value="">
            <!-- Leave input above for security protection, read docs for details -->

            <div id="middle-wizard">
                <div class="step">
                    <div class="question_title">
                        <h3>Pilih Tanggal Peminjaman!</h3>
                        <p>Silakan pilih tanggal untuk peminjaman ruangan kelas sesuai kebutuhan Anda.</p>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-10 mb-3">
                            <div class="form-floating">
                                <select class="form-select required" id="room_type_1" name="room_type"
                                    aria-label="Room type">
                                    <option value selected>Pilih Ruangan</option>
                                    <option value="1">CB Pemrograman</option>
                                    <option value="2">CB K70-1</option>
                                    <option value="3">CA RPL</option>
                                    <option value="4">CA KOM 1</option>
                                    <option value="5">CA KOM 2</option>
                                    <option value="6">CB KOM Jaringan</option>
                                    <option value="7">CB KOM 1</option>
                                    <option value="8">CB KOM 2</option>
                                    <option value="9">CB KOM 3</option>
                                    <option value="10">CB KOM 4</option>
                                    <option value="11">CB KOM 5</option>
                                </select>
                                <label for="room_type_1">Ruangan</label>
                            </div>
                        </div>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-12">
                            <div id="calendar-container" class="calendar-container">
                                <!-- input date -->
                                <input type="date" name="booking_date" class="required form-control"
                                    placeholder="MM/DD/YYYY" required>
                                <div class="calendar-header">
                                    <button id="prev-month" class="btn btn-primary">&lt;</button>
                                    <span id="current-month-year"></span>
                                    <button id="next-month" class="btn btn-primary">&gt;</button>
                                </div>
                                <div class="calendar-body">
                                    <div class="calendar-days">
                                        <div>Sun</div>
                                        <div>Mon</div>
                                        <div>Tue</div>
                                        <div>Wed</div>
                                        <div>Thu</div>
                                        <div>Fri</div>
                                        <div>Sat</div>
                                    </div>
                                    <div id="calendar-dates" class="calendar-dates"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                <!-- /Step -->

                <div class="step">
                    <div class="question_title">
                        <h3>Pilih Jenis Ruangan!</h3>
                        <p>Silakan pilih jenis ruangan yang sesuai dengan kebutuhan peminjaman Anda.</p>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-10 mb-3">
                            <div class="form-floating">
                                <select class="form-select required" id="room_type_2" name="room_type_locked"
                                    aria-label="Room type" disabled>
                                    <option value selected>Pilih Ruangan</option>
                                    <option value="1">CB Pemrograman</option>
                                    <option value="2">CB K70-1</option>
                                    <option value="3">CA RPL</option>
                                    <option value="4">CA KOM 1</option>
                                    <option value="5">CA KOM 2</option>
                                    <option value="6">CB KOM Jaringan</option>
                                    <option value="7">CB KOM 1</option>
                                    <option value="8">CB KOM 2</option>
                                    <option value="9">CB KOM 3</option>
                                    <option value="10">CB KOM 4</option>
                                    <option value="11">CB KOM 5</option>
                                </select>
                                <label for="room_type_2">Ruangan</label>
                            </div>

                        </div>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /Step -->

                <div class="step">
                    <div class="question_title">
                        <h3>Masukkan Jumlah Orang!</h3>
                        <p>Silakan tambahkan jumlah orang yang akan menggunakan ruangan.</p>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-sm-6">
                            <div class="mb-3 qty-buttons d-flex align-items-center">
                                <input type="button" value="+" class="qtyplus btn btn-primary"
                                    name="Jumlah Orang">
                                <input type="text" name="jumlah_orang" id="jumlah_orang" value="1"
                                    class="qty form-control required mx-2 flex-grow-1"
                                    placeholder="Jumlah Orang"
                                    style="width: 100%; text-align: left; padding-left: 10px;">
                                <input type="button" value="-" class="qtyminus btn btn-primary"
                                    name="Jumlah Orang">
                            </div>
                        </div>
                    </div>


                    <!-- /row -->
                    <!-- /row -->
                </div>
                <!-- /Step -->

                <div class="submit step">
                    <div class="question_title">
                        <h3>Isi Detail Anda!</h3>
                        <p>Silakan lengkapi informasi pribadi untuk melanjutkan peminjaman ruangan.</p>
                    </div>
                    <div class="row justify-content-center">
                        <div class="col-md-7">
                            <div class="mb-3 form-floating">
                                <input type="text" name="firstname" id="firstname"
                                    class="form-control required" placeholder="First Name">
                                <label for="firstname">Nama</label>
                            </div>
                            <div class="mb-3 form-floating">
                                <input type="text" name="nim" id="nim"
                                    class="form-control required" placeholder="NIM">
                                <label for="nim">NIM</label>
                            </div>
                            <div class="mb-3 form-floating">
                                <input type="text" name="jurusan" id="jurusan"
                                    class="form-control required" placeholder="Jurusan">
                                <label for="jurusan">Jurusan</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="email" name="email" id="email"
                                    class="form-control required" placeholder="E-Mail">
                                <label for="emial">E-mail</label>
                            </div>
                            <div class="form-floating mb-4">
                                <input type="text" name="telephone" id="telephone"
                                    class="form-control required" placeholder="Your Telephone">
                                <label for="telephone">No Telepon</label>
                            </div>
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="time" name="waktu_mulai" id="waktu_mulai"
                                            class="form-control required">
                                        <label for="waktu_mulai">Waktu Mulai</label>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-floating">
                                        <input type="time" name="waktu_selesai" id="waktu_selesai"
                                            class="form-control required">
                                        <label for="waktu_selesai">Waktu Selesai</label>
                                    </div>
                                </div>
                            </div>

                            <script>
                                document.querySelector("form[action='{{ route('booking.store') }}']").addEventListener("submit", function(event) {
                                    // Validasi waktu hanya untuk form peminjaman
                                });
                            </script>

                            <div class="mb-4 form-floating">
                                <textarea name="review" id="review" class="form-control required" placeholder="Your Review"></textarea>
                                <label for="review">Alasan Peminjaman</label>
                            </div>
                            <div class="form-floating mb-4 position-relative">
                                <input type="file" name="file" id="file-input" class="d-none"
                                    accept="application/pdf">
                                <input type="text" id="file-name" class="form-control"
                                    placeholder="Upload File" readonly
                                    style="pointer-events: none; background-color: #e9ecef;">
                                <label for="file-name">Surat Peminjaman</label>
                                <button
                                    class="btn btn-primary position-absolute end-0 top-50 translate-middle-y me-2"
                                    id="upload-btn">Choose File</button>
                            </div>

                            <script></script>

                            <div class="terms">
                                <label class="container_check">Please accept our <a href="#"
                                        data-bs-toggle="modal" data-bs-target="#terms-txt">Terms and
                                        conditions</a>
                                    <input type="checkbox" name="terms" value="Yes" class="required">
                                    <span class="checkmark"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                    <!-- /row -->
                </div>
                <!-- /Step -->

            </div>
            <!-- /middle-wizard -->

            <div id="bottom-wizard">
                <button type="button" name="backward" class="backward btn_1">Kembali</button>
                <button type="button" name="forward" class="forward btn_1 ciao"
                    id="next-button">Selanjutnya</button>
                <button type="submit" name="process" class="submit btn_1">Kirim</button>
            </div>
            <!-- /bottom-wizard -->

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if ($errors->has('file'))
                <div class="alert alert-danger">
                    {{ $errors->first('file') }}
                </div>
            @endif

        </form>
    </div>
    <!-- /Wizard container -->
</div>
<!-- /Container -->




<!-- /flex-column -->

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
                <input type="text" name="fullname" id="fullname" class="form-control"
                    placeholder="Full Name">
                <label for="fullname">Full Name</label>
            </div>
            <div class="mb-3 form-floating">
                <input type="email" name="email_help" id="email_help" class="form-control"
                    placeholder="Email Address">
                <label for="email_help">Email Address</label>
            </div>
            <div class="mb-3 form-floating">
                <textarea name="message_help" id="message_help" class="form-control" placeholder="Your Message"></textarea>
                <label for="message_help">Your Message</label>
            </div>
            <div class="mb-5 form-floating">
                <input class="form-control" type="text" name="verify_help" id="verify_help"
                    placeholder="Are you human? 3 + 1 =">
                <label for="verify_help">Are you human? 3 + 1 =</label>
            </div>
            <div class="text-center submit"><input type="submit" value="Submit" class="btn_1"
                    id="submit-help"></div>
        </div>
    </form>
</div>
<!-- /Help form Popup -->

<!-- Modal terms -->
<div class="modal fade" id="terms-txt" tabindex="-1" role="dialog" aria-labelledby="termsLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="termsLabel">Syarat dan Ketentuan Peminjaman Ruangan</h4>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <h4>1. Pendahuluan</h4>
                <p>
                    Syarat dan Ketentuan ini mengatur penggunaan sistem peminjaman ruangan oleh pengguna (User)
                    dan
                    admin (Admin).
                    Dengan menggunakan sistem ini, pengguna dianggap telah membaca, memahami, dan menyetujui
                    semua
                    ketentuan yang berlaku.
                </p>

                <h4>2. Definisi</h4>
                <ul>
                    <li><strong>User</strong>: Pengguna yang memiliki hak untuk mengajukan peminjaman ruangan
                        dan
                        menginput surat.</li>
                    <li><strong>Admin</strong>: Pihak yang bertanggung jawab untuk menyetujui atau menolak
                        peminjaman ruangan dan surat.</li>
                    <li><strong>Ruangan</strong>: Sarana yang tersedia untuk dipinjam sesuai dengan kebijakan
                        yang
                        berlaku.</li>
                    <li><strong>Peminjaman</strong>: Proses reservasi ruangan oleh user yang memerlukan
                        persetujuan
                        admin.</li>
                    <li><strong>Surat</strong>: Dokumen yang diajukan oleh user untuk keperluan tertentu dan
                        memerlukan validasi admin.</li>
                </ul>

                <h4>3. Ketentuan Peminjaman Ruangan</h4>
                <ul>
                    <li>Pengguna harus memiliki akun yang terdaftar dalam sistem untuk dapat mengajukan
                        peminjaman.
                    </li>
                    <li>Peminjaman hanya dapat dilakukan sesuai dengan jadwal yang tersedia dan kapasitas
                        ruangan.
                    </li>
                    <li>Admin berhak menyetujui atau menolak peminjaman berdasarkan kebijakan yang berlaku.</li>
                    <li>Pengguna bertanggung jawab menjaga fasilitas ruangan selama masa peminjaman.</li>
                    <li>Segala bentuk kerusakan atau kehilangan barang akibat pemakaian ruangan akan menjadi
                        tanggung jawab peminjam.</li>
                </ul>

                <h4>4. Ketentuan Pengajuan Surat</h4>
                <ul>
                    <li>User dapat mengajukan surat melalui sistem dengan mengisi formulir yang tersedia.</li>
                    <li>Surat yang diajukan akan diperiksa oleh admin sebelum disetujui atau ditolak.</li>
                    <li>Keputusan admin bersifat final dan tidak dapat diganggu gugat.</li>
                    <li>Pengguna wajib memastikan bahwa isi surat sesuai dengan ketentuan dan tujuan peminjaman.
                    </li>
                </ul>

                <h4>5. Hak dan Kewajiban Pengguna</h4>
                <ul>
                    <li>Pengguna berhak untuk mengakses sistem dan mengajukan peminjaman serta surat sesuai
                        prosedur.</li>
                    <li>Pengguna wajib memberikan informasi yang benar dan akurat dalam setiap pengajuan.</li>
                    <li>Pengguna wajib mematuhi semua aturan yang ditetapkan oleh sistem dan pihak terkait.</li>
                </ul>

                <h4>6. Hak dan Kewajiban Admin</h4>
                <ul>
                    <li>Admin bertanggung jawab untuk mengelola peminjaman dan surat yang diajukan.</li>
                    <li>Admin memiliki kewenangan untuk menyetujui atau menolak permohonan berdasarkan kebijakan
                        yang berlaku.</li>
                    <li>Admin wajib menjaga kerahasiaan data pengguna dan memastikan sistem berjalan dengan
                        baik.
                    </li>
                </ul>

                <h4>7. Pembatalan dan Sanksi</h4>
                <ul>
                    <li>Pengguna yang membatalkan peminjaman harus melakukannya melalui sistem sebelum batas
                        waktu
                        yang ditentukan.</li>
                    <li>Jika pengguna tidak menggunakan ruangan tanpa pemberitahuan, maka akan diberikan sanksi
                        sesuai kebijakan.</li>
                    <li>Penyalahgunaan sistem atau informasi palsu dapat berakibat pada pemblokiran akun.</li>
                </ul>

                <h4>8. Perubahan Syarat dan Ketentuan</h4>
                <p>Pihak admin berhak mengubah syarat dan ketentuan ini sewaktu-waktu tanpa pemberitahuan
                    terlebih
                    dahulu. Pengguna diharapkan untuk selalu memeriksa ketentuan yang berlaku sebelum
                    menggunakan
                    sistem.</p>

                <h4>9. Kontak dan Bantuan</h4>
                <p>Jika ada pertanyaan atau kendala dalam penggunaan sistem, pengguna dapat menghubungi admin
                    melalui kontak yang tersedia dalam sistem.</p>
            </div>
        </div>
        <!-- /modal-content -->
    </div>
    <!-- /modal-dialog -->
</div>
<!-- /modal -->



<!-- Modal untuk informasi booking -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="infoModalLabel">Informasi Booking</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" id="infoModalBody">
                <!-- Konten informasi akan diisi melalui JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk peringatan booking -->
<div class="modal fade" id="warningModal" tabindex="-1" aria-labelledby="warningModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="warningModalLabel">Peringatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body" id="warningModalBody">
                <!-- Konten peringatan akan diisi melalui JavaScript -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal untuk peringatan waktu -->
<div class="modal fade" id="timeWarningModal" tabindex="-1" aria-labelledby="timeWarningModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="timeWarningModalLabel">Peringatan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Waktu peminjaman harus antara jam 6 pagi hingga jam 8 malam.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>



<!-- Modal untuk login -->
<div class="modal fade" id="loginModal" tabindex="-1" aria-labelledby="loginModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="loginModalLabel">Login Diperlukan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Anda harus login terlebih dahulu untuk melanjutkan proses booking.
            </div>
            <div class="modal-footer">
                <a href="{{ url('/login') }}" class="btn btn-primary">Login</a>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>
@endsection