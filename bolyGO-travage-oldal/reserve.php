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

        function kiszamolAr(csomagar, fo, csomagid) {
            let kezdes = new Date(document.getElementById(csomagid + "_kezd").value);
            let vege = new Date(document.getElementById(csomagid + "_vege").value);
            let kulonbseg = vege.getTime() - kezdes.getTime();
            let napok = kulonbseg / (1000*3600*24);
            console.log(napok);
            let osszeg = napok*fo*csomagar + parseInt(document.getElementById(csomagid+"_jarmu").value)*fo*2;
            if (isFinite(osszeg)) document.getElementById(csomagid).innerText = "Ezen foglalásért fizetendő: " + osszeg + " kobalt.";
            else document.getElementById(csomagid).innerText = "Nincs elegendő adat az foglalás árának kiszámításához.";
        }
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
                    <p>Adja meg a foglalás kezdeti dátumát: <input onchange='kiszamolAr(<?=$data["csomagar"]?>, <?=$elem["fo"]?>, <?=$elem["id"]?>)' type="date" id="<?=$elem["id"]?>_kezd" min=<?=$data["kezdido"]?> max="<?=$data["vegido"]?>" required></p>
                    <p>Adja meg a foglalás végének dátumát: <input onchange='kiszamolAr(<?=$data["csomagar"]?>, <?=$elem["fo"]?>, <?=$elem["id"]?>)' type="date" id="<?=$elem["id"]?>_vege" min=<?=$data["kezdido"]?> max="<?=$data["vegido"]?>" required></p>
                    <p>
                        Válassza ki az utazáshoz igénybe venni kívánt járművet:
                        <select id="<?=$elem["id"]?>_jarmu" onchange='kiszamolAr(<?=$data["csomagar"]?>, <?=$elem["fo"]?>, <?=$elem["id"]?>)'>
                            <?php foreach ($data["jarmuvek"] as $jarmu):?>
                                <!--itt a jármű ára a value, mert majd ezzel lesz a teljes fizetendő kiszámolva-->
                                <option value="<?=$jarmu["ar"]?>"><?=$jarmu["nev"]?> (<?=$jarmu["ar"]?> kobalt/fő, <?=$jarmu["osztaly"]?>. osztály, <?php echo $jarmu["fekvohely"]==1 ? "van" : "nincs"?> fekvőhely)</option>
                            <?php endforeach;?>
                        </select>
                    </p>
                    <p id="<?=$elem["id"]?>">Nincs elegendő adat az foglalás árának kiszámításához.</p>
                </form>
            </details>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Még nem tett semmit a kosárba. <a href="index.php">Ide kattintva</a> teheti ezt meg.</p>
    <?php endif; ?>
</body>
</html>
