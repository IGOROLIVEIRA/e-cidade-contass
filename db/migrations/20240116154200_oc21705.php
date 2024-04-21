<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc21705 extends PostgresMigration
{
    public function up()
    {
		//Consulta no banco se existe o modelo 108 (mod_imprime109.php)
		$mod_imprime109 = $this->execute("SELECT * FROM cadmodcarne WHERE k47_sequencial = 109;");

		//Se o modelo 108 (mod_imprime108.php) não existir o mesmo será incluido.
		if (empty($mod_imprime109)){
			$this->execute("INSERT INTO cadmodcarne (k47_sequencial,k47_descr,k47_altura,k47_largura) VALUES (109,'RECIBO PADRAO - VISTORIA',0,0);");
		}
    }
}

