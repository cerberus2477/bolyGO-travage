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
        function sendTravelData() {
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
        }
    </script>
</head>
<body>
    <!-- here goes the nav -->
    <?php if (isset($_SESSION["kosar"])): ?>
        <?php foreach ($_SESSION["kosar"] as $item): ?>
            <details>
                <summary><?php echo isset($item[2]) ? $item[2] : "Nincs elérhető cím"; ?></summary>
                <!-- utazással kapcsolatos data -->
                <form onsubmit="event.preventDefault(); sendTravelData();">
                    <label for="departureCity">Departure City:</label>
                    <input type="text" id="departureCity" name="departureCity" required>
                    
                    <label for="destinationCity">Destination City:</label>
                    <input type="text" id="destinationCity" name="destinationCity" required>
                    
                    <label for="travelDate">Travel Date:</label>
                    <input type="date" id="travelDate" name="travelDate" required>
                    
                    <button type="submit">Submit</button>
                </form>
                <!-- Assuming $item[3] contains a list of customer data, corrected the loop structure -->
                <?php if (isset($item[3]) && is_array($item[3])): ?>
                    <?php foreach ($item[3] as $customerData): ?>
                        <!-- ügyfél adatai -->
                        <?php echo $customerData; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Nincs ügyél megadva</p>
                <?php endif; ?>
            </details>
        <?php endforeach; ?>
    <?php else: ?>
        <p>Még nem ettél semmit a bevásárlókocsidba <a href="index.php">ide kattintva</a> teheted ezt meg</p>
    <?php endif; ?>
</body>
</html>
