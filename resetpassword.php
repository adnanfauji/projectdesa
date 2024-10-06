<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Lupa Kata Sandi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/projectdesa/style.css" />
    <!-- <script>
        function handleSubmit(event) {
            event.preventDefault(); // Mencegah pengiriman formulir secara default
            // Ganti URL di bawah ini dengan URL yang sesuai
            window.location.href = '/projectdesa/confirm.php';
        }
    </script> -->
</head>

<body>
    <div class="wrapper">
        <div class="left">
                <img src="/projectdesa/img/forgotnew.png" alt=""/>
                <p>Setelah Anda mendapatkan tautan, klik pada tautan tersebut<br> dan  ikuti instruksi untuk membuat kata sandi baru.</p>
            </div>
            <form action="" method="post" class="login-wrapper" onsubmit="handleSubmit(event)">
                <h1>Lupa sandi?</h1>
                <p>Masukan email Anda dan kami akan mengirimkan tautan untuk mereset kata sandi Anda.</p>
                <div class="input-field">
                    <input type="email" id="email" name="email" autocomplete="on" required />
                    <label for="email">Masukan email Anda</label>
                </div>
                <!-- <div class="input-box">
                    <input type="submit" value="Kirim" />
                </div> -->
                <div>
                    <a href="/projectdesa/confirm.php" id="login">
                        <button type="submit" name="login" id="login" class="login">Kirim</button>
                    </a>
                </div>
                <div class="register">
                    <p><a href="/projectdesa/login.php">Cancel</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>