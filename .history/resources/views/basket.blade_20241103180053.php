<x-app-layout>
    <div class="container mt-4">
         <section class="h-100 h-custom" >  <!-- style="background: linear-gradient(135deg, #de7105 0%, white 100%);" -->
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-7">
                        <div class="card card-registration" style="border-radius: 15px; box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15);">
                            <div class="card-body p-0">
                                <div class="row g-0">
                                    @if (empty($cartItems))
                                    <div class="col mb-5 text-center p-5">
                                        <h1 class="fw-bold mb-4 text-black">Panier</h1>
                                        <div class="text-center" style="margin: 50px 0;">Votre panier est vide</div>
                                        <a href="/shop" class="btn btn-outline-secondary mt-3">
                                            <i class="fas fa-long-arrow-alt-left me-2"></i>Retour à la boutique
                                        </a>
                                    </div>
                                    @else
                                    <div class="col-lg-15">
                                        <div class="p-4" style="background-color: #f8f9fa;">
                                            <div class="d-flex justify-content-between align-items-center mb-4">
                                                <h1 class="fw-bold mb-0 text-black">Panier</h1>
                                                <h6 class="text-muted">{{ count($cartItems) }} articles</h6>
                                            </div>
                                            <hr class="my-3">

                                            @foreach ($cartItems as $index => $item)
                                            <div class="row mb-4 d-flex justify-content-between align-items-center {{ $index % 2 == 0 ? 'item-even' : 'item-odd' }}">
                                                <div class="col-md-2 col-lg-2 col-xl-2">
                                                    <img src="{{ asset('/img/' . $item['image']) }}" class="img-fluid rounded-3 shadow-sm" alt="{{ $item['name'] }}">
                                                </div>
                                                <div class="col-md-3 col-lg-3 col-xl-3">
                                                    <h6 class="{{ $index % 2 == 0 ? 'text-black' : 'text-white' }}">{{ $item['name'] }}</h6>
                                                </div>
                                                <div class="col-md-3 col-lg-2 col-xl-2 offset-lg-1">
                                                    <h6 class="{{ $index % 2 == 0 ? 'text-black' : 'text-white' }} mb-0 item-price" data-item-price="{{ $item['price'] }}">
                                                        € {{ number_format($item['price'] * $item['quantity'], 2) }}
                                                    </h6>
                                                </div>
                                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                    <input type="number" value="{{ $item['quantity'] }}" class="form-control rounded input-quantity" min="1" onchange="changerQuantiter(this)" data-item-price="{{ $item['price'] }}" data-item-id="{{ $item['id'] }}" style="width: 80px;">
                                                </div>
                                                <div class="col-md-1 col-lg-1 col-xl-1 text-end">
                                                    <a href="#!" class="text-muted delete-item-btn" onclick="viderArticlePanier(this)" data-article-id="{{ $item['id'] }}"><i class="fas fa-times"></i></a>
                                                </div>
                                            </div>
                                            <hr class="my-3">
                                            @endforeach

                                            <div class="pt-4 d-flex justify-content-between align-items-center">
                                                <button class="btn btn-danger btn-lg" onclick="viderPanier()">Vider le panier</button>
                                                <div>
                                                    <h3 class="fw-bold">Total : <span id="totalPrice">€ {{ number_format($totalPrice, 2) }}</span></h3>
                                                </div>
                                            </div>
                                            @if(auth()->check())
                                            <form action="{{ route('passer-commande') }}" method="post" onsubmit="event.preventDefault(); passerCommande();" class="mt-4">
                                                @csrf
                                                <input type="text" class="form-control form-control-lg mb-3" name="adresse_livraison" id="adresse_livraison" placeholder="Adresse de livraison" required>
                                                <button type="submit" id="passCommandButton" class="btn btn-dark btn-block btn-lg w-100">Passer la commande</button>
                                            </form>
                                            @else
                                            <p class="text-center mt-3">Connectez-vous pour passer une commande.</p>
                                            @endif
                                        </div>
                                    </div>
                                    @endif
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

    <style>
        .item-even {
            background-color: #ffffff;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .item-odd {
            background-color: #de7105;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
        }

        .input-quantity:focus {
            border-color: #de7105;
            box-shadow: 0px 0px 10px rgba(222, 113, 5, 0.3);
        }

        .input-quantity {
            transition: transform 0.2s ease;
        }

        .input-quantity:hover {
            transform: scale(1.1);
        }

        .delete-item-btn:hover {
            color: #de7105;
            transform: scale(1.1);
            transition: color 0.2s ease, transform 0.2s ease;
        }

        .btn-danger, .btn-dark {
            transition: background-color 0.3s ease, box-shadow 0.3s ease;
        }

        .btn-danger:hover {
            background-color: #de7105;
            box-shadow: 0px 5px 15px rgba(222, 113, 5, 0.3);
        }

        .btn-dark:hover {
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.3);
        }

        .row.mb-4:hover {
            transform: scale(1.02);
            box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.15);
            transition: transform 0.2s ease;
        }
    </style>

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
</x-app-layout>