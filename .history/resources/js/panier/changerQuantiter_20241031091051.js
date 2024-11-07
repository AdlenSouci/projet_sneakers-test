function changerQuantiter(input) {
    var newQuantity = parseInt(input.value);
    var pricePerItem = parseFloat(input.getAttribute("data-item-price"));

    if (!isNaN(newQuantity) && newQuantity > 0) {
        var itemPriceElement = input.closest('.row').querySelector(".item-price");

        if (itemPriceElement) {
            var newTotal = newQuantity * pricePerItem;
            itemPriceElement.textContent = "€ " + newTotal.toFixed(2);
            calculerPrixTotal();
        }
    } else {
        input.value = 1; 
    }
}
