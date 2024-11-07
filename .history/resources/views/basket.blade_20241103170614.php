<x-app-layout>
    <div class="container mt-4">
        <section class="h-100 h-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-8">
                        <div class="card card-registration" style="border-radius: 15px;">
                            <div class="card-body p-4 custom-container-basket-shadow">
                                <div class="d-flex justify-content-between align-items-center mb-4">
                                    <h6>
                                        <a href="/shop" class="text-muted text-decoration-none">
                                            <i class="fas fa-long-arrow-alt-left me-2"></i>Retour à la boutique
                                        </a>
                                    </h6>
                                    <h1 class="fw-bold mb-0 text-black">Votre Panier</h1>
                                </div>

                                <!-- Message Panier Vide -->
                                @if (empty($cartItems))
                                    <div class="text-center p-4">
                                        <h5>Votre panier est vide</h5>
                                        <a href="/shop" class="btn btn-primary mt-4">Continuer vos achats</a>
                                    </div>
                                @else
                                    <!-- Liste des Articles -->
                                    @foreach ($cartItems as $item)
                                        <div class="row mb-4 align-items-center panier-item">
                                            <div class="col-md-2">
                                                <img src="{{ asset('/img/' . $item['image']) }}" class="img-fluid rounded-3 shadow-sm" alt="{{ $item['name'] }}">
                                            </div>
                                            <div class="col-md-3">
                                                <h6 class="text-muted">Article</h6>
                                                <h5 class="text-black mb-0">{{ $item['name'] }}</h5>
                                            </div>
                                            <div class="col-md-3">
                                                <h6 class="text-muted">Prix</h6>
                                                <h5 class="text-primary mb-0">€{{ number_format($item['price'], 2) }}</h5>
                                            </div>
                                            <div class="col-md-2">
                                                <input type="number" value="{{ $item['quantity'] }}" class="form-control form-control-sm text-center panier-quantite" min="1" onchange="changerQuantiter(this)" data-item-price="{{ $item['price'] }}" data-item-id="{{ $item['id'] }}">
                                            </div>
                                            <div class="col-md-1 text-end">
                                                <button class="btn btn-link text-danger p-0" onclick="viderArticlePanier(this)" data-article-id="{{ $item['id'] }}">
                                                    <i class="fas fa-times"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <hr class="my-4">
                                    @endforeach

                                    <!-- Résumé -->
                                    <div class="row mt-4">
                                        <div class="col-lg-12">
                                            <h4 class="fw-bold">Résumé</h4>
                                            <hr>
                                            <div class="d-flex justify-content-between mb-4">
                                                <h5>Prix Total</h5>
                                                <h5 id="totalPrice">€ {{ number_format($totalPrice, 2) }}</h5>
                                            </div>

                                            <!-- Boutons d'actions -->
                                            <div class="d-flex justify-content-between mt-5">
                                                <button class="btn btn-outline-danger" onclick="viderPanier()">Vider le panier</button>
                                                @if(auth()->check())
                                                    <form action="{{ route('passer-commande') }}" method="post" onsubmit="event.preventDefault(); passerCommande();">
                                                        @csrf
                                                        <input type="text" class="form-control my-3" name="adresse_livraison" id="adresse_livraison" placeholder="Adresse de livraison" required>
                                                        <button type="submit" class="btn btn-primary">Passer la commande</button>
                                                    </form>
                                                @else
                                                    <p class="text-muted">Connectez-vous pour passer une commande.</p>
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

        <!-- Message de succès -->
        <div id="successMessage" class="alert alert-success position-fixed bottom-0 start-50 translate-middle-x w-50 text-center" style="display: none;">
            La commande a été passée avec succès !
        </div>
    </div>

    <!-- Styles et scripts personnalisés -->
    <style>
        .panier-item {
            transition: background-color 0.3s, box-shadow 0.3s;
        }

        .panier-item:hover {
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .panier-quantite {
            transition: all 0.3s ease;
        }

        .panier-quantite:focus {
            box-shadow: 0 0 8px #007bff;
            border-color: #007bff;
        }
    </style>

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
            .catch(error => console.error('Erreur:', error));
        }

        function changerQuantiter(input) {
            const itemId = input.dataset.itemId;
            const itemPrice = parseFloat(input.dataset.itemPrice);
            const quantity = input.value;
            const totalPriceElement = document.getElementById('totalPrice');
            
            // Mise à jour du prix total
            fetch(`/basket/changer-quantite/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ quantity }),
            })
            .then(response => response.json())
            .then(data => {
                totalPriceElement.textContent = '€ ' + data.totalPrice.toFixed(2);
            })
            .catch(error => console.error('Erreur:', error));
        }
    </script>
</x-app-layout>
