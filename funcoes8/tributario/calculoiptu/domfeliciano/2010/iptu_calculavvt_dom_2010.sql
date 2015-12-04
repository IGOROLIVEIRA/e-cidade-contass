drop function fc_iptu_calculavvt_dom_2010(integer,integer,numeric,integer, boolean,boolean);

drop type tp_iptu_calculavvt;

create type tp_iptu_calculavvt as (rnVvt     numeric(15,2),
                                   rnArea    numeric, 
                                   rtDemo    text,
                                   rtMsgerro text,
                                   rbErro    boolean,
																	 rtErro    text);

create or replace function fc_iptu_calculavvt_dom_2010(integer,integer,numeric,integer,boolean,boolean) returns tp_iptu_calculavvt as
$$
declare

    iMatricula                alias for $1;
    iIdbql                    alias for $2;
    nFracao                   alias for $3;
    iAnousu                   alias for $4;
    lMostrademo               alias for $5;
    lRaise                    alias for $6;

	nVvt					  numeric default 0;
    nAreaTerreno			  numeric default 1;
    nAreaCalc   			  numeric default 1;
	nAreaTributada			  numeric default 0;
	nValorUnitarioM			  numeric default 1;
	nFatorProfundidade		  numeric default 1;
	nFatorPedologia			  numeric default 1;
	nFatorTopografia		  numeric default 1;
	nFatorSituacao			  numeric default 1;
	nFatorGleba				  numeric default 1;
	nMedidaTestada			  numeric default 0;
	nProfundidadeMedia		  numeric default 0;
    nValorBase                    numeric default 0;

    rDadosLote                record;
    rDadosTestada             record;

    rtp_iptu_calculavvt       tp_iptu_calculavvt%ROWTYPE;

begin

    rtp_iptu_calculavvt.rnVvt      := 0; -- valor do terreno
    rtp_iptu_calculavvt.rnArea     := 0; -- area do lote
    rtp_iptu_calculavvt.rtDemo     := ''; -- string do demonstrativo de calculo
    rtp_iptu_calculavvt.rtMsgerro  := ''; -- mensagem de erro
