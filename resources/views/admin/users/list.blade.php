<x-app-layout>
    <h1>Liste des Articles</h1>
    <a href="{{ route('articles.create') }}" class="btn btn-primary">Ajouter un Article</a>

    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>id article </th>
                    <th>ID Famille</th>
                    <th>ID Marque</th>
                    <th>nom_Marque</th>
                    <th>Nom de Famille</th>
                    <th>Modèle</th>
                    <th>Description</th>
                    <th>nom_Couleur</th>
                    <th>Prix Public</th>
                    <th>Prix d'Achat</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($articles as $article)
                <tr>
                    <td>{{ $article->id }}</td>
                    <td>{{ $article->id_famille }}</td>
                    <td>{{ $article->id_marque }}</td>
                    <td>{{ $article->nom_marque }}</td>
                    <td>{{ $article->nom_famille }}</td>
                    <td>{{ $article->modele }}</td>
                    <td>{{ $article->description }}</td>
                    <td>{{ $article->nom_couleur }}</td>
                    <td>{{ $article->prix_public }}</td>
                    <td>{{ $article->prix_achat }}</td>
                   
                    <td><img src="{{ asset('img/' . $article->img) }}" alt="" style="height: 50px ; width: 60px"></td>
                    <td>
                        <a href="{{ route('articles.edit', $article->id) }}" class="btn btn-warning mr-2">Modifier</a>
                        <br>
                        <form method="POST" action="{{ route('articles.destroy', $article->id) }}" style="display:inline;" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer cet article ?');">
                            @csrf
                            @method('DELETE')
                            <br>
                            <button type="submit" class="btn btn-danger btn-custom-danger">Supprimer</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @vite(['resources/css/create.css', 'resources/js/create.js'])
</x-app-layout>
