var btncargaractasaprobadas = document.getElementById('btn-cargar-actas-aprobadas');
var ActasAprobadasAlertPlaceholder = document.getElementById('ActasAprobadasAlertPlaceholder');
var divtableactasaprobadas = document.getElementById('div_table_actas_aprobadas');

document.getElementById('nav-actas-aprobadas-tab').addEventListener("click", function (event) {
    ActasAprobadasAlertPlaceholder.innerHTML = "";
    consulta_periodos_aprobadas();
});

document.getElementById('actas_aprobadas').addEventListener("submit", function (event) {
    event.preventDefault();
    btncargaractasaprobadas.disabled = true;
    let form = document.querySelector('#actas_aprobadas');
    let fd = new FormData(form);
    let formObj = {};
    for (let [key, value] of fd.entries()) {
        formObj[key] = value;
    }
    let descripcion = event.submitter.getAttribute('description');
    if (window.confirm(`Al dar clic en aceptar se ejercutara la ${descripcion} \n ¿Esta seguro de continuar?`)) {
        alert(ActasAprobadasAlertPlaceholder, `El proceso ${descripcion} se esta ejecutando por favor espera...`, 'info')
        divtableactasaprobadas.hidden = false;
        actas_table_aprobada(formObj);
    } else {
        btncargaractasaprobadas.disabled = false;
    }
});

function consulta_periodos_aprobadas() {
    let fd = new FormData();
    fd.append('accion', 'lista_periodos_aprobadas');
    axios.post('src/Actions/print_control.php', fd).then(function (res) {
        let info = res.data.data;
        if (Object.entries(info).length !== 0) {
            fill_list('actas_aprobadas_periodo', info)
        } else {
            alert(ActasAprobadasAlertPlaceholder, 'Error al cargar los periodos', 'danger')
        }
    });
}

function actas_table_aprobada(array) {
    let fd = new FormData();
    fd.append(Object.keys(array), Object.values(array));
    fd.append('accion', 'lista_actas_aprobadas');
    axios.post('src/Actions/table_control.php', fd).then(function (res) {
        if (res) {
            alert(ActasAprobadasAlertPlaceholder, 'Se ejecuto la acción de forma correcta', 'success');
            btncargaractasaprobadas.disabled = false;
            $('#actas_table_aprobada').dataTable({
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
                    { data: 'resolucion_id' },
                    { data: 'fecha_resolucion' },
                    // { data: 'desc_plan' },
                    // { data: 'plan_estudio_id' },
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
                // BPlfrtip
                responsive: 'true',
                buttons: [{
                    extend: 'excelHtml5',
                    text: '<i class="fas fa-file-excel"></i> Reporte actas aprobadas',
                    titleAttr: 'Exportar a Excel',
                    className: 'btn btn-success',
                    autoFilter: true,
                    title: 'Reporte actas aprobadas',
                }]
            });
        } else {
            alert(ActasAprobadasAlertPlaceholder, 'Error en los parametros enviados', 'error');
        }
    });
}