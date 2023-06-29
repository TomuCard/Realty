let rentalPeriods = [];
const apartment_id = document.querySelector('#apartment_id').value;

fetch(`http://localhost:4000/apartment/get/allApartmentRental/${apartment_id}`)
  .then(response => {
    if (response.ok) {
      return response.json();
    }
  })
  .then(data => {
    data.forEach(element => {
      rentalPeriods.push(element)
    });
    console.log(rentalPeriods);
    // Appeler la fonction pour générer le calendrier initial
    generateCalendar();
  })
  .catch(error => {
    console.error('Erreur:', error);
  });

// Variable globale pour stocker la date actuelle
let currentDate = new Date(); 

function generateCalendar() {

  const currentYear = currentDate.getFullYear();

  const container = document.getElementById('calendar-container');
  // Effacer le contenu précédent de la div
  container.innerHTML = ''; 

  // Créer un élément div pour l'en-tête du calendrier
  const header = document.createElement('div');
  header.style.display = 'flex';
  header.style.justifyContent = 'space-between';
  // Ajouter l'en-tête à la div container
  container.appendChild(header);

  const previousBtn = document.createElement('button');
  previousBtn.style.backgroundImage = "url(../../images/leftArrow.svg)";
  previousBtn.style.backgroundRepeat = "no-repeat";
  previousBtn.addEventListener('click', showPreviousMonth);
  header.appendChild(previousBtn);

  // On lui ajouter une class pour le css
  previousBtn.classList.add("calandarBtn");

  // Créer un élément h2 pour afficher le mois courant
  const currentMonth = document.createElement('h3');
  // Et lui ajouter une class pour le css
  currentMonth.classList.add("calandarCurrentMonth");

  /*

  la méthode toLocaleString est utilisée pour formater la date en fonction des paramètres régionaux spécifiés. 
  Dans ce cas, la région spécifiée est "fr-FR", ce qui correspond au français pour la France.

  Les options { month: 'long', year: 'numeric' } indiquent que nous voulons afficher le mois sous forme de nom complet 
  (par exemple, "janvier", "février", etc.) et l'année sous forme de nombre à quatre chiffres (par exemple, "2023").

  */

  currentMonth.textContent = currentDate.toLocaleString('fr-FR', { month: 'long', year: 'numeric' });
  header.appendChild(currentMonth);

  const nextBtn = document.createElement('button');
  nextBtn.style.backgroundImage = "url(../../images/rightArrow.svg)";
  nextBtn.style.backgroundRepeat = "no-repeat";
  nextBtn.addEventListener('click', showNextMonth);
  header.appendChild(nextBtn);

  // On lui ajouter une class pour le css
  nextBtn.classList.add("calandarBtn");

  // Créer un élément div pour le calendrier
  const calendar = document.createElement('div');
  calendar.style.display = 'grid';

  // On lui ajouter une class pour le css
  calendar.classList.add("calandarNumberContainer");

  /*
    gridTemplateColumns : Cette propriété est utilisée pour spécifier le nombre et la largeur 
    des colonnes dans un conteneur de grille.

    la ligne 62 permet de diviser l'espace du conteneur du calendrier en 7 colonnes égales, 
    ce qui correspond aux 7 jours de la semaine. Chaque jour du calendrier sera ensuite 
    positionné dans une colonne distincte, facilitant ainsi l'affichage organisé et 
    régulier des jours de la semaine.

    Le mot-clé repeat : permet de répéter un certain nombre de fois un modèle de colonne 
    ou de ligne dans une grille.
  */

  calendar.style.gridTemplateColumns = 'repeat(7, 1fr)';
  // Ajouter le calendrier à la div container
  container.appendChild(calendar);

  const weekdays = ['Lun', 'Mar', 'Mer', 'Jeu', 'Ven', 'Sam', 'Dim'];

  for (let i = 0; i < weekdays.length; i++) {
    // Créer un élément div pour chaque jour du mois
    const weekday = document.createElement('div');
    weekday.textContent = weekdays[i];
    // Lui ajouter une class pour le css
    weekday.classList.add("calandarWeekday");
    // Ajouter le jour de la semaine au calendrier
    calendar.appendChild(weekday);
  }
  // Crée un objet Date pour représenter le premier jour du mois actuel
  const firstDayOfMonth = new Date(currentYear, currentDate.getMonth(), 1);
  // Crée un objet Date pour représenter le dernier jour du mois actuel
  const lastDayOfMonth = new Date(currentYear, currentDate.getMonth() + 1, 0);
  // Récupère le nombre de jours dans le mois actuel en utilisant la méthode getDate() de l'objet Date
  const daysInMonth = lastDayOfMonth.getDate();

  /*

    Les lignes de code suivantes sont utilisées pour  déterminer les informations de base sur le mois en cours, 
    telles que le premier jour du mois, le dernier jour du mois, le nombre total de jours dans le mois et 
    le décalage de démarrage (jour de la semaine où commence le mois). Ces informations sont utilisées dans la boucle 
    suivante pour générer les cellules du calendrier avec les bons numéros de jour.

  */

  // Calcule le décalage de démarrage (le jour de la semaine où commence le mois)
  let startOffset = firstDayOfMonth.getDay() - 1;
  // Si le décalage est -1 (le jour est un dimanche), nous le changeons à 6 (dimanche est le dernier jour de la semaine)
  if (startOffset === -1) {
    startOffset = 6;
  }
  // Variable pour garder une trace du numéro du jour dans le mois
  let dayCounter = 1;

  for (let i = 0; i < 42; i++) {
    // Créer un élément div pour chaque jour du mois
    const dayCell = document.createElement('div');
    dayCell.style.fontWeight = 'bold';

    calendar.appendChild(dayCell);
    // Lui ajouter une class pour le css
    dayCell.classList.add("calandarNumber");

    if (i >= startOffset && dayCounter <= daysInMonth) {
      dayCell.textContent = dayCounter;
      if (currentDate.getMonth() === firstDayOfMonth.getMonth() && dayCounter === currentDate.getDate()) {
        // Ajouter la classe 'today' pour mettre en évidence le jour actuel
        dayCell.style.backgroundColor= 'yellow';
        dayCell.style.borderRadius= '5px';
      }

      // Vérifier si le jour actuel fait partie d'une période de location

      const isRentalPeriod = rentalPeriods.some(rental => {
      const rentalStart = new Date(rental.apartment_rental_start);
      const rentalEnd = new Date(rental.apartment_rental_end);
      return currentYear === rentalStart.getFullYear() &&
        currentDate.getMonth() === rentalStart.getMonth() &&
        dayCounter >= rentalStart.getDate() &&
        dayCounter <= rentalEnd.getDate();
    });

      if (isRentalPeriod) {
        dayCell.style.color = 'grey';
        dayCell.style.fontStyle = 'italic';
        dayCell.style.fontWeight = 'light';
        
      }

      dayCounter++;
    }
  }
}

