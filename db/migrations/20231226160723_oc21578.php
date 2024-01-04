<?php

use Phinx\Migration\AbstractMigration;

class Oc21578 extends AbstractMigration
{
  public function up()
  {
      $this->atualizaEmpparametro();
      $this->atualizaMenu();
      $this->execute("INSERT INTO db_tipodoc VALUES (1509, 'ASSINATURA PADRÃO PAGAMENTO DE DESPESA');");
      $sql = "SELECT codigo FROM db_config";
      $row = $this->fetchAll($sql);
      foreach ($row as $data) {
          $this->inserirAssinatura($data["codigo"]);
      }
  }

  public function atualizaEmpparametro(){
    $sSql = "
          BEGIN;

          ALTER TABLE empenho.empparametro ADD COLUMN e30_modeloop int4 default 2;

          INSERT INTO db_syscampo ( codcam ,nomecam ,conteudo ,descricao ,valorinicial ,rotulo ,tamanho ,nulo ,maiusculo ,autocompl ,aceitatipo ,tipoobj ,rotulorel ) 
          VALUES ((SELECT max(codcam) + 1 FROM db_syscampo) ,'e30_modeloop' ,'int4' ,'Modelo da Ordem de Pagamento' ,'true' ,'Modelo da Ordem de Pagamento' ,5 ,'false' ,'false' ,'false' ,1 ,'text' ,'Modelo da Ordem de Pagamento' );
          INSERT INTO db_sysarqcamp ( codarq ,codcam ,seqarq ,codsequencia ) 
          VALUES (
          (SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empparametro'),
          (SELECT codcam FROM db_syscampo WHERE nomecam = 'e30_modeloop'),
          (SELECT max(seqarq) FROM db_sysarqcamp WHERE codarq = ((SELECT codarq FROM db_sysarquivo WHERE nomearq = 'empparametro'))) + 1,0 );

          COMMIT;
    ";

    $this->execute($sSql);
  }

  public function atualizaMenu(){
    $sSql = "
        BEGIN;

        UPDATE db_itensmenu SET descricao = 'Emite Ordem de Pagamento / Nota Liquidação' WHERE funcao = 'emp2_emitenotaliq001.php';
             
        INSERT INTO db_itensmenu
        VALUES (
                (SELECT max(id_item)+1 FROM db_itensmenu),
                'Emite Pagamento Despesa Orçamentária',
                'Emite Pagamento Despesa Orçamentária',
                'emp2_emitenotadespesa001.php',
                1,
                1,
                '',
                't'
            );

        INSERT INTO db_menu
        VALUES (
              (SELECT im.id_item FROM db_itensmenu im join db_menu m on im.id_item = m.id_item_filho WHERE im.descricao LIKE 'Documentos' and m.modulo = 398),
              (SELECT max(id_item) FROM db_itensmenu),
              (SELECT max(menusequencia)+1 FROM db_menu WHERE id_item = (SELECT im.id_item FROM db_itensmenu im join db_menu m on im.id_item = m.id_item_filho WHERE im.descricao LIKE 'Documentos' and m.modulo = 398) AND modulo = 398),
              398
            );

        COMMIT;
    ";

    $this->execute($sSql);
  }

  public function inserirAssinatura($instituicao)
  {
       $sql = "
              BEGIN;

              INSERT INTO db_documentopadrao VALUES ((SELECT max(db60_coddoc) FROM db_documentopadrao)+1, 'ASSINATURA PADRÃO PAGAMENTO DE DESPESA', 1509, $instituicao);

              INSERT INTO db_paragrafopadrao VALUES
              ((SELECT MAX(db61_codparag) FROM db_paragrafopadrao)+1, 'ASSINATURA PADRÃO PAGAMENTO DE DESPESA', '
              \$sql = \'select e41_descr as tipo_emp from pagordem inner join empempenho on e50_numemp = e60_numemp inner join emptipo on e60_codtipo = e41_codtipo where e50_codord = \'.\$this->ordpag;

              global \$tipo_emp;
              
              \$res_sql = pg_query(\$sql);
              if(pg_numrows(\$res_sql) > 0){
                db_fieldsmemory(\$res_sql,0);
              }else{
                \$tipo_emp = \' \';
              }
              //BOX ASSINATURAS TITULO
              \$this->objpdf->text(\$xcol+44,\$xlin+207,\'TESOUREIRO\');
              \$this->objpdf->text(\$xcol+135,\$xlin+207,\'ORDENADOR DE PAGAMENTO\');
              
              \$this->objpdf->rect(\$xcol,\$xlin+190,194,10,2,\'DF\',\'12\');
              \$this->objpdf->setfont(Arial,\'b\',7);
              \$this->objpdf->text(\$xcol+5,\$xlin+196,\'EMPENHO     \'. db_formatar(\$this->numemp,\'s\',\'0\',5).\'     \'. \$this->emptipo);
              
              
              //linha assinatura
              \$this->objpdf->line(\$xcol+120,\$xlin+224,\$xcol+185,\$xlin+224);
              \$this->objpdf->line(\$xcol+20,\$xlin+224,\$xcol+85,\$xlin+224);
              
              
              \$this->objpdf->SetFont(\'Arial\',\'\',6);
              
              //Assinaturas
              \$this->objpdf->text(\$xcol+40,\$xlin+227,\$this->tesoureiro);
              
              \$this->objpdf->text(\$xcol+140,\$xlin+227,\$this->ordenapagamento);
              
              // Moldura do canhoto
              \$this->objpdf->rect(\$xcol, \$xlin +246, 194, 26, 2, \'DF\', \'1234\');
              \$this->objpdf->SetFont(\'Arial\', \'\', 7);
              \$this->objpdf->text(\$xcol +90, \$xlin +249, \'R E C I B O\');
              \$this->objpdf->text(\$xcol +40, \$xlin +255, \'DECLARO QUE RECEBI O VALOR LÍQUIDO SUPRACITADO E DOU PLENA QUITAÇÃO DESTA DESPESA.\');
              \$this->objpdf->text(\$xcol +2, \$xlin +261, \'RESPONSÁVEL PELA QUITAÇÃO: ________________________________________________________________________\');
              \$this->objpdf->text(\$xcol +150, \$xlin +261, \'EM ________/________/________\', 0, 0, \'C\', 0);
              \$this->objpdf->text(\$xcol +42, \$xlin +268, \'________________________________________________________________________\', 0, 0, \'C\', 0);
              \$this->objpdf->SetFont(\'Arial\', \'\', 6);
              \$this->objpdf->text(\$xcol +90, \$xlin +271, \'ASSINATURA\', 0, 0, \'C\', 0);');
            COMMIT;
";

      $this->execute($sql);
      $sql = "INSERT INTO db_docparagpadrao VALUES (" . $this->getDb60CodDoc("ASSINATURA PADRÃO PAGAMENTO DE DESPESA") . ", " . $this->getDb61CodParag("ASSINATURA PADRÃO PAGAMENTO DE DESPESA") . ",{$instituicao})";
      $this->execute($sql);
  }

  public function getDb61CodParag($descricao)
  {
      $sql = "SELECT MAX(db61_codparag) db61_codparag FROM db_paragrafopadrao WHERE db61_descr = '{$descricao}'";
      $row = $this->fetchAll($sql);
      foreach ($row as $data) {
          return $data["db61_codparag"];
      }
  }

  public function getDb60CodDoc($descricao) {
      $sql = "SELECT MAX(db60_coddoc) db60_coddoc FROM db_documentopadrao WHERE db60_descr = '{$descricao}'";
      $row = $this->fetchAll($sql);
      foreach ($row as $data) {
          return $data["db60_coddoc"];
      }
  }

  public function down()
  {

  }
}
