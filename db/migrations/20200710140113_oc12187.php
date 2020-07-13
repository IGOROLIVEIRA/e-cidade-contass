<?php

use Phinx\Migration\AbstractMigration;

class Oc12187 extends AbstractMigration
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
        $sql = <<<SQL
        BEGIN;
              /*deletando primeiro paragrafo*/
              DELETE
                FROM db_docparagpadrao
                WHERE db62_codparag =
                        (SELECT db62_codparag
                         FROM db_documentopadrao
                         INNER JOIN db_docparagpadrao ON db62_coddoc = db60_coddoc
                         INNER JOIN db_paragrafopadrao ON db62_codparag = db61_codparag
                         WHERE db60_tipodoc = 1703
                             AND db62_ordem = 1);
              
             /*adicionando novo padrao ao relatorio paragrafo 2*/
             UPDATE db_paragrafopadrao
                SET db61_texto = 'O Sr(a) #$z01_nome#, CPF no #$z01_cgccpf#, nos usos da suas atribuições legais e nos termos da legislação em vigor, resolve HOMOLOGAR o Processo Licitatório nº #$l20_edital#, Pregão Presencial nº #$l20_numero#, cujo objeto é a #$l20_objeto#, no valor total de R$ #$totallicitacao# conforme fornecedor(es), item(ns) e valor(es) relacionado(s):'
                WHERE db61_codparag =
                        (SELECT db61_codparag
                         FROM db_documentopadrao
                         INNER JOIN db_docparagpadrao ON db62_coddoc = db60_coddoc
                         INNER JOIN db_paragrafopadrao ON db62_codparag = db61_codparag
                         WHERE db60_tipodoc = 1703
                             AND db62_ordem = 2);
             /*adicionando novo padrao ao relatorio paragravo 3*/
             UPDATE db_paragrafopadrao
                SET db61_texto = '$oPDF->ln();
                $result_orc=$clliclicita->sql_record($clliclicita->sql_query_pco($l20_codigo,"pc22_codorc as orcamento"));
                
                if ($clliclicita->numrows == 0) {
                    db_redireciona("db_erros.php?fechar=true&db_erro=Não existem registros de valores lancados!");
                    exit;
                }
                db_fieldsmemory($result_orc,0);
                $result_forne=$clpcorcamforne->sql_record($clpcorcamforne->sql_query(null,"*",null,"pc21_codorc=$orcamento"));
                $numrows_forne=$clpcorcamforne->numrows;
                
                $oPDF->SetFillColor(235);
                $cor=0;
                
                for($x = 0; $x < $numrows_forne;$x++){
                    db_fieldsmemory($result_forne,$x);
                    $result_itens=$clpcorcamitem->sql_record($clpcorcamitem->sql_query_homologados(null,"distinct l21_ordem,pc22_orcamitem,pc11_resum,pc01_descrmater","l21_ordem","pc22_codorc=$orcamento"));
                    $numrows_itens=$clpcorcamitem->numrows;
                    if ($oPDF->gety() > $oPDF->h - 30){
                        $oPDF->ln(2);
                        $oPDF->addpage();
                    }
                    for($w=0;$w<$numrows_itens;$w++){
                        db_fieldsmemory($result_itens,$w);
                        $result_valor=$clpcorcamval->sql_record($clpcorcamval->sql_query_julg(null,null,"pc23_valor,pc23_quant,pc23_vlrun,pc24_pontuacao",null,"pc23_orcamforne=$pc21_orcamforne and pc23_orcamitem=$pc22_orcamitem and pc24_pontuacao=1"));
                        if ($clpcorcamval->numrows>0){
                            db_fieldsmemory($result_valor,0);
                
                            if ($oPDF->gety() > $oPDF->h - 30){
                                $oPDF->ln(2);
                                $oPDF->addpage();
                            }
                            if ($z01_nome!=$z01_nomeant){
                                if ($quant_forne!=0){
                                    $oPDF->cell(120,$alt,"VALOR TOTAL HOMOLOGADO:","T",0,"R",0);
                                    $oPDF->cell(60,$alt,"R$".db_formatar($val_forne, "f"),"T",1,"R",0);
                                    $oPDF->ln();
                                    $quant_forne = 0;
                                    $val_forne = 0;
                                }
                                $oPDF->setfont("arial","b",9);
                                $z01_nomeant = $z01_nome;
                                $oPDF->cell(80,$alt,substr($z01_nome,0,40),0,1,"L",0);
                                $oPDF->cell(25,$alt,"Quantidade",0,0,"R",0);
                                $oPDF->cell(35,$alt,"Valor Untario",0,0,"R",0);
                                $oPDF->cell(120,$alt,"Valor Total Unitario",0,1,"R",0);
                                $oPDF->ln();
                                $oPDF->setfont("arial","",8);
                            }
                            if ($cor == 0) {
                                $cor = 1;
                            } else {
                                $cor = 0;
                            }
                
                            $oPDF->multicell(180,$alt,"Item ".$l21_ordem." - ".$pc01_descrmater . " - " . $pc11_resum,0,"J",$cor);
                            $oPDF->cell(20,$alt,$pc23_quant,0,0,"R",$cor);
                            $oPDF->cell(30,$alt,$pc23_vlrun,0,0,"R",$cor);
                            $oPDF->cell(130,$alt,"R$".db_formatar(@$pc23_valor,"f"),0,1,"R",$cor);
                            $quant_tot += $pc23_quant;
                            $val_tot += $pc23_valor;
                            $quant_forne += $pc23_quant;
                            $val_forne += $pc23_valor;
                            if ($oPDF->gety() > $oPDF->h - 30){
                                $oPDF->addpage();
                            }
                        }
                    }
                
                    if ($oPDF->gety() > $oPDF->h - 30){
                        $oPDF->ln(2);
                        $oPDF->addpage();
                    }
                }
                if ($val_forne > 0){
                    $oPDF->cell(120,$alt,"VALOR TOTAL HOMOLOGADO:","T",0,"R",0);
                    $oPDF->cell(60,$alt,"R$".db_formatar($val_forne, "f"),"T",1,"R",0);
                    $oPDF->ln();
                }
                
                $oPDF->ln();
                $oPDF->cell(120,$alt,"TOTAL:","T",0,"R",0);
                $oPDF->cell(60,$alt,"R$".db_formatar($val_tot, "f"),"T",1,"R",0);
                $oPDF->ln();'
                WHERE db61_codparag = (SELECT db61_codparag
                         FROM db_documentopadrao
                         INNER JOIN db_docparagpadrao ON db62_coddoc = db60_coddoc
                         INNER JOIN db_paragrafopadrao ON db62_codparag = db61_codparag
                         WHERE db60_tipodoc = 1703
                             AND db62_ordem = 3);                
             
              
SQL;

        $this->execute($sql);
    }
}
