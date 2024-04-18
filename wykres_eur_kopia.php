<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">   
    <title>Wykres Euro</title>
    <link rel="stylesheet" href="styl.css">
</head>
<body>
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
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
        <h2>Wykres przedstawiający kurs euro w ostatnich dniach:</h2>
        <div id="wykres" style="width:100%;max-width:800px;margin:auto"></div>
        <?php     
            $kw = "SELECT data, kurs FROM `eur`;";
            $rezultat = $db->query($kw);
            $daty = array();
            $kursy = array();
            foreach($rezultat as $x){
                array_push($daty,$x['data']);
                array_push($kursy,$x['kurs']);
            }
        ?>
        <script>
            var daty = <?php echo json_encode($daty); ?>;
            var kursy = <?php echo json_encode($kursy); ?>;
            
            var data = [{
            x: daty,
            y: kursy,
            mode:"lines"
            }];

            var layout = {
              xaxis: {range: daty, title: "Daty"},
              yaxis: {range: kursy, title: "Kurs"},  
              title: "Kursy w dniach"
            };

            Plotly.newPlot("wykres", data, layout);
        </script>
        
    </div>
    
    <div id="stopka">
        <p>Przygotował: Jakub Glazik</p>
    </div>
    <?php
        $db->close();
    ?>
</body>
</html>