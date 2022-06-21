let $sortie_ville = document.getElementById("sortie_ville")
let $sortie_lieuNolieu = document.getElementById("sortie_lieuNolieu")
let $detail_lieu = document.getElementById("detail_lieu")
// console.log($sortie_ville.value)

function returnLieux(event) {
    event.preventDefault()
    const url = 'http://127.0.0.1:8000/api/' + $sortie_ville.value
    console.log(url)
    axios.get(url).then(function (response) {
        $liste_lieux = response.data
        console.log($liste_lieux)
        // for (let index = 0; index < $liste_lieux.length; index++) {
        //     console.log($liste_lieux[index]);
        //     console.log($liste_lieux[index].id);
        //     console.log($liste_lieux[index].nom);
        // }
        $select = '<select id="sortie_lieuNolieu" name="sortie[lieuNolieu]">'
        for (let index = 0; index < $liste_lieux.length; index++) {
            $select += '<option value="' + $liste_lieux[index].id + '">' + $liste_lieux[index].nom + '</option>'
        }
        $select += '</select>'

        document.getElementById('sortie_lieuNolieu').innerHTML = $select
        // document.getElementById('detail_lieu').innerHTML = '<label id="detail_lieu">Détails lieu ' + $liste_lieux[index].rue + '</label>'

        console.log("Nom : " + response.data[0].nom)
    })
}
function returnDetail(event) {
    event.preventDefault()
    const url = 'http://127.0.0.1:8000/api/detail/' + $sortie_lieuNolieu.value
    console.log(url)
    axios.get(url).then(function (response) {
        $detail_lieux = response.data

        $html =  '<label id="detail_lieu">Détails lieu '
        + '<br> Rue ' +response.data[0].rue 
        + '<br> Latitude : ' +response.data[0].latitude 
        + '<br> Longitude : ' +response.data[0].longitude 
        + '</label>'
       
        document.getElementById('detail_lieu').innerHTML = $html

    })
}

$sortie_lieuNolieu.addEventListener("change", returnDetail)
$sortie_ville.addEventListener("change", returnLieux)



// var $sortie_ville = $("#sortie_ville")
// var $token = $("#sortie_token")

// $sortie_ville.change(

// function () {
//     var $form = $(this).closest('form')
//     var data = {}
//     console.log('test')

//     data[$token.attr('name')] = $token.val()
//     data[$sortie_ville.attr('name')] = $sortie_ville.val()
//     console.log(data)
//     console.log($sortie_ville)

//     $.post($form.attr('action'), data).then(function (response)
//     {
//         $("#sortie_lieuNolieu").replaceWith(
//             $(response).find("#sortie_lieuNolieu")
//             )
//             console.log('mise a jour des sorties')
//     })
// })

// function log($msg) {
//     console.log($msg)
// }


// let selectElement = document.querySelector('#sortie_lieuNolieu');
// let nomElement = selectElement.getAttribute('option');
// console.log(selectElement);
// console.log(nomElement);
// console.log("On veut voir le résultat");
// selectElement.addEventListener('change', (event) => {
//     console.log("Petit flag");
//     document.location.reload;
//     let result = document.querySelector('#result');
//     result.textContent = `${event.target.value}`;
//     console.log(result);
// });
