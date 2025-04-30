<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Peminjaman Ruangan Laboratorium Komputer Sekolah Vokasi IPB University">
    <meta name="author" content="Ansonika">
    <title>@yield('title', 'Peminjaman Ruangan')</title>

    <!-- Favicons -->
    <link rel="shortcut icon" href="{{ asset('img/apple-touch-icon-114x114-precomposed.png') }}" type="image/x-icon">
    <link rel="apple-touch-icon" type="image/x-icon" href="{{ asset('img/apple-touch-icon-57x57-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="72x72"
        href="{{ asset('img/apple-touch-icon-72x72-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="114x114"
        href="{{ asset('img/apple-touch-icon-114x114-precomposed.png') }}">
    <link rel="apple-touch-icon" type="image/x-icon" sizes="144x144"
        href="{{ asset('img/apple-touch-icon-144x144-precomposed.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('css/vendors.css') }}" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body class="bg_color_gray">

    <div id="preloader">
        <img src="{{ asset('img/logo.png') }}" height="40" width="40" alt="Loading...">
    </div><!-- /Preload -->
    <div id="loader_form">
        <img src="{{ asset('img/logo.png') }}" height="40" width="40" alt="Loading...">
    </div><!-- /loader_form -->

    <div class="min-vh-100 d-flex flex-column">
        @include('partials.navbar')

        <main>
            @yield('content')
        </main>

        @include('partials.footer')
    </div>

    <!-- COMMON SCRIPTS -->
    <script src="{{ asset('js/common_scripts.min.js') }}"></script>
    <script src="{{ asset('js/common_functions.js') }}"></script>
    <script src="{{ asset('assets/validate.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/6.1.15/index.global.min.js"></script>

    <!-- SPECIFIC SCRIPTS -->
    <script src="{{ asset('js/reservation_wizard_func.js') }}"></script>
    <script src="{{ asset('js/daterangepicker_func.js') }}"></script>
    <script>
        document.getElementById('next-button').addEventListener('click', function() {
            <?php if (isset($_SESSION['auth']) && $_SESSION['auth']): ?>
            // Jika user sudah login, lanjutkan ke langkah berikutnya
            document.querySelector('.forward').click();
            <?php else: ?>
            // Jika user belum login, arahkan ke halaman login
            const loginModal = new bootstrap.Modal(document.getElementById('loginModal'));
            loginModal.show();
            <?php endif; ?>
        });

        document.addEventListener("DOMContentLoaded", function() {
            document.querySelector(".qtyplus").addEventListener("click", function() {
                let input = document.getElementById("jumlah_orang");
                input.value = parseInt(input.value) + 1;
            });

            document.querySelector(".qtyminus").addEventListener("click", function() {
                let input = document.getElementById("jumlah_orang");
                if (parseInt(input.value) > 1) {
                    input.value = parseInt(input.value) - 1;
                }
            });
        });

        document.getElementById('upload-btn').addEventListener('click', function() {
            document.getElementById('file-input').click();
        });

        document.getElementById('file-input').addEventListener('change', function() {
            let fileName = this.files.length > 0 ? this.files[0].name : '';
            document.getElementById('file-name').value = fileName;
        });

        document.addEventListener("DOMContentLoaded", function() {
            const roomType1 = document.getElementById("room_type_1");
            const roomType2 = document.getElementById("room_type_2");

            roomType1.addEventListener("change", function() {
                const selectedIndex = roomType1.selectedIndex;
                roomType2.selectedIndex = selectedIndex;
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Inisialisasi FullCalendar
            let calendar = new FullCalendar.Calendar(document.getElementById('calendar-dates'), {
                initialView: 'dayGridMonth',
                selectable: true,
                events: function(fetchInfo, successCallback, failureCallback) {
                    // Ambil data booking dari API
                    $.ajax({
                        url: '{{ route('booked.dates.by.room') }}', // Endpoint API
                        method: 'GET',
                        success: function(response) {
                            console.log('Data dari API:', response); // Log data dari API
                            // Format data untuk FullCalendar
                            let events = response.map(function(item) {
                                return {
                                    title: item.status === 'booked' ? 'Booked' :
                                        'Available',
                                    start: item.start,
                                    color: item.status === 'booked' ? '#ff0000' :
                                        '#00ff00', // Warna merah untuk booked, hijau untuk available
                                    textColor: 'white',
                                    status: item
                                        .status // Tambahkan status untuk logika klik
                                };
                            });
                            successCallback(events); // Kirim data ke FullCalendar
                        },
                        error: function() {
                            alert('Gagal mengambil data booking.');
                            failureCallback();
                        }
                    });
                },
                dateClick: function(info) {
                    // Ketika tanggal diklik
                    let selectedDate = info.dateStr;
                    let event = calendar.getEvents().find(function(event) {
                        return event.startStr === selectedDate;
                    });

                    if (event && event.extendedProps.status === 'booked') {
                        alert('Tanggal ini sudah dibooking dan tidak bisa dipilih.');
                    } else {
                        $('#dates').val(selectedDate); // Set tanggal ke input
                        alert('Tanggal dipilih: ' + selectedDate);
                    }
                }
            });

            // Render kalender
            calendar.render();
        });

        document.addEventListener("DOMContentLoaded", function() {
            const calendarDates = document.getElementById("calendar-dates");
            const currentMonthYear = document.getElementById("current-month-year");
            const prevMonthBtn = document.getElementById("prev-month");
            const nextMonthBtn = document.getElementById("next-month");
            const roomTypeSelect = document.getElementById("room_type_1");

            let currentDate = new Date();
            let selectedRoomType = roomTypeSelect.value; // Default room type

            // Fungsi untuk mendapatkan data booking dari API berdasarkan room_type
            async function fetchBookedDates(roomType) {
                try {
                    const response = await fetch(`{{ route('booked.dates.by.room') }}?room_type=${roomType}`);
                    const data = await response.json();
                    console.log("Data booking:", data); // Debugging
                    return data.map(item => ({
                        date: item.date,
                        status: item.status,
                        bookings: item.bookings || [] // Detail booking
                    }));
                } catch (error) {
                    console.error("Gagal mengambil data booking:", error);
                    return [];
                }
            }

            // Fungsi untuk merender kalender
            async function renderCalendar() {
                const bookedDates = await fetchBookedDates(selectedRoomType);
                const year = currentDate.getFullYear();
                const month = currentDate.getMonth();

                // Set header bulan dan tahun
                currentMonthYear.textContent = `${currentDate.toLocaleString("default", {
                                        month: "long"
                                    })} ${year}`;

                // Hapus tanggal sebelumnya
                calendarDates.innerHTML = "";

                // Dapatkan hari pertama bulan
                const firstDay = new Date(year, month, 1).getDay();

                // Dapatkan jumlah hari dalam bulan
                const daysInMonth = new Date(year, month + 1, 0).getDate();

                // Tambahkan tanggal kosong sebelum hari pertama
                for (let i = 0; i < firstDay; i++) {
                    const emptyDiv = document.createElement("div");
                    calendarDates.appendChild(emptyDiv);
                }

                // Tambahkan tanggal ke kalender
                for (let day = 1; day <= daysInMonth; day++) {
                    const dateDiv = document.createElement("div");
                    const date =
                        `${year}-${String(month + 1).padStart(2, "0")}-${String(day).padStart(2, "0")}`;

                    dateDiv.classList.add("calendar-date");
                    dateDiv.textContent = day;

                    // Periksa apakah tanggal sudah dibooking
                    const bookedInfo = bookedDates.find(booked => booked.date === date);

                    if (bookedInfo) {
                        // Jika status booking adalah approved
                        if (bookedInfo.status === "approved") {
                            // Periksa apakah ada booking pada jam 6 pagi hingga 8 malam
                            const isFullyBooked = bookedInfo.bookings.some(booking => {
                                const startTime = parseInt(booking.waktu_mulai.split(":")[0]);
                                const endTime = parseInt(booking.waktu_selesai.split(":")[0]);
                                return startTime <= 6 && endTime >=
                                    20; // Terbooking penuh dari jam 6 pagi hingga 8 malam
                            });

                            const isPartiallyBooked = bookedInfo.bookings.some(booking => {
                                const startTime = parseInt(booking.waktu_mulai.split(":")[0]);
                                const endTime = parseInt(booking.waktu_selesai.split(":")[0]);
                                return (startTime >= 6 && startTime < 20) || (endTime > 6 && endTime <=
                                    20);
                            });

                            if (isFullyBooked) {
                                dateDiv.classList.add("fully-booked");
                                dateDiv.setAttribute("title",
                                    "Tanggal ini sudah dibooking penuh pada jam 6 pagi hingga 8 malam");

                                // Tambahkan event listener untuk menampilkan popup info booking
                                dateDiv.addEventListener("click", () => {
                                    const modalBody = document.getElementById("infoModalBody");
                                    modalBody.innerHTML = `<strong>Detail Booking:</strong><br>`;
                                    bookedInfo.bookings.forEach(booking => {
                                        modalBody.innerHTML +=
                                            `Nama: ${booking.nama || "Unknown"}<br>`;
                                        modalBody.innerHTML +=
                                            `Waktu: ${booking.waktu_mulai} - ${booking.waktu_selesai}<br><br>`;
                                    });
                                    const infoModal = new bootstrap.Modal(document.getElementById(
                                        "infoModal"));
                                    infoModal.show();
                                });
                            } else if (isPartiallyBooked) {
                                dateDiv.classList.add("partially-booked");
                                dateDiv.setAttribute("title", "Tanggal ini sebagian sudah dibooking.");

                                // Tambahkan event listener untuk menampilkan popup info booking
                                dateDiv.addEventListener("click", () => {
                                    const modalBody = document.getElementById("infoModalBody");
                                    modalBody.innerHTML = `<strong>Detail Booking:</strong><br>`;
                                    bookedInfo.bookings.forEach(booking => {
                                        modalBody.innerHTML +=
                                            `Nama: ${booking.nama || "Unknown"}<br>`;
                                        modalBody.innerHTML +=
                                            `Waktu: ${booking.waktu_mulai} - ${booking.waktu_selesai}<br><br>`;
                                    });
                                    const infoModal = new bootstrap.Modal(document.getElementById(
                                        "infoModal"));
                                    infoModal.show();
                                });
                            }
                        }
                    } else {
                        // Jika tidak ada booking atau status pending, tetap hijau
                        dateDiv.classList.add("available");
                        dateDiv.setAttribute("title", "Tanggal ini tersedia untuk booking.");
                    }

                    calendarDates.appendChild(dateDiv);
                }
            }

            // Navigasi bulan sebelumnya
            prevMonthBtn.addEventListener("click", () => {
                currentDate.setMonth(currentDate.getMonth() - 1);
                renderCalendar();
            });

            // Navigasi bulan berikutnya
            nextMonthBtn.addEventListener("click", () => {
                currentDate.setMonth(currentDate.getMonth() + 1);
                renderCalendar();
            });

            // Event listener untuk room_type
            roomTypeSelect.addEventListener("change", () => {
                selectedRoomType = roomTypeSelect.value; // Ambil nilai room_type yang dipilih
                renderCalendar(); // Render ulang kalender
            });

            // Render kalender pertama kali
            renderCalendar();
        });
    </script>
    @stack('scripts')

</body>

</html>




