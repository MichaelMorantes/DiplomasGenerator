function alert(alertPlaceholder, message, type) {
    var wrapper = document.createElement('div')
    wrapper.innerHTML = '<div class="alert alert-' + type + ' alert-dismissible" role="alert">' + message + '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button></div>'
    alertPlaceholder.append(wrapper)
}

function fill_list(datalist, array, mensaje = null) {
    var opt = '';
    opt += `<option disabled selected>Seleccione una opción</option>`;
    for (var i = 0; i < Object.entries(array).length; i++) {
        if (mensaje) {
            opt += `<option value="${Object.values(array[i])[0]}" >${Object.values(array[i])[0] + mensaje + Object.values(array[i])[1]}</option>`;
        } else {
            opt += `<option value="${Object.values(array[i])[0]}" >${Object.values(array[i])[0]}</option>`;
        }
    }
    document.getElementById(datalist).innerHTML = opt;
}

function fill_input(array) {
    var i = 0;
    array.forEach(element => {
        document.getElementById('id_resolucion_' + i).setAttribute("required", "");
        document.getElementById('fecha_resolucion_' + i).setAttribute("required", "");
        document.getElementById(Object.keys(array[0])[0] + '_' + i).value = element.fecha_grado;
        i++;
    });
}