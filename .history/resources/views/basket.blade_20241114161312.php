<x-app-layout>
    <div class="container mt-4">
        <section class="h-100 h-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-7 col-md-10 col-sm-12">
                        <div class="card card-registration" style="border-radius: 15px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    @if (empty($cartItems))
                                    <div class="col text-center p-5">
                                        <h1 class="fw-bold mb-4 text-black">Panier</h1>
                                        <div class="text-center text-white mb-3" style="margin: 50px 0;">Votre panier est vide</div>
                                        <a href="/shop" class="btn btn-outline-secondary mt-3">
                                            <i class="fas fa-long-arrow-alt-left me-2"></i>Retour à la boutique
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-12">
                                        <div class="p-4 rounded-3" style="background-color: #000000;">
                                            <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
                                                <h1 class="fw-bold mb-0 text-white">Panier</h1>
                                                <h6 class="mb-0 text-white">{{ count($cartItems) }} articles</h6>
                                            </div>
                                            <hr class="my-3">

                                            @foreach ($cartItems as $index => $item)
                                            <div class="row mb-4 d-flex justify-content-between align-items-center {{ $index % 2 == 0 ? 'item-even' : 'item-odd' }} py-1">
                                                <div class="col-4 col-sm-3 col-md-2">
                                                    <img src="{{ asset('/img/' . $item['image']) }}" class="img-fluid rounded-3 shadow-sm" alt="{{ $item['name'] }}">
                                                </div>
                                                <div class="col-6 col-sm-4 col-md-3">
                                                    <h6 class="{{ $index % 2 == 0 ? 'text-black' : 'text-white' }} mb-1">{{ $item['name'] }}</h6>
                                                </div>
                                                <div class="col-6 col-sm-4 col-md-2 text-start text-md-end">
                                                    <h6 class="{{ $index % 2 == 0 ? 'text-black' : 'text-white' }} mb-0 item-price" data-item-price="{{ $item['price'] }}">
                                                        € {{ number_format($item['price'] * $item['quantity'], 2) }}
                                                    </h6>
                                                </div>
                                                <div class="col-3 col-sm-2 col-md-2">
                                                    <input type="number" value="{{ $item['quantity'] }}" class="form-control rounded input-quantity" min="1" onchange="changerQuantiter(this)" data-item-price="{{ $item['price'] }}" data-item-id="{{ $item['id'] }}" style="width: 80px;">
                                                </div>
                                                <div class="col-3 col-sm-1 text-end">
                                                    <a href="#!" class="text-muted delete-item-btn" onclick="viderArticlePanier(this)" data-article-id="{{ $item['id'] }}"><i class="fas fa-times"></i></a>
                                                </div>
                                            </div>
                                            @endforeach

                                            <div class="pt-4 d-flex justify-content-between align-items-center flex-wrap">
                                                <button class="btn btn-danger  " onclick="viderPanier()">Vider le panier</button>
                                                <div>
                                                    <h3 class="fw-bold text-white">Total : <span id="totalPrice">€ {{ number_format($totalPrice, 2) }}</span></h3>
                                                </div>
                                            </div>

                                            @if(auth()->check())
                                            <form action="{{ route('passer-commande') }}" method="post" onsubmit="event.preventDefault(); passerCommande();" class="mt-4">
                                                @csrf
                                                <input type="text" class="form-control form-control-lg mb-3" name="adresse_livraison" id="adresse_livraison" placeholder="Adresse de livraison" required>
                                                <button type="submit" id="passCommandButton" class="btn btn-dark btn-block  w-100">Passer la commande</button>
                                            </form>
                                            @else
                                            <p class="text-center text-white mt-3">Connectez-vous pour passer une commande.</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <div id="successMessage" class="alert alert-success text-center mt-3" style="display: none;">
            La commande a été passée avec succès !
        </div>
    </div>

    <script>
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

        function calculerPrixTotal() {
            var itemPrices = document.querySelectorAll('.item-price');
            var totalPrice = Array.from(itemPrices).reduce((sum, itemPrice) => sum + parseFloat(itemPrice.textContent.replace('€ ', '')), 0);
            document.querySelector('#totalPrice').textContent = "€ " + totalPrice.toFixed(2);
        }

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

    @vite(['resources/css/panier.css'])
</x-app-layout>