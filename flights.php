<?php
include("database.php");

$vapaat_paikat = ["VapaatPaikat > 0"];

if ($_GET) {
    if (!empty($_GET['departure'])) {
        $departure = mysqli_real_escape_string($conn, $_GET['departure']);
        $vapaat_paikat[] = "LahtoPaikka LIKE '%$departure%'";
    }
    
    if (!empty($_GET['destination'])) {
        $destination = mysqli_real_escape_string($conn, $_GET['destination']);
        $vapaat_paikat[] = "PaaMaara LIKE '%$destination%'";
    }
    
    if (!empty($_GET['time'])) {
        $time = mysqli_real_escape_string($conn, $_GET['time']);
        $vapaat_paikat[] = "Aika = '$time'";
    }
    
    if (!empty($_GET['category'])) {
        $category = mysqli_real_escape_string($conn, $_GET['category']);
        $vapaat_paikat[] = "AikaKategoria = '$category'";
    }

    if (!empty($_GET['passengers'])) {
        $passengers = (int)$_GET['passengers'];
        $vapaat_paikat[] = "VapaatPaikat >= $passengers";
    }
}

$lauseke = implode(" AND ", $vapaat_paikat);
$query = "SELECT * FROM lennot WHERE " . $lauseke;
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lennot - JC Airlines</title>
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
            <?php if(isset($_SESSION['user_id'])): ?>
                <button class="round-button" onclick="window.location.href='logout.php'">
                    <i class="fa fa-sign-out"></i> Kirjaudu ulos
                </button>
            <?php else: ?>
                <button class="round-button" onclick="window.location.href='login.php'">
                    <i class="fa fa-sign-in"></i> Kirjaudu
                </button>
            <?php endif; ?>
        </div>
    </nav>

    <div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem;">
        <h1>Saatavilla olevat lennot</h1>
        
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($flight = mysqli_fetch_assoc($result)): ?>
                <div class="flight-card">
                    <div class="flight-info">
                        <div>
                            <h3><?php echo htmlspecialchars($flight['PaaMaara']); ?></h3>
                            <p>Lähtöpaikka: <?php echo htmlspecialchars($flight['LahtoPaikka']); ?></p>
                            <p>
                                Aika: <?php echo htmlspecialchars($flight['Aika']); ?>
                                <span class="time-badge"><?php echo htmlspecialchars($flight['AikaKategoria']); ?></span>
                            </p>
                            <p>Kone: <?php echo htmlspecialchars($flight['Kone']); ?></p>
                            <p>Vapaita paikkoja: <?php echo htmlspecialchars($flight['VapaatPaikat']); ?></p>
                        </div>
                        <div>
                            <h3><?php echo number_format($flight['LipunHinta'], 2); ?>€</h3>
                            <?php if(isset($_SESSION['user_id'])): ?>
                                <form action="book.php" method="post">
                                    <input type="hidden" name="flight_id" value="<?php echo $flight['LentoID']; ?>">
                                    <input type="hidden" name="passengers" value="<?php echo $_GET['passengers'] ?? 1; ?>">
                                    <button type="submit" class="search-btn">Varaa lento</button>
                                </form>
                            <?php else: ?>
                                <p>Kirjaudu sisään ensin.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="error-message">Ei löytynyt lentoja.</div>
        <?php endif; ?>
    </div>
</body>
</html>