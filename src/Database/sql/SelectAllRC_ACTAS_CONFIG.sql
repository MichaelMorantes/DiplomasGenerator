SELECT PLAN_ESTUDIO_ID,
    CONVERT(PADPS_PLAN_ESTUDIO.fVAGetDESCRIPCION(PLAN_ESTUDIO_ID), 'UTF8') DESC_PLAN,
    CANTIDAD_ESTUDIANTES,
    TO_CHAR(FECHA_GRADO,'DD/MM/YYYY HH12:MI:SS AM') FECHA_GRADO,
    TIPO_GRADO
FROM RC_ACTAS_CONFIG
WHERE ESTADO_DATOS = 'SIN_APROBAR'