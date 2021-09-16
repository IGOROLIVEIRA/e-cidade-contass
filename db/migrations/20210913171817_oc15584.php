<?php

use Phinx\Migration\AbstractMigration;

class Oc15584 extends AbstractMigration
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
        $sql = utf8_encode('
            begin;
            INSERT INTO db_itensmenu VALUES((select max(id_item)+1 from db_itensmenu),\'Ratificação(novo)\',\'Ratificação(novo)\',\'rat2_ratificacaoprocnovo001.php\',1,1,\'Ratificação(novo)\',\'t\');
            INSERT INTO db_menu VALUES(1797,(select max(id_item) from db_itensmenu),1002,381);
            INSERT INTO db_tipodoc VALUES ((SELECT max(db08_codigo)+1 from db_tipodoc),\'RATIFICACAO NOVO\');
                   
            INSERT INTO db_documentopadrao VALUES ((SELECT max(db60_coddoc) FROM db_documentopadrao)+1, \'RATIFICACAO NOVO\', (select max(db08_codigo) from db_tipodoc), 1);
            insert into db_documento values ((select max(db03_docum)+1 from db_documento),\'RATIFICACAO NOVO\',(select max(db08_codigo) from db_tipodoc), 1);
            INSERT INTO db_paragrafo
            VALUES (
                        (SELECT MAX(db02_idparag)+1
                         FROM db_paragrafo),
                     \'RATIFICACAO NOVO\',
                     \'PROCEDIMENTO ADMINISTRATIVO Nº #$l20_edital# 
            TERMO DE #$l44_descricao#  Nº #$l20_numero#
            
            O PREFEITO, NO USO DE SUAS ATRIBUIÇÕES LEGAIS,
            
            RESOLVE,
            
            RATIFICAR E HOMOLOGAR, o Procedimento Licitatório nº #$l20_edital#, Termo de #$l44_descricao# nº #$l20_numero# conforme justificativa apresentada pela Comissão de Licitação da #$instit#, e Parecer da Assessoria Jurídica, AUTORIZANDO a #$l20_objeto#  no valor total de R$ #$totallicitacao# para contratação do(s) fornecedor(es) relacionado(s) abaixo.\',
                     0,
                     0,
                     1,
                     5,
                     0,
                     \'J\',
                     1,
                     1);
			insert into db_docparagpadrao(db62_coddoc, db62_codparag, db62_ordem) values ((select max(db60_coddoc) from db_documentopadrao), (select max(db61_codparag) from db_paragrafopadrao), 1);
         insert into db_docparag values ((select max(db03_docum) from db_documento),(SELECT MAX(db02_idparag)FROM db_paragrafo),1);

            INSERT INTO db_paragrafo
            VALUES (
                        (SELECT MAX(db02_idparag)+1
                         FROM db_paragrafo),
                     \'ITENS RATIFICACAO NOVO\',
                     \'$oPDF->ln();
$result_orc=$clliclicita->sql_record($clliclicita->sql_query_pco($l20_codigo,"pc22_codorc as orcamento"));

if ($clliclicita->numrows == 0) {
    db_redireciona("db_erros.php?fechar=true&db_erro=Não existem registros de valores lancados!");
    exit;
}
db_fieldsmemory($result_orc,0);
$result_forne=$clpcorcamforne->sql_record($clpcorcamforne->sql_query(null,"*",null,"pc21_codorc=$orcamento"));
//db_criatabela($result_forne);exit;
$numrows_forne=$clpcorcamforne->numrows;

$oPDF->SetFillColor(235);
$cor=0;

for($x = 0; $x < $numrows_forne;$x++){
    db_fieldsmemory($result_forne,$x);
    $result_itens=$clpcorcamitem->sql_record($clpcorcamitem->sql_query_homologados(null,"distinct l21_ordem,pc22_orcamitem,pc11_resum,pc01_descrmater","l21_ordem","pc22_codorc=$orcamento"));
    $numrows_itens=$clpcorcamitem->numrows;

    /**
     * Verifica se existe em algum item a descriçãi da Marca ou OBS
     */
    for($w=0;$w<$numrows_itens;$w++){
        db_fieldsmemory($result_itens,$w);
        $result_valor=$clpcorcamval->sql_record($clpcorcamval->sql_query_julg(null,null,"pc23_valor,pc23_quant,pc23_obs,pc23_vlrun,pc24_pontuacao",null,"pc23_orcamforne=$pc21_orcamforne and pc23_orcamitem=$pc22_orcamitem and pc24_pontuacao=1"));

        if ($clpcorcamval->numrows>0){

            $op = 1;
            if($clpcorcamval->numrows>0){

                for($i=0;$i<$clpcorcamval->numrows;$i++){
                    $result2 = db_utils::fieldsMemory($result_valor,$i);

                    if($result2->pc23_obs != ""){
                        $op = 2;
                    }
                }
            }
        }
    }

    if ($oPDF->gety() > $oPDF->h - 30){
        $oPDF->ln(2);
        $oPDF->addpage();
    }
    for($w=0;$w<$numrows_itens;$w++){
        db_fieldsmemory($result_itens,$w);
        $result_valor=$clpcorcamval->sql_record($clpcorcamval->sql_query_julg(null,null,"pc23_valor,pc23_quant,pc23_obs,pc23_vlrun,pc24_pontuacao",null,"pc23_orcamforne=$pc21_orcamforne and pc23_orcamitem=$pc22_orcamitem and pc24_pontuacao=1"));
        if ($clpcorcamval->numrows>0){
            db_fieldsmemory($result_valor,0);

            if ($oPDF->gety() > $oPDF->h - 30){
                $oPDF->ln(2);
                $oPDF->addpage();
            }
            if ($z01_nome!=$z01_nomeant){
                $empresas .= $z01_nome.", ";

                if ($quant_forne!=0){
                    $oPDF->cell(120,$alt,"VALOR TOTAL RATIFICADO:","T",0,"R",0);
                    $oPDF->cell(60,$alt,"R$".db_formatar($val_forne, "f"),"T",1,"R",0);
                    $oPDF->ln();
                    $quant_forne = 0;
                    $val_forne = 0;
                }
                if($op==2){
                    $oPDF->setfont("arial","b",9);
                    $z01_nomeant = $z01_nome;
                    $oPDF->cell(80,$alt,substr($z01_nome,0,40)." - ".$z01_cgccpf,0,1,"L",0);
                    $oPDF->cell(25,$alt,"Quantidade",0,0,"R",0);
                    $oPDF->cell(35,$alt,"Marca",0,0,"C",0);
                    $oPDF->cell(40,$alt,"Valor Unitário",0,0,"R",0);
                    $oPDF->cell(80,$alt,"Valor Total",0,1,"R",0);
                    $oPDF->ln();
                    $oPDF->setfont("arial","",8);
                }else if($op==1){
                    $oPDF->setfont("arial","b",9);
                    $z01_nomeant = $z01_nome;
                    $oPDF->cell(80,$alt,substr($z01_nome,0,40)." - ".$z01_cgccpf,0,1,"L",0);
                    $oPDF->cell(25,$alt,"Quantidade",0,0,"R",0);
                    $oPDF->cell(35,$alt,"Valor Unitário",0,0,"R",0);
                    $oPDF->cell(120,$alt,"Valor Total",0,1,"R",0);
                    $oPDF->ln();
                    $oPDF->setfont("arial","",8);
                }

            }
            if ($cor == 0) {
                $cor = 1;
            } else {
                $cor = 0;
            }
            if($op==2){

                $oPDF->multicell(180,$alt,"Item ".$l21_ordem." - ".$pc01_descrmater . " - " . $pc11_resum,0,"J",$cor);
                $oPDF->cell(15,$alt,$pc23_quant,0,0,"R",$cor);
                $oPDF->cell(55,$alt,$pc23_obs,0,0,"C",$cor);
                $oPDF->cell(20,$alt,db_formatar(@$pc23_vlrun,"f"),0,0,"R",$cor);
                $oPDF->cell(90,$alt,"R$".trim(db_formatar(@$pc23_valor,"f")),0,1,"R",$cor);
                $quant_tot += $pc23_quant;
                $val_tot += $pc23_valor;
                $quant_forne += $pc23_quant;
                $val_forne += $pc23_valor;
            }else if($op==1){

                $oPDF->multicell(180,$alt,"Item ".$l21_ordem." - ".$pc01_descrmater . " - " . $pc11_resum,0,"J",$cor);
                $oPDF->cell(15,$alt,$pc23_quant,0,0,"R",$cor);
                $oPDF->cell(35,$alt,$pc23_vlrun,0,0,"R",$cor);
                $oPDF->cell(130,$alt,"R$".trim(db_formatar(@$pc23_valor,"f")),0,1,"R",$cor);
                $quant_tot += $pc23_quant;
                $val_tot += $pc23_valor;
                $quant_forne += $pc23_quant;
                $val_forne += $pc23_valor;
            }

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
    $oPDF->cell(120,$alt,"VALOR TOTAL RATIFICADO:","T",0,"R",0);
    $oPDF->cell(60,$alt,"R$".db_formatar($val_forne, "f"),"T",1,"R",0);
    $oPDF->ln();
}

$oPDF->ln();
$oPDF->cell(120,$alt,"TOTAL:","T",0,"R",0);
$oPDF->cell(60,$alt,"R$".db_formatar($val_tot, "f"),"T",1,"R",0);
$oPDF->ln();
$oPDF->MultiCell(180,$alt,"Intime-se ".$empresas." para formalização do contrato.",0,\'J\',0);
$oPDF->ln();
$oPDF->cell(60,$alt,"Cumpra-se.","",1,"L",0);

$oPDF->setfont(\'arial\',\'\',9);
$dia=date(\'d\',db_getsession("DB_datausu"));
$mes=date(\'m\',db_getsession("DB_datausu"));
$ano=date(\'Y\',db_getsession("DB_datausu"));
$mes=db_mes($mes);
$oPDF->ln();
$oPDF->ln();
$oPDF->cell(90,$alt,"",0,0,"R",0);
$oPDF->cell(90,$alt,"$munic, $dia $mes de $ano.",0,1,"C",0);
$oPDF->ln(15);

$sqlparag = "select db02_texto
       from db_documento
        inner join db_docparag on db03_docum = db04_docum
            inner join db_tipodoc on db08_codigo  = db03_tipodoc
          inner join db_paragrafo on db04_idparag = db02_idparag
      where db03_tipodoc = 1000 and db03_instit = $dbinstit order by db04_ordem ";

$resparag = @pg_query($sqlparag);
$numrows  = 0;
$numrows  = @pg_numrows($resparag);

for($i = 0; $i < $numrows; $i++){
    db_fieldsmemory($resparag,$i);

    $oPDF->cell(90,0.5,"",0,0,"R",0);
    $oPDF->cell(90,$alt,$db02_texto,0,1,"C",0);
    $oPDF->cell(90,0.5,"",0,1,"R",0);
}\',
                     0,
                     0,
                     1,
                     5,
                     0,
                     \'J\',
                     3,
                     1);
         insert into db_docparag values ((select max(db03_docum) from db_documento),(SELECT MAX(db02_idparag)FROM db_paragrafo),2);
             INSERT INTO db_paragrafo
            VALUES (
                        (SELECT MAX(db02_idparag)+1
                         FROM db_paragrafo),
                     \'ASSINATURA RATIFICACAO NOVO\',
                     \'if ($numrows == 0){
                         $oPDF->cell(90,$alt,"",0,0,"R",0);
                         $oPDF->cell(90,$alt,"ASSINATURA",0,1,"C",0);
                     }\',
                     0,
                     0,
                     1,
                     5,
                     0,
                     \'J\',
                     3,
                     1);
         insert into db_docparag values ((select max(db03_docum) from db_documento),(SELECT MAX(db02_idparag)FROM db_paragrafo),3);
commit;          
        ');
        $this->execute($sql);
    }
}
