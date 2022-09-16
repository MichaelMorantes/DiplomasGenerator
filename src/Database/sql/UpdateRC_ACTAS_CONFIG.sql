UPDATE RC_ACTAS_CONFIG
SET    RESOLUCION_ID        = :resolucion_id,
       FECHA_RESOLUCION     = TO_DATE(:fecha_resolucion, 'DD/MM/YYYY')
WHERE  ESTADO_DATOS      = 'SIN_APROBAR'
AND FECHA_GRADO = TO_DATE(:fecha_grado, 'DD/MM/YYYY HH12:MI:SS a.m.')