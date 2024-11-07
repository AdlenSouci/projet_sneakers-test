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