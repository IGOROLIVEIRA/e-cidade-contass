begin;
select fc_startsession();
alter type tp_socio_promitente alter attribute rvnome type varchar(100);
DROP FUNCTION fc_busca_envolvidos(boolean, integer, character, integer);

CREATE OR REPLACE FUNCTION fc_busca_envolvidos(boolean, integer, character, integer)
  RETURNS SETOF tp_socio_promitente AS
$BODY$
declare

lPrincipal		alias for  $1;    -- Traz apenas o proprietario principal
iRegra			alias for  $2;    -- Traz a regra configurada na db_config, pardiv ou parjuridico
iTipoOrigem	    alias for  $3;    -- Verifica se é "M" Matrícula, "I" Inscrição ou "C" Cgm
iCodOrigem	    alias for  $4;    -- Traz o código da Matrícula ou Inscrição
		
iNumcgm         integer;
		
sNome           varchar(100);
		
lraise          boolean default false;
		
sSql            text	  default '';

rSocios         record; 
rPromitente     record; 
rProprietarios  record; 
		
rtp_promitente  tp_socio_promitente%ROWTYPE;

begin

 if iTipoOrigem = 'I' then 
			 
   -- Traz CGM do Issbase			 
				
   select z01_numcgm,
		  z01_nome
     into iNumcgm,
	      sNome
     from issbase 
	      inner join cgm  on z01_numcgm = q02_numcgm
	where q02_inscr = iCodOrigem; 
         
	rtp_promitente.riNumcgm	   := iNumcgm;
	rtp_promitente.rvNome	   := sNome;
	rtp_promitente.riInscr	   := iCodOrigem;
	rtp_promitente.riTipoEnvol := 4;
	return  next rtp_promitente;
			 
	-- Traz CGM dos Socios			
	 
	if iRegra = 1 and lPrincipal = false then

		sSql := 'select z01_nome,
		                z01_numcgm
			       from issbase 
						inner join socios on q95_cgmpri = q02_numcgm
						inner join cgm    on z01_numcgm = q95_numcgm
				  where q95_tipo  = 1 
                    and q02_inscr = '||iCodOrigem; 
         
		for rSocios in execute sSql loop
				  
			rtp_promitente.riNumcgm	   := rSocios.z01_numcgm;
			rtp_promitente.rvNome	   := rSocios.z01_nome; 
			rtp_promitente.riInscr	   := iCodOrigem;
			rtp_promitente.riTipoEnvol := 5;
			return  next rtp_promitente;

		end loop;
		   
	end if;
    
