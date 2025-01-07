<?php
include("database.php");

if (!isset($_SESSION['user_id'])) {
    redirect("login.php");
}

$error = "";
$success = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['flight_id']) && isset($_POST['passengers'])) {
        $flight_id = mysqli_real_escape_string($conn, $_POST['flight_id']);
        $passengers = (int)$_POST['passengers'];
        
        $check_sql = "SELECT * FROM lennot WHERE LentoID = '$flight_id' AND VapaatPaikat >= $passengers";
        $check_result = mysqli_query($conn, $check_sql);
        
        if (mysqli_num_rows($check_result) > 0) {
            $flight = mysqli_fetch_assoc($check_result);
            
            $user_id = $_SESSION['user_id'];
            $booking_date = date('Y-m-d H:i:s');
            
            $sql = "INSERT INTO bookings (UserID, LentoID, BookingDate, NumberOfTickets) 
                    VALUES ('$user_id', '$flight_id', '$booking_date', $passengers)";
            
            if (mysqli_query($conn, $sql)) {
                $update_sql = "UPDATE lennot SET VapaatPaikat = VapaatPaikat - $passengers 
                              WHERE LentoID = '$flight_id'";
                mysqli_query($conn, $update_sql);
                
                $success = "Lennon varaus onnistui.";
            } else {
                $error = "Virhe varauksen teossa. Yritä uudelleen.";
            }
        } else {
            $error = "Lentoa ei löydy tai vapaita paikkoja ei ole tarpeeksi.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Varaus - JC Airlines</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar">
        <img src="assets/img/logo.png" alt="JC Airlines Logo" class="logo">
        <div class="buttons">
            <button class="round-button" onclick="window.location.href='index.php'">
                <i class="fa fa-home"></i> Etusivu
            </button>
            <button class="round-button" onclick="window.location.href='flights.php'">
                <i class="fa fa-plane"></i> Lennot
            </button>
        </div>
    </nav>

    <div class="search-form">
        <?php if($error): ?>
            <div class="error-message"><?php echo $error; ?></div>
        <?php endif; ?>
        <?php if($success): ?>
            <div class="success-message">
                <?php echo $success; ?>
                <p>Voit nyt palata <a href="flights.php" style="color: var(--primary-color);">lentoihin</a></p>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>