<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">   
    <title>Kantor walutowy</title>
    <link rel="stylesheet" href="styl2.css">
</head>
<body>
    <script>
        function wys(val){
            if(document.getElementById(val).style.display == "block"){
                document.getElementById(val).setAttribute("style","display: none")
            }else{
                document.getElementById(val).setAttribute("style","display: block")
            }
        }
    </script>
    <?php
        $db = new mysqli('localhost','root','','kantor');
    ?>
    <div id="baner">
        <h1>Internetowy kantor walutowy</h1>
    </div>
    <div id="main">
        <h2 class="lista" onclick="wys('aktualne')">> Aktualna tabela kursów</h2>
        <div id="aktualne">
            <?php
                $kw = "SELECT * FROM `kursy` ORDER BY data DESC LIMIT 1;";
                $rezultat = $db->query($kw);
                
                foreach($rezultat as $wiersz){
                     $data = $wiersz['data'];
                }
                
                $kw = "SELECT * FROM `kursy` ORDER BY data DESC LIMIT 34;";
                $rezultat = $db->query($kw);
                $tab = array();
                foreach($rezultat as $wiersz){
                        array_push($tab,array($wiersz['nr_tabeli'],$wiersz['waluta'],$wiersz['kurs']));
                }
                echo "<h2>Tabela aktualnych kursów z dzisiejszego dnia: $data</h2>";
                echo "<table><tr><th>waluta</th><th>kurs [zł]</th></tr>";
                foreach($tab as $wiersz){
                    echo "<tr><td><b>".$wiersz[1]."<b></td><td>".$wiersz[2]."</td></tr>";
                }
                echo "</table>";
            ?>
        </div>
        <hr>
        <h2 class="lista" onclick="wys('archiwum')">> Archiwalne tabele kursów</h2>
        <div id="archiwum">
            <form action="index.php" method="get">
                <label>Podaj datę, z której kursy chcesz wyświetlić:</label>
                    <?php
                    $kw = "SELECT data, count(waluta) FROM `kursy` GROUP BY data;";
                    $rezultat = $db->query($kw);

                    echo "<select name='data'>";
                    foreach($rezultat as $wiersz){
                        echo "<option>".$wiersz['data']."</option>";
                    }
                    echo "</select>";
                    $kw = "SELECT waluta FROM `kursy` ORDER BY data DESC limit 34;";
                    $rezultat = $db->query($kw);
                    echo "<select name='kod' style='width:100px'>";
                    foreach($rezultat as $wiersz){
                        echo "<option>".$wiersz['waluta']."</option>";
                    }
                    echo "</select><br><br>";
                ?>
                <input type="submit" name="submit" value="Wyświetl">
            </form>
            <?php
                if(isset($_GET['submit'])){
                    $data = $_GET['data'];
                    $kod = $_GET['kod'];
                    $kw = "SELECT * FROM `kursy` WHERE data = '$data' AND waluta = '$kod'";
                    $rezultat = $db->query($kw);
                    echo "<h2>Archiwalny kurs wybranej waluty z dnia: <i>$data</i></h2>";
                    echo "<table><tr><th>waluta</th><th>kurs [zł]</th></tr>";
                    foreach($rezultat as $wiersz){
                         echo "<tr><td><b>".$wiersz['waluta']."<b></td><td>".$wiersz['kurs']."</td></tr>";
                    }
                    echo "</table>";
                    $rezultat->free_result();
                    echo "<script>document.getElementById('archiwum').setAttribute('style','display: block')</script>";
                }
            ?>
        </div>
        <hr>
        <h2 class="lista" onclick="wys('calc')">> Kalkulator walutowy</h2>
        <div id="calc">
            <h2>Przelicznik PLN na wybraną walutę:</h2>
            <form action="index.php" method="get">
                <label>Podaj kwotę jaką chcesz przeliczyć: </label>
                <input type="number" name="kwota" min="0" step="0.01" required>
                <label>Wybierz walute:</label>
                    <?php
                        // $kw = "SELECT * FROM `kursy` ORDER BY data DESC LIMIT 34;";
                        // $rezultat = $db->query($kw);
                        // $tab = array();
                        // foreach($rezultat as $wiersz){
                        //     array_push($tab,array($wiersz['nr_tabeli'],$wiersz['waluta'],$wiersz['kurs']));
                        // }

                        echo "<select name='kod'>";
                        foreach($tab as $x){
                            echo "<option>".$x[1]."</option>";
                        }
                        echo "</select><br>";
                    ?>
                <input type="submit" name="calc1" value="Wyświetl">
            </form>
                    
            <?php
                if(isset($_GET['calc1'])){
                    $kod = $_GET['kod'];
                    $kwota = $_GET['kwota'];

                    foreach($tab as $x){
                        if($x[1] == $kod){
                            $kurs = $x[2];
                        };
                    }
                    echo "<p>Obecny kurs dla $kod to: <b>$kurs PLN</b></p><p><b>$kwota PLN</b> to w przeliczeniu <b>".round($kwota/$kurs,2)." $kod</b></p>";
                    echo "<script>document.getElementById('calc').setAttribute('style','display: block')</script>";
                }
            ?>
            <br><br><br>
            <h2>Przelicznik wybranej waluty na PLN:</h2>
            <form action="index.php" method="get">
                <label>Podaj kwotę jaką chcesz przeliczyć: </label>
                <input type="number" name="kwota1" min="0" step="0.01" required>
                <label>Wybierz walute:</label>
                    <?php
                        echo "<select name='kod1'>";
                        foreach($tab as $x){
                            echo "<option>".$x[1]."</option>";
                        }
                        echo "</select><br>";
                    ?>
                <input type="submit" name="calc2" value="Wyświetl">
            </form>
                    
                <?php
                    if(isset($_GET['calc2'])){
                        $kod = $_GET['kod1'];
                        $kwota = $_GET['kwota1'];

                        foreach($tab as $x){
                            if($x[1] == $kod){
                                $kurs = $x[2];
                            };
                        }
                        echo "<p>Obecny kurs dla $kod to: <b>$kurs PLN</b></p><p><b>$kwota $kod</b> to w przeliczeniu <b>".round($kwota*$kurs,2)." PLN</b></p>";
                        echo "<script>document.getElementById('calc').setAttribute('style','display: block')</script>";
                    }
                ?>
            </div>
            <hr>
            <h2 class="lista" onclick="wys('wykresy')">> Wybrane wykresy</h2>
            <div id="wykresy">
                <h3><a href="wykres_eur.php">Wykres kusu euro</a></h3>
                <h3><a href="wykres_gbp.php">Wykres kusu funta</a></h3>
                <h3><a href="wykres_usd.php">Wykres kusu dolara amerykańskiego</a></h3>
            </div>
            <hr>
    </div>
    <?php
        $db->close();
    ?>
</body>
</html>