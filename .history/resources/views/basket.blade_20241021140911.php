<x-app-layout>
    <div class="container mt-4 ">
    <section class="h-100 gradient-custom">
  <div class="container py-5">
    <div class="row d-flex justify-content-center my-4">
      <div class="col-md-8">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Cart - {{ $basket->count() }} items</h5>
          </div>
          <div class="card-body">
            <!-- Loop through basket items -->
            @foreach($basket as $item)
            <div class="row">
              <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                <!-- Image -->
                <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                  <img src="{{ $item->image_url }}" class="w-100" alt="{{ $item->name }}" />
                  <a href="#!">
                    <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                  </a>
                </div>
              </div>

              <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                <!-- Data -->
                <p><strong>{{ $item->name }}</strong></p>
                <p>Color: {{ $item->color }}</p>
                <p>Size: {{ $item->size }}</p>
                <form action="{{ route('basket.remove', $item->id) }}" method="POST">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-primary btn-sm me-1 mb-2" title="Remove item">
                    <i class="fas fa-trash"></i>
                  </button>
                </form>
                <form action="{{ route('wishlist.move', $item->id) }}" method="POST">
                  @csrf
                  <button type="submit" class="btn btn-danger btn-sm mb-2" title="Move to wishlist">
                    <i class="fas fa-heart"></i>
                  </button>
                </form>
              </div>

              <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                <!-- Quantity -->
                <form action="{{ route('basket.update', $item->id) }}" method="POST">
                  @csrf
                  @method('PUT')
                  <div class="d-flex mb-4" style="max-width: 300px">
                    <button class="btn btn-primary px-3 me-2" onclick="this.parentNode.querySelector('input[type=number]').stepDown()">
                      <i class="fas fa-minus"></i>
                    </button>

                    <div class="form-outline">
                      <input id="form1" min="0" name="quantity" value="{{ $item->quantity }}" type="number" class="form-control" />
                      <label class="form-label" for="form1">Quantity</label>
                    </div>

                    <button class="btn btn-primary px-3 ms-2" onclick="this.parentNode.querySelector('input[type=number]').stepUp()">
                      <i class="fas fa-plus"></i>
                    </button>
                  </div>
                  <button type="submit" class="btn btn-success">Update</button>
                </form>
                <!-- Price -->
                <p class="text-start text-md-center">
                  <strong>${{ $item->price }}</strong>
                </p>
              </div>
            </div>

            <hr class="my-4" />
            @endforeach
            <!-- End loop through basket items -->
          </div>
        </div>

        <!-- Shipping info -->
        <div class="card mb-4">
          <div class="card-body">
            <p><strong>Expected shipping delivery</strong></p>
            <p class="mb-0">{{ $shipping_date_start }} - {{ $shipping_date_end }}</p>
          </div>
        </div>

        <!-- Payment info -->
        <div class="card mb-4 mb-lg-0">
          <div class="card-body">
            <p><strong>We accept</strong></p>
            <img class="me-2" width="45px" src="visa_image_url" alt="Visa" />
            <img class="me-2" width="45px" src="amex_image_url" alt="American Express" />
            <img class="me-2" width="45px" src="mastercard_image_url" alt="Mastercard" />
            <img class="me-2" width="45px" src="paypal_image_url" alt="PayPal" />
          </div>
        </div>
      </div>

      <!-- Summary -->
      <div class="col-md-4">
        <div class="card mb-4">
          <div class="card-header py-3">
            <h5 class="mb-0">Summary</h5>
          </div>
          <div class="card-body">
            <ul class="list-group list-group-flush">
              <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 pb-0">
                Products
                <span>${{ $total_price }}</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                Shipping
                <span>Free</span>
              </li>
              <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0 mb-3">
                <div>
                  <strong>Total amount</strong>
                  <p class="mb-0">(including VAT)</p>
                </div>
                <span><strong>${{ $total_price }}</strong></span>
              </li>
            </ul>
            <a href="{{ route('checkout') }}" class="btn btn-primary btn-lg btn-block">Go to checkout</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

        <div id="successMessage" class="alert alert-success" style="display: none;">
            La commande a été passée avec succès !
        </div>
    </div>

    <script>
        function viderPanier() {
            fetch('/vider-panier', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    location.reload();
                })
                .catch(error => {
                    console.error('Erreur lors de la suppression du panier :', error);
                });
        }

        function viderArticlePanier(button) {
            var articleId = button.getAttribute('data-article-id');

            fetch('{{ route("vider-article-panier") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        article_id: articleId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    alert(data.message);
                    if (!data.error) {
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la suppression de l\'article :', error);
                });
        }

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
                input.value = 1; // Default to 1 if invalid
            }
        }

        function calculerPrixTotal() {
            var itemPrices = document.querySelectorAll('.item-price');
            var totalPrice = Array.from(itemPrices).reduce((sum, itemPrice) => sum + parseFloat(itemPrice.textContent.replace('€ ', '')), 0);
            document.querySelector('#totalPrice').textContent = "€ " + totalPrice.toFixed(2);
        }

        function passerCommande() {
            const adresseLivraison = document.getElementById('adresse_livraison').value;

            fetch('{{ route("passer-commande") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        adresse_livraison: adresseLivraison
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.error) {
                        alert(data.message);
                        viderPanier();
                    } else {
                        alert(data.message || 'Une erreur est survenue.');
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la commande :', error);
                    alert('Une erreur est survenue lors du passage de la commande.');
                });
        }
    </script>
</x-app-layout>