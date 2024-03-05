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
                        $data = json_decode(file_get_contents($url), true);
                    ?>
                    <p>Helyszín: <?=$data["bolygo"]?></p>
                    <p>Ajánlat tartama: <?=$data["kezdido"]?> - <?=$data["vegido"]?></p>
                    <p>Adja meg a foglalás kezdeti dátumát: <input type="date" name="<?=$elem["id"]?>_kezd" min=<?=$data["kezdido"]?> max="<?=$data["vegido"]?>" required></p>
                    <p>Adja meg a foglalás végének dátumát: <input type="date" name="<?=$elem["id"]?>_vege" min=<?=$data["kezdido"]?> max="<?=$data["vegido"]?>" required></p>
                    <p>
                        Válassza ki az utazáshoz igénybe venni kívánt járművet:
                        <select name="<?=$elem["id"]?>_jarmu">
                            <?php foreach ($data["jarmuvek"] as $jarmu):?>
                                <!--itt a jármű ára a value, mert majd ezzel lesz a teljes fizetendő kiszámolva-->
                                <option value="<?=$jarmu["ar"]?>"><?=$jarmu["nev"]?> (<?=$jarmu["ar"]?> kobalt/fő, <?=$jarmu["osztaly"]?>. osztály, <?php echo $jarmu["fekvohely"]==1 ? "van" : "nincs"?> fekvőhely)</option>
                            <?php endforeach;?>
                        </select>
                    </p>
                </form>
            </details>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Még nem tett semmit a kosárba. <a href="index.php">Ide kattintva</a> teheti ezt meg.</p>
    <?php endif; ?>
</body>
</html>
