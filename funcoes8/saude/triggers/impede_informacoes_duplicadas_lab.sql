-- Trigger que verifica se um controle já foi incluído, impedindo inserção / alteração do registro
-- Por exemplo, se o exame X foi lançado para o departamento Y do dia 01/01/2011 a 01/02/2011, 
-- nenhum outro registro com informações de controle do exame X para o departamento Y pode existir para este período
CREATE OR REPLACE FUNCTION fc_impede_informacoes_duplicadas_lab ()
RETURNS TRIGGER AS $$
DECLARE
  
  pGrupo CURSOR FOR SELECT sd60_c_grupo FROM sau_grupo WHERE sd60_i_codigo = NEW.la56_i_grupo LIMIT 1;
  pSubGrupo CURSOR FOR SELECT sd61_c_subgrupo FROM sau_subgrupo WHERE sd61_i_codigo = NEW.la56_i_subgrupo LIMIT 1;
  pFormaOrganizacao CURSOR FOR SELECT sd62_c_formaorganizacao FROM sau_formaorganizacao WHERE sd62_i_codigo = NEW.la56_i_formaorganizacao LIMIT 1;
  iTipoControle INT;
  rsGrupo RECORD;
  rsSubGrupo RECORD;
  rsFormaOrganizacao RECORD;
  sGrupo CHAR(2);
  sSubGrupo CHAR(2);
  sFormaOrganizacao CHAR(2);
  sMsg VARCHAR;
  
