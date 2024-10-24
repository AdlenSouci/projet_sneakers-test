<x-app-layout>
    <h1>Ajouter un Article</h1>

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
                        <h3>Ajouter un Nouvel Article</h3>
                        <form method="POST" action="{{ route('articles.store') }}">
                            @csrf

                            <div class="form-group">
                                <label for="id_famille">Famille <span class="text-danger">*</span></label>
                                <select class="form-control" id="id_famille" name="id_famille" required>
                                    <option value="" disabled selected>Sélectionner une famille</option>
                                    @foreach($familles as $famille)
                                    <option value="{{ $famille->id }}" {{ old('id_famille') == $famille->id ? 'selected' : '' }}>{{ $famille->nom_famille }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="id_marque">Marque <span class="text-danger">*</span></label>
                                <select class="form-control" id="id_marque" name="nom_marque" required>
                                    <option value="" disabled selected>Sélectionner une marque</option>
                                    @foreach($marques as $marque)
                                    <option value="{{ $marque->nom_marque }}" {{ old('nom_marque') == $marque->nom_marque ? 'selected' : '' }}>{{ $marque->nom_marque }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="modele">Modèle <span class="text-danger">*</span></label>
                                <input class="form-control" type="text" id="modele" name="modele" placeholder="Modèle" value="{{ old('modele') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control" id="description" name="description" placeholder="Description">{{ old('description') }}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="id_couleur">Couleur <span class="text-danger">*</span></label>
                                <select class="form-control" id="id_couleur" name="id_couleur" required>
                                    <option value="" disabled selected>Sélectionner une couleur</option>
                                    @foreach($couleurs as $couleur)
                                    <option value="{{ $couleur->id }}" {{ old('id_couleur') == $couleur->id ? 'selected' : '' }}>{{ $couleur->nom_couleur }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="prix_public">Prix Public <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" id="prix_public" name="prix_public" step="0.01" placeholder="Prix Public" value="{{ old('prix_public') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="prix_achat">Prix d'Achat <span class="text-danger">*</span></label>
                                <input class="form-control" type="number" id="prix_achat" name="prix_achat" step="0.01" placeholder="Prix d'Achat" value="{{ old('prix_achat') }}" required>
                            </div>

                            <div class="form-group">
                                <label for="img">Image URL <span class="text-danger">*</span></label>
                                //
                                <input class="form-control" type="text" id="img" name="img" placeholder="/img/" value="{{ old('img') }}" required>
                            </div>

                            <div class="form-button mt-3">
                                <button id="submit" type="submit" class="btn btn-primary">Ajouter l'Article</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @vite(['resources/css/create.css', 'resources/js/create.js'])
</x-app-layout>
