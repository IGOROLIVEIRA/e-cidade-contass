<?php

use App\Support\Database\Instituition;
use ECidade\Suporte\Phinx\PostgresMigration;

class Oc21467 extends PostgresMigration
{
    use Instituition;

	public const PMPIRAPORA 	= '23539463000121';
	public const PMBURITIZEIRO	= '18279067000172';

    public function up()
    {		
		//Cria a tabela autorizausuarioexcluirpgtoparcial, para inclusão dos id_usuario que será autorizado na rotina arr4_excluiPagamentoParcial001.php
		$this->execute("CREATE TABLE IF NOT EXISTS arrecadacao.autorizausuarioexcluirpgtoparcial (id_usuario int8 NOT NULL DEFAULT 0, 
						CONSTRAINT autorizausuarioexcluirpgtoparcial_idusuario_pk PRIMARY KEY (id_usuario));");

		if (!empty($this->checkInstituicaoExists(self::PMPIRAPORA))){
			$this->execute("INSERT INTO autorizausuarioexcluirpgtoparcial VALUES (2050);");
			$this->execute("INSERT INTO autorizausuarioexcluirpgtoparcial VALUES (2463);");
			$this->execute("INSERT INTO autorizausuarioexcluirpgtoparcial VALUES (2086);");
			$this->execute("INSERT INTO autorizausuarioexcluirpgtoparcial VALUES (2046);");
			$this->execute("INSERT INTO autorizausuarioexcluirpgtoparcial VALUES (2766);");
		}

		if (!empty($this->checkInstituicaoExists(self::PMBURITIZEIRO))){
			$this->execute("INSERT INTO autorizausuarioexcluirpgtoparcial VALUES (1163);");
			$this->execute("INSERT INTO autorizausuarioexcluirpgtoparcial VALUES (1164);");
			$this->execute("INSERT INTO autorizausuarioexcluirpgtoparcial VALUES (1193);");
		}
    }
}
