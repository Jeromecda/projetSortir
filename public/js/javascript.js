var $sortie_ville = $("#sortie_ville")
var $token = $("#post_token")

$sortie_ville.change(function () {
    var $form = $(this).closest('form')
    var data = {}

    data($token.attr('name')) = $token.val()
    data($sortie_ville.attr('name')) = $sortie_ville.val()

    $.post($form.attr('action'), data).then(function (response) {
        $('sortie_lieuNolieu').replaceWith(
            $(response).find($sortie_lieuNolieu)
        )
    })
})

function log($msg) {
    console.log($msg)
}
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
