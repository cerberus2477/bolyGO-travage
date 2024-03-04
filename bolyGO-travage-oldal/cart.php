<?php 
    session_start();
?>
<!DOCTYPE html>
<html lang="hu">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kosár</title>
    <script src="js/cartAPP.js"></script>
    <link rel="stylesheet" href="styles/style.css">
    <link rel="shortcut icon" href="resources/logo.ico" type="image/x-icon">

    
    <style>

    </style>
</head>
<body>

    <header class="header-cart">
        <div class="header-content">
            <h1>Kosár</h1>
        </div>
    </header>


    <nav data-state="closed" data-scrolled="false">
        <div class="nav-elements">
            <a class="logo" href="#">bolyGO</a>
            <a class="btn" href="./index.php">X</a>
        </div>
    </nav>
    
    <main class="main-cart">
        <!--kiírja a $_SESSION-ből a kosár tartalmát (az emberek száma változtatható)-->
        <table>
        <?php $orderNum = 0;?>
        <?php foreach ($_SESSION["kosar"] as $item):?> 
            <?php $orderNum++;?>
            <tr class="lineOfCart" id="line_<?= $item["id"]?>">
                <td class="orderNum"><?= $orderNum?>.</td>
                <td>
                    <p class="name">Csomagnév: <b><?= $item["nev"]?></b></p>
                    <p>Utazók száma: <input type="number" name="<?= "numOfPeople_".$item["id"]?>" value="<?= $item["fo"]?>"><button class="delete" name="deleteElement" value="<?=$item["id"]?>">Töröl</button></p>
                    <input type="hidden" name="id" value="<?=$item["id"]?>">
                </td>
            </tr>
        <?php endforeach ?>
        </table>
    </main>
</body>
    

</html>