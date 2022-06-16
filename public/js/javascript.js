let selectElement = document.querySelector('#sortie_lieuNolieu');
// let nomElement = selectElement.getAttribute('option');
console.log(selectElement);
// console.log(nomElement);
console.log("On veut voir le résultat");
selectElement.addEventListener('change', (event) => {
    console.log("Petit flag");
    // document.location.reload;
    let result = document.querySelector('#result');
    result.textContent = `${event.target.value}`;
    console.log(result);
});
