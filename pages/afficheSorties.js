// afficheSorties.js
console.log(sorties); // Vérifier que la variable est bien reçue
sorties_cards = document.getElementById("sorties_cards")
console.log(sorties_cards)

// Exemple d'utilisation :
sorties.forEach(sortie => {
    console.log(`Sortie : ${sortie.nom}, Lieu : ${sortie.lieu}`);
    const div_sortie = document.createElement("div");

    div_sortie.innerHTML += `<div>${sortie.nom}</div>`
    div_sortie.innerHTML += `<div>lieu : ${sortie.lieu}</div>`
    div_sortie.innerHTML += `<div>prix : ${sortie.prix} €</div>`
    div_sortie.innerHTML += `<div>${sortie.description}</div>`

    div_sortie.addEventListener("click", e => {
        location.href = `descriptionSortie.php?id_sortie=${sortie.id}`
    })

    div_sortie.classList.add("sortie")

    sorties_cards.appendChild(div_sortie)

});