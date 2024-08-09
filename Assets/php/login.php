<?php
    @ob_start();
    session_start();
    if (isset($_POST['proses'])) {
        require 'config.php';

        $user = strip_tags($_POST['user']);
        $pass = strip_tags($_POST['pass']);

        $sql = 'SELECT member.*, login.user, login.pass, user_roles.role_id 
                FROM member 
                INNER JOIN login ON member.id_member = login.id_member
                INNER JOIN user_roles ON member.id_member = user_roles.id_member
                WHERE login.user = ? AND login.pass = ?';
        $row = $config->prepare($sql);
        $row->execute(array($user, $pass)); 
        $jum = $row->rowCount();
        if ($jum > 0) {
            $hasil = $row->fetch();
            $_SESSION['admin'] = $hasil;
            $_SESSION['admin']['role_id'] = $hasil['role_id']; // Menyimpan role_id ke dalam session
            echo '<script>alert("Login Sukses");window.location="index.php"</script>';
        } else {
            echo '<script>alert("Login Gagal");history.go(-1);</script>';
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- Mobile Metas -->
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <!-- Site Metas -->
    <link rel="icon" type="image/x-icon" href="Gallery/RameninAjah Logo.png" />
    <link rel="icon" type="image/x-icon" href="../../../../RameninAjah/Gallery/RameninAjah Logo.png" />
    <title>RameninAjah - Login Admin</title>
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>
    <div class="formlogin-container">
        <div class="formlogin-box">
            <div class="formlogin-logo">
                <img src="../../Gallery/RameninAjah.png" alt="Ramenin Ajah" class="formlogin-logo-image">
            </div>
            <h2>LOGIN</h2>
            <p>Yang Bisa login hanya pelayan, kasir dan chef !</p>
            <p>Contact : RameninAjah@gmail.com</p>
            <form method="POST">
                <div class="formlogin-input-group">
                    <label for="username" class="formlogin-input-icon formlogin-user-icon"></label>
                    <input type="text" id="username" name="user" placeholder="Masukan Username">
                </div>
                <div class="formlogin-input-group">
                    <label for="password" class="formlogin-input-icon formlogin-key-icon"></label>
                    <input type="password" id="password" name="pass" placeholder="Masukan Password">
                </div>
                <a href="../../admin.html"><button type="button" class="back-button">BACK</button></a>
                <button type="submit" name="proses" class="login-button">LOGIN</button>
            </form>
        </div>
    </div>
</body>
</html>
