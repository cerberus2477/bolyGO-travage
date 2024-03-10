<!-- data-csomagid id helyett lehet-e a soroknál? szebb lenne pls cserélje ki aki tudja mi van thx -->

<?php 
    session_start();

    if (isset($_POST["deleteElement"])) {
        unset($_SESSION["kosar"][$_POST["deleteElement"]]);
        unset($_POST["deleteElement"]);
    } 
    else if (isset($_POST["submitted"])) {
        for ($i = 0; $i < count($_SESSION["kosar"]); $i++) {
            $_SESSION["kosar"][$i]["fo"] = $_POST["numOfPeople_".$_SESSION["kosar"][$i]["id"]];
            if ($_SESSION["kosar"][$i]["fo"] == 0) {
                unset($_SESSION["kosar"][$i]);
                $_SESSION["kosar"] = array_values($_SESSION["kosar"]);
            }
        }
        unset($_POST["submitted"]);
        header('Location: ./reserve.php');
        die();
    }
?>

<script>
    function szamolAr(csomagid, summa=true) {
        let fo = parseInt(document.getElementById("numOfPeople_"+csomagid).value);
        let csomagar = parseInt(document.getElementById("csomagar_"+csomagid).value);
        let jarmuar = parseInt(document.getElementById("minjarmuar_"+csomagid).value);
        let ar = fo*(csomagar + 2*jarmuar)
        document.getElementById("ar_"+csomagid).textContent = ar;
        if (summa) vegosszeg();
    }

    function vegosszeg() {
        let arak =document.querySelectorAll('[id^=ar_]');
        let sum = 0;
        arak.forEach(element => {
            sum += parseInt(element.textContent);
        });
        document.getElementById("total-price").textContent = sum;
    }
</script>

<!DOCTYPE html>
<html lang="hu">
<head>
<meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kosár ✦ bolyGO</title>
    <link rel="shortcut icon favicon" href="styles/img/logo_ikon.png" type="image/x-icon">
    <link rel="stylesheet" href="styles/style.css">
    <!-- <link rel="stylesheet" href="styles/cart.css"> -->
    <script defer src="https://kit.fontawesome.com/af2e246792.js" crossorigin="anonymous"></script>
    <script defer src="./scripts/design.js"></script>
    <script defer src="./scripts/cart.js"></script>
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
        <a class="btn pc-btn btn-auto-hover" href="./index.php">Vissza <i class="fa-solid fa-circle-chevron-left"></i></a>
    </nav>

    <header class="header-cart">
        <div class="header-content">
            <h1>Kosár</h1>
        </div>
    </header>

    <main>
        <!--kiírja a $_SESSION-ből a kosár tartalmát (az emberek száma változtatható)-->
        <form class="items" action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" id="cartform">
            <input type="hidden" name="submitted" value="van">
            <?php foreach ($_SESSION["kosar"] as $key => $item):?> 

                <?php
                    //API meghívása
                    $url = "http://".$_SERVER['HTTP_HOST'].implode("/",array_map('rawurlencode',explode("/",dirname($_SERVER['SCRIPT_NAME'])."/api.php")))."?csomagid=".$item["id"];
                    //@ ignorálja az errorokat, így nem jelenik meg az oldalon. később kezeljük.
                    $raw_data = @file_get_contents($url);
                    $data = json_decode($raw_data, true);
                ?>

                <section class="item" id="line_<?= $item["id"]?>"> 
                    <div class="item-head">
                        <h3><?= $item["nev"]?></h3>
                        <button class="btn delete" name="deleteElement" value="<?=$key?>"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-row">
                        <img src="<?= './styles/csomag_img/'.$item["id"].'.png'?>" alt="<?= $item["nev"].' képe'?>">
                        <div>
                            <p>Helyszín: <?=$data["bolygo"]?></p>
                            <p>Ajánlat tartama: <?=$data["kezdido"]?> - <?=$data["vegido"]?></p>
                            <p>Utasok száma: <input class="quantity" type="number" id="<?="numOfPeople_".$item["id"]?>" name="<?="numOfPeople_".$item["id"]?>" value="<?= $item["fo"]?>" min=0 onchange="szamolAr(<?=$item['id']?>)">

                            <?php
                                $minar = PHP_INT_MAX;
                                foreach ($data["jarmuvek"] as $jarmu) {
                                    if ($jarmu["ar"] < $minar) $minar = $jarmu["ar"];
                                }
                            ?>

                            <input type="hidden" id="csomagar_<?=$item["id"]?>" value="<?=$data["csomagar"]?>">
                            <input type="hidden" id="minjarmuar_<?=$item["id"]?>" value="<?=$minar?>">

                            <p><i>Ár összesen: </i><span class="price" id="ar_<?=$item["id"]?>"></span> kobalttól</p>

                            <script>szamolAr(<?=$item["id"]?>, false)</script>

                            <input type="hidden" name="id" value="<?=$item["id"]?>"></p>
                        </div>
                    </div>
                </section>
            <?php endforeach;?>

        </form>
        <div class="checkout-container">
            <div class="right-content">
                <p>Végösszeg: <span id="total-price"></span> kobalt</p>
                <script>vegosszeg();</script>
                <button class="btn pc-btn icon-btn" onclick="document.getElementById('cartform').submit();">Tovább <i class="fa-solid fa-circle-chevron-right"></i></button>       
            </div>
        </div>
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






