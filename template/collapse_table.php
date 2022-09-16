<div class="card-header d-flex justify-content-center">
    <div class="card-title">Tablas</div>
</div>
<div class="card-body">
    <nav>
        <div class="nav nav-tabs" id="nav-tab" role="tablist">
            <button class="nav-link active" id="nav-parametros-tab" data-bs-toggle="tab" data-bs-target="#nav-parametros" type="button" role="tab" aria-controls="nav-parametros" aria-selected="true">2.1. Parámetros actas</button>
            <button class="nav-link" id="nav-actas-sinaprobar-tab" data-bs-toggle="tab" data-bs-target="#nav-actas-sinaprobar" type="button" role="tab" aria-controls="nav-actas-sinaprobar" aria-selected="false">2.2. Actas sin aprobar</button>
            <button class="nav-link" id="nav-actas-aprobadas-tab" data-bs-toggle="tab" data-bs-target="#nav-actas-aprobadas" type="button" role="tab" aria-controls="nav-actas-aprobadas" aria-selected="false">2.3. Actas aprobadas</button>
            <form action="src/Actions/printxlsx.php" target="_self" rel="external" method="GET">
                <button type="submit" name="reporte" value="reporte_aptos_grado" class="btn btn-success" id="nav-aptos-tab"><i class="fas fa-file-excel"></i> Estudiantes con estado AGR</button>
                <button type="submit" name="reporte" value="reporte_estudio_grado" class="btn btn-success" id="nav-estudio-tab"><i class="fas fa-file-excel"></i> Estudio de grado</button>
            </form>
        </div>
    </nav>
    <div class="tab-content" id="nav-tabContent">
        <div class="tab-pane show active" id="nav-parametros" role="tabpanel" aria-labelledby="nav-parametros-tab">
            <?php include __DIR__ . "/tables/actas_config.html"; ?>
        </div>
        <div class="tab-pane" id="nav-actas-sinaprobar" role="tabpanel" aria-labelledby="nav-actas-sinaprobar-tab">
            <?php include __DIR__ . "/tables/actas_sinaprobar.html"; ?>
        </div>
        <div class="tab-pane" id="nav-actas-aprobadas" role="tabpanel" aria-labelledby="nav-actas-aprobadas-tab">
            <?php include __DIR__ . "/tables/actas_aprobadas.html"; ?>
        </div>
    </div>
</div>