function showPreviousMonth() {
  // Décrémente le mois de currentDate d'une unité pour afficher le mois précédent
  currentDate.setMonth(currentDate.getMonth() - 1);
  // Génère le calendrier mis à jour
  generateCalendar();
}

function showNextMonth() {
  // Incrémente le mois de currentDate d'une unité pour afficher le mois suivant
  currentDate.setMonth(currentDate.getMonth() + 1);
   // Génère le calendrier mis à jour
  generateCalendar();
}

const startDate = document.querySelector('#start-date');
const endDate = document.querySelector('#end-date');
const nights = document.querySelector('#nights');
const totalPrice = document.querySelector('#total-price');
const unitPrice = document.querySelector('#unit-price').textContent;
const tax = document.querySelector('#tax');
const priceTtc = document.querySelector('#price-ttc');
const input_total = document.querySelector('#input_total');

tax.textContent = 65;
nights.textContent = 0;
totalPrice.textContent = 0;
let start = null;
let end = null;
priceTtc.textContent = 0;

startDate.addEventListener('change', (e) => {
  start = new Date(e.target.value);
});

endDate.addEventListener('change', (e) => {
  end = new Date(e.target.value);
  
  if (start && end) {
    const differenceInMilliseconds = end - start;
    const differenceInDays = Math.floor(differenceInMilliseconds / (1000 * 60 * 60 * 24));
    nights.textContent = differenceInDays;
    const pricePerDay = parseInt(unitPrice) * parseInt(differenceInDays);
    totalPrice.textContent = pricePerDay;
    console.log( 'prix toute nuit :' + pricePerDay, 'Taxe:' + tax)
    const finalPrice = parseInt(pricePerDay) + parseInt(tax.textContent)
    priceTtc.textContent = finalPrice;
    input_total.value = finalPrice;

  }
});