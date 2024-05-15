git <?php

    use ECidade\Suporte\Phinx\PostgresMigration;

    class Oc21061 extends PostgresMigration
    {


      public function up()
      {
        $this->_run();
      }

      public function down()
      {
      }

      private function _run()
      {
        $sql = <<<SQL
        BEGIN;
          -- Cria itens de menu
          INSERT INTO db_itensmenu values ((select max(id_item)+1 from db_itensmenu),'Classificação de Fornecedores','Classificação de Fornecedores','lic2_classificacaofornecedores001.php',1,1,'Classificação de Fornecedores','t');
          INSERT INTO db_menu VALUES((SELECT db_menu.id_item FROM db_itensmenu inner join db_menu on db_menu.id_item_filho = db_itensmenu.id_item WHERE descricao = 'Relatório Resumido da Licitação' LIMIT 1),(select max(id_item) from db_itensmenu),4001662,381);
        COMMIT;
        SQL;

        $this->execute($sql);
      }
    }
