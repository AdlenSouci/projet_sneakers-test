<x-app-layout>
    <h1>Modifier l'Article</h1>

    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <div class="form-body">
        <div class="row">
            <div class="form-holder">
                <div class="form-content">
                    <div class="form-items">
                        <h3>Modifier l'Article</h3>
                        <form method="POST" action="{{ route('articles.update', $article->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label for="id_famille">Famille</label>
                                <select class="form-control" id="id_famille" name="id_famille" required>
                                    @foreach ($familles as $famille)
                                    <option value="{{ $famille->id }}" {{ $famille->id == $article->id_famille ? 'selected' : '' }}>
                                        {{ $famille->nom_famille }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_marque">Marque</label>
                                <select class="form-control" id="id_marque" name="id_marque" required onchange="updateNomMarque(this)">
                                    @foreach ($marques as $marque)
                                    <option value="{{ $marque->id }}" {{ $marque->id == $article->id_marque ? 'selected' : '' }}>
                                        {{ $marque->nom_marque }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>
                            <input type="hidden" id="nom_marque" name="nom_marque" value="{{ $article->nom_marque }}">


                            <div class="form-group">
                                <label for="modele">Modèle</label>
                                <input class="form-control" type="text" id="modele" name="modele" value="{{ $article->modele }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description">{{ $article->description }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="id_couleur">Couleur</label>
                                <select class="form-control" id="id_couleur" name="id_couleur" required>
                                    @foreach ($couleurs as $couleur)
                                    <option value="{{ $couleur->id }}" {{ $couleur->nom_couleur == $article->nom_couleur ? 'selected' : '' }}>
                                        {{ $couleur->nom_couleur }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="prix_public">Prix Public</label>
                                <input class="form-control" type="number" id="prix_public" name="prix_public" step="0.01" value="{{ $article->prix_public }}" required>
                            </div>

                            <div class="form-group">
                                <label for="prix_achat">Prix d'Achat</label>
                                <input class="form-control" type="number" id="prix_achat" name="prix_achat" step="0.01" value="{{ $article->prix_achat }}" required>
                            </div>

                            <div class="form-group">
                                <label for="img">Image URL</label>
                                <input class="form-control" type="text" id="img" name="img" value="{{ $article->img }}" required>
                            </div>

                            <div class="form-button mt-3">
                                <button id="submit" type="submit" class="btn btn-primary">Modifier l'Article</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function updateNomMarque(select) {
            var selectedOption = select.options[select.selectedIndex];
            document.getElementById('nom_marque').value = selectedOption.text; // Update hidden input
        }
    </script>
    @vite(['resources/css/create.css', 'resources/js/create.js'])


</x-app-layout>