<div class="card-header d-flex justify-content-center">
    <div class="card-title">Imprenta actas</div>
</div>
<div class="card-body">
    <div id="PrintAlertPlaceholder">
    </div>
    <?php include __DIR__ . "/../src/Utils/alert/alert_action.php"; ?>
    <form id="carga_parametros_print">
        <div class="row mb-3">
            <div class="col-md-4">
                <label for="p_periodo_grado" class="form-label">Periodo</label>
                <div class="input-group">
                    <select class="form-control" id="p_periodo_grado" name="PERIODO_ID" aria-describedby="btn-cargar-actas-aprobadas" required>
                    </select>
                    <button type="submit" name="accion" description="CARGUE PARAMETROS DE IMPRESIÓN" value="lista_actas_aprobadas" id="btn-cargar-actas-aprobadas" class="btn btn-primary">Cargar</button>
                </div>
            </div>
        </div>
    </form>
    <form formtarget="_blank" target="_blank" class="g-3" id="print" action="src/Actions/print_control.php" method="POST">
        <div class="card">
            <div class="card-body">
                <fieldset id="fieldset_print" disabled>
                    <div class="mb-3 row">
                        <div class="col-md-3">
                            <label for="version_acta" class="form-label">Version del acta<label style="color:red">*</label></label>
                            <select class="form-select" id="version_acta" name="version_acta" required>
                                <option value="V2">V2.0 (2021-1 a 2022-2)</option>
                                <option value="V1">V1.0 (2019-2 a 2020-2)</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="p_codigo" class="form-label">Código estudiante</label>
                            <input type="text" class="form-control" list="SelectCodigoAprobadas" id="p_codigo" name="ESTUDIANTE_ID" placeholder="Escribe para buscar...">
                            <datalist id="SelectCodigoAprobadas">
                            </datalist>
                        </div>
                        <div class="col-md-2">
                            <label for="p_documento" class="form-label">Documento identidad</label>
                            <input type="text" class="form-control" list="SelectCedulaAprobadas" id="p_documento" name="DOC_IDENT" placeholder="Escribe para buscar...">
                            <datalist id="SelectCedulaAprobadas">
                            </datalist>
                        </div>
                        <div class="col-md-5">
                            <label for="SelectPlanEstudioAprobadas" class="form-label">Plan de estudio</label>
                            <select class="form-select" id="SelectPlanEstudioAprobadas" name="PLAN_ESTUDIO_ID">
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="SelectFechaAprobadas" class="form-label">Fecha grado</label>
                            <select class="form-select" id="SelectFechaAprobadas" name="FECHA_GRADO">
                            </select>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-2">
                            <label for="SelectLibroAprobadas" class="form-label">Libro</label>
                            <select class="form-select" id="SelectLibroAprobadas" name="LIBRO_ID">
                            </select>
                        </div>
                        <div class="col-md-2">
                            <label for="p_registro" class="form-label">Registro</label>
                            <input type="text" class="form-control" list="SelectRegistroAprobadas" name="REGISTRO_ID" id="p_registro" placeholder="Escribe para buscar...">
                            <datalist id="SelectRegistroAprobadas">
                            </datalist>
                        </div>
                        <div class="col-md-2">
                            <label for="p_folio" class="form-label">Folio</label>
                            <input type="text" class="form-control" list="SelectFolioAprobadas" name="FOLIO_ID" id="p_folio" placeholder="Escribe para buscar...">
                            <datalist id="SelectFolioAprobadas">
                            </datalist>
                        </div>
                        <div class="col-md-2">
                            <label for="p_acta" class="form-label">Acta</label>
                            <input type="text" class="form-control" list="SelectCodActaAprobadas" name="CARRERA_ACTAS_ID" id="p_acta" placeholder="Escribe para buscar...">
                            <datalist id="SelectCodActaAprobadas">
                            </datalist>
                        </div>
                    </div>
                    <div class="mb-3 row">
                        <div class="col-md-5">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="acta_base" name="tipo_acta" id="tipo_acta_base" checked required>
                                <label class="form-check-label" for="tipo_acta_base">
                                    Acta base
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" value="duplicado" name="tipo_acta" id="tipo_acta_duplicado">
                                <label class="form-check-label" for="tipo_acta_duplicado">
                                    Duplicado
                                </label>
                            </div>
                        </div>
                    </div>
                    <button type="submit" name="accion" value="imprimir_actas" id="btn-imprimir-actas" class="btn btn-primary" onclick="return confirm('Al dar clic en aceptar se ejercutara la IMPRESIÓN DE ACTAS \n ¿Esta seguro de continuar?');">Imprimir</button>
                    <button type="button" id="btn-limpiar-print" class="btn btn-danger">Limpiar</button>
                </fieldset>
            </div>
        </div>
    </form>
</div>