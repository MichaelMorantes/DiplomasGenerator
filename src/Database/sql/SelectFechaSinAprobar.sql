SELECT TO_CHAR(FECHA_GRADO,'DD/MM/YYYY HH12:MI:SS a.m.') FECHA_GRADO
FROM RC_ACTAS
WHERE ESTADO_ACTA = 'SIN_APROBAR'
GROUP BY TO_CHAR(FECHA_GRADO,'DD/MM/YYYY HH12:MI:SS a.m.')