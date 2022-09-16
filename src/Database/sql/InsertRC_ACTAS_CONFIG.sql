INSERT INTO RC_ACTAS_CONFIG (
      ACTAS_CONFIG_ID,
      PLAN_ESTUDIO_ID,
      CANTIDAD_ESTUDIANTES,
      FECHA_GRADO,
      TIPO_GRADO
   ) --TO_DATE('19700101','YYYYMMDD')+(:fecha_grado/24/60/60)
VALUES (
      SEQ_RC_ACTAS_CONFIG.NEXTVAL,
      :plan_estudio_id,
      :cantidad_estudiantes,
      TO_DATE(:fecha_grado, 'DD/MM/YYYY HH24:MI:SS'),
      :tipo_grado
   )