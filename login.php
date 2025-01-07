<?php
include("database.php");

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];
    
    $sql = "SELECT * FROM users WHERE Username = '$username' AND Password = '$password'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $user['UserID'];
        $_SESSION['username'] = $user['Username'];
        redirect("index.php");
    } else {
        $error = "Väärä nimi tai salasana";
    }
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kirjaudu - JC Airlines</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-image: url('assets/img/world.png');">
    <nav class="navbar">
        <img src="assets/img/logo.png" alt="JC Airlines Logo" class="logo">
        <div class="buttons">
            <button class="round-button" onclick="window.location.href='index.php'">
                <i class="fa fa-home"></i> Etusivu
            </button>
        </div>
    </nav>

    <div class="search-form">
        <h2>Kirjaudu sisään</h2>
        <?php if($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <input type="text" name="username" class="input-field" placeholder="Käyttäjänimi" required>
            <input type="password" name="password" class="input-field" placeholder="Salasana" required>
            <button type="submit" class="search-btn">Kirjaudu</button>
        </form>
        
        <p style="text-align: center; margin-top: 1rem;">
            Ei tiliä? <a href="register.php" style="color: var(--primary-color);">Rekisteröidy</a>
        </p>
    </div>
</body>
</html>