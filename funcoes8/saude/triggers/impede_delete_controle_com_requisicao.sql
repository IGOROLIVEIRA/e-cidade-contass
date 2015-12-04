-- Trigger que verifica se houve algum lançamento de requisição de exame a partir da data incial de validade do controle
CREATE OR REPLACE FUNCTION fc_impede_delete_controle_com_requisicao()
RETURNS TRIGGER AS $$
BEGIN
  IF EXISTS(SELECT * FROM lab_requiitem WHERE la21_d_data >= OLD.la56_d_ini) THEN -- NÃ£o pode deletar
  
    RAISE EXCEPTION 'O registro de controle não pode ser excluído porque existem registros de requisição após a data de início da validade do controle.';
    RETURN NEW;  
    
  ELSE -- Pode deletar
    RETURN OLD;
  END IF;
    
END;
$$LANGUAGE 'plpgsql';

CREATE TRIGGER tg_impede_delete_controle_com_requisicao
BEFORE DELETE ON lab_controlefisicofinanceiro FOR EACH ROW
EXECUTE PROCEDURE fc_impede_delete_controle_com_requisicao();
