<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>bolyGO-adatok megadása</title>
</head>
<body>
    <!-- here goes the nav -->
    <?php foreach ($_SESSION["kosar"] as $item) ?>
        <details>
            <summary><?$item[2]?></summary>
            <!-- utazással kapcsolatos data -->
            

            <!-- minden ügyflnek megkérzezi az adatait -->
            <?PHP for ($i=0; $i < $item[3]; $i++) ?>
                <!-- ügyfél adatai -->
                <?$item[3][$i]?>
            <?php endfor?>
        </details>
    <?php endforeach?>
</body>
</html>