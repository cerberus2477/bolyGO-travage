<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kosár</title>
    <script src="js/cartAPP.js"></script>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="styles/img/logo_ikon.png" type="image/x-icon">
</head>
<body>
    <header>
        <a href="index.php">
            <img src="logo_ikon.png" alt="logo">
            <p>bolyGO</p>
        </a>
    </header>
    <main>
        <!--kiírja a $_SESSION-ből a kosár tartalmát (az emberek száma változtatható)-->
        <?PHP foreach ($_SESSION["kosar"] as $item):?> 
                <div class="lineOfCart" id="line<?$item[1]?>">
                    <p class="orderNum"><?$item[0]?></p>
                    <p class="name"><?$item[2]?></p>
                    <input type="number" name="<?"numOfPeople".$item[0]?>" id="<?"numOfPeople".$item[0]?>" value="<?$item[3]?>">
                    <button class="delete" onclick="del(<?$item[1]?>)">törlés</button>
                </div>
        <?php endforeach ?>

    </main>
</body>
    

</html>