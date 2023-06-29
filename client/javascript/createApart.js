const fileInput = document.getElementById('file-input');
const imageContainer = document.getElementById('image-container');

fileInput.addEventListener('change', function() {
  const file = this.files[0];
  const reader = new FileReader();

  reader.onload = function(e) {
    imageContainer.style.backgroundImage = `url(${e.target.result})`;
    imageContainer.classList.add("imageCreateLocation");
    imageContainer.removeAttribute("id");
  };

  reader.readAsDataURL(file);
});

let listEquipement = document.getElementById("equipementJs");

function equipement() {
  let nameEquipement = document.getElementById("textService").value;
  console.log(nameEquipement);

  let oneEquipement = document.createElement("div");
  oneEquipement.className = "listEquipement";

  let inputOneEquipement = document.createElement("input");
  inputOneEquipement.type = "checkbox";
  inputOneEquipement.id = nameEquipement;
  inputOneEquipement.name = nameEquipement;
  oneEquipement.appendChild(inputOneEquipement);

  let labelOneEquipement = document.createElement("label");
  labelOneEquipement.for = nameEquipement;
  labelOneEquipement.innerHTML = nameEquipement;
  oneEquipement.appendChild(labelOneEquipement);

  listEquipement.appendChild(oneEquipement);
}