document.addEventListener("DOMContentLoaded", function (event) {
    consulta_proceso();
    consulta_config();
    secuencias();
});

document.getElementById('nav-generar-tab').addEventListener("click", function (event) {
    FormAlertPlaceholder.innerHTML = "";
    consulta_proceso();
    consulta_config();
    secuencias();
});

document.getElementById('form').addEventListener('submit', submit_proceso);
document.getElementById('form_agr').addEventListener('submit', submit_agr);
var FormAlertPlaceholder = document.getElementById('FormAlertPlaceholder');
var btnlistadoprevio = document.getElementById('btn-listado-previo');
var btnagr = document.getElementById('btn-agr');

function submit_proceso(event) {
    event.preventDefault();
    var fd = new FormData();
    if (window.confirm("Al dar clic en aceptar se subirá la información brindada para la CONFIGUARIÓN DE ACTAS \n ¿Esta seguro de continuar?")) {
        const rbs = document.querySelectorAll('input[name="tipo_grado"]');
        let selectedValue;
        for (const rbv of rbs) {
            if (rbv.checked) {
                selectedValue = rbv.value;
                break;
            }
        }
        fd.append("excel", document.querySelector('#excel').files[0]);
        fd.append("tipo_grado", selectedValue);
        fd.append("accion", "ingreso_excel");
        axios.post('src/Actions/form_control.php', fd, {
            headers: {
                'Content-Type': 'multipart/form-data'
            }
        }).then(function (response) {
            let res = response.data.respuesta;
            consulta_proceso();
            secuencias();
            document.getElementById('form').reset();
            if (res === true) {
                alert(FormAlertPlaceholder, 'Se subio la información de forma correcta', 'success')
            } else if (res === false) {
                alert(FormAlertPlaceholder, 'Error durante la validación de datos', 'danger');
            } else if (typeof res === 'string') {
                alert(FormAlertPlaceholder, 'Excepción capturada para una o mas filas:' + res, 'warning')
            } else {
                alert(FormAlertPlaceholder, 'Error desconocido', 'danger')
            }
        })
    }
}

function submit_agr(event) {
    event.preventDefault();
    btnlistadoprevio.disabled = true;
    btnagr.disabled = true;
    var fd = new FormData();
    if (window.confirm("Al dar clic en aceptar se ejecutara el PROCESO DE ACTUALIZACIÓN DE ESTADO DE ESTUDIANTES A AGR \n ¿Esta seguro de continuar?")) {
        alert(FormAlertPlaceholder, `El proceso PROCESO DE ACTUALIZACIÓN DE ESTADO DE ESTUDIANTES A AGR se esta ejecutando por favor espera...`, 'info')
        fd.append("accion", "proceso_agr");
        axios.post('src/Actions/form_control.php', fd, {
        }).then(function (response) {
            btnlistadoprevio.disabled = false;
            btnagr.disabled = false;
            let res = response.data.respuesta;
            if (res === true) {
                alert(FormAlertPlaceholder, 'Se actualizó el estado de los estudiantes de forma correcta', 'success')
            } else if (typeof res === 'string') {
                alert(FormAlertPlaceholder, 'Excepción capturada para una o mas filas:' + res, 'warning')
            } else {
                alert(FormAlertPlaceholder, 'Error desconocido', 'danger')
            }
        })
    } else {
        btnlistadoprevio.disabled = false;
        btnagr.disabled = false;
    }
}

function consulta_proceso() {
    let btn = document.getElementById('btn-listado-previo');
    let fd = new FormData();
    fd.append('accion', 'estado_proceso');
    axios.post('src/Actions/form_control.php', fd).then(function (res) {
        let info = res.data.data;
        if (Object.entries(info).length !== 0) {
            alert(FormAlertPlaceholder, 'No se puede ejecutar el proceso, existe un listado previo sin aprobar', 'danger')
            btn.disabled = true;
        } else {
            alert(FormAlertPlaceholder, 'Se puede ejecutar el proceso', 'primary')
            btn.disabled = false;
        }
    });
}

function consulta_config() {
    let fd = new FormData();
    fd.append('accion', 'estado_config');
    axios.post('src/Actions/form_control.php', fd).then(function (res) {
        let info = res.data.data;
        if (Object.entries(info).length !== 0) {
            alert(FormAlertPlaceholder, 'Precaución existe un listado de Parámetros de actas', 'warning')
        }
    });
}

function secuencias() {
    let fd = new FormData();
    fd.append('accion', 'lista_seq');
    axios.post('src/Actions/form_control.php', fd).then(function (res) {
        let info = res.data.data;
        if (Object.entries(info).length !== 0) {
            document.getElementById('registro').value = Object.values(info[0])[2];
            document.getElementById('libro').value = Object.values(info[1])[2];
            document.getElementById('folio').value = Object.values(info[2])[2];
            actas_seq(info);
        } else {
            alert(FormAlertPlaceholder, '¡Urgente! secuencias vacías, comunicate con el área de soporte', 'danger')
        }
    });
}

function actas_seq(array_actas) {
    for (var i = 3; i <= Object.entries(array_actas).length - 3; i++) {
        valores = Object.values(array_actas[i])[1] + ' - Acta: ' + Object.values(array_actas[i])[2] + '\n';
        document.getElementById('actas').value += valores;
        let text = document.getElementById('actas').value;
        text.replace(/\r?\n/g, '<br />')
    }
}