const challengesContainer = $('#challenges-container');
const challengesData = challengesContainer.data('challenges');
const challenges = JSON.parse(challengesData);

// Nombre d'éléments par page
const itemsPerPage = 15; // Choisis le nombre d'éléments que tu veux afficher par page.

// Initialise la pagination
challengesContainer.pagination({
    items: challenges.length, // Le nombre total d'éléments
    itemsOnPage: itemsPerPage, // Le nombre d'éléments par page
    displayedPages: 5, // Le nombre de pages affichées dans la barre de pagination
    edges: 1, // Le nombre de pages affichées au début et à la fin
    onPageClick: function (pageNumber) {
        // Fonction à exécuter lorsqu'une page est cliquée
        displayChallenges(pageNumber);
    },
});

// Fonction pour afficher les challenges de la page actuelle
function displayChallenges(pageNumber) {
    const startIndex = (pageNumber - 1) * itemsPerPage;
    const endIndex = startIndex + itemsPerPage;
    const visibleChallenges = challenges.slice(startIndex, endIndex);

    // Affiche les challenges dans ton conteneur (à adapter selon ta structure HTML)
    challengesContainer.html('');
    visibleChallenges.forEach(challenge => {
        // Ajoute le code HTML pour afficher le challenge dans le conteneur
        challengesContainer.append(`<div>${challenge.nom}</div>`);
    });
}

// Affiche les challenges de la première page au chargement de la page
displayChallenges(1);