<?php

use ECidade\Suporte\Phinx\PostgresMigration;

class Oc17014 extends PostgresMigration
{
    public function up()
    {
        $jsonData = file_get_contents('db/migrations/20220329182150_oc17014.json');
        $jsonDados = json_decode($jsonData);
        $dbName = $this->fetchAll("SELECT datname FROM pg_database WHERE current_database() = 'e-cidade-zerada-2019'");
        $clientInstit = $this->fetchAll("SELECT codigo FROM db_config WHERE cgc IN ('18650945000114','17097791000112', '01612501000191')");

        if (!empty($dbName) || !empty($clientInstit)) {

            $aExercicios = $this->fetchAll("SELECT DISTINCT c60_anousu FROM conplanoorcamento WHERE c60_anousu >= 2022");
            foreach ($aExercicios as $ano) {

                foreach ($jsonDados->contas as $conta) {

                    $existPcasp = $this->fetchRow("SELECT * FROM conplano WHERE c60_anousu = {$ano['c60_anousu']} AND c60_estrut = '{$conta->estrutural}'");

                    if (empty($existPcasp)) {

                        $c60_codcon                     = current($this->fetchRow("select nextval('conplano_c60_codcon_seq')"));
                        $c60_anousu                     = $ano['c60_anousu'];
                        $c60_estrut                     = substr($conta->estrutural, 0, 15);
                        $c60_descr                      = substr($conta->nomeclatura, 0, 50);
                        $c60_finali                     = $conta->nomeclatura;
                        $c60_codsis                     = 2;
                        $c60_codcla                     = 1;
                        $c60_consistemaconta            = 0;
                        $c60_naturezasaldo              = $conta->natsaldo == "AMBOS" ? 3 : NULL;
                        $c60_nregobrig                  = $conta->nro_reg == "0" ? 0 : NULL;
                        $c60_infcompmsc                 = $conta->ic_msc != "" ? 1 : NULL;

                        $aConPlano = array($c60_codcon, $c60_anousu, $c60_estrut, $c60_descr, $c60_finali, $c60_codsis, $c60_codcla, $c60_consistemaconta, $c60_naturezasaldo, $c60_nregobrig, $c60_infcompmsc);
                        $this->insertConplano($aConPlano);
                        
                        if ($c60_infcompmsc == 1) {
    
                            $aInstit = $this->fetchAll("SELECT DISTINCT codigo FROM db_config JOIN conplanoreduz ON (c61_instit, c61_anousu) = (codigo, {$ano['c60_anousu']})");
    
                            foreach ($aInstit as $instituicao) {
    
                                $c61_codcon        = $c60_codcon;
                                $c61_anousu        = $ano['c60_anousu'];
                                $c61_reduz         = current($this->fetchRow("select nextval('conplanoreduz_c61_reduz_seq')"));
                                $c61_instit        = $instituicao['codigo'];
                                $c61_codigo        = 1;
                                $c61_contrapartida = 0;
    
                                $aConPlanoReduz    = array($c61_codcon, $c61_anousu, $c61_reduz, $c61_instit, $c61_codigo, $c61_contrapartida);
                                $this->insertConplanoReduz($aConPlanoReduz);
    
                                $aConplanoExe      = array($c61_anousu, $c61_reduz, $c61_codigo, 0, 0);
                                $this->insertConplanoExe($aConplanoExe);
                            }
                        }
                    }

                }
            }
        }
    }

    public function insertConplano($data)
    {
        $fields = array(
            'c60_codcon',
            'c60_anousu',
            'c60_estrut',
            'c60_descr',
            'c60_finali',
            'c60_codsis',
            'c60_codcla',
            'c60_consistemaconta',
            'c60_naturezasaldo',
            'c60_nregobrig',
            'c60_infcompmsc'
        );
        $this->table('conplano', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
    }

    public function insertConplanoReduz($data)
    {
        $fields = array(
            'c61_codcon',
            'c61_anousu',
            'c61_reduz',
            'c61_instit',
            'c61_codigo',
            'c61_contrapartida'
        );
        $this->table('conplanoreduz', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
    }

    public function insertConplanoExe($data)
    {
        $fields = array(
            'c62_anousu',
            'c62_reduz',
            'c62_codrec',
            'c62_vlrcre',
            'c62_vlrdeb'
        );

        $this->table('conplanoexe', array('schema' => 'contabilidade'))->insert($fields, array($data))->saveData();
    }
}
