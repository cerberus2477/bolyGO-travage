<?php 
    session_start();
    print_r($_SESSION["kosar"]);
?>
<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Foglalás ✦ bolyGO</title>
    <link rel="shortcut icon favicon" href="styles/img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/reserve.css">
    <script defer src="https://kit.fontawesome.com/af2e246792.js" crossorigin="anonymous"></script>
    <script defer src="./scripts/design.js"></script>
    <script defer src="./scripts/reserve.js"></script>
</head>
</head>
<body>

    <nav data-state="closed" data-scrolled="false">
        <div class="nav-first-row">
            <img class="logo" src="styles/img/logo_transparent.png" alt="bolyGO logo">
            <a href="./cart.php" class="btn mobile-btn" ><i class="fa-solid fa-cart-shopping"></i></a>
            <a href="#" class="btn btn-dark mobile-btn" onclick="toggleNav();"><i class="fa fa-bars"></i></a>
        </div>
      
        <a class="navlink" href="index.php#csomagok" data-active="true">Csomagok</a>
        <a class="navlink" href="index.php#rolunk">Rólunk</a>
        <a class="navlink" href="index.php#kapcsolat">Kapcsolat</a>
        <a class="btn pc-btn btn-auto-hover" href="./cart.php">Kosár <i class="fa-solid fa-cart-shopping"></i></a>
    </nav>

    <header class="header-cart">
        <div class="header-content">
            <h1>Foglalás</h1>
        </div>
    </header>

    <main>
        <?php if (isset($_SESSION["kosar"])): ?>
            <?php $orderNum=0;?>
            <?php foreach ($_SESSION["kosar"] as $elem): ?>
                <?php $orderNum++; ?>
                <details id="details_<?=$orderNum?>">
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
                        <h1>Utazók adatainak megadása</h1>
                        <input type="hidden" id="<?=$elem["id"]?>_fo" value="<?=$elem["fo"]?>">
                        <?php for ($i = 1; $i <= $elem["fo"]; $i++):?>
                            <p><?=$i?>. utazó</p>
                            <p>Név: <input required type="text" id="<?=$elem["id"]?>_utas<?=$i?>_nev"></p>
                            <p>Lakcím: <input required type="text" id="<?=$elem["id"]?>_utas<?=$i?>_lakcim"></p>
                            <p>Szül. dátum: <input required type="date" id="<?=$elem["id"]?>_utas<?=$i?>_szul"></p>
                            <p>Nem: <input required type="text" id="<?=$elem["id"]?>_utas<?=$i?>_nem"></p>
                            <p>Telefonszám: <input required type="tel" id="<?=$elem["id"]?>_utas<?=$i?>_tel"></p>
                            <p>Email-cím: <input required type="email" id="<?=$elem["id"]?>_utas<?=$i?>_email"></p>
                        <?php endfor;?>
                        <p><button type="button" onclick='changeDetails(<?=$orderNum?>, <?=$orderNum+1?>)'>Következő foglalás</button></p>
                    </form>
                </details>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Még nem tett semmit a kosárba. <a href="index.php">Ide kattintva</a> teheti ezt meg.</p>
        <?php endif; ?>
    </main>
</body>
</html>
