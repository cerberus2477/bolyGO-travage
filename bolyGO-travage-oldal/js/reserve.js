function kiszamolAr(csomagar, fo, csomagid) {
    let kezdes = new Date(document.getElementById(csomagid + "_kezd").value);
    let vege = new Date(document.getElementById(csomagid + "_vege").value);
    let kulonbseg = vege.getTime() - kezdes.getTime();
    let napok = kulonbseg / (1000*3600*24);
    let osszeg = napok*fo*csomagar + parseInt(document.getElementById(csomagid+"_jarmu").value)*fo*2;
    if (isFinite(osszeg)) document.getElementById(csomagid).innerText = "Ezen foglalásért fizetendő: " + osszeg + " kobalt.";
    else document.getElementById(csomagid).innerText = "Nincs elegendő adat az foglalás árának kiszámításához.";
}

function closedetails(sorszam) {
    document.getElementById('details_'+sorszam).open = false;
}

function opendetails(sorszam) {
    document.getElementById('details_'+sorszam).open = true;
}

function changeDetails(from, to) {
    closedetails(from);
    opendetails(to);
}