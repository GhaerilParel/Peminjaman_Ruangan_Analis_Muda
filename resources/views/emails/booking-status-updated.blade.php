<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Status Booking Diperbarui</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            background-color: #ecf0f1;
            margin: 0;
            padding: 0;
            color: #2c3e50;
        }
        .container {
            max-width: 600px;
            margin: 20px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            color: #1abc9c;
            text-align: center;
            margin-bottom: 20px;
        }
        p {
            font-size: 16px;
            line-height: 1.5;
        }
        h3 {
            color: #34495e;
            font-size: 20px;
            margin-bottom: 15px;
            border-bottom: 2px solid #1abc9c;
            padding-bottom: 5px;
        }
        ul {
            list-style: none;
            padding-left: 0;
        }
        ul li {
            font-size: 14px;
            margin-bottom: 10px;
        }
        ul li strong {
            color: #16a085;
        }
        .status-box {
            display: inline-block;
            padding: 10px;
            margin: 10px 0;
            color: white;
            font-weight: bold;
            border-radius: 5px;
        }
        .approved {
            background-color: #27ae60; /* Green */
        }
        .rejected {
            background-color: #e74c3c; /* Red */
        }
        .pending {
            background-color: #3498db; /* Blue */
        }
        .message {
            background-color: #1abc9c;
            color: white;
            padding: 10px;
            border-radius: 5px;
            margin-top: 20px;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            font-size: 14px;
            color: #7f8c8d;
        }
        .footer a {
            color: #1abc9c;
            text-decoration: none;
        }
        .footer a:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Status Booking Anda Telah Diperbarui</h1>

        <p>Halo {{ $nama }},</p>
        <p>Kami ingin menginformasikan bahwa status booking Anda telah diperbarui menjadi: 
            <span class="status-box {{ strtolower($status) }}">
                {{ ucfirst($status) }}
            </span>
        </p>

        <h3>Berikut adalah detail peminjaman Anda:</h3>
        <ul>
            <li><strong>Tanggal Booking:</strong> {{ $booking_date }}</li>
            <li><strong>Waktu Mulai:</strong> {{ $waktu_mulai }}</li>
            <li><strong>Waktu Selesai:</strong> {{ $waktu_selesai }}</li>
            <li><strong>Jumlah Orang:</strong> {{ $jumlah_orang }}</li>
            <li><strong>Tipe Ruangan:</strong> {{ $room_type }}</li>
        </ul>

        <p class="message"><strong>Pesan:</strong> {{ $alasan }}</p>

        <p>Terima kasih telah menggunakan layanan kami. Jika Anda membutuhkan bantuan lebih lanjut, tim kami siap membantu Anda kapan saja.</p>

        <div class="footer">
            <p>Salam hangat, <br> Tim Layanan Pelanggan</p>
            <p><a href="mailto:support@company.com">Hubungi kami</a> | <a href="https://company.com">Website kami</a></p>
        </div>
    </div>

</body>

</html>
