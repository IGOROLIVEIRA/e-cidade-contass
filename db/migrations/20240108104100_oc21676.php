<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc21676 extends PostgresMigration
{
    public function up()
    {
		//Consulta no banco se existe o modelo 108 (mod_imprime108.php)
		$mod_imprime108 = $this->execute("SELECT * FROM cadmodcarne WHERE k47_sequencial = 108;");

		//Se o modelo 108 (mod_imprime108.php) não existir o mesmo será incluido.
		if (empty($mod_imprime108)){
			$this->execute("INSERT INTO cadmodcarne (k47_sequencial,k47_descr,k47_altura,k47_largura) VALUES (108,'MODELO 4 CARNE IPTU PDF AGRUPADO',0,0);");
		}
    }
}

