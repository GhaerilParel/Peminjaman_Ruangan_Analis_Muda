<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Limmo - Register, Reservation, Questionare, Reviews, Quotation form Multipurpose Wizard with SMTP and HTML email support">
    <meta name="author" content="Ansonika">
    <title>Peminjaman Ruangan Laboratorium Komputer Sekolah Vokasi IPB University</title>

    <!-- GOOGLE WEB FONT -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- BASE CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/vendors2.css" rel="stylesheet">

    <!-- YOUR CUSTOM CSS -->
    <link href="css/custom.css" rel="stylesheet">
    
    <script type="text/javascript">
    function delayedRedirect(){
        window.location = "{{ url('/index') }}"
    }
    </script>
</head>

<body onLoad="setTimeout('delayedRedirect()', 8000)" style="background-color:#fff;">
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'src/Exception.php';
require 'src/PHPMailer.php';

$mail = new PHPMailer(true);

try {
    // Set up pengirim dan penerima email
    $mail->setFrom('parelparel71@gmail.com', 'Admin Peminjaman Ruangan');
    $mail->addAddress('parelparel71@gmail.com', 'Admin IPB'); // Ganti dengan email admin yang menangani peminjaman
    $mail->addReplyTo($_POST['email'], $_POST['firstname']); // User sebagai pengirim

    // Setup email
    $mail->isHTML(true);
    $mail->Subject = 'Pengajuan Peminjaman Ruangan';
    
    // Membuat isi email
    $message = "<h3>Detail Peminjaman Ruangan</h3>";
    $message .= "<strong>Tanggal Peminjaman:</strong> " . $_POST['dates'] . "<br />";
    $message .= "<strong>Ruangan:</strong> " . $_POST['room_type'] . "<br />";
    $message .= "<strong>Jumlah Orang:</strong> " . $_POST['jumlah_orang'] . "<br />";
    $message .= "<h3>Detail Peminjam</h3>";
    $message .= "<strong>Nama:</strong> " . $_POST['firstname'] . "<br />";
    $message .= "<strong>NIM:</strong> " . $_POST['nim'] . "<br />";
    $message .= "<strong>Jurusan:</strong> " . $_POST['jurusan'] . "<br />";
    $message .= "<strong>Email:</strong> " . $_POST['email'] . "<br />";
    $message .= "<strong>No Telepon:</strong> " . $_POST['telephone'] . "<br />";
    $message .= "<strong>Alasan Peminjaman:</strong> " . $_POST['review'] . "<br />";
    $message .= "<strong>Terms and Conditions:</strong> " . $_POST['terms'] . "<br />";

    // Tambahkan attachment jika ada surat peminjaman
    if (!empty($_FILES['file']['name'])) {
        $file_tmp = $_FILES['file']['tmp_name'];
        $file_name = $_FILES['file']['name'];
        $mail->addAttachment($file_tmp, $file_name);
    }

    // Masukkan isi email
    $mail->Body = $message;

    // Kirim email
    $mail->send();

    // Konfirmasi ke user
    $mail->ClearAddresses();
    $mail->addAddress($_POST['email']); // Email user
    $mail->Subject = 'Konfirmasi Peminjaman Ruangan';
    $mail->Body = "<h3>Permohonan Peminjaman Anda telah diterima</h3><p>Admin akan segera memproses permohonan Anda.</p>";

    $mail->send();

    echo '
   <div id="success">
            <div class="icon icon--order-success svg">
                 <svg xmlns="http://www.w3.org/2000/svg" width="72px" height="72px">
                  <g fill="none" stroke="#8EC343" stroke-width="2">
                     <circle cx="36" cy="36" r="35" style="stroke-dasharray:240px, 240px; stroke-dashoffset: 480px;"></circle>
                     <path d="M17.417,37.778l9.93,9.909l25.444-25.393" style="stroke-dasharray:50px, 50px; stroke-dashoffset: 0px;"></path>
                  </g>
                 </svg>
             </div>
            <h4><span>Permohonan berhasil dikirim!</span> Terima kasih telah mengajukan peminjaman.</h4>
            <small>You will be redirect back in 5 seconds.</small>
        </div>';

} catch (Exception $e) {
    echo "Pesan tidak dapat dikirim. Error: {$mail->ErrorInfo}";
}
?>  

</body>
</html>

