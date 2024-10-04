<!DOCTYPE html>
<html lang="id" dir="ltr">

<head>
    <meta charset="UTF-8" />
    <title>Lupa Kata Sandi</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="/projectdesa/reset.css" />
    <script>
        function handleSubmit(event) {
            event.preventDefault(); // Mencegah pengiriman formulir secara default
            // Ganti URL di bawah ini dengan URL yang sesuai
            window.location.href = '/projectdesa/confirm.php';
        }
    </script>
</head>

<body>
    <div class="container">
        <div class="content">
            <div class="image-box">
                <img src="/projectdesa/img/contact.png" alt="Ilustrasi Kontak" />
            </div>
            <form action="" method="post" class="reset" onsubmit="handleSubmit(event)">
                <div class="topic">Lupa sandi?</div>
                <div class="topic2">Masukan email Anda dan kami akan mengirimkan tautan untuk mereset kata sandi Anda.</div>
                <div class="input-box">
                    <input type="email" id="email" name="email" autocomplete="on" required />
                    <label for="email">Masukan email Anda</label>
                </div>
                <div class="input-box">
                    <input type="submit" value="Kirim" />
                </div>
                <div class="cancel-link">
                    <p><a href="/projectdesa/login.php">Cancel</a></p>
                </div>
            </form>
        </div>
    </div>
</body>

</html>