SELECT TO_CHAR(FECHA_GRADO,'DD/MM/YYYY HH12:MI:SS a.m.') FECHA_GRADO
FROM RC_ACTAS
WHERE ESTADO_ACTA = 'APROBADO'
GROUP BY TO_CHAR(FECHA_GRADO,'DD/MM/YYYY HH12:MI:SS a.m.')