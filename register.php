<?php
include("database.php");

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $firstName = mysqli_real_escape_string($conn, $_POST['firstName']);
    $lastName = mysqli_real_escape_string($conn, $_POST['lastName']);
    $password = $_POST['password'];
    
    $check_sql = "SELECT * FROM users WHERE Username = '$username'";
    $check_result = mysqli_query($conn, $check_sql);
    
    if (mysqli_num_rows($check_result) > 0) {
        $error = "Käyttäjänimi on jo käytössä";
    } else {
        $sql = "INSERT INTO users (Username, FirstName, LastName, Password) 
                VALUES ('$username', '$firstName', '$lastName', '$password')";
        
        if (mysqli_query($conn, $sql)) {
            $success = "Rekisteröinti onnistui! Voit nyt kirjautua sisään.";
        } else {
            $error = "Virhe rekisteröinnissä. Yritä uudelleen.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekisteröidy JC Airlines</title>
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
        <h2>Rekisteröidy</h2>
        <?php if($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if($success): ?>
            <div class="success-message"><?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="post">
            <input type="text" name="username" class="input-field" placeholder="Käyttäjänimi" required>
            <input type="text" name="firstName" class="input-field" placeholder="Etunimi" required>
            <input type="text" name="lastName" class="input-field" placeholder="Sukunimi" required>
            <input type="password" name="password" class="input-field" placeholder="Salasana" required>
            <button type="submit" class="search-btn">Rekisteröidy</button>
        </form>
        
        <p style="text-align: center; margin-top: 1rem;">
            Onko sinulla tili? <a href="login.php" style="color: var(--primary-color);">Kirjaudu sisään</a>
        </p>
    </div>
</body>
</html>