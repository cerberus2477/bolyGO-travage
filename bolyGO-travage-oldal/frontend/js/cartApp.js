function del(num){
    const element=document.getElementById("line"+num);
    element.remove();
}


//rövid kártyára kattintáskor lekéri az adott csomag id-jét a html-ből
document.addEventListener("DOMContentLoaded", function() {
    var buttons = document.querySelectorAll(".details-button");
    buttons.forEach(function(button) {
        button.addEventListener("click", function() {
            var card = this.closest(".card");
            var csomagid = card.getAttribute("data-csomagid");
            // Pass the csomagid to your JavaScript function
            // For example: myFunction(csomagid);
            console.log(csomagid);
        });
    });
});