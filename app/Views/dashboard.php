<!DOCTYPE html>
<html>
<head>
    <title>Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .container {
            max-width: 400px;
            padding: 40px;
            background-color: #fff;
            border-radius: 6px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        h2 {
            color: #333333;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
        }

        p {
            color: #666666;
            margin-bottom: 20px;
        }

        #sessionExpiration {
            color: #990000;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.1);
        }

        a {
            color: #fff;
            text-decoration: none;
            display: inline-block;
            margin-top: 20px;
            padding: 10px 20px;
            background-color: #4285f4;
            border: 1px solid #357ae8;
            border-radius: 4px;
            box-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
            transition: background-color 0.3s;
            text-align: center;
        }

        a:hover {
            background-color: #357ae8;
        }
    </style>
</head>
<body>

    <div class="container">
        <h2>Selamat Datang, <?php echo $user['username']; ?>!</h2>
        <p>User Id Anda adalah: <?php echo $user['id']; ?></p>
        <p id="sessionExpiration">Session will expire at: <?php echo date('Y-m-d H:i:s', $sessionExpiration); ?></p>
        <a href="auth/logout" id="logoutLink">Logout</a> <!-- Ganti '/auth/logout' dengan URL logout Anda -->
    </div>

    <script>
        var sessionExpireTime = <?php echo $sessionExpiration; ?>;
        var timeLeft = sessionStorage.getItem('timeLeft') || sessionExpireTime;

        function redirectOnSessionExpiry() {
            // Kirim permintaan penghapusan user_id dari server
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/clearuser", true);
            xhr.send();

            // Hapus sesi dari penyimpanan lokal
            sessionStorage.removeItem('timeLeft');

            // Arahkan ke halaman login
            window.location.href = "/login";
        }

        function countdown() {
            var currentTime = Math.floor(Date.now() / 1000);
            var secondsLeft = timeLeft - currentTime;

            if (secondsLeft > 0) {
                var hours = Math.floor(secondsLeft / 3600);
                var minutes = Math.floor((secondsLeft % 3600) / 60);
                var seconds = secondsLeft % 60;

                var countdownDisplay = document.getElementById("sessionExpiration");
                countdownDisplay.innerHTML = "Demi keamanan akun anda akan Logout secara otomatis dalam  : " + hours + " Jam, " + minutes + " Menit, " + seconds + " Detik";

                sessionStorage.setItem('timeLeft', timeLeft); // Simpan waktu yang tersisa di sesi
                setTimeout(countdown, 1000);
            } else {
                redirectOnSessionExpiry();
            }
        }

        document.getElementById("logoutLink").addEventListener("click", function() {
            // Hapus sesi saat logout diklik
            var xhr = new XMLHttpRequest();
            xhr.open("GET", "/clearsession", true);
            xhr.send();
            sessionStorage.removeItem('timeLeft'); // Hapus waktu yang tersisa dari sesi saat logout
        });

        countdown(); // Mulai hitungan mundur saat halaman dimuat
    </script>

</body>
</html>
