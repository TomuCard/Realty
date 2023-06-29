// Récupérer les références aux boutons de pagination et au conteneur des locations
const prevButton = document.querySelector('.dateSelectContainer button:first-child');
const nextButton = document.querySelector('.dateSelectContainer button:last-child');
const locationsContainer = document.querySelector('.global-mainContainer');

const locationsPerPage = 5;
const totalLocations = window.totalLocationsPHP;

prevButton.addEventListener('click', () => {

    const currentPage = parseInt(nextButton.previousElementSibling.textContent);
    const previousPage = currentPage - 1;

    if (previousPage >= 1) {
        nextButton.previousElementSibling.textContent = previousPage;
        updateDisplayedLocations(previousPage);
    }
});

nextButton.addEventListener('click', () => {

    const currentPage = parseInt(prevButton.nextElementSibling.textContent);
    const nextPage = currentPage + 1;

    if (nextPage <= Math.ceil(totalLocations / locationsPerPage)) {
        prevButton.nextElementSibling.textContent = nextPage;
        updateDisplayedLocations(nextPage);
    }
});

function updateDisplayedLocations(page) {
    const allLocations = locationsContainer.querySelectorAll('.global-locationContainer');

    const startIndex = (page - 1) * locationsPerPage;
    const endIndex = startIndex + locationsPerPage;

    allLocations.forEach((location) => {
        location.style.display = 'none';
    });

    for (let i = startIndex; i < endIndex; i++) {
        if (allLocations[i]) {
            allLocations[i].style.display = 'flex';
        }
    }
}
updateDisplayedLocations(1);