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
    <?php if (isset($_SESSION["kosar"])): ?>
        <?php foreach ($_SESSION["kosar"] as $item): ?>
            <details>
                <summary><?php echo isset($item[2]) ? $item[2] : "No title available"; ?></summary>
                <!-- utazással kapcsolatos data -->
                <!-- Assuming $item[3] contains a list of customer data, corrected the loop structure -->
                <?php if (isset($item[3]) && is_array($item[3])): ?>
                    <?php foreach ($item[3] as $customerData): ?>
                        <!-- ügyfél adatai -->
                        <?php echo $customerData; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No customer data available.</p>
                <?php endif; ?>
            </details>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Még nem ettél semmit a bevásárlókocsidba <a href="index.php">ide kattintva</a> teheted ezt meg</p>
    <?php endif; ?>
</body>
</html>
