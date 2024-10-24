@if(auth()->check() && $article->commandes->contains('user_id', auth()->id()))
                <form action="{{ route('avis.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="article_id" value="{{ $article->id }}">

                    <div>
                        <label for="note">Note :</label>
                        <select name="note" id="note" required>
                            <option value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                        </select>
                    </div>

                    <div>
                        <label for="contenu">Commentaire :</label>
                        <textarea name="contenu" id="contenu" required></textarea>
                    </div>

                    <button type="submit">Laisser un avis</button>
                </form>
            @endif

            <!-- Affichage des avis existants -->
            <h3>Avis :</h3>
            @foreach($article->avis as $avis)
                <div>
                    <strong>{{ $avis->user->name }}</strong> ({{ $avis->note }} étoiles) :
                    <p>{{ $avis->contenu }}</p>
                </div>
            @endforeach