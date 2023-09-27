<?php

use Phinx\Migration\AbstractMigration;

class Ocalteracgmnaturezajuridica extends AbstractMigration
{
    public function getcgm(){
        return $this->fetchAll("select z01_numcgm,z01_cgccpf,length(trim(z01_cgccpf)) as tipo from cgm where z01_cgccpf !=''");
    }
    public function up()
    {
        $sSql = "";
        $aRowsCgm = $this->getcgm();
        foreach ($aRowsCgm as $Cgm) {
            if ($Cgm['tipo'] == 14){
                $sSql .= " update cgm set z01_naturezajuridica='8885' where z01_numcgm = {$Cgm['z01_numcgm']}; ";
            }else{
                $sSql .= " update cgm set z01_naturezajuridica='0000' where z01_numcgm = {$Cgm['z01_numcgm']}; ";
            }
        }
        $this->execute($sSql);
    }
}
