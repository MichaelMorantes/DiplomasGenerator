SELECT ''
FROM RC_ACTAS
WHERE ESTADO_ACTA = 'SIN_APROBAR'
AND FECHA_GRADO = TO_DATE(:fecha_grado, 'DD/MM/YYYY HH12:MI:SS a.m.')