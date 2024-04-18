<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">   
    <title>Kalkulator walut</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <?php
        $db = new mysqli('localhost','root','','kantor');
        $kw = "SELECT * FROM `kursy` ORDER BY data DESC LIMIT 34;";
        $rezultat = $db->query($kw);
        $tab = array();
        foreach($rezultat as $wiersz){
            array_push($tab,array($wiersz['nr_tabeli'],$wiersz['waluta'],$wiersz['kurs']));
        }
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
        <h2>Przelicznik PLN na wybraną walutę:</h2>
        <form action="kalkulator.php" method="get">
            <label>Podaj kwotę jaką chcesz przeliczyć: </label>
            <input type="number" name="kwota" min="0" step="0.01">
            <label>Wybierz walute:</label>
                <?php
                    echo "<select name='kod'>";
                    foreach($tab as $x){
                        echo "<option>".$x[1]."</option>";
                    }
                    echo "</select><br>";
                ?>
            <input type="submit" name="submit" value="Wyświetl">
        </form>
        
        <?php
            if(isset($_GET['submit'])){
                $kod = $_GET['kod'];
                $kwota = $_GET['kwota'];
                
                foreach($tab as $x){
                    if($x[1] == $kod){
                        $kurs = $x[2];
                    };
                }
                echo "<p>Obecny kurs dla $kod to: <b>$kurs PLN</b></p><p><b>$kwota PLN</b> to w przeliczeniu <b>".round($kwota/$kurs,2)." $kod</b></p>";
            }
        ?>
        <br><br><br><br>
        <h2>Przelicznik wybranej waluty na PLN:</h2>
        <form action="kalkulator.php" method="get">
            <label>Podaj kwotę jaką chcesz przeliczyć: </label>
            <input type="number" name="kwota" min="0" step="0.01">
            <label>Wybierz walute:</label>
                <?php
                    echo "<select name='kod'>";
                    foreach($tab as $x){
                        echo "<option>".$x[1]."</option>";
                    }
                    echo "</select><br>";
                ?>
            <input type="submit" name="submit1" value="Wyświetl">
        </form>
        
        <?php
            if(isset($_GET['submit1'])){
                $kod = $_GET['kod'];
                $kwota = $_GET['kwota'];
                
                foreach($tab as $x){
                    if($x[1] == $kod){
                        $kurs = $x[2];
                    };
                }
                echo "<p>Obecny kurs dla $kod to: <b>$kurs PLN</b></p><p><b>$kwota $kod</b> to w przeliczeniu <b>".round($kwota*$kurs,2)." PLN</b></p>";
            }
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