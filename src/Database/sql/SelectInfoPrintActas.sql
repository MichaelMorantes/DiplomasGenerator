SELECT LPAD(A.CARRERA_ACTAS_ID, 3, '0') CARRERA_ACTAS_ID,
    A.PROCONSECUTIVO_ID,
	CONVERT(
            PADPS_PLAN_ESTUDIO.fVAGetDESCRIPCION(A.PLAN_ESTUDIO_ID),
           'UTF8'
    ) DESC_PLAN,
    SUBSTR(
        CONVERT(
            PADPS_PLAN_ESTUDIO.fVAGetDESCRIPCION(A.PLAN_ESTUDIO_ID),
            'UTF8'
        ),
        16,
        100
	    ) DESC_TECNOLOGO,
    TO_CHAR(A.FECHA_GRADO, 'HH12:MI a.m.') HORA_GRADO,
    TO_CHAR(A.FECHA_GRADO, 'DD') DIA_GRADO,
    TO_CHAR(
        A.FECHA_GRADO,
        'fmMONTH',
        'nls_date_language=spanish'
    ) MES_GRADO,
    TO_CHAR(A.FECHA_GRADO, 'YYYY') ANO_GRADO,
    TO_CHAR(A.FECHA_GRADO + (1 / 24) * 1.5, 'HH12:MI a.m.') HORA_FIN_GRADO,
    A.RESOLUCION_ID,
    TO_CHAR(A.FECHA_RESOLUCION, 'DD') DIA_RESOLUCION,
    TO_CHAR(
        A.FECHA_RESOLUCION,
        'fmMONTH',
        'nls_date_language=spanish'
    ) MES_RESOLUCION,
    TO_CHAR(
        A.FECHA_RESOLUCION,
        'YYYY',
        'nls_date_language=spanish'
    ) ANO_RESOLUCION,
	TO_CHAR(sysdate, 'HH12:MI a.m.') HORA_EXPEDICION,
    TO_CHAR(sysdate, 'DD') DIA_EXPEDICION,
    TO_CHAR(sysdate, 'fmMONTH', 'nls_date_language=spanish') MES_EXPEDICION,
    TO_CHAR(sysdate, 'YYYY') ANO_EXPEDICION,
	CONVERT(C.NOMBRES || ' ' || C.APELLIDOS, 'UTF8') NOMBRE,
	DECODE(
        C.TIPO_DOCIDENT_ID,
        1,
        'CÉDULA DE CIUDADANÍA',
        2,
        'TARJETA DE IDENTIDAD',
        3,
        'REGISTRO CIVIL',
        4,
        'PASAPORTE',
        5,
        'CÉDULA DE EXTRANJERÍA',
        6,
        'CERTIFICADO CABILDO',
        7,
        'NÚMERO DE IDENTIFICACIÓN TRIBUTARIA',
        8,
        'DOCUMENTO DE IDENTIDAD EXTRANJERA'
    ) TIPO_DOCIDENT_DESC,
    CONVERT(DECODE(
        C.TIPO_DOCIDENT_ID,
        1,
        'C.C.',
        2,
        'T.I.',
        3,
        'R.C.',
        4,
        'P.S.',
        5,
        'C.E.',
        6,
        'C.A',
        7,
        'N.I.',
        8,
        'D.E.'
    ), 'UTF8') TIPO_DOCIDENT_ABREV,
	CONVERT(PADGE_MUNICIPIO.fVAGetDESCRIPCION(C.MUNIC_EXPEDICION), 'UTF8') MUNICIPIO_DOCIDENT,
    A.DOC_IDENT,
    A.TIPO_GRADO,
    A.PERIODO_ID
FROM RC_ACTAS A,
    RC_ESTUDIANTE B,
    RC_DATBAS_ESTUD C
WHERE A.ESTADO_ACTA = 'APROBADO'
    AND A.ESTUDIANTE_ID = B.ESTUDIANTE_ID
    AND B.DATBAS_ESTUD_ID = C.DATBAS_ESTUD_ID