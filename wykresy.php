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
        // $kw = "SELECT * FROM `kursy` ORDER BY data DESC LIMIT 34;";
        // $rezultat = $db->query($kw);
        // $tab = array();
        // foreach($rezultat as $wiersz){
        //     array_push($tab,array($wiersz['nr_tabeli'],$wiersz['waluta'],$wiersz['kurs']));
        // }
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
        <form action="wykresy.php" method="get">
            <label>Wybierz, którą z walut chcesz wyświetliść: </label>
            <select name="kod">
                <option>EUR</option>
                <option>GBP</option>
                <option>USD</option>
            </select>
            <br>
            <input type="submit" name="submit" style="width: 200px"value="Generuj wykres">
        </form>
        
        <?php
            if(isset($_GET['submit'])){
                $kod = strtolower($_GET['kod']);
                
                $kw = "SELECT data, kurs FROM `$kod`;";
                $rezultat = $db->query($kw);

                $daty = array();
                $kursy = array();
                foreach($rezultat as $x){
                    array_push($daty,$x['data']);
                    array_push($kursy,$x['kurs']);
                }
                print_r($kursy);
                echo "<script> xd(); </script>";
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