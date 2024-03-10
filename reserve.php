<?php 
    session_start();
    
    if (isset($_POST["submittedForm"])) {
        $message = array();
        foreach ($_SESSION["kosar"] as $elem) {
            $id = $elem["id"];
            
            $ugyfelek = array();
            for ($i = 1; $i <= intval($_POST[$id."_fo"]); $i++) {
                $ugyfelek[] = array(
                    "nev" => $_POST[$id."_utas".$i."_nev"],
                    "lakcim" => $_POST[$id."_utas".$i."_lakcim"],
                    "szul" => $_POST[$id."_utas".$i."_szul"],
                    "nem" => $_POST[$id."_utas".$i."_nem"],
                    "tel" => $_POST[$id."_utas".$i."_tel"],
                    "email" => $_POST[$id."_utas".$i."_email"]
                );
            }
            
            $message[] = array(
                "csomagid" => $id,
                "kezdido" => $_POST[$id."_kezd"],
                "vegido" => $_POST[$id."_vege"],
                "ar" => intval($_POST[$id."_ar"]),
                "ugyfelek" => $ugyfelek
            );
        }

        $dataToSend = json_encode($message, JSON_PRETTY_PRINT);

        $url = "http://".$_SERVER['HTTP_HOST'].implode("/",array_map('rawurlencode',explode("/",dirname($_SERVER['SCRIPT_NAME']))))."/api.php";
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type: application/json',
                'content' => $dataToSend
            )
        );
        $context = stream_context_create($options);

        $response = file_get_contents($url, false, $context);

        $_SESSION["apiresponse"] = $response;

        unset($_POST["submittedForm"]);
        header('Location: ./receipt.php');
        die();
    }
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
        <a class="btn pc-btn btn-auto-hover" href="./cart.php">Vissza <i class="fa-solid fa-circle-chevron-left"></i></a>
    </nav>

    <header class="header-cart">
        <div class="header-content">
            <h1>Foglalás</h1>
        </div>
    </header>

    <main>
        <?php if (isset($_SESSION["kosar"])): ?>
            <form method="post" action="<?=$_SERVER["PHP_SELF"]?>">
                <input type="hidden" name="submittedForm" value="true">
                <?php $orderNum=0;?>
                <?php foreach ($_SESSION["kosar"] as $elem): ?>
                    <?php $orderNum++; ?>
                    <details id="details_<?=$orderNum?>" <?php if ($elem == array_values($_SESSION["kosar"])[0]) echo "open"?>>
                        <summary><?=$orderNum?>. foglalás: <?=$elem["nev"]?></summary>
                        <section>
                                <?php 
                                    //API meghívása
                                    $url = "http://".$_SERVER['HTTP_HOST'].implode("/",array_map('rawurlencode',explode("/",dirname($_SERVER['SCRIPT_NAME'])."/api.php")))."?csomagid=".$elem["id"];
                                    $data = json_decode(file_get_contents($url), true);
                                ?>
                                <h3>Utzazás adatai</h3>
                                <p>Kérjük adja meg az utazás (csomag) adatait.</p>
                                <div class="form-group">
                                    <label for="<?=$elem["id"]?>_kezd">Adja meg a foglalás kezdeti dátumát:</label>
                                    <input onchange='kiszamolAr(<?=$data["csomagar"]?>, <?=$elem["fo"]?>, <?=$elem["id"]?>)' type="date" id="<?=$elem["id"]?>_kezd" name="<?=$elem["id"]?>_kezd" min=<?=$data["kezdido"]?> max="<?=$data["vegido"]?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="<?=$elem["id"]?>_vege">Adja meg a foglalás végének dátumát:</label>
                                    <input onchange='kiszamolAr(<?=$data["csomagar"]?>, <?=$elem["fo"]?>, <?=$elem["id"]?>)' type="date" id="<?=$elem["id"]?>_vege" name="<?=$elem["id"]?>_vege" min=<?=$data["kezdido"]?> max="<?=$data["vegido"]?>" required>
                                </div>
                                <div class="form-group">
                                    <label for="<?=$elem["id"]?>_jarmu">Válassza ki az utazáshoz igénybe venni kívánt járművet:</label>
                                    <select id="<?=$elem["id"]?>_jarmu" onchange='kiszamolAr(<?=$data["csomagar"]?>, <?=$elem["fo"]?>, <?=$elem["id"]?>)'>
                                        <?php foreach ($data["jarmuvek"] as $jarmu):?>
                                            <!--itt a jármű ára a value, mert majd ezzel lesz a teljes fizetendő kiszámolva-->
                                            <option value="<?=$jarmu["ar"]?>"><?=$jarmu["nev"]?> (<?=$jarmu["ar"]?> kobalt/fő, <?=$jarmu["osztaly"]?>. osztály, <?php echo $jarmu["fekvohely"]==1 ? "van" : "nincs"?> fekvőhely)</option>
                                        <?php endforeach;?>
                                    </select>
                                </div>
                                <p id="<?=$elem["id"]?>"  class="price">Nincs elegendő adat az foglalás árának kiszámításához.</p>
                                <input type="hidden" name="<?=$elem["id"]?>_ar" id="<?=$elem["id"]?>_ar" value="0">
                                <h3>Utasok adatai</h3>
                                <p>Kérjük adja meg az utasok szükséges adatait.</p>
                                <input type="hidden" id="<?=$elem["id"]?>_fo" name="<?=$elem["id"]?>_fo" value="<?=$elem["fo"]?>">
                                <?php for ($i = 1; $i <= $elem["fo"]; $i++):?>
                                    <h4><?=$i?>. utas</h4>
                                    <div class="form-group">
                                        <label for="<?=$elem["id"]?>_utas<?=$i?>_nev">Név:</label>
                                        <input required type="text" id="<?=$elem["id"]?>_utas<?=$i?>_nev" name="<?=$elem["id"]?>_utas<?=$i?>_nev">
                                    </div>
                                    <div class="form-group">
                                        <label for="<?=$elem["id"]?>_utas<?=$i?>_lakcim">Lakcím:</label>
                                        <input required type="text" id="<?=$elem["id"]?>_utas<?=$i?>_lakcim" name="<?=$elem["id"]?>_utas<?=$i?>_lakcim">
                                    </div>
                                    <div class="form-group">
                                        <label for="name">Születési dátum:</label>
                                        <input required type="date" id="<?=$elem["id"]?>_utas<?=$i?>_szul" name="<?=$elem["id"]?>_utas<?=$i?>_szul">
                                    </div>
                                    <div class="form-group">
                                        <label for="<?=$elem["id"]?>_utas<?=$i?>_nem">Nem:</label>
                                        <input required type="text" id="<?=$elem["id"]?>_utas<?=$i?>_nem" name="<?=$elem["id"]?>_utas<?=$i?>_nem">
                                    </div>
                                    <div class="form-group">
                                        <label for="<?=$elem["id"]?>_utas<?=$i?>_nem">Telefon:</label>
                                        <input required type="tel" id="<?=$elem["id"]?>_utas<?=$i?>_tel" name="<?=$elem["id"]?>_utas<?=$i?>_tel">
                                    </div>
                                    <div class="form-group">
                                        <label for="<?=$elem["id"]?>_utas<?=$i?>_nem">E-mail:</label>
                                        <input required type="email" id="<?=$elem["id"]?>_utas<?=$i?>_email" name="<?=$elem["id"]?>_utas<?=$i?>_email">
                                    </div>
                                <?php endfor;?>
                            <?php if ($elem != end($_SESSION["kosar"])):?>
                            <button class="btn" type="button" onclick='changeDetails(<?=$orderNum?>, <?=$orderNum+1?>)'>Következő foglalás <i class="fa-solid fa-circle-chevron-down"></i></button>
                            <?php endif;?>
                        </section>
                    </details>
                <?php endforeach; ?>
                <button class="btn" type="submit">Foglalás véglegesítése</button>
            </form>
        <?php else: ?>
            <p>Még nem tett semmit a kosárba. <a href="index.php">Ide kattintva</a> teheti ezt meg.</p>
        <?php endif; ?>
    </main>
    <footer class="dark-blur">
        <section>
            <h3>Nav</h3>
            <a href="#csomagok">Csomagok</a>
            <a href="#rolunk">Rólunk</a>
            <a href="#kapcsolat">Kapcsolat</a>
            <a class="btn pc-btn btn-auto-hover" href="./cart.php">Kosár <i class="fa-solid fa-cart-shopping"></i></a>
        </section>
        <section>
            <h3>Forduljon hozzánk bizalommal!</h3>
            <ul>
                <li>Tel: +369696969 <i class="fa fa-mobile"></i></li>
                <li>meoww <i class="fa fa-cat"></i></li>
                <li>cicákat akarok most ide most gimme <i class="fa fa-cat"></i></li>
            </ul>
        </section>
        <section>
            <h3>Telephelyünk <i class="fa-solid fa-map-location-dot"></i></h3>
            <div class="maps-container">
                <iframe width="100%" height="100%"
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2706.7356574234536!2d19.23691240392388!3d47.28042171934365!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741930014fc0d9b%3A0x195b02a0b1e91634!2sMacskalapos!5e0!3m2!1sen!2sus!4v1709628639614!5m2!1sen!2sus"
                    frameborder="0" scrolling="no" marginheight="0" marginwidth="0">
                </iframe>
            </div>
        </section>
    </footer>
</body>
</html>
