var ActasSinAprobarAlertPlaceholder = document.getElementById('ActasSinAprobarAlertPlaceholder');
var btnaprobarprevio = document.getElementById('btn-aprobar-previo');
var btneliminarprevio = document.getElementById('btn-eliminar-previo');
var lista_sinaprobar = document.getElementById('lista_resolucion_x_fecha');
var fecha_grado = document.getElementById('fecha_grado');
document.getElementById('form_actas').addEventListener('submit', submit_acta_sinaprobar);
btneliminarprevio.addEventListener('click', eliminar_listado_previo, true);

document.getElementById('nav-actas-sinaprobar-tab').addEventListener("click", function (event) {
    document.getElementById('form_actas').reset();
    actas_table_sinaprobar();
    lista_parametros_fechas();
});

function lista_parametros_fechas() {
    let fd = new FormData();
    fd.append('accion', 'lista_fechas_sinaprobar');
    axios.post('src/Actions/form_control.php', fd).then(function (res) {
        let info = res.data.data;
        if (Object.entries(info).length !== 0) {
            fill_input(info);
        } else {
            alert(ActasSinAprobarAlertPlaceholder, 'No hay fechas de grado definidas', 'warning')
        }
    });
}

function submit_acta_sinaprobar(event) {
    event.preventDefault();
    btnaprobarprevio.disabled = true;
    btneliminarprevio.disabled = true;
    let descripcion = event.submitter.getAttribute('description');
    let name = event.submitter.getAttribute('name');
    let value = event.submitter.getAttribute('value');
    var fd = new FormData();
    if (value == "aprobar_listado_previo") {
        for (let index = 0; index < 3; index++) {
            fd.append('fecha_grado_' + index, document.getElementById('fecha_grado_' + index).value);
            fd.append('resolucion_id_' + index, document.getElementById('id_resolucion_' + index).value);
            fd.append('fecha_resolucion_' + index, document.getElementById('fecha_resolucion_' + index).value);
        }
    }
    if (window.confirm(`Al dar clic en aceptar se ejercutara la ${descripcion} \n ¿Esta seguro de continuar?`)) {
        alert(ActasSinAprobarAlertPlaceholder, `El proceso ${descripcion} se esta ejecutando por favor espera...`, 'info')
        fd.append(name, value);
        axios.post('src/Actions/procedimientos_control.php', fd, {
        }).then(function (response) {
            let res = response.data.respuesta;
            actas_table_sinaprobar();
            if (res === true) {
                alert(ActasSinAprobarAlertPlaceholder, 'Se ejecuto la acción de forma correcta', 'success')
            } else if (res === false) {
                alert(ActasSinAprobarAlertPlaceholder, 'Error durante la ejecución', 'danger');
            } else {
                alert(ActasSinAprobarAlertPlaceholder, 'Error desconocido', 'danger')
            }
        })
    } else {
        btnaprobarprevio.disabled = false;
        btneliminarprevio.disabled = false;
    }
}

function eliminar_listado_previo() {
    btnaprobarprevio.disabled = true;
    btneliminarprevio.disabled = true;
    let button = document.getElementById('btn-eliminar-previo');
    let descripcion = button.getAttribute('description');
    let name = button.getAttribute('name');
    let value = button.getAttribute('value');
    var fd = new FormData();
    if (window.confirm(`Al dar clic en aceptar se ejercutara la ${descripcion} \n ¿Esta seguro de continuar?`)) {
        alert(ActasSinAprobarAlertPlaceholder, `El proceso ${descripcion} se esta ejecutando por favor espera...`, 'info')
        fd.append(name, value);
        axios.post('src/Actions/procedimientos_control.php', fd, {
        }).then(function (response) {
            let res = response.data.respuesta;
            actas_table_sinaprobar();
            if (res === true) {
                alert(ActasSinAprobarAlertPlaceholder, 'Se ejecuto la acción de forma correcta', 'success')
            } else if (res === false) {
                alert(ActasSinAprobarAlertPlaceholder, 'Error durante la ejecución', 'danger');
            } else {
                alert(ActasSinAprobarAlertPlaceholder, 'Error desconocido', 'danger')
            }
        })
    } else {
        btnaprobarprevio.disabled = false;
        btneliminarprevio.disabled = false;
    }
}

function actas_table_sinaprobar() {
    let fd = new FormData();
    fd.append('accion', 'lista_actas_sinaprobar');
    axios.post('src/Actions/table_control.php', fd).then(function (res) {
        if (Object.entries(res.data.data).length !== 0) {
            btnaprobarprevio.disabled = false;
            btneliminarprevio.disabled = false;
        }
        else {
            btneliminarprevio.disabled = true;
            btnaprobarprevio.disabled = true;
        }
        $('#actas_table_sinaprobar').dataTable({
            aaData: res.data.data,
            destroy: true,
            scrollY: 500,
            iDisplayLength: 100,
            scrollX: true,
            columns: [
                { data: 'registro_id' },
                { data: 'tipo_docident_abrev' },
                { data: 'doc_ident' },
                { data: 'municipio_docident' },
                { data: 'nombre' },
                { data: 'titulo_diploma' },
                { data: 'fecha_grado_formato' },
                { data: 'folio_id' },
                { data: 'libro_id' },
                { data: 'fecha_registro_formato' },
                { data: 'consecutivo_diploma' },
                { data: 'carrera_actas_id' },
                { data: 'titulo_acta' },
                { data: 'proconsecutivo_id' },
                // { data: 'desc_plan' },
                // { data: 'resolucion_id' },
                // { data: 'plan_estudio_id' },
                // { data: 'fecha_resolucion' },
                // { data: 'periodo_id' },
                { data: 'estudiante_id' },
                { data: 'tipo_grado' },
                { data: 'estado_acta' }
            ],
            language: {
                lengthMenu: 'Mostrar _MENU_ registros',
                zeroRecords: 'No se encontraron resultados',
                info: 'Se encontró un total de _TOTAL_ registros',
                infoEmpty: 'Mostrando registros del 0 al 0 de un total de 0 registros',
                infoFiltered: '(filtrado de un total de _MAX_ registros)',
                sSearch: 'Buscar:',
                oPaginate: {
                    sFirst: 'Primero',
                    sLast: 'Último',
                    sNext: 'Siguiente',
                    sPrevious: 'Anterior',
                },
                sProcessing: 'Procesando...',
            },
            //para usar los botones
            dom: 'Bfrtip',
            responsive: 'true',
            buttons: [{
                extend: 'excelHtml5',
                text: '<i class="fas fa-file-excel"></i> Reporte actas sin aprobar',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                autoFilter: true,
                title: 'Reporte actas sin aprobar',
            }]
        });
    });
}