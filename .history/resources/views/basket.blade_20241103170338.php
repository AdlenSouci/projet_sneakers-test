<x-app-layout>
    <div class="container mt-4">
        <section class="h-100 h-custom">
            <div class="container py-5 h-100">
                <div class="row d-flex justify-content-center align-items-center h-100">
                    <div class="col-lg-8">
                        <div class="card card-registration" style="border-radius: 15px; box-shadow: 0px 10px 15px rgba(0,0,0,0.1);">
                            <div class="card-body p-4">
                                @if (empty($cartItems))
                                    <div class="text-center">
                                        <h1 class="fw-bold text-black mb-3">Panier</h1>
                                        <p class="text-muted mb-5">Votre panier est vide</p>
                                        <a href="/shop" class="btn btn-outline-primary btn-lg">
                                            <i class="fas fa-long-arrow-alt-left me-2"></i>Retour à la boutique
                                        </a>
                                    </div>
                                @else
                                    <div>
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h1 class="fw-bold text-black">Panier</h1>
                                            <span class="badge bg-primary rounded-pill">{{ count($cartItems) }} items</span>
                                        </div>
                                        <hr class="mb-4">

                                        @foreach ($cartItems as $item)
                                            <div class="row mb-4 d-flex justify-content-between align-items-center shadow-sm p-3 rounded cart-item">
                                                <div class="col-md-2">
                                                    <img src="{{ asset('/img/' . $item['image']) }}" class="img-fluid rounded-3" alt="{{ $item['name'] }}">
                                                </div>
                                                <div class="col-md-4">
                                                    <h6 class="text-muted">Article</h6>
                                                    <h5 class="text-black">{{ $item['name'] }}</h5>
                                                </div>
                                                <div class="col-md-3">
                                                    <h6 class="text-muted">Prix</h6>
                                                    <h5 class="text-black">€{{ number_format($item['price'] * $item['quantity'], 2) }}</h5>
                                                </div>
                                                <div class="col-md-2">
                                                    <input type="number" value="{{ $item['quantity'] }}" class="form-control quantity-input" min="1" onchange="changerQuantiter(this)" data-item-price="{{ $item['price'] }}" data-item-id="{{ $item['id'] }}">
                                                </div>
                                                <div class="col-md-1 text-end">
                                                    <button class="btn btn-outline-danger btn-sm remove-item" onclick="viderArticlePanier(this)" data-article-id="{{ $item['id'] }}">
                                                        <i class="fas fa-times"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        @endforeach

                                        <div class="mt-5 d-flex justify-content-between">
                                            <button class="btn btn-danger" onclick="viderPanier()">Vider le panier</button>
                                            <div>
                                                <h4 class="text-uppercase">Prix Total: <span id="totalPrice" class="text-dark">€ {{ number_format($totalPrice, 2) }}</span></h4>
                                            </div>
                                        </div>

                                        @if(auth()->check())
                                            <form action="{{ route('passer-commande') }}" method="post" onsubmit="event.preventDefault(); passerCommande();" class="mt-4">
                                                @csrf
                                                <input type="text" class="form-control mb-3" name="adresse_livraison" placeholder="Adresse de livraison" required>
                                                <button type="submit" id="passCommandButton" class="btn btn-dark btn-lg w-100">Passer la commande</button>
                                            </form>
                                        @else
                                            <p class="text-center text-muted mt-4">Connectez-vous pour passer une commande.</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <div id="successMessage" class="alert alert-success" style="display: none;">
        La commande a été passée avec succès !
    </div>

    <!-- Custom CSS -->
    <style>
        .card-registration {
            border-radius: 15px;
        }
        .btn-outline-danger:hover, .btn-outline-primary:hover {
            background-color: #e3342f;
            color: #fff;
        }
        .quantity-input {
            width: 70px;
            transition: all 0.3s ease;
        }
        .quantity-input:focus {
            transform: scale(1.1);
            border-color: #007bff;
        }
        .remove-item:hover {
            background-color: #f8d7da;
            color: #721c24;
        }
        .cart-item:hover {
            box-shadow: 0px 5px 15px rgba(0,0,0,0.15);
        }
        .btn-outline-primary:hover {
            background-color: #007bff;
            color: #fff;
        }
    </style>

    <!-- Custom JavaScript -->
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
                console.error('Erreur:', error);
            });
        }

        function changerQuantiter(element) {
            const itemPrice = element.getAttribute('data-item-price');
            const itemId = element.getAttribute('data-item-id');
            const quantity = element.value;

            fetch(`/change-quantity/${itemId}`, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                },
                body: JSON.stringify({ quantity }),
            })
            .then(response => response.json())
            .then(data => {
                location.reload();
            })
            .catch(error => {
                console.error('Erreur:', error);
            });
        }

        document.querySelectorAll('.quantity-input').forEach(input => {
            input.addEventListener('mouseover', function() {
                this.style.transition = "all 0.3s ease";
                this.style.transform = "scale(1.1)";
                this.style.borderColor = "#007bff";
            });
            input.addEventListener('mouseout', function() {
                this.style.transform = "scale(1)";
                this.style.borderColor = "";
            });
        });
    </script>
</x-app-layout>
