<?php

use Classes\PostgresMigration;

class AlteraTipoDadosIptuCalc extends PostgresMigration
{
  public function up()
  {
    $this->table('iptucale', array('schema' => 'cadastro'))
      ->changeColumn('j22_pontos', 'decimal')
      ->update();

    $this->table('iptucalc', array('schema' => 'cadastro'))
      ->addColumn('j23_pontosterr', 'decimal', array('null' => true))
      ->update();
  }
}
