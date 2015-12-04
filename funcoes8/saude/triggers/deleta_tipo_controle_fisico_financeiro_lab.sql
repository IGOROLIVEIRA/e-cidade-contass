-- Trigger que deleta a informação do tipo de controle quando não se tem mais informação de controle lançada.
-- Desta forma, torna-se possível escolher um outro tipo de controle
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
