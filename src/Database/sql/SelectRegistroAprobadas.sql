SELECT REGISTRO_ID
FROM RC_ACTAS
WHERE ESTADO_ACTA = 'APROBADO'
GROUP BY REGISTRO_ID