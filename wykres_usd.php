<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">   
    <title>Wykres Euro</title>
    <link rel="stylesheet" href="styl2.css">
</head>
<body>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.9.4/Chart.js">
    </script>
    <?php
        $db = new mysqli('localhost','root','','kantor');
    ?>
    <div id="baner">
        <h1>Internetowy kantor walutowy</h1>
    </div>
    <div id="main">
        
        <div id="drugi">
            <a href="index.php"><h2 class="lista" style="text-align: left;">> Strona główna</h2></a>
            <p>Kursy z ostatich dni:</p>
            <?php
                $kw = "SELECT data, kurs FROM `usd`;";
                $rezultat = $db->query($kw);
                $daty = array();
                $kursy = array();
                echo "<table><tr><th>waluta</th><th>kurs [zł]</th></tr>";
                foreach($rezultat as $x){
                    array_push($daty,$x['data']);
                    array_push($kursy,$x['kurs']);
                    echo "<tr><td><b>".$x['data']."<b></td><td>".$x['kurs']."</td></tr>";
                }
                echo "</table>";
            ?>
        </div>
        <div id="pierwszy">
            <h2 style="text-align: center;">Wykres przedstawiający kurs Dolara Amerykańskiego w ostatnich dniach:</h2>
            <canvas id="wykres" style="max-width:800px;margin: auto"></canvas>
        </div>
        <script>
            var daty = <?php echo json_encode($daty); ?>;
            var kursy = <?php echo json_encode($kursy); ?>;

            new Chart("wykres", {
              type: "line",
              data: {
                labels: daty,
                datasets: [{
                    fill: false,
                    backgroundColor: "rgba(0,0,0,1.0)",
                    borderColor: "rgba(0,0,0,0.1)",
                    data: kursy
                }]
              },
              options:{
                  legend: {display: false}
              }
            });
        </script>
        
    </div>
    <?php
        $db->close();
    ?>
</body>
</html>