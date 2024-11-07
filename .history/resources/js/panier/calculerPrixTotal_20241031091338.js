function calculerPrixTotal() {
    var itemPrices = document.querySelectorAll('.item-price');
    var totalPrice = Array.from(itemPrices).reduce((sum, itemPrice) => sum + parseFloat(itemPrice.textContent.replace('€ ', '')), 0);
    document.querySelector('#totalPrice').textContent = "€ " + totalPrice.toFixed(2);
}