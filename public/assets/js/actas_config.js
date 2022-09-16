document.getElementById('nav-parametros-tab').addEventListener('click', actas_config_table);
document.getElementById('actas_config').addEventListener('submit', submit_acta_config);
var ActasConfigAlertPlaceholder = document.getElementById('ActasConfigAlertPlaceholder');
var btngenerarprevio = document.getElementById('btn-generar-previo');
var btneliminarconfig = document.getElementById('btn-eliminar-config');

document.addEventListener("DOMContentLoaded", function (event) {
    actas_config_table();
});

function submit_acta_config(event) {
    event.preventDefault();
    btngenerarprevio.disabled = true;
    btneliminarconfig.disabled = true;
    let descripcion = event.submitter.getAttribute('description');
    let name = event.submitter.getAttribute('name');
    let value = event.submitter.getAttribute('value');
    var fd = new FormData();
    if (window.confirm(`Al dar clic en aceptar se ejercutara la ${descripcion} \n ¿Esta seguro de continuar?`)) {
        alert(ActasConfigAlertPlaceholder, `El proceso ${descripcion} se esta ejecutando por favor espera...`, 'info')
        fd.append(name, value);
        axios.post('src/Actions/procedimientos_control.php', fd, {
        }).then(function (response) {
            let res = response.data.respuesta;
            actas_config_table();
            if (res === true) {
                alert(ActasConfigAlertPlaceholder, 'Se ejecuto la acción de forma correcta', 'success')
            } else if (res === false) {
                alert(ActasConfigAlertPlaceholder, 'Error durante la ejecución', 'danger');
            } else {
                alert(ActasConfigAlertPlaceholder, 'Error desconocido', 'danger')
            }
        })
    } else {
        btngenerarprevio.disabled = false;
        btneliminarconfig.disabled = false;
    }
}

function actas_config_table() {
    let fd = new FormData();
    fd.append('accion', 'lista_actas_config');
    axios.post('src/Actions/table_control.php', fd).then(function (res) {
        if (Object.entries(res.data.data).length !== 0) {
            btngenerarprevio.disabled = false;
            btneliminarconfig.disabled = false;
        }
        else {
            btngenerarprevio.disabled = true;
            btneliminarconfig.disabled = true;
        }
        $('#actas_config_table').dataTable({
            aaData: res.data.data,
            destroy: true,
            scrollY: 500,
            iDisplayLength: 100,
            scrollX: true,
            columns: [
                { data: 'plan_estudio_id' },
                { data: 'desc_plan' },
                { data: 'cantidad_estudiantes' },
                { data: 'fecha_grado' },
                { data: 'tipo_grado' }
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
                text: '<i class="fas fa-file-excel"></i> Reporte configuración actas',
                titleAttr: 'Exportar a Excel',
                className: 'btn btn-success',
                autoFilter: true,
                title: 'Reporte configuracion actas',
            }]
        });
    });
}