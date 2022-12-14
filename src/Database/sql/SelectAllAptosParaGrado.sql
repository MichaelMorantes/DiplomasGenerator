SELECT
B.PLAN_ESTUDIO_ID,
CONVERT(PADPS_PLAN_ESTUDIO.fVAGetDESCRIPCION(B.PLAN_ESTUDIO_ID),'UTF8') DESC_PLAN,
UT_ULTIMO_PERIODO(B.ESTUDIANTE_ID)ULTIMO_PERIODO,
B.PENSUM_ID,
A.ESTADO_ESTUDIANTE_ID,
B.ESTUDIANTE_ID,
B.DOC_IDENT,
CONVERT(B.APELLIDOS,'UTF8') APELLIDOS,
CONVERT(B.NOMBRES,'UTF8') NOMBRES,
B.EMAIL,
B.TELEF_CELULAR,
B.TELEF_RESID_PRI,
B.TELEF_RESID_ALT,
B.TELEF_OFICINA,
B.JORNADA_ID,
B.SEMESTRE,
Ps_Total_Materias(B.PENSUM_X_PLESTUDIO_ID) TOTAL_MAT_PLAN,
Rc_Materias_Aprobadas(B.ESTUDIANTE_ID,B.PENSUM_X_PLESTUDIO_ID) TOTAL_MAT_ESTUD,
CONVERT(DECODE(B.PENSUM_X_PLESTUDIO_ID,NULL,99,RC_MATERIAS_PENDIENTES(B.ESTUDIANTE_ID,B.PENSUM_X_PLESTUDIO_ID)),'UTF8') MAT_PEND,
REP_RC_MAT_PEND2(B.ESTUDIANTE_ID)MATERIAS_PENDIENTES,
DECODE(REP_MAT_ARTE_O_DEPORTE(B.ESTUDIANTE_ID),NULL,'',REP_MAT_ARTE_O_DEPORTE(B.ESTUDIANTE_ID) ||' - '|| CONVERT(PADPS_MATERIA.fVAGetDESCRIPCION(REP_MAT_ARTE_O_DEPORTE(B.ESTUDIANTE_ID)),'UTF8')) ARTE_O_DEPORTE,
REP_NMAT_ARTE_O_DEPORTE(B.ESTUDIANTE_ID,REP_MAT_ARTE_O_DEPORTE(B.ESTUDIANTE_ID)) ESTADO_ARTE_O_DEPORTE,
CONVERT(REP_GI_DOC_PEND(B.ESTUDIANTE_ID),'UTF8') DOCUMENTOS_PENDIENTES,
CONVERT(A.OBSERVACION,'UTF8') OBSERVACION_DOC,
(SELECT D.SABER_PRO FROM RC_SABER_PRO D WHERE D.ESTUDIANTE_ID = B.ESTUDIANTE_ID)SABER_PRO,
(SELECT D.NUMERO_ICFES FROM RC_ICFES D WHERE D.ESTUDIANTE_ID = A.ESTUDIANTE_ID AND ROWNUM = 1) COD_PRUEBA_SABER_11,
UT_ULTIMO_PERIODO(B.ESTUDIANTE_ID) ULTIMO_PER_MATRICULADO,
REP_COD_APR_DIP_GRADO(B.ESTUDIANTE_ID) ESTUDIANTE_ID_DIPLOMADO,
--REP_ESTADO_MAT_GRADO(B.ESTUDIANTE_ID,'TD00001') DIP_GRADO_COD_TECNO,
REP_PER_APR_DIP_GRADO(B.ESTUDIANTE_ID) PER_APR_DIPLOMADO,
CONVERT(REP_DIPLO_GRADO(B.ESTUDIANTE_ID),'UTF8') NOMBRE_DIPLOMADO_APR,
(CASE WHEN REP_ESTADO_MAT_GRADO(B.ESTUDIANTE_ID,'TD00001') = 'APR' THEN 'S' WHEN LENGTH(REP_DIPLO_GRADO(B.ESTUDIANTE_ID)) > 0 THEN 'S' ELSE 'N' END) DIPLOMADO_APROBADO,
CONVERT((SELECT F.NOMBRE_PROY FROM RC_PROYGRADO F WHERE F.ESTUDIANTE_ID = B.ESTUDIANTE_ID AND ROWNUM = 1),'UTF8') PROYECTO_GRADO,
(SELECT F.FECHA_SISTEMA FROM RC_PROYGRADO F WHERE F.ESTUDIANTE_ID = B.ESTUDIANTE_ID AND ROWNUM = 1) FEC_APR_TRA_GRADO,
REP_ESTADO_MAT_GRADO(B.ESTUDIANTE_ID,'TG00001') TRABAJO_GRADO,
(CASE WHEN LENGTH((SELECT F.NOMBRE_PROY FROM RC_PROYGRADO F WHERE F.ESTUDIANTE_ID = B.ESTUDIANTE_ID AND ROWNUM = 1)) > 0 THEN 'S' WHEN REP_ESTADO_MAT_GRADO(B.ESTUDIANTE_ID,'TG00001') = 'APR' THEN 'S' ELSE 'N' END ) TRABAJO_APROBADO,
(SELECT 'X' FROM  TE_RECIBOCAJA F , TE_MOVRECIBOCAJA G WHERE F.RECIBO_CAJA_ID = G.RECIBO_CAJA_ID AND G.CONCEPTO_PAGO_ID = '28' AND F.ESTADO_RECIBO_ID = 'AC' AND F.ESTUDIANTE_ID = B.ESTUDIANTE_ID HAVING SUM(G.VALOR) >= PADGE_PARAMETRO.fVAGetVALOR('VAL_DERE_GRAD')) ESTADO_DER_GRADO,
(SELECT SUM(G.VALOR) FROM  TE_RECIBOCAJA F , TE_MOVRECIBOCAJA G WHERE F.RECIBO_CAJA_ID = G.RECIBO_CAJA_ID AND G.CONCEPTO_PAGO_ID = '28' AND F.ESTADO_RECIBO_ID = 'AC' AND F.ESTUDIANTE_ID = B.ESTUDIANTE_ID)VPAGO_DERECHO_GRADO,
(SELECT 'X' FROM CA_CREDITO A WHERE A.ESTUDIANTE_ID = B.ESTUDIANTE_ID AND A.ESTADO_CREDITO_ID = 'CON' AND ROWNUM = 1) ESTADO_CREDITO,
(SELECT 'X' FROM FI_MULTAS A WHERE A.ESTUDIANTE_ID = B.ESTUDIANTE_ID AND A.ESTADO_RECARGO = 'ACT' AND ROWNUM = 1) ESTADO_MULTAS,
(SELECT SUM(G.VALOR) FROM  TE_RECIBOCAJA F , TE_MOVRECIBOCAJA G WHERE F.RECIBO_CAJA_ID = G.RECIBO_CAJA_ID AND G.CONCEPTO_PAGO_ID = '90' AND F.ESTADO_RECIBO_ID = 'AC' AND F.ESTUDIANTE_ID =B.ESTUDIANTE_ID)VPAGO_REINGRESO,
B.SEXO GENERO,
CONVERT(PADGE_TIPO_DOCIDENT.fVAGetDESCRIPCION(B.TIPO_DOCIDENT_ID),'UTF8') TIPO_DOCUMENTO,
CONVERT(DECODE(B.MUNIC_EXPEDICION, NULL,'', PADGE_MUNICIPIO.fVAGetDESCRIPCION(B.MUNIC_EXPEDICION)),'UTF8') LUGAR_EXP_DOC,
CONVERT(B.DIR_RESIDENCIA,'UTF8') DIRECCION,
DECODE(PADRC_DATBAS_ESTUD.fNUGetRESID_BARRIO_ID(B.DATBAS_ESTUD_ID),NULL,'SIN_BARRIO',CONVERT(PADGE_BARRIO.fVAGetDESCRIPCION(PADRC_DATBAS_ESTUD.fNUGetRESID_BARRIO_ID(B.DATBAS_ESTUD_ID)),'UTF8')) BARRIO_ESTUD,
DECODE(PADRC_DATBAS_ESTUD.fNUGetRESID_MUNICIPIO_ID(B.DATBAS_ESTUD_ID),NULL,'SIN_MUNICIPIO',CONVERT(PADGE_MUNICIPIO.fVAGetDESCRIPCION(PADRC_DATBAS_ESTUD.fNUGetRESID_MUNICIPIO_ID(B.DATBAS_ESTUD_ID)),'UTF8')) MUNICIPIO_ESTU,
B.FECHA_NACIMIENTO,
PADRC_DATBAS_ESTUD.fNUGetESTRATO(B.DATBAS_ESTUD_ID) ESTRATO,
(CASE WHEN REP_ESTADO_MAT_GRADO(B.ESTUDIANTE_ID,'TD00001') = 'APR' THEN 'OK_DIP' WHEN LENGTH(REP_DIPLO_GRADO(B.ESTUDIANTE_ID)) > 0 THEN 'OK_DIP'
WHEN LENGTH((SELECT F.NOMBRE_PROY FROM RC_PROYGRADO F WHERE F.ESTUDIANTE_ID = B.ESTUDIANTE_ID AND ROWNUM = 1)) > 0 THEN 'OK_TG' WHEN REP_ESTADO_MAT_GRADO(B.ESTUDIANTE_ID,'TG00001') = 'APR' THEN 'OK_TG' ELSE 'PDTE' END )OPCION_GRADO,
(SELECT I.FECHA_ENVIO FROM RC_SOLICITUD_DE_GRADO I WHERE I.ESTUDIANTE_ID = B.ESTUDIANTE_ID) SOLICITUD_DE_GRADO,
(SELECT V.PERIODO_ID FROM  RC_RECONOCIMIENTO V WHERE V.ESTUDIANTE_ID = A.ESTUDIANTE_ID AND V.TIPO_RECONOCIMIENTO_ID = 2) PERIODO_MENCION_HONOR,
CONVERT((SELECT V.PROYECTO FROM  RC_RECONOCIMIENTO V WHERE V.ESTUDIANTE_ID = A.ESTUDIANTE_ID AND V.TIPO_RECONOCIMIENTO_ID = 2),'UTF8') PROYECTO_MENCION_HONOR,
CONVERT((SELECT V.JUSTIFICACION FROM  RC_RECONOCIMIENTO V WHERE V.ESTUDIANTE_ID = A.ESTUDIANTE_ID AND V.TIPO_RECONOCIMIENTO_ID = 2),'UTF8') JUSTIFICACION_MENCION_HONOR
FROM RC_ESTUDIANTE A, VW_DATBAS_ESTUDIANTE B
WHERE A.ESTUDIANTE_ID = B.ESTUDIANTE_ID
AND A.ESTADO_ESTUDIANTE_ID = 'AGR' --CAMBIAR A AGR