var btnimprimiractas = document.getElementById('btn-imprimir-actas');
var PrintAlertPlaceholder = document.getElementById('PrintAlertPlaceholder');
var radiobuttons = document.forms['print'].elements['tipo_acta'];
var filtros = ['SelectPlanEstudioAprobadas', 'SelectFechaAprobadas', 'SelectLibroAprobadas', 'p_folio', 'p_acta'];
var querys = ['SelectCodigoAprobadas', 'SelectCedulaAprobadas', 'SelectPlanEstudioAprobadas', 'SelectLibroAprobadas', 'SelectRegistroAprobadas', 'SelectFolioAprobadas', 'SelectCodActaAprobadas', 'SelectFechaAprobadas']

for (var i = 0, length = radiobuttons.length; i < length; i++) {
    radiobuttons[i].onchange = function () {
        filtros.forEach(Element => {
            let item = document.getElementById(Element);
            item.disabled ? item.disabled = false : item.disabled = true;
        });
    };
}

document.addEventListener("DOMContentLoaded", function (event) {
    existen_actas_print();
    consulta_periodo_print();
    document.getElementById('print').reset();
});

document.getElementById('nav-imprimir-tab').addEventListener("click", function (event) {
    PrintAlertPlaceholder.innerHTML = "";
    existen_actas_print();
    consulta_periodo_print();
    document.getElementById('print').reset();
});

document.getElementById('btn-limpiar-print').addEventListener('click', function (event) {
    document.getElementById('print').reset();
    filtros.forEach(Element => {
        let item = document.getElementById(Element);
        item.disabled = false;
    });
});

document.getElementById('carga_parametros_print').addEventListener("submit", function (event) {
    event.preventDefault();
    let form = document.querySelector('#carga_parametros_print');
    let fd = new FormData(form);
    let formObj = {};
    for (let [key, value] of fd.entries()) {
        formObj[key] = value;
    }
    let descripcion = event.submitter.getAttribute('description');
    if (window.confirm(`Al dar clic en aceptar se ejercutara la ${descripcion} \n ¿Esta seguro de continuar?`)) {
        alert(ActasAprobadasAlertPlaceholder, `El proceso ${descripcion} se esta ejecutando por favor espera...`, 'info')
        querys.forEach(element => {
            lista_parametros_print(element, formObj['PERIODO_ID']);
        });
        document.getElementById('fieldset_print').disabled = false;
    }
});

function lista_parametros_print(query_y_elemento, periodo) {
    let fd = new FormData();
    fd.append('query', query_y_elemento);
    fd.append('periodo', periodo);
    fd.append('accion', 'lista_parametros_print');
    axios.post('src/Actions/print_control.php', fd).then(function (res) {
        let info = res.data.data;
        if (Object.entries(info).length !== 0) {
            if (query_y_elemento === 'SelectPlanEstudioAprobadas') {
                fill_list(query_y_elemento, info, ' - ')
            } else {
                fill_list(query_y_elemento, info)
            }
        } else {
            alert(PrintAlertPlaceholder, 'Error al cargar los códigos estudiantiles', 'danger')
        }
    });
}

function existen_actas_print() {
    let fd = new FormData();
    fd.append('accion', 'lista_actas_aprobadas');
    axios.post('src/Actions/table_control.php', fd).then(function (res) {
        let info = res.data.data;
        if (info == 0) {
            alert(PrintAlertPlaceholder, 'No existen actas aprobadas', 'warning')
            btnimprimiractas.disabled = true;
        } else {
            btnimprimiractas.disabled = false;
        }
    });
}

function consulta_periodo_print() {
    let fd = new FormData();
    fd.append('accion', 'lista_periodos_aprobadas');
    axios.post('src/Actions/print_control.php', fd).then(function (res) {
        let info = res.data.data;
        if (Object.entries(info).length !== 0) {
            fill_list('p_periodo_grado', info)
        } else {
            alert(PrintAlertPlaceholder, 'Error al cargar los periodos de grado', 'danger')
        }
    });
}