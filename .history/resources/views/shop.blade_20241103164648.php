

    <!-- Section des avis des clients -->
    <section class="py-5 custom-section bg-light">
        <div class="container px-4 px-lg-5 mt-5">
            <h5 class="text-center mb-4" style="color: #de7105;">Avis des clients</h5>
            <ul class="list-unstyled">
                @foreach ($articlesData as $article)
                @if ($article->avis && $article->avis->count() > 0)
                @foreach ($article->avis as $avis)
                <li class="mb-2">
                    <div class="p-3 border border-light rounded" style="background-color: #f9f9f9;">
                        <strong>{{ $avis->user->name }} :</strong> {{ $avis->contenu }}
                        <span class="text-warning">{{ str_repeat('★', $avis->note) }} {{ str_repeat('☆', 5 - $avis->note) }}</span>
                        <div>Article évalué : {{ $article->modele }}</div>
                    </div>
                </li>
                @endforeach
                @else

                @endif
                @endforeach
            </ul>
        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script>
        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('ajouter_au_panier')) {
                var articleId = event.target.getAttribute('data-article-id');
                var pointure = event.target.parentElement.querySelector('#pointure').value;
                if (pointure) {
                    $.ajax({
                        url: '{{ route("ajouter_au_panier") }}',
                        type: 'POST',
                        data: {
                            '_token': '{{ csrf_token() }}',
                            'article_id': articleId,
                            pointure,
                            'quantite': event.target.parentElement.querySelector('[name="quantite"]').value
                        },
                        success: function(response) {
                            alert(response.message);
                            document.querySelector('#nbitems').textContent = "panier(" + response.nbitems + ")";
                        },
                        error: function(error) {
                            console.log(error);
                        }
                    });
                } else {
                    alert('Veuillez choisir une pointure');
                }
            }
        });

        $(document).ready(function() {
            $('.rating').raty({
                score: function() {
                    return $(this).data('score');
                },
                half: true,
                readOnly: true
            });
        });

        $(document).ready(function() {
            $('#filterForm').on('submit', function(e) {
                e.preventDefault();

                const selectedMarque = $('#marque').val();
                const selectedCouleur = $('#couleur').val();

                $('.row-cols-xl-4 .col').each(function() {
                    const articleMarque = $(this).data('marque');
                    const articleCouleur = $(this).data('couleur');

                    const matchesMarque = selectedMarque === "" || articleMarque === selectedMarque;
                    const matchesCouleur = selectedCouleur === "" || articleCouleur === selectedCouleur;

                    if (matchesMarque && matchesCouleur) {
                        $(this).show(); // Affiche l'article
                    } else {
                        $(this).hide(); // Masque l'article
                    }
                });
            });
        });
    </script>

    @vite(['resources/css/templatemo.css', 'resources/js/templatemo.js', 'resources/css/slick-theme.css', 'resources/css/slick-theme.min.css', 'resources/css/slick.min.css'])
</x-app-layout>




