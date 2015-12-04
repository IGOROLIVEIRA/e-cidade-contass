drop function fc_fichacompensacao(integer, integer, integer, date, float8);

drop type tp_fichacompensacao;
create type tp_fichacompensacao as (codigobarras text, linhadigitavel text, erro boolean, mensagem text, convenio text, nossonumero text, campolivre text);

create or replace function fc_fichacompensacao(integer, integer, integer, date, float8) returns tp_fichacompensacao  as
$$
declare
  -- Parametros
  iCodConvenio alias for $1;
  iNumpre      alias for $2;
  iNumpar      alias for $3;
  dVencimento  alias for $4;
  nValor       alias for $5;

  -- Formatacao do Codigo de barras
  sBanco       char(3);
  sAgencia     varchar;
  sMoeda       char(1) default '9';
  sDigito      char(1);
  sFatorVenc   char(4);
  sValor       char(10);
  sCampoLivre  char(25);

  -- Formatacao Campo Livre
  sCedente     varchar;
  sConvenio    char(7);
  sCarteira    char(6); 
  sOperacao    char(3); 
  sNossoNumero text;
  sRetornoNossoNumero varchar;
  sNumBanco    varchar; -- numero do banco(arrbanco ) para padrao bsj

  -- Outros
  dDataBase    date default '1997-10-07';
  sCodBar      text default '';
  sLinha       text default '';
  sLinhaCampo1 text;
  sLinhaCampo2 text;
  sLinhaCampo3 text;
  sLinhaCampo4 text;
  sLinhaCampo5 text;

  iModalidadeConvenio integer;
  iTipoConvenio       integer;
  iDigito1            integer;
  iDigito2            integer;
  iResto              integer;

  rRetorno     tp_fichacompensacao;

  -- Debug
  lRaise       boolean default false;

