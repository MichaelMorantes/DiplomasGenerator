UPDATE RC_ACTAS_SEQ
SET    SEQ_ACTUAL_ID = SEQ_INICIAL_ID
WHERE  ABREV_SEQ      IN('L','R','F')
