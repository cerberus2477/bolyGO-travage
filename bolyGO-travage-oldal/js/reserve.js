
/*function sendTravelData() {
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
}*/

function kiszamolAr(csomagar, fo, csomagid) {
    let kezdes = new Date(document.getElementById(csomagid + "_kezd").value);
    let vege = new Date(document.getElementById(csomagid + "_vege").value);
    let kulonbseg = vege.getTime() - kezdes.getTime();
    let napok = kulonbseg / (1000*3600*24);
    console.log(napok);
    let osszeg = napok*fo*csomagar + parseInt(document.getElementById(csomagid+"_jarmu").value)*fo*2;
    if (isFinite(osszeg)) document.getElementById(csomagid).innerText = "Ezen foglalásért fizetendő: " + osszeg + " kobalt.";
    else document.getElementById(csomagid).innerText = "Nincs elegendő adat az foglalás árának kiszámításához.";
}
