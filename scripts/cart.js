function del(num){
    const element=document.getElementById("line"+num);
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





// ez állítaná a mennyiséget
document.addEventListener("DOMContentLoaded", function() {
    const deleteButtons = document.querySelectorAll(".delete");
    const quantityInputs = document.querySelectorAll(".quantity");
    const totalPriceElement = document.getElementById("total-price"); 

    deleteButtons.forEach(button => {
        button.addEventListener("click", function() {
            const item = button.closest(".item");
            item.remove();
            updateTotal();
        });
    });

    quantityInputs.forEach(input => {
        input.addEventListener("input", function() {
            updateTotal();
        });
    });

    function updateTotal() {
        let totalPrice = 0;
        const items = document.querySelectorAll(".item");

        items.forEach(item => {
            const price = parseFloat(item.querySelector("p:last-child").textContent.replace("$", ""));
            const quantity = parseInt(item.querySelector(".quantity").value);
            const itemTotal = price * quantity;
            item.querySelector(".item-total").textContent = "$" + itemTotal.toFixed(2); // Update item total
            totalPrice += itemTotal;
        });

        totalPriceElement.textContent = "$" + totalPrice.toFixed(2); // Update total price
    }

    updateTotal(); // Call updateTotal initially
});

