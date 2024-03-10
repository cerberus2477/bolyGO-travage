<!-- data-csomagid id helyett lehet-e a soroknál? szebb lenne pls cserélje ki aki tudja mi van thx -->

<?php 
    session_start();

    if (isset($_POST["deleteElement"])) {
        $i = 0;
        while ($i < count($_SESSION["kosar"]) && $_SESSION["kosar"][$i]["id"] != $_POST["deleteElement"]) $i++;
        if ($i < count($_SESSION["kosar"])) {
            unset($_SESSION["kosar"][$i]);
            $_SESSION["kosar"] = array_values($_SESSION["kosar"]);
        }
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
            print_r($_SESSION["kosar"]);
        die();
    }
?>

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
            <!-- <?php $orderNum = 0;?> -->
            <input type="hidden" name="submitted" value="van">

            <?php foreach ($_SESSION["kosar"] as $item):?> 
                <!-- <?php $orderNum++;?> -->
                <!-- <?=var_dump($item)?> -->
                <section class="item" id="line_<?= $item["id"]?>"> 
                    <div class="item-head">
                        <h3><?= $item["nev"]?></h3>
                        <button class="btn delete" name="deleteElement" value="<?=$item["id"]?>"><i class="fa-solid fa-trash"></i></button>
                    </div>
                    <div class="item-row">
                        <img src="<?= './styles/csomag_img/'.$item["id"].'.png'?>" alt="<?= $item["nev"].' képe'?>">
                        <div>
                            <!-- <p class="orderNum"><?= $orderNum?>.</p> -->
                            <p>Helyszín: <?=$item["bolygo"]?></p>
                            <p>Ajánlat tartama: <?=$item["kezdido"]?> - <?=$item["vegido"]?></p>
                            <p>Utasok száma: <input class="quantity" type="number" name="<?="numOfPeople_".$item["id"]?>" value="<?= $item["fo"]?>" min=0>
                            <!-- <p class="name"><b>Ár összesen: <span><?= $item["ar"] * $item["fo"]?></span>-től</p> -->
                            <p><i>Ár összesen: <span class="price"><?=$item["fo"]?></span>-től</i></p>

                            <input type="hidden" name="id" value="<?=$item["id"]?>"></p>
                        </div>
                    </div>
                </section>
            <?php endforeach;?>

        </form>
        <div class="checkout-container">
            <div class="right-content">
                <p>Végösszeg: <span id="total-price"></span></p>
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