BEGIN
  
  iTipoControle = NEW.la56_i_tipocontrole;
  IF iTipoControle = 1 THEN -- Controle por departamento solicitante
  
    IF EXISTS(SELECT * FROM lab_controlefisicofinanceiro 
                WHERE la56_i_depto = NEW.la56_i_depto
                  AND la56_i_codigo != NEW.la56_i_codigo -- Para funcionar o update
                  AND ((NEW.la56_d_fim IS NULL AND la56_d_fim IS null) -- Verificacao das datas de validade
                       OR (NEW.la56_d_fim IS NULL AND NEW.la56_d_ini <= la56_d_ini)
                       OR (la56_d_fim IS NULL AND la56_d_ini <= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NULL AND la56_d_fim IS NOT NULL AND la56_d_fim >= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NOT NULL AND la56_d_fim IS NULL AND NEW.la56_d_fim >= la56_d_ini)
                       OR (NEW.la56_d_ini BETWEEN la56_d_ini AND la56_d_fim)
                       OR (NEW.la56_d_fim BETWEEN la56_d_ini AND la56_d_fim)
                       OR (la56_d_ini BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim)
                       OR (la56_d_fim BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim))) THEN
                       
      RAISE EXCEPTION 'Controle físico / financeiro já informado para este departamento no período indicado.';
      RETURN OLD;
      
    END IF;

  ELSEIF iTipoControle = 2 THEN -- Controle por departamento solicitante e exame
  
    IF EXISTS(SELECT * FROM lab_controlefisicofinanceiro 
                WHERE la56_i_depto = NEW.la56_i_depto
                  AND la56_i_exame = NEW.la56_i_exame
                  AND la56_i_codigo != NEW.la56_i_codigo -- Para funcionar o update
                  AND ((NEW.la56_d_fim IS NULL AND la56_d_fim IS null) -- Verificacao das datas de validade
                       OR (NEW.la56_d_fim IS NULL AND NEW.la56_d_ini <= la56_d_ini)
                       OR (la56_d_fim IS NULL AND la56_d_ini <= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NULL AND la56_d_fim IS NOT NULL AND la56_d_fim >= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NOT NULL AND la56_d_fim IS NULL AND NEW.la56_d_fim >= la56_d_ini)
                       OR (NEW.la56_d_ini BETWEEN la56_d_ini AND la56_d_fim)
                       OR (NEW.la56_d_fim BETWEEN la56_d_ini AND la56_d_fim)
                       OR (la56_d_ini BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim)
                       OR (la56_d_fim BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim))) THEN
                       
      RAISE EXCEPTION 'Controle físico / financeiro já informado para este departamento e este exame no período indicado.';
      RETURN OLD;
      
    END IF;
  
  ELSEIF iTipoControle = 3 THEN -- Controle por departamento solicitante e grupo de exames
  
    OPEN pGrupo;
    FETCH pGrupo INTO rsGrupo;
    IF FOUND THEN
      sGrupo := rsGrupo.sd60_c_grupo;
    ELSE
      sGrupo := NULL;
    END IF;
    
    OPEN pSubGrupo;
    FETCH pSubGrupo INTO rsSubGrupo;
    IF FOUND THEN
      sSubGrupo := rsSubGrupo.sd61_c_subgrupo;
    ELSE
      sSubGrupo := NULL;
    END IF;
    
    OPEN pFormaOrganizacao;
    FETCH pFormaOrganizacao INTO rsFormaOrganizacao;
    IF FOUND THEN
      sFormaOrganizacao := rsFormaOrganizacao.sd62_c_formaorganizacao;
    ELSE
      sFormaOrganizacao := NULL;
    END IF;
    
  
    IF EXISTS(SELECT * FROM lab_controlefisicofinanceiro
                INNER JOIN sau_grupo ON sd60_i_codigo = la56_i_grupo
                LEFT  JOIN sau_subgrupo ON sd61_i_codigo = la56_i_subgrupo
                LEFT  JOIN sau_formaorganizacao ON sd62_i_codigo = la56_i_formaorganizacao
                WHERE la56_i_depto = NEW.la56_i_depto
                  AND ((sd60_c_grupo = sGrupo AND sd61_c_subgrupo IS NULL AND sd62_c_formaorganizacao IS NULL)
                       OR (sd60_c_grupo = sGrupo AND sd61_c_subgrupo = sSubGrupo AND sd62_c_formaorganizacao IS NULL)
                       OR (sd60_c_grupo = sGrupo AND sd61_c_subgrupo = sSubGrupo AND sd62_c_formaorganizacao = sFormaOrganizacao)
                       OR (sd60_c_grupo = sGrupo AND sSubGrupo IS NULL AND sFormaOrganizacao IS NULL)
                       OR (sd60_c_grupo = sGrupo AND sd61_c_subgrupo = sSubGrupo AND sFormaOrganizacao IS NULL))
                  AND la56_i_codigo != NEW.la56_i_codigo -- Para funcionar o update
                  AND ((NEW.la56_d_fim IS NULL AND la56_d_fim IS null) -- Verificacao das datas de validade
                       OR (NEW.la56_d_fim IS NULL AND NEW.la56_d_ini <= la56_d_ini)
                       OR (la56_d_fim IS NULL AND la56_d_ini <= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NULL AND la56_d_fim IS NOT NULL AND la56_d_fim >= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NOT NULL AND la56_d_fim IS NULL AND NEW.la56_d_fim >= la56_d_ini)
                       OR (NEW.la56_d_ini BETWEEN la56_d_ini AND la56_d_fim)
                       OR (NEW.la56_d_fim BETWEEN la56_d_ini AND la56_d_fim)
                       OR (la56_d_ini BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim)
                       OR (la56_d_fim BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim))) THEN
                       
      RAISE EXCEPTION 'Controle físico / financeiro já informado para este departamento e grupo de exames no período indicado.';
      RETURN OLD;
      
    END IF;
  
  ELSEIF iTipoControle = 4 THEN -- Controle por laboratorio
  
    IF EXISTS(SELECT * FROM lab_controlefisicofinanceiro 
                WHERE la56_i_laboratorio = NEW.la56_i_laboratorio
                  AND la56_i_codigo != NEW.la56_i_codigo -- Para funcionar o update
                  AND ((NEW.la56_d_fim IS NULL AND la56_d_fim IS null) -- Verificacao das datas de validade
                       OR (NEW.la56_d_fim IS NULL AND NEW.la56_d_ini <= la56_d_ini)
                       OR (la56_d_fim IS NULL AND la56_d_ini <= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NULL AND la56_d_fim IS NOT NULL AND la56_d_fim >= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NOT NULL AND la56_d_fim IS NULL AND NEW.la56_d_fim >= la56_d_ini)
                       OR (NEW.la56_d_ini BETWEEN la56_d_ini AND la56_d_fim)
                       OR (NEW.la56_d_fim BETWEEN la56_d_ini AND la56_d_fim)
                       OR (la56_d_ini BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim)
                       OR (la56_d_fim BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim))) THEN
                       
      RAISE EXCEPTION 'Controle físico / financeiro já informado para este laboratório no período indicado.';
      RETURN OLD;
      
    END IF;
  
  ELSEIF iTipoControle = 5 THEN -- Controle por laboratorio e exame
    
    IF EXISTS(SELECT * FROM lab_controlefisicofinanceiro 
                WHERE la56_i_laboratorio = NEW.la56_i_laboratorio
                  AND la56_i_exame = NEW.la56_i_exame
                  AND la56_i_codigo != NEW.la56_i_codigo -- Para funcionar o update
                  AND ((NEW.la56_d_fim IS NULL AND la56_d_fim IS null) -- Verificacao das datas de validade
                       OR (NEW.la56_d_fim IS NULL AND NEW.la56_d_ini <= la56_d_ini)
                       OR (la56_d_fim IS NULL AND la56_d_ini <= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NULL AND la56_d_fim IS NOT NULL AND la56_d_fim >= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NOT NULL AND la56_d_fim IS NULL AND NEW.la56_d_fim >= la56_d_ini)
                       OR (NEW.la56_d_ini BETWEEN la56_d_ini AND la56_d_fim)
                       OR (NEW.la56_d_fim BETWEEN la56_d_ini AND la56_d_fim)
                       OR (la56_d_ini BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim)
                       OR (la56_d_fim BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim))) THEN
                       
      RAISE EXCEPTION 'Controle físico / financeiro já informado para este laboratório e este exame no período indicado.';
      RETURN OLD;
      
    END IF;
  
  ELSEIF iTipoControle = 6 THEN -- Controle por laboratorio e grupo de exames
  
    OPEN pGrupo;
    FETCH pGrupo INTO rsGrupo;
    IF FOUND THEN
      sGrupo := rsGrupo.sd60_c_grupo;
    ELSE
      sGrupo := NULL;
    END IF;
    
    OPEN pSubGrupo;
    FETCH pSubGrupo INTO rsSubGrupo;
    IF FOUND THEN
      sSubGrupo := rsSubGrupo.sd61_c_subgrupo;
    ELSE
      sSubGrupo := NULL;
    END IF;
    
    OPEN pFormaOrganizacao;
    FETCH pFormaOrganizacao INTO rsFormaOrganizacao;
    IF FOUND THEN
      sFormaOrganizacao := rsFormaOrganizacao.sd62_c_formaorganizacao;
    ELSE
      sFormaOrganizacao := NULL;
    END IF;
  
    IF EXISTS(SELECT * FROM lab_controlefisicofinanceiro
                INNER JOIN sau_grupo ON sd60_i_codigo = la56_i_grupo
                LEFT  JOIN sau_subgrupo ON sd61_i_codigo = la56_i_subgrupo
                LEFT  JOIN sau_formaorganizacao ON sd62_i_codigo = la56_i_formaorganizacao
                WHERE la56_i_laboratorio = NEW.la56_i_laboratorio
                  AND ((sd60_c_grupo = sGrupo AND sd61_c_subgrupo IS NULL AND sd62_c_formaorganizacao IS NULL)
                       OR (sd60_c_grupo = sGrupo AND sd61_c_subgrupo = sSubGrupo AND sd62_c_formaorganizacao IS NULL)
                       OR (sd60_c_grupo = sGrupo AND sd61_c_subgrupo = sSubGrupo AND sd62_c_formaorganizacao = sFormaOrganizacao)
                       OR (sd60_c_grupo = sGrupo AND sSubGrupo IS NULL AND sFormaOrganizacao IS NULL)
                       OR (sd60_c_grupo = sGrupo AND sd61_c_subgrupo = sSubGrupo AND sFormaOrganizacao IS NULL))
                  AND la56_i_codigo != NEW.la56_i_codigo -- Para funcionar o update
                  AND ((NEW.la56_d_fim IS NULL AND la56_d_fim IS null) -- Verificacao das datas de validade
                       OR (NEW.la56_d_fim IS NULL AND NEW.la56_d_ini <= la56_d_ini)
                       OR (la56_d_fim IS NULL AND la56_d_ini <= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NULL AND la56_d_fim IS NOT NULL AND la56_d_fim >= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NOT NULL AND la56_d_fim IS NULL AND NEW.la56_d_fim >= la56_d_ini)
                       OR (NEW.la56_d_ini BETWEEN la56_d_ini AND la56_d_fim)
                       OR (NEW.la56_d_fim BETWEEN la56_d_ini AND la56_d_fim)
                       OR (la56_d_ini BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim)
                       OR (la56_d_fim BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim))) THEN
                       
      RAISE EXCEPTION 'Controle físico / financeiro já informado para este laboratório e grupo de exames no período indicado.';
      RETURN OLD;
      
    END IF;
    
  ELSEIF iTipoControle = 7 THEN -- Controle por grupo de exames
  
    OPEN pGrupo;
    FETCH pGrupo INTO rsGrupo;
    IF FOUND THEN
      sGrupo := rsGrupo.sd60_c_grupo;
    ELSE
      sGrupo := NULL;
    END IF;
    
    OPEN pSubGrupo;
    FETCH pSubGrupo INTO rsSubGrupo;
    IF FOUND THEN
      sSubGrupo := rsSubGrupo.sd61_c_subgrupo;
    ELSE
      sSubGrupo := NULL;
    END IF;
    
    OPEN pFormaOrganizacao;
    FETCH pFormaOrganizacao INTO rsFormaOrganizacao;
    IF FOUND THEN
      sFormaOrganizacao := rsFormaOrganizacao.sd62_c_formaorganizacao;
    ELSE
      sFormaOrganizacao := NULL;
    END IF;
    
    -- RAISE NOTICE 'Grupo %    SubGrupo %  FormaOrganizacao %', sGrupo, sSubGrupo, sFormaOrganizacao;
    
    IF EXISTS(SELECT * FROM lab_controlefisicofinanceiro
                INNER JOIN sau_grupo ON sd60_i_codigo = la56_i_grupo
                LEFT  JOIN sau_subgrupo ON sd61_i_codigo = la56_i_subgrupo
                LEFT  JOIN sau_formaorganizacao ON sd62_i_codigo = la56_i_formaorganizacao
                WHERE ((sd60_c_grupo = sGrupo AND sd61_c_subgrupo IS NULL AND sd62_c_formaorganizacao IS NULL)
                       OR (sd60_c_grupo = sGrupo AND sd61_c_subgrupo = sSubGrupo AND sd62_c_formaorganizacao IS NULL)
                       OR (sd60_c_grupo = sGrupo AND sd61_c_subgrupo = sSubGrupo AND sd62_c_formaorganizacao = sFormaOrganizacao)
                       OR (sd60_c_grupo = sGrupo AND sSubGrupo IS NULL AND sFormaOrganizacao IS NULL)
                       OR (sd60_c_grupo = sGrupo AND sd61_c_subgrupo = sSubGrupo AND sFormaOrganizacao IS NULL))
                  AND la56_i_codigo != NEW.la56_i_codigo -- Para funcionar o update
                  AND ((NEW.la56_d_fim IS NULL AND la56_d_fim IS null) -- Verificacao das datas de validade
                       OR (NEW.la56_d_fim IS NULL AND NEW.la56_d_ini <= la56_d_ini)
                       OR (la56_d_fim IS NULL AND la56_d_ini <= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NULL AND la56_d_fim IS NOT NULL AND la56_d_fim >= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NOT NULL AND la56_d_fim IS NULL AND NEW.la56_d_fim >= la56_d_ini)
                       OR (NEW.la56_d_ini BETWEEN la56_d_ini AND la56_d_fim)
                       OR (NEW.la56_d_fim BETWEEN la56_d_ini AND la56_d_fim)
                       OR (la56_d_ini BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim)
                       OR (la56_d_fim BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim))) THEN
                       
      RAISE EXCEPTION 'Controle físico / financeiro já informado para este grupo de exames no período indicado.';
      RETURN OLD;
      
    END IF;
        
  ELSEIF iTipoControle = 8 THEN -- Controle por exames
  
    IF EXISTS(SELECT * FROM lab_controlefisicofinanceiro 
                WHERE la56_i_exame = NEW.la56_i_exame
                  AND la56_i_codigo != NEW.la56_i_codigo -- Para funcionar o update
                  AND ((NEW.la56_d_fim IS NULL AND la56_d_fim IS null) -- Verificacao das datas de validade
                       OR (NEW.la56_d_fim IS NULL AND NEW.la56_d_ini <= la56_d_ini)
                       OR (la56_d_fim IS NULL AND la56_d_ini <= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NULL AND la56_d_fim IS NOT NULL AND la56_d_fim >= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NOT NULL AND la56_d_fim IS NULL AND NEW.la56_d_fim >= la56_d_ini)
                       OR (NEW.la56_d_ini BETWEEN la56_d_ini AND la56_d_fim)
                       OR (NEW.la56_d_fim BETWEEN la56_d_ini AND la56_d_fim)
                       OR (la56_d_ini BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim)
                       OR (la56_d_fim BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim))) THEN
                       
      RAISE EXCEPTION 'Controle físico / financeiro já informado para este exame no período indicado.';
      RETURN OLD;
      
    END IF;

  ELSEIF iTipoControle = 9 THEN -- Controle por departamento solicitante e laboratório
  
    IF EXISTS(SELECT * FROM lab_controlefisicofinanceiro 
                WHERE la56_i_depto = NEW.la56_i_depto
                  AND la56_i_laboratorio = NEW.la56_i_laboratorio
                  AND la56_i_codigo != NEW.la56_i_codigo -- Para funcionar o update
                  AND ((NEW.la56_d_fim IS NULL AND la56_d_fim IS null) -- Verificacao das datas de validade
                       OR (NEW.la56_d_fim IS NULL AND NEW.la56_d_ini <= la56_d_ini)
                       OR (la56_d_fim IS NULL AND la56_d_ini <= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NULL AND la56_d_fim IS NOT NULL AND la56_d_fim >= NEW.la56_d_ini)
                       OR (NEW.la56_d_fim IS NOT NULL AND la56_d_fim IS NULL AND NEW.la56_d_fim >= la56_d_ini)
                       OR (NEW.la56_d_ini BETWEEN la56_d_ini AND la56_d_fim)
                       OR (NEW.la56_d_fim BETWEEN la56_d_ini AND la56_d_fim)
                       OR (la56_d_ini BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim)
                       OR (la56_d_fim BETWEEN NEW.la56_d_ini AND NEW.la56_d_fim))) THEN
                       
      RAISE EXCEPTION 'Controle físico / financeiro já informado para este departamento e este laboratório no período indicado.';
      RETURN OLD;
      
    END IF;
    
  END IF;
  
  RETURN NEW;
    
END;
$$LANGUAGE 'plpgsql';

DROP TRIGGER IF EXISTS tg_impede_informacoes_duplicadas_lab ON lab_controlefisicofinanceiro;

CREATE TRIGGER tg_impede_informacoes_duplicadas_lab
BEFORE INSERT OR UPDATE ON lab_controlefisicofinanceiro FOR EACH ROW
EXECUTE PROCEDURE fc_impede_informacoes_duplicadas_lab();
