<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bolyGO-adatok megadása</title>
    <script>
        /*function sendTravelData() {
            const departureCity = document.getElementById('departureCity').value;
            const destinationCity = document.getElementById('destinationCity').value;
            const travelDate = document.getElementById('travelDate').value;
            
            fetch('../backend/api.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    kezdido
                    vegido
                    ugyfelnev
                    lakcim
                    szul
                    nem
                    tel
                    email
                }),
            })
            .then(response => response.json())
            .then(data => console.log(data))
            .catch((error) => console.error('Error:', error));
        }*/
    </script>
</head>
<body>
    <!-- here goes the nav -->
    <?php if (isset($_SESSION["kosar"])): ?>
        <?php $orderNum=0;?>
        <?php foreach ($_SESSION["kosar"] as $elem): ?>
            <?php $orderNum++; ?>
            <details>
                <summary><?=$orderNum?>. foglalás: <?=$elem["nev"]?></summary>
                <form onsubmit="event.preventDefault(); Folytat(<?=$orderNum?>);">
                    <?php 
                    //API meghívása
                    $url = "http://".$_SERVER['HTTP_HOST'].implode("/",array_map('rawurlencode',explode("/",dirname($_SERVER['SCRIPT_NAME'])."/api.php")))."?csomagid=".$elem["id"];
                    /*$options = array(
                        'http' => array(
                            'method' => 'GET',
                            'header' => 'Content-Type: application/json'
                        )
                    );
                    $context = stream_context_create($options);*/
                    //$data = json_decode(file_get_contents($url, false, $context), true);
                    $data = json_decode(file_get_contents($url), true);
                    ?>
                    <p><?php print_r($data)?></p>
                </form>
            </details>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Még nem ettél semmit a bevásárlókocsidba <a href="index.php">ide kattintva</a> teheted ezt meg</p>
    <?php endif; ?>
</body>
</html>