--    rtp_iptu_calculavvt.riCoderro  := 0;
    rtp_iptu_calculavvt.rbErro     := 'f'; -- true se ocorreu um erro ou false se nao ocorreu

    perform fc_debug('Iniciando calculo do valor venal territorial ...',lRaise,false,false); 
    
    
    perform fc_debug('',lRaise,false,false); 
    perform fc_debug('Processando tabela [Fator de profundidade]',lRaise,false,false); 
    perform fc_debug('',lRaise,false,false); 
	
	/*Buscando valor m2 do terreno */
	select j81_valorterreno,j36_testad 
	  into nValorUnitarioM, nMedidaTestada 
	  from lote 
		   inner join testada   on testada.j36_idbql  = lote.j34_idbql 
		   inner join testpri   on testpri.j49_idbql  = testada.j36_idbql 
                               and testpri.j49_face   = testada.j36_face 
                               and testpri.j49_codigo = testada.j36_codigo 
		   inner join facevalor on facevalor.j81_face = testpri.j49_face  
	 where lote.j34_idbql = iIdbql 
       and facevalor.j81_anousu = iAnousu;
			
	
	if not found or nValorUnitarioM = 0 then 

      rtp_iptu_calculavvt.rtMsgerro := 'Valor não encontrado para face de quadra [ IDBQL : '||coalesce(iIdbql,'')||' ] ';
      rtp_iptu_calculavvt.rbErro    := 't';
      return rtp_iptu_calculavvt;
	
	end if;

	perform fc_debug('Valor encontrado par face de quadra valor = ' || nValorUnitarioM ,lRaise,false,false);

	/*Busca a área do terreno */
	select j34_area
	  into nAreaTerreno
	  from lote 
	 where j34_idbql = iIdbql;

	if not found or nAreaTerreno = 0 then

	  rtp_iptu_calculavvt.rtMsgerro := 'Área não encontrado para terreno [ IDBQL : '||coalesce(iIdbql,'')||' ] ';
      rtp_iptu_calculavvt.rbErro    := 't';
      return rtp_iptu_calculavvt;

	end if;

    perform fc_debug('Valor encontrado para area do terreno = ' || nAreaTerreno ,lRaise,false,false);

	/* Calula a profundidade média */
	nProfundidadeMedia := ( nAreaTerreno / nMedidaTestada );
    perform fc_debug('Valor encontrado para profundidade media = ' || nProfundidadeMedia ,lRaise,false,false);

	/* Calcula o fator de profundiade */
    if nAreaTerreno <= 5000 then 
		if nProfundidadeMedia < 20 then
			
			nFatorProfundidade = (nProfundidadeMedia / 20) ^ 0.5;
	
		elsif nProfundidadeMedia >= 20 and nProfundidadeMedia <= 40 then
	
			nFatorProfundidade = 1;
	
		elsif nProfundidadeMedia > 40 and nProfundidadeMedia <= 80 then
	
	        nFatorProfundidade = 1;
			/*nFatorProfundidade = ( 50 / nProfundidadeMedia ) ^ 0.5;*/	
	
		elsif nProfundidadeMedia > 80 then
	
			nFatorProfundidade = 0.70;	
	
		end if;        

    elsif nAreaTerreno > 5000 then
        
        nFatorProfundidade  = 1;

    end if;
    perform fc_debug('Valor encontrado para fator de profundidade = ' || nFatorProfundidade ,lRaise,false,false);
	/* Busca fator de pedologia */

	select j74_fator 
	  into nFatorPedologia	
	  from carlote 
         inner join caracter on caracter.j31_codigo = carlote.j35_caract 
         inner join carfator on carfator.j74_caract = caracter.j31_codigo 
   where carfator.j74_anousu = iAnousu 
     and caracter.j31_grupo = 12
     and carlote.j35_idbql = iIdbql ;  

	if not found or nFatorPedologia = 0 then

	  rtp_iptu_calculavvt.rtMsgerro := 'Fator de pedologia não encontrado para terreno [ IDBQL : '||coalesce(iIdbql,'')||' ] ';
      rtp_iptu_calculavvt.rbErro    := 't';
      return rtp_iptu_calculavvt;

	end if;
	perform fc_debug('Valor encontrado para fator de pedologia = ' || nFatorPedologia ,lRaise,false,false);
	/* Busca fator de topografia */

	select j74_fator 
	  into nFatorTopografia	
	  from carlote 
           inner join caracter on caracter.j31_codigo = carlote.j35_caract 
           inner join carfator on carfator.j74_caract = caracter.j31_codigo 
     where carfator.j74_anousu = iAnousu 
       and caracter.j31_grupo = 11
       and carlote.j35_idbql = iIdbql ;

	if not found or nFatorTopografia = 0 then

	  rtp_iptu_calculavvt.rtMsgerro := 'Fator de topografia não encontrado para terreno [ IDBQL : '||coalesce(iIdbql,'')||' ] ';
      rtp_iptu_calculavvt.rbErro    := 't';
      return rtp_iptu_calculavvt;

	end if;
	perform fc_debug('Valor encontrado para fator de topografia = ' || nFatorTopografia ,lRaise,false,false);
	/* Busca fator de situacao */

	select j74_fator 
	  into nFatorSituacao
	  from carlote 
           inner join caracter on caracter.j31_codigo = carlote.j35_caract 
           inner join carfator on carfator.j74_caract = caracter.j31_codigo 
     where carfator.j74_anousu = iAnousu 
       and caracter.j31_grupo = 9 
       and carlote.j35_idbql = iIdbql ;

	if not found or nFatorSituacao = 0 then

	  rtp_iptu_calculavvt.rtMsgerro := 'Fator de situacao não encontrado para terreno [ IDBQL : '||coalesce(iIdbql,'')||' ] ';
      rtp_iptu_calculavvt.rbErro    := 't';
      return rtp_iptu_calculavvt;

	end if;
	perform fc_debug('Valor encontrado para fator situacao = ' || nFatorSituacao ,lRaise,false,false);
	/* Calcula fator de Gleba*/

	if nAreaTerreno < 5000.00 then
	 
		nFatorGleba := 1;
		
	else
		
    -- conforme T36834 foi solicitado colocar fixo 0.7 ao inves de executar o calculo pela regra da lei
		--nFatorGleba := ( 10 * ( ( nAreaTerreno ) ^ (0.45) ) * ( nMedidaTestada ^ 0.20 ) );
    nFatorGleba := 0.70;

	end if;
    perform fc_debug('Valor encontrado para gleba = ' || nFatorGleba ,lRaise,false,false);

     select j18_vlrref
        into nValorBase  
        from cfiptu
       where j18_anousu = iAnousu;

     if not found or nValorBase = 0 then
    
       perform fc_debug('Valor base não encontrado',bRaise,false,false);
       rtp_iptu_calculavvt.rtMsgerro := 'Valor base não encontrado';
       rtp_iptu_calculavvt.rbErro    := 't';
       return rtp_iptu_calculavvt;
          
     end if;  

	/* Calculo do valor venal do terreno */
	
	nAreaTributada = nAreaTerreno * (nFracao / 100); 

    perform fc_debug('Valor encontrado para area atribuida = ' || nAreaTributada ,lRaise,false,false);

	nVvt := ( nAreaTributada * nValorUnitarioM * nFatorProfundidade * nFatorPedologia * nFatorTopografia * nFatorSituacao * nFatorGleba * nValorBase);
     
    nAreaCalc := ( nAreaTributada * nFatorProfundidade * nFatorPedologia * nFatorTopografia * nFatorSituacao * nFatorGleba );

    rtp_iptu_calculavvt.rnVvt      := nVvt;
    rtp_iptu_calculavvt.rnArea     := nAreaTributada;
    

    update tmpdadosiptu set vvt =  nVvt, areat = nAreaTributada, vm2t = nValorUnitarioM;

    return rtp_iptu_calculavvt;
   
end;
$$ language 'plpgsql';
