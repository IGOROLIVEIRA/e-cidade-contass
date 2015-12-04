-- Trigger que verifica se houve algum lan�amento de requisi��o de exame a partir da data incial de validade do controle
CREATE OR REPLACE FUNCTION fc_impede_delete_controle_com_requisicao()
RETURNS TRIGGER AS $$
BEGIN
  IF EXISTS(SELECT * FROM lab_requiitem WHERE la21_d_data >= OLD.la56_d_ini) THEN -- Não pode deletar
  
    RAISE EXCEPTION 'O registro de controle n�o pode ser exclu�do porque existem registros de requisi��o ap�s a data de in�cio da validade do controle.';
    RETURN NEW;  
    
  ELSE -- Pode deletar
    RETURN OLD;
  END IF;
    
END;
$$LANGUAGE 'plpgsql';

CREATE TRIGGER tg_impede_delete_controle_com_requisicao
BEFORE DELETE ON lab_controlefisicofinanceiro FOR EACH ROW
EXECUTE PROCEDURE fc_impede_delete_controle_com_requisicao();
