console.log("salut")

const base_api = "https://apicarto.ign.fr/api"

const form = document.querySelector('form');
const cpElem = document.querySelector('input[name="code_postal"]');
const ville = document.querySelector('#ville');


cpElem.addEventListener('change', get)

function get() {
    // alert("salut")
    const codePostal = cpElem.value;
    fetch(`${base_api}/codes-postaux/communes/${codePostal}`)
        .then(r => {
            if (r.status != 200) throw new Error('reftghnjk;l')
            return r.json()
        })
        .then(data => {
            ville.innerHTML = ""
            for (const datum of data) {
                let option = document.createElement("option");
                option.value = datum.nomCommune;
                option.textContent = datum.nomCommune
                ville.appendChild(option);
            }
        }).catch(err => {
            console.error('la réponse est incorrecte')
    })
}