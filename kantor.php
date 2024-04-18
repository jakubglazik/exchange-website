<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">   
    <title>Kantor walutowy</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <?php
        $db = new mysqli('localhost','root','','kantor');

    ?>
    <div id="baner">
        <h1>Internetowy kantor walutowy</h1>
    </div>
        <div id="menu">
            <ul>
            <li><a href="kantor.php">Strona główna</a></li>
                <li><a href="kalkulator.php">Kalkulator</a></li>
                <li><a href="archiwum.php">Archiwum</a></li>
                <li>Wykresy</li>
                <ul>
                    <li><a href="wykres_eur.php">EUR</a></li>
                    <li><a href="wykres_gbp.php">USD</a></li>
                    <li><a href="wykresy_usd.php">GBP</a></li>
                </ul>
            </ul>
        </div>
        <div id="main">
            <?php
                $kw = "SELECT * FROM `kursy` ORDER BY data DESC LIMIT 1;";
                $rezultat = $db->query($kw);
                
                foreach($rezultat as $wiersz){
                    $data = $wiersz['data'];
                }
                
                $kw = "SELECT * FROM `kursy` ORDER BY data DESC LIMIT 34;";
                $rezultat = $db->query($kw);
                echo "<h2>Tabela aktualnych kursów z dzisiejszego dnia: $data</h2>";
                echo "<table><tr><th>waluta</th><th>kurs [zł]</th></tr>";
                foreach($rezultat as $wiersz){
                    echo "<tr><td><b>".$wiersz['waluta']."<b></td><td>".$wiersz['kurs']."</td></tr>";
                }
                echo "</table>";
            ?>
        </div>
    
    <div id="stopka">
        <p>Przygotował: Jakub Glazik</p>
    </div>
    <?php
        $db->close();
    ?>
</body>
</html>