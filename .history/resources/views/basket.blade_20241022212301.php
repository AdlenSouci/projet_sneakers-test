<x-app-layout>
    <div class="container mt-4 ">
        <section class="h-100 h-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-7">
                        <div class="card card-registration card-registration-2" style="border-radius: 15px;">
                            <div class="card-body p-0 custom-container-basket-shadow">
                                <div class="row g-0">
                                    @if (empty($cartItems))
                                    <div class="col mb-5 custom-col ">
                                        <div class="col-lg-15 ">
                                            <div class="p-10">
                                                <div class="d-flex justify-content-between align-items-center mb-5">
                                                    <h6 class="mb-0">
                                                        <a href="/shop" class="text-body">
                                                            <i class="fas fa-long-arrow-alt-left me-2"></i>Retour à la boutique
                                                        </a>
                                                    </h6>
                                                    <h1 class="fw-bold mb-0 text-black">Panier</h1>
                                                </div>
                                                <div class="text-center" style="margin: 50px 0;">Votre panier est vide</div>
                                            </div>
                                        </div>
                                    </div>
                                    @else
                                    <div class="col-lg-15">
                                        <div class="p-10">
                                            <div class="d-flex justify-content-between align-items-center mb-5">
                                                <h6 class="mb-0">
                                                    <a href="/shop" class="text-body">
                                                        <i class="fas fa-long-arrow-alt-left me-2"></i>Retour à la boutique
                                                    </a>
                                                </h6>
                                                <h1 class="fw-bold mb-0 text-black">Panier</h1>
                                                <h6 class="mb-0 text-muted">{{ count($cartItems) }} articles</h6>
                                            </div>
                                            <hr class="my-4">

                                            @foreach ($cartItems as $item)
                                            <div class="row mb-4 d-flex justify-content-between align-items-center">
                                                <div class="col-lg-3 col-md-12 mb-4 mb-lg-0">
                                                    <div class="bg-image hover-overlay hover-zoom ripple rounded" data-mdb-ripple-color="light">
                                                        <img src="{{ asset('/img/' . $item['image']) }}" class="w-100" alt="{{ $item['name'] }}" />
                                                        <a href="#!">
                                                            <div class="mask" style="background-color: rgba(251, 251, 251, 0.2)"></div>
                                                        </a>
                                                    </div>
                                                </div>

                                                <div class="col-lg-5 col-md-6 mb-4 mb-lg-0">
                                                    <p><strong>{{ $item['name'] }}</strong></p>
                                                    <button type="button" class="btn btn-primary btn-sm me-1 mb-2" onclick="viderArticlePanier(this)" data-article-id="{{ $item['id'] }}">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                    <button type="button" class="btn btn-danger btn-sm mb-2" title="Ajouter à la liste de souhaits">
                                                        <i class="fas fa-heart"></i>
                                                    </button>
                                                </div>

                                                <div class="col-lg-4 col-md-6 mb-4 mb-lg-0">
                                                    <div class="d-flex mb-4" style="max-width: 300px">
                                                        <button class="btn btn-primary px-3 me-2" onclick="changerQuantiter(this, -1, {{ $item['id'] }})">
                                                            <i class="fas fa-minus"></i>
                                                        </button>
                                                        <div class="form-outline">
                                                            <input id="form1" min="1" name="quantity" value="{{ $item['quantity'] }}" type="number" class="form-control" data-item-id="{{ $item['id'] }}" onchange="changerQuantiter(this, 0, {{ $item['id'] }})" />
                                                        </div>
                                                        <button class="btn btn-primary px-3 ms-2" onclick="changerQuantiter(this, 1, {{ $item['id'] }})">
                                                            <i class="fas fa-plus"></i>
                                                        </button>
                                                    </div>

                                                    <p class="text-start text-md-center">
                                                        <strong>€ {{ number_format($item['price'] * $item['quantity'], 2) }}</strong>
                                                    </p>
                                                </div>
                                            </div>
                                            <hr class="my-4">
                                            @endforeach

                                            <div class="pt-5">
                                                <button class="btn btn-danger" onclick="viderPanier()">Vider le panier</button>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 bg-grey">
                                            <div class="p-5">
                                                <h3 class="fw-bold mb-5 mt-2 pt-1">Résumé</h3>
                                                <hr class="my-4">
                                                <div class="d-flex justify-content-between mb-5">
                                                    <h5 class="text-uppercase">Prix Total</h5>
                                                    <h5 id="totalPrice">€ {{ number_format($totalPrice, 2) }}</h5>
                                                </div>
                                                @if(auth()->check())
                                                <form action="{{ route('passer-commande') }}" method="post" onsubmit="event.preventDefault(); passerCommande();">
                                                    @csrf
                                                    <input type="text" class="form-control" name="adresse_livraison" id="adresse_livraison" placeholder="Adresse de livraison" required>
                                                    <br>
                                                    <button type="submit" id="passCommandButton" class="btn btn-dark btn-block btn-lg">Passer la commande</button>
                                                </form>
                                                @else
                                                <p>Connectez-vous pour passer une commande.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    @endif
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

        function changerQuantiter(button, step, itemId) {
            var input = button.closest('.d-flex').querySelector('input[name="quantity"]');
            var newQuantity = parseInt(input.value) + step;
            var pricePerItem = parseFloat(button.closest('.col-lg-4').querySelector('.text-md-center strong').textContent.replace('€', '').trim()) / parseInt(input.value);

            if (newQuantity >= 1) {
                input.value = newQuantity;
                var itemPriceElement = button.closest('.row').querySelector(".text-md-center strong");
                var newTotal = newQuantity * pricePerItem;
                itemPriceElement.textContent = "€ " + newTotal.toFixed(2);
                calculerPrixTotal();
            }

            fetch('{{ route("changer-quantiter") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        article_id: itemId,
                        quantity: newQuantity
                    })
                })
                .then(response => response.json())
                .catch(error => {
                    console.error('Erreur lors de la modification de la quantité :', error);
                });
        }

        function calculerPrixTotal() {
            var itemPrices = document.querySelectorAll('.text-md-center strong');
            var totalPrice = 0;
            itemPrices.forEach(function(price) {
                totalPrice += parseFloat(price.textContent.replace('€', '').trim());
            });
            document.getElementById('totalPrice').textContent = '€ ' + totalPrice.toFixed(2);
        }

        function passerCommande() {
            var adresseLivraison = document.getElementById('adresse_livraison').value;
            fetch('{{ route("passer-commande") }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    },
                    body: JSON.stringify({
                        adresse_livraison: adresseLivraison
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        document.getElementById('successMessage').style.display = 'block';
                        setTimeout(() => {
                            location.reload();
                        }, 1500);
                    }
                })
                .catch(error => {
                    console.error('Erreur lors de la commande :', error);
                });
        }
    </script>

@
</x-app-layout>
