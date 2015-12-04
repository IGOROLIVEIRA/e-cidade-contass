create or replace function fc_fichacompensacaoarrebanco(integer, integer, integer) returns varchar  as
$$
declare
  -- Parametros
  iCodConvenio alias for $1;
  iNumpre      alias for $2;
  iNumpar      alias for $3;
  
  sMsgRet           varchar;
  sNumbcoSeq        integer; -- sequencial do arrebanco;
  iSequencia        integer;
  iCodBanco         integer; 
  sConvenio         varchar;
  sCarteira         varchar;
  sAgencia          varchar;
  sNumBanco         varchar;
  sNumBancoa        varchar;
  iResto            integer;
  iDigito1          integer;
  iDigito2          integer;
  iMaximo           integer;
  iTipoConvenio     integer;
  iConvenioCobranca integer;

  lEncontraConvenio boolean default false;
  lRaise            boolean default false;

begin
   
  lRaise  := ( case when fc_getsession('DB_debugon') is null then false else true end );

  -- selecionamos os dados do banco (agencia, proximo numero da sequencia e o convenio;)
  select db89_codagencia, 
         ar13_convenio,
         ar13_carteira,
         db89_db_bancos,
         coalesce((select max(ar20_sequencia) from conveniocobrancaseq where ar20_conveniocobranca = ar13_sequencial),0) as ar20_sequencia,
         ar13_sequencial,
         ar12_sequencial
    into sAgencia,
         sConvenio,
         sCarteira,
         iCodBanco,
         iSequencia,
         iConvenioCobranca,
         iTipoConvenio
    from cadconvenio
         inner join cadtipoconvenio  on ar12_sequencial  = ar11_cadtipoconvenio
         inner join conveniocobranca on ar13_cadconvenio = ar11_sequencial
         inner join bancoagencia     on db89_sequencial  = ar13_bancoagencia
   where ar11_sequencial = iCodConvenio;

   if found then
     lEncontraConvenio := true;
   else
     lEncontraConvenio := false;
   end if;

    if iCodBanco = 1 then
       iMaximo := 99999;
    else

       if iTipoConvenio = 5 then
         iMaximo := 99999999;
       else 
         iMaximo := 9999999;
       end if;

    end if;

    if iSequencia > 0 then
        
      select (ar20_valor + 1) as ar20_valor
        into sNumbcoSeq
        from conveniocobrancaseq 
       where ar20_conveniocobranca = iConvenioCobranca 
         and ar20_sequencia        = iSequencia;


      if sNumbcoSeq < iMaximo then

        update conveniocobrancaseq 
           set ar20_valor = ar20_valor + 1 
         where ar20_conveniocobranca = iConvenioCobranca 
           and ar20_sequencia        = iSequencia;

      else 

        iSequencia = iSequencia + 1;
        sNumbcoSeq = 1;
        insert into conveniocobrancaseq select nextval('conveniocobrancaseq_ar20_sequencial_seq'), iConvenioCobranca, iSequencia, sNumbcoSeq;

      end if;


    else

      sNumbcoSeq = 1;
      insert into conveniocobrancaseq select nextval('conveniocobrancaseq_ar20_sequencial_seq'), iConvenioCobranca, 1, sNumbcoSeq;

    end if;

  if lEncontraConvenio then 
 
     -- Verifica convenio SICOB
     if iTipoConvenio = 5 then 

       if sCarteira = 9 then
         sNumBancoa := lpad(sNumbcoSeq,9,0);
       else
         sNumBancoa := lpad(sNumbcoSeq,8,0);
       end if;

       sNumBancoa := trim(sCarteira)||sNumBancoa;
  
       iDigito1 := 11 - fc_modulo11(sNumBancoa,2,9);
          
       if iDigito1 > 9 then
         iDigito1 := 0;
       end if;

       sNumBancoa := sNumBancoa||iDigito1;

     elsif iTipoConvenio = 6 then 

       sConvenio  := trim(sConvenio);
       sNumBancoa := trim(sConvenio)||trim(to_char(sNumbcoSeq,'0000000'));
       iDigito1   := fc_modulo10(sNumBancoa); -- Calcula Modulo 10 do NossoNumero
       iResto     := fc_modulo11(sNumBancoa||cast(iDigito1 as char(1)), 2, 7); -- Retornar Resto

       if iResto = 1 then -- Digito Invalido 
         iDigito1 := iDigito1 + 1; -- Soma-se 1 ao primeiro DV
         if iDigito1 > 9 then
           iDigito1 := 0;
         end if;
         iDigito2 := fc_modulo11(sNumBancoa||cast(iDigito1 as char(1)), 1, 7);
       elsif iResto = 0 then
         iDigito2 := 0;
       else
         iDigito2 := fc_modulo11(sNumBancoa||cast(iDigito1 as char(1)), 1, 7);
       end if;
       -- Monta Nosso Numero
       sNumBancoa := sNumBancoa||cast(iDigito1 as char(1))||cast(iDigito2 as char(1));
       if lRaise then
         raise notice 'Processando SIGCB sNumbancoa: %',sNumbancoa;
       end if;