elsif iTipoOrigem = 'M' then
				
  if lraise then
	raise notice 'Regra IPTU: % ',iRegra;
  end if;
			 
  -- Traz CGM do Proprietário e Promitente
  if iRegra = 0 then 
					
	 select z01_numcgm,
	        z01_nome
	   into iNumcgm,
		    sNome
       from cgm 
	        inner join iptubase on iptubase.j01_numcgm = cgm.z01_numcgm
	  where j01_matric = iCodOrigem;

	  rtp_promitente.riNumcgm	 := iNumcgm;
	  rtp_promitente.rvNome		 := sNome;
	  rtp_promitente.riMatric	 := iCodOrigem;
	  rtp_promitente.riTipoEnvol := 1;
	  rtp_promitente.riInscr	 := null;
	  return  next rtp_promitente;
            
      -- Se lPrincipal for true mesmo sendo regra 2  retorna apenas o Proprietário
      if lPrincipal = false then 

		 sSql := ' select z01_numcgm,
		                  z01_nome
				     from promitente
					      inner join cgm on z01_numcgm = j41_numcgm
					where j41_matric = '||iCodOrigem||' order by j41_tipopro desc';
						 
		 for rPromitente in execute sSql loop
			 rtp_promitente.riNumcgm	:= rPromitente.z01_numcgm;
			 rtp_promitente.rvNome		:= rPromitente.z01_nome;
			 rtp_promitente.riMatric	:= iCodOrigem;
			 rtp_promitente.riTipoEnvol := 3;
			 return  next rtp_promitente;
		 end loop;

		 sSql := 'select z01_numcgm,
		                 z01_nome
				    from propri
				         inner join cgm on z01_numcgm = j42_numcgm
				   where j42_matric = '||iCodOrigem;

		 for rProprietarios in execute sSql loop
		     rtp_promitente.riNumcgm	:= rProprietarios.z01_numcgm;
			 rtp_promitente.rvNome		:= rProprietarios.z01_nome;
			 rtp_promitente.riMatric	:= iCodOrigem;
			 rtp_promitente.riTipoEnvol := 2;
		     return  next rtp_promitente;
		 end loop;
					
	  end if;

   -- Traz CGM do Proprietário
  elsif iRegra = 1 then
				
	  select z01_numcgm,
			 z01_nome
		into iNumcgm,
		     sNome
		from cgm 
	         inner join iptubase on iptubase.j01_numcgm = cgm.z01_numcgm
	   where j01_matric = iCodOrigem;

	   rtp_promitente.riNumcgm	   := iNumcgm;
	   rtp_promitente.rvNome	   := sNome;
	   rtp_promitente.riMatric	   := iCodOrigem;
	   rtp_promitente.riTipoEnvol  := 1;
	   rtp_promitente.riInscr	   := null;
	   return  next rtp_promitente;

       -- Se lPrincipal for true retorna outros proprietário
       if lPrincipal = false then 

		  sSql := ' select z01_numcgm,
						   z01_nome
					  from propri
					       inner join cgm on z01_numcgm = j42_numcgm
					 where j42_matric = '|| iCodOrigem;

		  for rProprietarios in execute sSql loop
			  rtp_promitente.riNumcgm		 := rProprietarios.z01_numcgm;
			  rtp_promitente.rvNome			 := rProprietarios.z01_nome;
			  rtp_promitente.riMatric		 := iCodOrigem;
			  rtp_promitente.riTipoEnvol     := 2;
			  return  next rtp_promitente;
		  end loop;
					
	   end if;
			
	-- Traz CGM do  Promitente
  elsif iRegra = 2 then 
				 
	   sSql := 'select z01_numcgm,
					   z01_nome
				  from promitente
				       inner join cgm on z01_numcgm = j41_numcgm
				 where j41_matric = '||iCodOrigem||' order by j41_tipopro desc ';
					
				 for rPromitente in execute sSql loop
						rtp_promitente.riNumcgm	   := rPromitente.z01_numcgm;
						rtp_promitente.rvNome	   := rPromitente.z01_nome;
						rtp_promitente.riMatric	   := iCodOrigem;
						rtp_promitente.riTipoEnvol := 3;
						return  next rtp_promitente;
				 end loop;

       -- Se nao encontrou forca regra = 1
       if not found then
          for rPromitente in select * from fc_busca_envolvidos(lPrincipal, 1, 'M', iCodOrigem) loop
         	  rtp_promitente.riNumcgm		:= rPromitente.riNumcgm;
	  		  rtp_promitente.rvNome			:= rPromitente.rvNome;
			  rtp_promitente.riMatric		:= iCodOrigem;
			  rtp_promitente.riTipoEnvol    := 1;
           
			  return  next rtp_promitente;
           end loop;
       end if;

	end if;
		
end if;
			 
if iTipoOrigem = 'C' then

   select z01_numcgm,
		  z01_nome
	 into iNumcgm,
	      sNome	 
	 from cgm 
	where z01_numcgm  = iCodOrigem;
				
	rtp_promitente.riNumcgm		 := iNumcgm;
	rtp_promitente.rvNome		 := sNome;
	rtp_promitente.riMatric		 := iCodOrigem;
	rtp_promitente.riTipoEnvol   := 1;
	rtp_promitente.riInscr		 := null;
	return  next rtp_promitente;

end if;

 return;

end;

$BODY$
  LANGUAGE plpgsql VOLATILE
  COST 100
  ROWS 1000;
ALTER FUNCTION fc_busca_envolvidos(boolean, integer, character, integer)
  OWNER TO dbportal;

commit;
