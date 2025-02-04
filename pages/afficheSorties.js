// afficheSorties.js
console.log(sorties); // Vérifier que la variable est bien reçue
sorties_cards = document.getElementById("sorties_cards")
console.log(sorties_cards)

// Exemple d'utilisation :
sorties.forEach(sortie => {
    console.log(`Sortie : ${sortie.nom}, Lieu : ${sortie.lieu}`);
    const div_sortie = document.createElement("div");
    // const img_sortie = document.createElement("img");
    const nom_sortie = document.createElement("div");
    const lieu_sortie = document.createElement("div");
    const prix_sortie = document.createElement("div");
    const desc_sortie = document.createElement("div");
    nom_sortie.innerText = sortie.nom
    lieu_sortie.innerText = "lieu : "+sortie.lieu
    prix_sortie.innerText = "prix : "+sortie.prix+" €"
    desc_sortie.innerText = sortie.description

    // div_sortie.appendChild(img_sortie)
    div_sortie.appendChild(nom_sortie)
    div_sortie.appendChild(lieu_sortie)
    div_sortie.appendChild(prix_sortie)
    div_sortie.appendChild(desc_sortie)

    div_sortie.classList.add("sortie")

    sorties_cards.appendChild(div_sortie)

});