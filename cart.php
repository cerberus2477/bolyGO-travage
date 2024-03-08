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
    <link rel="shortcut icon favicon" href="styles/img/logo.ico" type="image/x-icon">
    <link rel="stylesheet" href="styles/style.css">
    <link rel="stylesheet" href="styles/cart.css">
    <script defer src="https://kit.fontawesome.com/af2e246792.js" crossorigin="anonymous"></script>
    <script defer src="./js/design.js"></script>
    <script defer src="./js/cart.js"></script>
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
            <h1>Kosár</h1>
        </div>
    </header>

    <main>
        <!--kiírja a $_SESSION-ből a kosár tartalmát (az emberek száma változtatható)-->
        <form action="<?php echo $_SERVER["PHP_SELF"]?>" method="post" id="cartform">
            <table>
            <?php $orderNum = 0;?>
            <input type="hidden" name="submitted" value="van">
            <?php foreach ($_SESSION["kosar"] as $item):?> 
                <?php $orderNum++;?>
                <tr class="lineOfCart" id="line_<?= $item["id"]?>">
                    <td class="orderNum"><?= $orderNum?>.</td>
                    <td>
                        <p class="name">Csomagnév: <b><?= $item["nev"]?></b></p>
                        <p>Utazók száma: <input type="number" name="<?="numOfPeople_".$item["id"]?>" value="<?= $item["fo"]?>" min=0><button class="delete" name="deleteElement" value="<?=$item["id"]?>">Töröl</button>
                        <input type="hidden" name="id" value="<?=$item["id"]?>"></p>
                    </td>
                </tr>
            <?php endforeach;?>
            </table>
            <a class="btn pc-btn icon-btn" onclick="document.getElementById('cartform').submit();">Foglalási adatok kitöltése <i class="fa-solid fa-circle-chevron-right"></i></i></a>
        </form>
        <!-- <div class="cart-items">
        <?php foreach ($items as $item):?>
            <div class="item">
                <img class="big-card-img" src="<?= './styles/csomag_img/'.$item["id"].'.png'?>" alt="<?= $item["nev"].' képe'?>">
                <div class="details">
                    <h2><?=$item["name"]?></h2>
                    <p><?=$item["description"]?></p>
                    <p><?=$item["price"]?></p>
                    <p>total price: </p>
                </div>
                <div class="actions">
                    <input type="number" class="quantity" value="1" min="1">
                    <button class="delete">Delete</button>
                </div>
            </div>
        <?php endforeach;?>
        <div id="total-price">Grand Total: $0.00</div>  -->
    </div>        
    </main>

</body>
    

</html>






