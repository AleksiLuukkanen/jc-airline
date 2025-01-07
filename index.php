<?php
include("database.php");
?>
<!DOCTYPE html>
<html lang="fi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>JC Airlines - Kotisivu</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="style.css">
</head>
<body style="background-image: url('assets/img/world.png');">
    <nav class="navbar">
        <img src="assets/img/logo.png" alt="JC Airlines Logo" class="logo">
        <div class="buttons">
            <button class="round-button" onclick="window.location.href='flights.php'">
                <i class="fa fa-plane"></i> Lennot
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

    <main>
        <form class="search-form" action="flights.php" method="GET">
            <input type="text" name="departure" class="input-field" placeholder="Lähtöpaikka" required>
            <input type="text" name="destination" class="input-field" placeholder="Päämäärä" required>
            
            <div class="select-group">
                <select name="category" class="select-option" required>
                    <option value="">Valitse ajankohta</option>
                    <option value="Aamu">Aamu</option>
                    <option value="Päivä">Päivä</option>
                    <option value="Ilta">Ilta</option>
                </select>

                <select name="time" class="select-option" required>
                    <option value="">Valitse aika</option>
                    <option value="10:00">10:00</option>
                    <option value="14:00">14:00</option>
                    <option value="18:00">18:00</option>
                </select>
            </div>

            <select name="passengers" class="select-option" required>
                <option value="">Valitse matkustajamäärä</option>
                <?php for($i = 1; $i <= 8; $i++): ?>
                    <option value="<?php echo $i; ?>"><?php echo $i; ?> matkustajaa</option>
                <?php endfor; ?>
            </select>

            <button type="submit" class="search-btn">
                <i class="fa fa-search"></i> Hae Lentoja
            </button>
        </form>
    </main>
</body>
</html>