begin

  lRaise  := ( case when fc_getsession('DB_debugon') is null then false else true end );

  rRetorno.codigobarras   := sCodBar;
  rRetorno.linhadigitavel := sLinha;
  rRetorno.erro           := false;
  rRetorno.mensagem       := '';

  select ar12_sequencial,
         ar12_cadconveniomodalidade,
         ar13_cedente,
         ar13_convenio,
         ar13_carteira,
         ar13_operacao,
         db89_db_bancos,
         db89_codagencia
    into iTipoConvenio,
         iModalidadeConvenio,
         sCedente, 
         sConvenio, 
         sCarteira, 
         sOperacao, 
         sBanco,
         sAgencia
    from cadconvenio 
         inner join cadtipoconvenio  on ar12_sequencial  = ar11_cadtipoconvenio
         inner join conveniocobranca on ar13_cadconvenio = ar11_sequencial
         inner join bancoagencia     on db89_sequencial  = ar13_bancoagencia
   where ar11_sequencial = iCodConvenio;

  if not found then
    rRetorno.erro     := true;
    rRetorno.mensagem := 'Banco nao cadastrado!';
    return rRetorno;
  end if;

  if iModalidadeConvenio != 1 then
    rRetorno.erro     := true;
    rRetorno.mensagem := 'Tipo de convênio diferente de cobrança!';
    return rRetorno;
  end if;

  if sCedente  is null or 
     sConvenio is null or 
     sCarteira is null or
     sBanco    is null or 
     sCedente  = '' or 
     sConvenio = '' or 
     sCarteira = '' or
     sBanco    = '' then
     
    rRetorno.erro     := true;
    rRetorno.mensagem := 'Verificar configuracoes do Cadastro do Banco (Cedente, Convenio, Carteira, Banco)';

    return rRetorno;
  end if;
  
  -- Formatacoes
  sFatorVenc   := trim(to_char(dVencimento - dDataBase, '0000'));

  --sNossoNumero := '00000600179100058'; -- Para testes...
  sConvenio    := trim(sConvenio);
  sValor       := trim(to_char(nValor * 100, '0000000000'));

  -- Quatro Digitos = BSJ do Banrisul

  if iTipoConvenio  = 2 then
   
    sConvenio    := trim(to_char(sConvenio::integer, '0000'));
    -- nosso numero sem os  digitos verificadores (para codigo de barras e linha digitavel)
    sNumBanco    := trim(fc_fichacompensacaoarrebanco(iCodConvenio, iNumpre, iNumpar))::integer;

    --
    -- 1. Nosso Numero
    --
    sNossoNumero := sConvenio||lpad(sNumBanco,7,0);
    
    iDigito1     := fc_modulo10(sNossoNumero); -- Calcula Modulo 10 do NossoNumero

    iResto       := fc_modulo11(sNossoNumero||cast(iDigito1 as char(1)), 2, 7); -- Retornar Resto (Calculo Modulo 11 Peso 7)

    if iResto = 1 then -- Digito Invalido 
      iDigito1 := iDigito1 + 1; -- Soma-se 1 ao primeiro DV

      if iDigito1 > 9 then
        iDigito1 := 0;
      end if;
    
      iDigito2 := fc_modulo11(sNossoNumero||cast(iDigito1 as char(1)), 1, 7); -- Retornar Digito (Calculo Modulo 11 Peso 7)
    elsif iResto = 0 then
      iDigito2 := 0;
    else
      iDigito2 := fc_modulo11(sNossoNumero||cast(iDigito1 as char(1)), 1, 7); -- Retornar Digito (Calculo Modulo 11 Peso 7)
    end if;

    -- Monta Nosso Numero
    sNossoNumero := sNossoNumero||cast(iDigito1 as char(1))||cast(iDigito2 as char(1));

    --
    -- 2. Campo Livre
    --
    sCampoLivre  := ('23' || sNossoNumero || '00000' || sBanco ); -- '23' + Nosso Num (9) + '00000' + Banco (041) = 25 caracteres
    iDigito1     := fc_modulo10(sCampoLivre); -- Calcula Modulo 10 do Campo Livre
    iResto       := fc_modulo11(sCampoLivre||cast(iDigito1 as char(1)), 2, 7); -- Retornar Resto (Calculo Modulo 11 Peso 7)

    if iResto = 1 then -- Digito Invalido 
      iDigito1 := iDigito1 + 1; -- Soma-se 1 ao primeiro DV

      if iDigito1 > 9 then
        iDigito1 := 0;
      end if;
    
      iDigito2 := fc_modulo11(sCampoLivre||cast(iDigito1 as char(1)), 1, 7); -- Retornar Digito (Calculo Modulo 11 Peso 7)
    elsif iResto = 0 then
      iDigito2 := 0;
    else
      iDigito2 := fc_modulo11(sCampoLivre||cast(iDigito1 as char(1)), 1, 7); -- Retornar Digito (Calculo Modulo 11 Peso 7)
    end if;

    -- Monta Campo Livre
    sCampoLivre := sCampoLivre||cast(iDigito1 as char(1))||cast(iDigito2 as char(1));


	elsif iTipoConvenio = 1 and length(sConvenio) = 6 then
    
    sConvenio    := trim(to_char(sConvenio::integer, '000000'));
		sNossoNumero := trim(to_char(coalesce(iNumpre, 0), '00000000000000')) || trim(to_char(coalesce(iNumpar, 0), '000'));
    sCampoLivre  := (sConvenio || sNossoNumero || '21'); -- Conv (6) + Nosso Num (17) + '21' (2) = 25 caracteres

	elsif iTipoConvenio = 1 and length(sConvenio) = 7 then
  
    sConvenio    := trim(to_char(sConvenio::integer, '0000000'));
	  if iNumpar > 99 then
			rRetorno.erro     := true;
			rRetorno.mensagem := 'para convenios com 7 digitos, parcela deve ser no maximo 99';
			return rRetorno;
		end if;
		sNossoNumero := trim(to_char(coalesce(iNumpre, 0), '00000000')) || trim(to_char(coalesce(iNumpar, 0), '00'));
    sCampoLivre  := ('000000' || sConvenio || sNossoNumero || sCarteira); 
		-- seis zeros + convenio de 7 posicoes + Nosso Num (10 - numpre (8) + numpar (2) ) + carteira (2) = 25 caracteres
  
 

  -- CONVENIO SICOB 11 Posições
  elsif iTipoConvenio = 5 then

    sNumBanco := trim(fc_fichacompensacaoarrebanco(iCodConvenio, iNumpre, iNumpar))::integer;
    -- 82 = Sem Registro
    -- 9  = Rápida
    sAgencia := substr(lpad(sAgencia,5,0),2,4);
    if sCarteira = 9 then
      sNossoNumero := lpad(sNumBanco,9,0);
    else 
      sNossoNumero := lpad(sNumBanco,8,0);
    end if;

      iDigito1 := 11 - fc_modulo11(sCarteira||sNossoNumero,2,9);
      if iDigito1 > 9 then
        iDigito1 := 0;
      end if;
      sRetornoNossoNumero := (sCarteira||sNossoNumero||'-'||iDigito1);

    if lRaise is true then
      raise notice ' Campo Livre SICOB 11 Pos:';
      raise notice ' Carteira: %, Nosso Número: %, Agencia: %, Operação: %, Cedente: % ',sCarteira,sNossoNumero,sAgencia,sOperacao,sCedente;
    end if;

    if length(sCedente) != 8 then
      rRetorno.erro     := true;
      rRetorno.mensagem := 'Tamanho do campo cedente difere de 8 caracteres!';
      return rRetorno;
    end if;
    sCampoLivre := (sCarteira||sNossoNumero||sAgencia||sOperacao||sCedente);

  
  -- CONVENIO SIGCB 17 Posições
  
  elsif iTipoConvenio = 6 then

    if length(sCedente) != 6 then
      rRetorno.erro     := true;
      rRetorno.mensagem := 'Tamanho do campo cedente difere de 6 caracteres!';
      return rRetorno;
    end if;

    -- Calcula DV Cedente
    iDigito1 := 11 - fc_modulo11(sCedente,2,9);
    if iDigito1 > 9 then
      iDigito1 := 0;
    end if;
    sCedente := sCedente || iDigito1;

    sNossoNumero  := trim(fc_fichacompensacaoarrebanco(iCodConvenio, iNumpre, iNumpar));

    if lRaise is true then
      raise notice ' Campo Livre SIGCB :';
      raise notice ' Carteira: %, Nosso Número: %, Cedente: % ',sCarteira,sNossoNumero,sCedente;
    end if;


    sRetornoNossoNumero := substr(sNossoNumero,1,3) ||
						   substr(sNossoNumero,5,3) ||
						   substr(sNossoNumero,9,9);

    iDigito1 := 11 - fc_modulo11(sCarteira||sRetornoNossoNumero,2,9);

    if iDigito1 > 9 then
      iDigito1 := 0;
    end if;

    sRetornoNossoNumero := (sCarteira||'/'||sRetornoNossoNumero||'-'||iDigito1);

    sCampoLivre := ( sCedente || sNossoNumero );

    -- Calcula DV Campo Livre
    iDigito1 := 11 - fc_modulo11(sCampoLivre,2,9);
    if iDigito1 > 9 then
      iDigito1 := 0;
    end if;

    sCampoLivre := ( sCampoLivre || iDigito1 );

    -- Cendente         (7) +
    -- Nosso Numero 1pt (3) + 
    -- Constante1       (1) + 
    -- Nosso Numero 2pt (3) + 
    -- Constante2       (1) + 
    -- Nosso Numero 3pt (9) + 
    -- DV Campo Livre   (1)
    --  
    -- Total Caraceteres =  25 caracteres
    if lRaise then
      raise notice 'Campo livre : % ',sCampoLivre;
    end if;

  else
    rRetorno.erro     := true;
    rRetorno.mensagem := 'convenio diferente de 4 (BSJ), 6 ou 7 posicoes';
    return rRetorno;
	end if;

  if lRaise is true then
    raise notice 'Banco: %  Moeda: %  Fator Venc: %  Nosso Numero: %  Convenio: %  Valor: %  Campo Livre: %', 
      sBanco, sMoeda, sFatorVenc, sNossoNumero, sConvenio, sValor, sCampoLivre;
      
    raise notice 'Tam Banco: %  Tam Moeda: %  Tam Fator Venc: %  Tam Nosso Numero: %  Tam Convenio: %  Tam Valor: %  Tam Campo Livre: %', 
      length(sBanco), length(sMoeda), length(sFatorVenc), length(sNossoNumero), length(sConvenio), length(sValor), length(sCampoLivre);
  end if;
  
  -- Codigo Barras 43 posicoes (da 1 a 4  e da 6 a 44) + Digito Verificador na posicao 5 = Totalizando 44 Posicoes
  --                           1          2          3         4
  --              123 4 5 6789 0123456789 012345 67890123456789012 34
  --              999 9 9 9999 9999999999 999999 99999999999999999 21
  --              ^^^ ^ ^ ^^^^ ^^^^^^^^^^ ^^^^^^^^^^^^^^^^^^^^^^^^^^^
  --               |  | |  |     |               |
  --               |  | |  |     |               +------------------- Campo Livre (Convenio (6) + Nosso Num (17) + '21')
  --               |  | |  |     +----------------------------------- Valor
  --               |  | |  +----------------------------------------- Fator Vencimento (data venc - 07/10/1997)              
  --               |  | +-------------------------------------------- Digito Verificador Modulo 11 do codigo de barras (1-4 e 6-44)
  --               |  +---------------------------------------------- Moeda
  --               +------------------------------------------------- Codigo do Banco
  --

  -- Codigo de Barras sem Digito Verificador
  sCodBar      := trim(sBanco || sMoeda || sFatorVenc || sValor || sCampoLivre);

  if lRaise is true then
    raise notice 'CodBar Sem Digito: [%] ', sCodBar;
  end if;
  
  -- Calcula Digito verificador Modulo 11 para o Codigo de Barras
  sDigito      := fc_modulo11(sCodBar)::char(1); -- Calcula Digito Modulo 11 (Peso 9)
  -- Se retornar '0' entao trocar pra '1', de acordo com manual do CNAB
  --if sDigito = '0' then
  --  sDigito := '1';
  --end if;
  
  -- Insere Digito verificador na posicao 5-5 do Codigo de Barras
  sCodBar      := trim(sBanco || sMoeda || sDigito || sFatorVenc || sValor || sCampoLivre);

  if lRaise is true then
    raise notice 'CodBar Com Digito: [%]  Digito: %', sCodBar, sDigito;
  end if;

  if length(sCodBar) <> 44 then
    if lRaise is true then
      raise notice 'Tamanho: %', length(sCodBar);
    end if;
    
    rRetorno.erro     := true;
    rRetorno.mensagem := 'Problema na geracao do codigo de barras, tamanho deve ser 44 e gerou '||length(sCodBar);

    return rRetorno;
  end if;

  -- Linha Digitavel
  sLinhaCampo1 := sBanco || sMoeda || substr(sCodBar, 20, 5);
  sLinhaCampo1 := sLinhaCampo1 || fc_modulo10(sLinhaCampo1); -- 10 Bytes

  sLinhaCampo2 := substr(sCodBar, 25, 10);
  sLinhaCampo2 := sLinhaCampo2 || fc_modulo10(sLinhaCampo2); -- 11 Bytes

  sLinhaCampo3 := substr(sCodBar, 35, 10);
  sLinhaCampo3 := sLinhaCampo3 || fc_modulo10(sLinhaCampo3); -- 11 Bytes

  sLinhaCampo4 := sDigito; -- 1 Byte

  sLinhaCampo5 := sFatorVenc || sValor; -- 14 bytes

  if lRaise is true then
    raise notice 'Linha Campo1: %  Campo2: %  Campo3: %  Campo4: %  Campo5: %', 
      sLinhaCampo1, sLinhaCampo2, sLinhaCampo3, sLinhaCampo4, sLinhaCampo5;
  end if;
  

  -- 
  -- Campos Linha Digitavel
  --
  --           1           2           3           4
  -- 12345 67890 12345 678901 23456 789012  3  45678901234567
  -- 99999.99999 99999.999999 99999.999999  9  99999999999999
  -- ^^^^^^^^^^^ ^^^^^^^^^^^^ ^^^^^^^^^^^^  ^  ^^^^^^^^^^^^^^
  --   bloco 1     bloco 2       bloco 3    D    bloco 4
  --
  -- Tamanho total: 57
  --
  -- Posicoes:
  --
  -- - BLOCO 1
  --   . 01-03 = Codigo do Banco
  --   . 04-04 = Codigo da Moeda (padrao 9)
  --   . 05-09 = Posicao 20 - 24 do Codigo de Barras (CONVENIO - primeiros 5 digitos)
  --   . 10-10 = Digito verificador Modulo 10 da Posicao 01-09
  --
  -- - BLOCO 2
  --   . 11-20 = Posicao 25 - 34 do Codigo de Barras (Ultimo digito do Convenio + 9 caracteres inicias do NOSSO NUMERO)
  --   . 21-21 = Digito verificador Modulo 10 da Posicao 11-20
  --
  -- - BLOCO 3
  --   . 22-31 = Posicao 35 - 44 do Codigo de Barras (8 Ultimos digitos do NOSSO NUMERO + '21')
  --   . 32-32 = Digito verificador Modulo 10 da Posicao 11-20
  --
  -- - DIGITO VERIFICADOR
  --   . 33-33 = Digito Verificador do Codigo de Barras (Posicao 5-5 do Codigo de Barras)
  --
  -- - BLOCO 4
  --   . 34-37 = Fator Vencimento (data venc - 07/10/1997)
  --   . 38-47 = Valor do Documento
  --
  sLinha := substr(sLinhaCampo1, 1, 5) ||'.'|| substr(sLinhaCampo1, 6, 5) || ' ' ||
            substr(sLinhaCampo2, 1, 5) ||'.'|| substr(sLinhaCampo2, 6, 6) || ' ' ||
            substr(sLinhaCampo3, 1, 5) ||'.'|| substr(sLinhaCampo3, 6, 6) || '  ' ||
            sLinhaCampo4 || '  ' || sLinhaCampo5;

  rRetorno.codigobarras   := sCodBar;
  rRetorno.linhadigitavel := sLinha;
  rRetorno.convenio       := sConvenio;
  rRetorno.campolivre     := sCampoLivre;
  
  if iTipoConvenio in (5,6) then
    rRetorno.nossonumero  := sRetornoNossoNumero;
  else 
    rRetorno.nossonumero  := sNossoNumero;
  end if;

  return rRetorno;

end;
$$
language 'plpgsql';
