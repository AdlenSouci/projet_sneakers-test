<header class="py-5 header-custom">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-white">
            <h1 class="display-4 fw-bolder" style="color: #de7105;">My Sneakers</h1>
            <p id="rotating-text" class="lead fw-normal  mb-0">
                propose une large sélection de modèles, de marques et de prix.
            </p>
        </div>
    </div>
</header>

<style>
    /* Fixe une hauteur pour éviter le changement de position */
  
</style>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Textes à faire tourner
        const texts = [
            "propose une large sélection de modèles, de marques et de prix.",
            "collectionneur averti ou simple amateur de sneakers, vous trouverez votre bonheur.",
            "Nous proposons une large sélection de sneakers, des modèles classiques aux modèles les plus exclusifs. ",
        ];

        let currentIndex = 0;
        const rotatingTextElement = document.getElementById("rotating-text");

        // Fonction pour changer le texte avec une transition de fondu
        function rotateText() {
            rotatingTextElement.style.opacity = 0; // Disparaît doucement

            setTimeout(() => {
                currentIndex = (currentIndex + 1) % texts.length;
                rotatingTextElement.textContent = texts[currentIndex];
                rotatingTextElement.style.opacity = 1; // Réapparaît doucement
            }, 500); // Délai de 0,5 seconde pour la transition de sortie
        }

        // Démarre la rotation toutes les 5 secondes après le premier texte
        setInterval(rotateText, 5000); // Change toutes les 5 secondes
    });
</script>
