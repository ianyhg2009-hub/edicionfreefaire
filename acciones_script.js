window.addEventListener("load", iniciarf);

function iniciarf() {
    vcosto = document.getElementById("costop");
    vporcentaje = document.getElementById("porcentajev");
    vimage = document.getElementById("simagen");
    vimageUpdate = document.getElementById("imagen_update");

    if (vcosto) {
        vcosto.addEventListener("input", mostrarpventa);
    }
    if (vporcentaje) {
        vporcentaje.addEventListener("input", mostrarpventa);
    }
    if (vimage) {
        vimage.addEventListener("change", function () {
            mostrarImagen(this, document.querySelector('#preview_simagen'));
        });
    }
    if (vimageUpdate) {
        vimageUpdate.addEventListener("change", function () {
            mostrarImagen(this, document.getElementById('preview_update'));
        });
    }
}

function calcularPorcentaje(costof, porcentajef) {
    let TantoTotal = costof * (porcentajef / 100);
    let PVenta = parseFloat(costof) + parseFloat(TantoTotal);
    return PVenta;
}

function mostrarpventa() {
    if (vcosto && vporcentaje && vcosto.value != "" && vporcentaje.value != "") {
        let calculo = calcularPorcentaje(vcosto.value, vporcentaje.value);
        var pventaElement = document.getElementById("pventa");
        if (pventaElement) {
            pventaElement.value = calculo;
        }
    } else {
        var pventaElement = document.getElementById("pventa");
        if (pventaElement) {
            pventaElement.value = "";
        }
    }
}

function mostrarImagen(inputElement, previewElement) {
    if (!inputElement || !previewElement) {
        return;
    }
    var archivof = inputElement.files[0];
    var leerarchivo = new FileReader();

    leerarchivo.onloadend = function () {
        previewElement.src = leerarchivo.result;
        previewElement.style.display = "block";
    }

    if (archivof) {
        leerarchivo.readAsDataURL(archivof);
    } else {
        previewElement.src = "";
        previewElement.style.display = "none";
    }
}