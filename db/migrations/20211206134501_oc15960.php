<?php

use Classes\PostgresMigration;

class Oc15960 extends PostgresMigration
{

    public function up()
    {
        $sql =" 

            CREATE OR REPLACE FUNCTION fc_taborcvinculodeducao_inc()
              RETURNS trigger AS
            \$BODY$
              declare
                sEstrutural            varchar; 
                sEstruturalProcurar    varchar;
                iClasse                integer;
                iCodigoReceitaInclusao integer;
                iInstit                integer;
                iCodigoConta           integer;
                iReceitaInclusao       record;
                tamanho                integer;
                sEstruturalProcurar1   varchar;
                sEstruturalProcurar2   varchar;
                sEstruturalProcurar3   varchar;
                        
                begin
                    
                    iInstit := cast(fc_getsession('DB_instit') as integer);
                    if iInstit is null then
                      raise exception 'Instituicao nao informada.';
                    end if;
                    
                    sEstrutural         := new.k02_estorc;
                    iClasse             := cast(substr(sEstrutural, 1, 2) as integer);
                    
                    case 
                      when iClasse < 49 then 
                        tamanho                 := length(sEstrutural)-3;
                        sEstruturalProcurar     := substr(sEstrutural, 2, tamanho);
                                       
                        sEstruturalProcurar1 := '493'||sEstruturalProcurar;
                        sEstruturalProcurar2 := '491'||sEstruturalProcurar;
                        sEstruturalProcurar3 := '0';
                         
                      when iClasse = 49 then             
                        tamanho                 := length(sEstrutural);
                        sEstruturalProcurar     := substr(sEstrutural, 4, tamanho);

                        sEstruturalProcurar1 := '0';
                        sEstruturalProcurar2 := '0';
                        sEstruturalProcurar3 := '4'||sEstruturalProcurar||'00';
                         
                    end case;
                    
                  FOR iReceitaInclusao IN select tabrec.k02_codigo as receita 
                    from tabrec 
                         inner join taborc                     on tabrec.k02_codigo     = taborc.k02_codigo 
                         inner join orcreceita                 on orcreceita.o70_codrec = taborc.k02_codrec 
                                                              and orcreceita.o70_anousu = taborc.k02_anousu 
                         inner join orcfontes                  on orcfontes.o57_codfon  =  orcreceita.o70_codfon 
                                                              and orcfontes.o57_anousu  =  orcreceita.o70_anousu                                         
                         inner join conplanoorcamento          on conplanoorcamento.c60_codcon = orcfontes.o57_codfon 
                                                              and conplanoorcamento.c60_anousu = orcfontes.o57_anousu 
                         inner join conplanoconplanoorcamento  on conplanoconplanoorcamento.c72_conplanoorcamento = conplanoorcamento.c60_codcon 
                                                              and conplanoconplanoorcamento.c72_anousu            = conplanoorcamento.c60_anousu 
                         inner join conplano                   on conplano.c60_codcon = conplanoconplanoorcamento.c72_conplano          
                                                              and conplano.c60_anousu = conplanoconplanoorcamento.c72_anousu 
                         inner join conplanoreduz              on conplanoreduz.c61_codcon = conplano.c60_codcon 
                                                              and conplanoreduz.c61_anousu = conplano.c60_anousu 
                   where conplanoorcamento.c60_estrut in (sEstruturalProcurar1,sEstruturalProcurar2,sEstruturalProcurar3) 
                     and conplanoreduz.c61_instit     = iInstit 
                     and conplanoreduz.c61_anousu     = new.k02_anousu 

                LOOP 

                iCodigoReceitaInclusao = iReceitaInclusao.receita;
                
                    case 
                        when iClasse < 49 then 
                            perform 1 
                            from taborcvinculodeducao 
                            where k164_taborcdeducao = iCodigoReceitaInclusao
                            and k164_taborcprincipal  = new.k02_codigo
                            and k164_anousu   = new.k02_anousu;
                        
                            if not found then                  
                                iCodigoConta := new.k02_codigo;
                                insert into taborcvinculodeducao (k164_sequencial,
                                                      k164_taborcprincipal,
                                                      k164_taborcdeducao,
                                                      k164_anousu)
                                              values (nextval('taborcvinculodeducao_k164_sequencial_seq'),
                                                      iCodigoConta,
                                                      iCodigoReceitaInclusao,
                                                      new.k02_anousu);
                            end if;
                         
                        when iClasse = 49 then 
                            perform  1 
                            from taborcvinculodeducao 
                            where k164_taborcdeducao = new.k02_codigo
                            and k164_taborcprincipal  = iCodigoReceitaInclusao
                            and k164_anousu          = new.k02_anousu;
                            
                            if NOT found then               
                                iCodigoConta           := iCodigoReceitaInclusao;
                                iCodigoReceitaInclusao := new.k02_codigo;

                        insert into taborcvinculodeducao (k164_sequencial,
                                                      k164_taborcprincipal,
                                                      k164_taborcdeducao,
                                                      k164_anousu)
                                              values (nextval('taborcvinculodeducao_k164_sequencial_seq'),
                                                      iCodigoConta,
                                                      iCodigoReceitaInclusao,
                                                      new.k02_anousu);  
                        end if;
                    end case;        
                              
                    END LOOP;
                   
                return new;
            end;
            \$BODY$
              LANGUAGE plpgsql VOLATILE
              COST 100;
            ALTER FUNCTION fc_taborcvinculodeducao_inc()
              OWNER TO dbportal;
        ";

        $this->execute($sql);
    }

}
