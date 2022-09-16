<?php session_start(); ?>
<!doctype html>
<html lang="es">

<head>
    <!-- Required meta tags -->
    <meta http-equiv="Content-type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">
    <!-- FontAwesome -->
    <script src="https://kit.fontawesome.com/265908e74f.js" crossorigin="anonymous"></script>
    <!-- Axios -->
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>
    <!-- Datatable -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.2/css/jquery.dataTables.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.6.2/css/buttons.bootstrap4.min.css" />
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/datetime/1.1.1/css/dataTables.dateTime.min.css" />
    <title>Actas de grado</title>
</head>

<body>
    <div class="container-fluid" style="padding: 0px;">
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-generar-tab" data-bs-toggle="tab" data-bs-target="#nav-generar" type="button" role="tab" aria-controls="nav-generar" aria-selected="true">1.Generar</button>
                <button class="nav-link" id="nav-tablas-tab" data-bs-toggle="tab" data-bs-target="#nav-tablas" type="button" role="tab" aria-controls="nav-tablas" aria-selected="false">2.Tablas</button>
                <button class="nav-link" id="nav-imprimir-tab" data-bs-toggle="tab" data-bs-target="#nav-imprimir" type="button" role="tab" aria-controls="nav-imprimir" aria-selected="false">3.Imprimir</button>
            </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-generar" role="tabpanel" aria-labelledby="nav-generar-tab">
                <?php include __DIR__ . "/template/form.html"; ?>
            </div>
            <div class="tab-pane fade" id="nav-tablas" role="tabpanel" aria-labelledby="nav-tablas-tab">
                <?php include __DIR__ . "/template/collapse_table.php"; ?>
            </div>
            <div class="tab-pane fade" id="nav-imprimir" role="tabpanel" aria-labelledby="nav-imprimir-tab">
                <?php include __DIR__ . "/template/print.php"; ?>
            </div>
        </div>
    </div>
    <!-- Option 2: Separate Popper and Bootstrap JS -->

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.3/dist/umd/popper.min.js" integrity="sha384-eMNCOe7tC1doHpGoWe/6oMVemdAVTMs2xqW4mwXrXsW0L84Iytr2wi5v2QjrP/xp" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.min.js" integrity="sha384-cn7l7gDp0eyniUwwAZgrzD06kc/tftFf19TOAs2zVinnD/C7E91j9yyk5//jjpt/" crossorigin="anonymous"></script>
    <!-- Datatable -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
    <!-- Dates -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.18.1/moment.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/datetime/1.1.1/js/dataTables.dateTime.min.js"></script>
    <!-- Buttons -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/dataTables.buttons.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.bootstrap4.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.html5.min.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.6.2/js/buttons.print.min.js"></script>


    <!-- <script src="public/assets/js/aptos_grado.js"></script>
    <script src="public/assets/js/estudio_grado.js"></script> -->
    <script src="public/assets/js/actas_config.js"></script>
    <script src="public/assets/js/actas_sinaprobar.js"></script>
    <script src="public/assets/js/actas_aprobadas.js"></script>
    <script src="public/assets/js/table.js"></script>
    <script src="public/assets/js/functions.js"></script>
    <script src="public/assets/js/form.js"></script>
    <script src="public/assets/js/print.js"></script>
    <script src="public/assets/js/functions.js"></script>
</body>

</html>