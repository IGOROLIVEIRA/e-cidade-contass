<?php

use App\Support\Database\Instituition;
use ECidade\Suporte\Phinx\PostgresMigration;

class Oc21492 extends PostgresMigration
{
    use Instituition;

	public const PMLAGOADOSPATOS    = '16901381000110';

    public function up()
    {		
		//Cria a tabela issnotaavulsatomadorcgmretencao, para inclusão dos cgm para retenção na rotina de impressão fpdf151/imprimemodelos/mod_imprime492.php.php
		$this->execute("CREATE TABLE IF NOT EXISTS issqn.issnotaavulsatomadorcgmretencao (numcgm int8 NOT NULL DEFAULT 0, prefeitura boolean NOT NULL DEFAULT false,
                        CONSTRAINT ssnotaavulsatomadorcgmretencao_numcgm_pk PRIMARY KEY (numcgm));");

        //Inclui as colunas numcgm, prefeitura da tabela db_config;
        $this->execute("INSERT INTO issnotaavulsatomadorcgmretencao (SELECT numcgm, prefeitura FROM db_config);");

		//Inclui o cgm 1022 - Caixa Escolar Rosa Artiminia da Prefeiutra de Lagoa dos Patos
        if (!empty($this->checkInstituicaoExists(self::PMLAGOADOSPATOS))){
			$this->execute("INSERT INTO issnotaavulsatomadorcgmretencao VALUES (1022);");
		}
    }
}