------------------------------------------------------------------------------------------------------------

       sNumBancoa   := lpad(sNumBancoa,15,0);
       sNumBancoa   := substr(sNumBancoa,1,3) || -- 1pt Nosso Numero
                       substr(sCarteira,1,1)  || -- Modalidade de cobrança pode ser 1 'Com registro' ou 2 'Sem registro'
                       substr(sNumBancoa,4,3) || -- 2pt Nosso Numero
                       substr(sCarteira,2,1)  || -- Constante modo de impressão pode 1 'Impresso pela CEF' ou 4 'Impresso pelo cedente'
                       substr(sNumBancoa,7,9);   -- 3pt Nosso Numero

------------------------------------------------------------------------------------------------------------

     else 

       sConvenio  := trim(sConvenio);
       sNumBancoa := trim(sConvenio)||trim(to_char(sNumbcoSeq,'0000000'));
       iDigito1   := fc_modulo10(sNumBancoa); -- Calcula Modulo 10 do NossoNumero
       iResto     := fc_modulo11(sNumBancoa||cast(iDigito1 as char(1)), 2, 7); -- Retornar Resto

       if iResto = 1 then -- Digito Invalido 
         iDigito1 := iDigito1 + 1; -- Soma-se 1 ao primeiro DV
         if iDigito1 > 9 then
           iDigito1 := 0;
         end if;
         iDigito2 := fc_modulo11(sNumBancoa||cast(iDigito1 as char(1)), 1, 7);
       elsif iResto = 0 then
         iDigito2 := 0;
       else
         iDigito2 := fc_modulo11(sNumBancoa||cast(iDigito1 as char(1)), 1, 7);
       end if;
       -- Monta Nosso Numero
       sNumBancoa := sNumBancoa||cast(iDigito1 as char(1))||cast(iDigito2 as char(1));
     end if;
     
     if lRaise then
       raise notice 'antes insert arrebanco sNumbancoa: %',sNumbancoa;
     end if;
     insert into arrebanco (k00_numpre, k00_numpar, k00_codbco, k00_codage, k00_numbco)
                    values (iNumpre, iNumpar, iCodBanco, trim(sAgencia),sNumBancoa);

--     update cadban set k15_seq1 = sNumbcoSeq where k15_codigo = iCodBanco;

  else 
    raise  exception 'Não foi encontrado banco (%)',iCodBanco;
  end if;
  
  if iTipoConvenio = 5 then 
    sNumBanco := trim(to_char(sNumbcoSeq,'00000000'));
  elsif iTipoConvenio = 6 then 
    sNumBanco := trim(sNumBancoa);
  else 
    sNumBanco := trim(to_char(sNumbcoSeq,'0000000'));
  end if;
  
  if lRaise then
    raise notice 'Antes do retorno sNumBanco : % ',sNumBanco;
  end if;

  return sNumBanco;

end;
$$
language 'plpgsql';
