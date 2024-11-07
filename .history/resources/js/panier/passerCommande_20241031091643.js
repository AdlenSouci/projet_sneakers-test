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