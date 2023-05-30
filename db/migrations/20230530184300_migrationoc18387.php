<?php

use Phinx\Migration\AbstractMigration;

class Migrationoc18387 extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function up()
    {
        $sql='BEGIN;

        CREATE TEMP TABLE instituicoes(
            sequencial SERIAL,
            inst INT
        );

        INSERT INTO instituicoes(inst) (SELECT codigo FROM db_config where codigo <> 1);

        SELECT * FROM instituicoes;


        CREATE OR REPLACE FUNCTION getAllCodigos() RETURNS SETOF instituicoes AS
        $$
        DECLARE
            r instituicoes%rowtype;
        BEGIN
            FOR r IN SELECT * FROM instituicoes
            LOOP

                        
                insert into db_documento values ((select max(db03_docum)+1 from db_documento),\'SOLICITACAO DE DISPO. FINANCEIRA1\',(select max(db08_codigo) from db_tipodoc),r.inst);
                insert into db_paragrafo values ((select max(db02_idparag)+1 from db_paragrafo),\'PARTE1\',\'if($tipo==1){$pdf->x = 30;$pdf->cell(190,5,"De: Pregoeira/ Comissão permanente de Licitação",0,1,"L",0);$pdf->x = 30;$pdf->cell(190,5,"Para: Setor contábil",0,1,"L",0);}else if($tipo==2){echo "<div ><strong>SOLICITAÇÃO DE PARECER DE DISPONIBILIDADE FINANCEIRA</strong></div><div><p>De: Pregoeira/ Comissão permanente de Licitação<br>Para: Setor contábil</p></div>";}\',0,0,1,1,1,\'J\',3,r.inst);
                insert into db_docparag values ((select max(db03_docum) from db_documento),(select max(db02_idparag) from db_paragrafo),r.inst);
                insert into db_paragrafo values ((select max(db02_idparag)+1 from db_paragrafo),\'PARTE2\',\'if($codigo_preco == null || $codigo_preco = ""){if($tipo==1){$pdf->MultiCell(160,5,"     Solicito ao departamento contábil se há no orçamento vigente, disponibilidade financeira que atenda ".mb_strtoupper($objeto,"ISO-8859-1").".",0,"J",0);}else if($tipo==2){echo "<p>Solicito ao departamento contábil se há no orçamento vigente, disponibilidade financeira que atenda ".mb_strtoupper($objeto,"ISO-8859-1").".</p>";}} else {if($tipo==1){$pdf->MultiCell(160,5,"     Solicito ao departamento contábil se há no orçamento vigente, disponibilidade financeira que atenda ".mb_strtoupper($objeto,"ISO-8859-1").", no valor total estimado de R$".trim(db_formatar($nTotalItens,"f")).".",0,"J",0);}else if($tipo==2){echo "<p>Solicito ao departamento contábil se há no orçamento vigente, disponibilidade financeira que atenda ".mb_strtoupper($objeto,"ISO-8859-1").", no valor total estimado de R$ ".trim(db_formatar($nTotalItens,"f")).".</p>";}}\',0,0,1,1,1,\'J\',3,r.inst);
                insert into db_docparag values ((select max(db03_docum) from db_documento),(select max(db02_idparag) from db_paragrafo),2);
                insert into db_paragrafo values ((select max(db02_idparag)+1 from db_paragrafo),\'PARTE3\',\'if($tipo==1){$pdf->cell(190,5,"________________________"                                ,0,1,"C",0);$pdf->cell(190,5,"Presidente da CPL"                                       ,0,1,"C",0);$pdf->cell(190,5,"e/ou Presidente da Comissão de Licitação"                ,0,1,"C",0);}else if($tipo==2){echo "<div >             <center>  _________________________________________  </center>                <p>Presidente da CPL<br>e/ou Presidente da Comissão de Licitação</p>            </div>";}\',0,0,1,1,1,\'J\',3,r.inst);
                insert into db_docparag values ((select max(db03_docum) from db_documento),(select max(db02_idparag) from db_paragrafo),3);


                insert into db_documento values ((select max(db03_docum)+1 from db_documento),\'DECLARACAO DE REC. ORC. E FINANCEIRO1\',(select max(db08_codigo) from db_tipodoc),r.inst);
                insert into db_paragrafo values ((select max(db02_idparag)+1 from db_paragrafo),\'PARTE1\',\'if ($tipo==1){$pdf->MultiCell(160,5,"     Examinando  as  Dotações  constantes  do  orçamento  fiscal  e  levando-se  em  conta  o objeto que se  pretende  contratar, ".mb_strtoupper($objeto,"ISO-8859-1")." , no valor total estimado de R$ ".trim(db_formatar($nTotalItens,"f"))." em atendimento aos dispositivos da Lei 8666/93, informo que existe dotações das quais correrão a despesas:",0,"J",0);}else if($tipo == 2){echo "     Examinando  as  Dotações  constantes  do  orçamento  fiscal  e  levando-se  em  conta  o objeto que se  pretende  contratar, ".mb_strtoupper($objeto,"ISO-8859-1")." , no valor total estimado de R$ ".trim(db_formatar($nTotalItens,"f"))." em atendimento aos dispositivos da Lei 8666/93, informo que existe dotações das quais correrão a despesas:";}\',0,0,1,1,1,\'J\',3,r.inst);
                insert into db_docparag values ((select max(db03_docum) from db_documento),(select max(db02_idparag) from db_paragrafo),r.inst);
                insert into db_paragrafo values ((select max(db02_idparag)+1 from db_paragrafo),\'PARTE2\',\'if ($tipo==1){$pdf->MultiCell(160,5,"que as despesas atendem ao disposto nos artigos 16 e 17 da Lei Complementar Federal 101/2000, uma vez, foi considerado o impacto na execução orçamentária e também está de acordo com a previsão do Plano Plurianual e da Lei de Diretrizes Orçamentárias para exercício. Informamos ainda que foi verificado o impacto financeiro da despesa e sua inclusão na programação deste órgão.",0,"J",0);}else if($tipo == 2){echo "que as despesas atendem ao disposto nos artigos 16 e 17 da Lei Complementar Federal 101/2000, uma vez, foi considerado o impacto na execução orçamentária e também está de acordo com a previsão do Plano Plurianual e da Lei de Diretrizes Orçamentárias para exercício. Informamos ainda que foi verificado o impacto financeiro da despesa e sua inclusão na programação deste órgão.";}\',0,0,1,1,1,\'J\',3,r.inst);
                insert into db_docparag values ((select max(db03_docum) from db_documento),(select max(db02_idparag) from db_paragrafo),2);
                insert into db_paragrafo values ((select max(db02_idparag)+1 from db_paragrafo),\'PARTE3\',\'if($tipo==1){$pdf->cell(95,4,"________________________"                                ,0,0,"C",0);$pdf->cell(95,4,"________________________"                                ,0,1,"C",0);$pdf->cell(95,5,"Serviço contábil"                                        ,0,0,"C",0);$pdf->cell(95,5,"Serviço Financeiro"                                      ,0,0,"C",0);}else if($tipo==2){echo "<tr>                <td >  _________________________________________                  <p>Serviço contábil</p></td>                <td >  _________________________________________                 <p>Serviço Financeiro</p></td>";}\',0,0,1,1,1,\'J\',3,r.inst);
                insert into db_docparag values ((select max(db03_docum) from db_documento),(select max(db02_idparag) from db_paragrafo),3);
                
                RETURN NEXT r;

            END LOOP;
            RETURN;
        END
        $$
        LANGUAGE plpgsql;

        SELECT * FROM getAllCodigos();
 
        DROP FUNCTION getAllCodigos();
        
        COMMIT;';

        $this->execute($sql);

    }
}
