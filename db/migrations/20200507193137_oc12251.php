<?php

use Phinx\Migration\AbstractMigration;

class Oc12251 extends AbstractMigration
{
    public function up()
    {
		$sql = "
				CREATE TABLE obrascodigos(
					db151_sequencial SERIAL,
					db151_codigoobra INTEGER NOT NULL,
					db151_liclicita INTEGER NOT NULL,
					PRIMARY KEY(db151_codigoobra),
					FOREIGN KEY(db151_liclicita) REFERENCES liclicita(l20_codigo)
				);
				
				INSERT INTO obrascodigos(db151_codigoobra, db151_liclicita) (SELECT db150_codobra, db150_liclicita FROM obrasdadoscomplementares);
				SELECT * FROM obrascodigos;
				
				ALTER TABLE obrasdadoscomplementares ADD CONSTRAINT fk_codigoobra FOREIGN KEY(db150_codobra) REFERENCES obrascodigos(db151_codigoobra);
				ALTER TABLE obrasdadoscomplementares DROP COLUMN db150_liclicita;
		";
		$this->execute($sql);
    }

    public function down(){

	}
}
