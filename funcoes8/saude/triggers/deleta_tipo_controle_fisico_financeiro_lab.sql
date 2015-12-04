-- Trigger que deleta a informa��o do tipo de controle quando n�o se tem mais informa��o de controle lan�ada.
-- Desta forma, torna-se poss�vel escolher um outro tipo de controle
CREATE OR REPLACE FUNCTION fc_deleta_tipo_controle_fisico_financeiro_lab ()
RETURNS TRIGGER AS $$
BEGIN
  IF NOT EXISTS(SELECT * FROM lab_controlefisicofinanceiro) THEN
    DELETE FROM lab_tipocontrolefisicofinanceiro;
  END IF;
  RETURN NEW;
END;
$$LANGUAGE 'plpgsql';

CREATE TRIGGER tg_deleta_tipo_controle_fisico_financeiro_lab
AFTER DELETE ON lab_controlefisicofinanceiro FOR EACH ROW
EXECUTE PROCEDURE fc_deleta_tipo_controle_fisico_financeiro_lab ();
