//Récupère l'élément HTML qui initie la modification
let $sortie_ville = document.getElementById("sortie_ville")
let $sortie_lieuNolieu = document.getElementById("sortie_lieuNolieu")
let $detail_lieu = document.getElementById("detail_lieu")

// Appelle une fonction en réponse à une modification de l'élément initial
$sortie_lieuNolieu.addEventListener("change", returnDetail)
$sortie_ville.addEventListener("change", returnLieux)

// Retourne La liste des lieux associés à la ville
function returnLieux(event) {
    event.preventDefault()
    // URL de la route vers le controller API qui effectuera la requête
    const url = 'http://127.0.0.1:8000/api/' + $sortie_ville.value
    console.log(url)
    
    // Appel Ajax via Axios à l'URL cible puis gestion de la réponse
    axios.get(url).then(function (response) {
        // La réponse est la liste des lieux sous forme d'array d'array
        $liste_lieux = response.data
    
        // Un élément HTML select est reconstruit en combinant les éléments issus de la réponse
        $select = '<select id="sortie_lieuNolieu" name="sortie[lieuNolieu]">'
        for (let index = 0; index < $liste_lieux.length; index++) {
            $select += '<option value="' + $liste_lieux[index].id + '">' + $liste_lieux[index].nom + '</option>'
        }
        $select += '</select>'

        //L'élément HTML est utilisé pour remplacer un élément existant
        document.getElementById('sortie_lieuNolieu').innerHTML = $select
    })
}
function returnDetail(event) {
    event.preventDefault()
    const url = 'http://127.0.0.1:8000/api/detail/' + $sortie_lieuNolieu.value
    console.log(url)
    axios.get(url).then(function (response) {
        $detail_lieux = response.data

        $html =  '<label id="detail_lieu">Adresse :'
        + '<ul><li>Rue ' +response.data[0].rue 
        + '<li>Latitude : ' +response.data[0].latitude 
        + '<li>Longitude : ' +response.data[0].longitude 
        + '</ul></label>'
       
        document.getElementById('detail_lieu').innerHTML = $html

    })
}
// let $sortie_ville = document.getElementById("sortie_ville")
// let $sortie_lieuNolieu = document.getElementById("sortie_lieuNolieu")
// let $detail_lieu = document.getElementById("detail_lieu")
// // console.log($sortie_ville.value)

// $sortie_lieuNolieu.addEventListener("change", returnDetail)
// $sortie_ville.addEventListener("change", returnLieux)

// function returnLieux(event) {
//     event.preventDefault()
//     const url = 'http://127.0.0.1:8000/api/' + $sortie_ville.value
//     console.log(url)
//     axios.get(url).then(function (response) {
//         $liste_lieux = response.data
//         console.log($liste_lieux)
//         // for (let index = 0; index < $liste_lieux.length; index++) {
//         //     console.log($liste_lieux[index]);
//         //     console.log($liste_lieux[index].id);
//         //     console.log($liste_lieux[index].nom);
//         // }
//         $select = '<select id="sortie_lieuNolieu" name="sortie[lieuNolieu]">'
//         for (let index = 0; index < $liste_lieux.length; index++) {
//             $select += '<option value="' + $liste_lieux[index].id + '">' + $liste_lieux[index].nom + '</option>'
//         }
//         $select += '</select>'

//         document.getElementById('sortie_lieuNolieu').innerHTML = $select
//         // document.getElementById('detail_lieu').innerHTML = '<label id="detail_lieu">Détails lieu ' + $liste_lieux[index].rue + '</label>'

//         console.log("Nom : " + response.data[0].nom)
//     })
// }
// function returnDetail(event) {
//     event.preventDefault()
//     const url = 'http://127.0.0.1:8000/api/detail/' + $sortie_lieuNolieu.value
//     console.log(url)
//     axios.get(url).then(function (response) {
//         $detail_lieux = response.data

//         $html =  '<label id="detail_lieu">Adresse :'
//         + '<ul><li>Rue ' +response.data[0].rue 
//         + '<li>Latitude : ' +response.data[0].latitude 
//         + '<li>Longitude : ' +response.data[0].longitude 
//         + '</ul></label>'
       
//         document.getElementById('detail_lieu').innerHTML = $html

//     })
// }