<?php

use Phinx\Migration\AbstractMigration;

class Oc21467 extends AbstractMigration
{
    public function up()
    {		
		//Cria a tabela autoriza_cgm_excluipgtoparcial, para inclusão dos numcgm que será autorizado na rotina arr4_excluiPagamentoParcial001.php
		$this->execute("CREATE TABLE IF NOT EXISTS issqn.autorizacgmexcluirpgtoparcial (id_usuario int8 NOT NULL DEFAULT 0, 
						CONSTRAINT autorizacgmexcluirpgtoparcial_idusuario_pk PRIMARY KEY (id_usuario));");

		$sqlPmPirapora 		= $this->query("select 1 from db_config where prefeitura = true and db21_codcli = (58)");
		$resPmPirapora		= $sqlPmPirapora->fetchAll(\PDO::FETCH_ASSOC);

		if (!empty($resPmPirapora)){
			$this->execute("INSERT INTO autorizacgmexcluirpgtoparcial VALUES (2050);");
			$this->execute("INSERT INTO autorizacgmexcluirpgtoparcial VALUES (2463);");
			$this->execute("INSERT INTO autorizacgmexcluirpgtoparcial VALUES (2086);");
			$this->execute("INSERT INTO autorizacgmexcluirpgtoparcial VALUES (2046);");
			$this->execute("INSERT INTO autorizacgmexcluirpgtoparcial VALUES (2766);");
		}

		$sqlPmBuritizeiro 	= $this->query("select 1 from db_config where prefeitura = true and db21_codcli = (89)");
		$resPmBuritizeiro	= $sqlPmBuritizeiro->fetchAll(\PDO::FETCH_ASSOC);

		if (!empty($resPmBuritizeiro)){
			$this->execute("INSERT INTO autorizacgmexcluirpgtoparcial VALUES (1163);");
			$this->execute("INSERT INTO autorizacgmexcluirpgtoparcial VALUES (1164);");
			$this->execute("INSERT INTO autorizacgmexcluirpgtoparcial VALUES (1193);");
		}
    }
}
