function del(num){
    const element=document.getElementById("item"+num);
    element.remove();
}

// EZT HASZNÁLJUK??
//rövid kártyára kattintáskor lekéri az adott csomag id-jét a html-ből
document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.querySelectorAll(".details-button");
    buttons.forEach(function(button) {
        button.addEventListener("click", function() {
            var card = this.closest(".card");
            var csomagid = card.getAttribute("data-csomagid");
            console.log(csomagid);
        });
    });
});


function szamolAr(csomagid, summa = true) {
    let fo = parseInt(document.getElementById("numOfPeople_" + csomagid).value);
    let csomagar = parseInt(document.getElementById("csomagar_" + csomagid).value);
    let jarmuar = parseInt(document.getElementById("minjarmuar_" + csomagid).value);
    let ar = fo * (csomagar + 2 * jarmuar)
    document.getElementById("ar_" + csomagid).textContent = ar;
    if (summa) vegosszeg();
}

function vegosszeg() {
    let arak = document.querySelectorAll('[id^=ar_]');
    let sum = 0;
    arak.forEach(element => {
        sum += parseInt(element.textContent);
    });
    document.getElementById("total-price").textContent = sum;
}
