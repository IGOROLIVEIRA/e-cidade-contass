<?php

use Phinx\Migration\AbstractMigration;
require_once("model/orcamento/ControleOrcamentario.model.php");
class Oc21524 extends AbstractMigration
{
    public function up(){


        $sqlConsulta = $this->query("select * from empempenho 
        inner join orcdotacao on o58_coddot = e60_coddot and o58_anousu = e60_anousu where e60_anousu = 2023");
        $resultado = $sqlConsulta->fetchAll(\PDO::FETCH_ASSOC);

        foreach ($resultado as $dados){
            
            $oCodigoAcompanhamento  = new ControleOrcamentario();
            $oCodigoAcompanhamento->setTipoDespesa( $dados['e60_tipodespesa']);
            $oCodigoAcompanhamento->setFonte($dados['o58_codigo']);
            $oCodigoAcompanhamento->setEmendaParlamentar($dados['e60_emendaparlamentar']);
            $oCodigoAcompanhamento->setEsferaEmendaParlamentar($dados['e60_esferaemendaparlamentar']);
            $oCodigoAcompanhamento->setDeParaFonteCompleta();
            $e60_codco = $oCodigoAcompanhamento->getCodigoParaEmpenho();
            if ($e60_codco != '0000') {
                $this->atualizaCodCO($e60_codco,$dados['e60_numemp'],$dados['e60_anousu']);
            }
            
        }

        $sSqlCampos = " e60_numemp,e60_tipodespesa , e60_emendaparlamentar, e60_esferaemendaparlamentar,e60_anousu,
        CASE
          WHEN o58_codigo = 100 THEN 15000000
          WHEN o58_codigo = 101 THEN 15000001
          WHEN o58_codigo = 102 THEN 15000002
          WHEN o58_codigo = 103 THEN 18000000
          WHEN o58_codigo = 104 THEN 18010000
          WHEN o58_codigo = 105 THEN 18020000
          WHEN o58_codigo = 106 THEN 15760010
          WHEN o58_codigo = 107 THEN 15440000
          WHEN o58_codigo = 108 THEN 17080000
          WHEN o58_codigo = 112 THEN 16590020
          WHEN o58_codigo = 113 THEN 15990030
          WHEN o58_codigo = 116 THEN 17500000
          WHEN o58_codigo = 117 THEN 17510000
          WHEN o58_codigo = 118 THEN 15400007
          WHEN o58_codigo = 119 THEN 15400000
          WHEN o58_codigo = 120 THEN 15760000
          WHEN o58_codigo = 121 THEN 16220000
          WHEN o58_codigo = 122 THEN 15700000
          WHEN o58_codigo = 123 THEN 16310000
          WHEN o58_codigo = 124 THEN 17000000
          WHEN o58_codigo = 129 THEN 16600000
          WHEN o58_codigo = 130 THEN 18990040
          WHEN o58_codigo = 131 THEN 17590050
          WHEN o58_codigo = 132 THEN 16040000
          WHEN o58_codigo = 133 THEN 17150000
          WHEN o58_codigo = 134 THEN 17160000
          WHEN o58_codigo = 135 THEN 17170000
          WHEN o58_codigo = 136 THEN 17180000
          WHEN o58_codigo = 142 THEN 16650000
          WHEN o58_codigo = 143 THEN 15510000
          WHEN o58_codigo = 144 THEN 15520000
          WHEN o58_codigo = 145 THEN 15530000
          WHEN o58_codigo = 146 THEN 15690000
          WHEN o58_codigo = 147 THEN 15500000
          WHEN o58_codigo = 153 THEN 16010000
          WHEN o58_codigo = 154 THEN 16590000
          WHEN o58_codigo = 155 THEN 16210000
          WHEN o58_codigo = 156 THEN 16610000
          WHEN o58_codigo = 157 THEN 17520000
          WHEN o58_codigo = 158 THEN 18990060
          WHEN o58_codigo = 159 THEN 16000000
          WHEN o58_codigo = 160 THEN 17040000
          WHEN o58_codigo = 161 THEN 17070000
          WHEN o58_codigo = 162 THEN 17490120
          WHEN o58_codigo = 163 THEN 17130070
          WHEN o58_codigo = 164 THEN 17060000
          WHEN o58_codigo = 165 THEN 17490000
          WHEN o58_codigo = 166 THEN 15420007
          WHEN o58_codigo = 167 THEN 15420000
          WHEN o58_codigo = 168 THEN 17100100
          WHEN o58_codigo = 169 THEN 17100000
          WHEN o58_codigo = 170 THEN 15010000
          WHEN o58_codigo = 171 THEN 15710000
          WHEN o58_codigo = 172 THEN 15720000
          WHEN o58_codigo = 173 THEN 15750000
          WHEN o58_codigo = 174 THEN 15740000
          WHEN o58_codigo = 175 THEN 15730000
          WHEN o58_codigo = 176 THEN 16320000
          WHEN o58_codigo = 177 THEN 16330000
          WHEN o58_codigo = 178 THEN 16360000
          WHEN o58_codigo = 179 THEN 16340000
          WHEN o58_codigo = 180 THEN 16350000
          WHEN o58_codigo = 181 THEN 17010000
          WHEN o58_codigo = 182 THEN 17020000
          WHEN o58_codigo = 183 THEN 17030000
          WHEN o58_codigo = 184 THEN 17090000
          WHEN o58_codigo = 185 THEN 17530000
          WHEN o58_codigo = 186 THEN 17040000
          WHEN o58_codigo = 187 THEN 17050000
          WHEN o58_codigo = 188 THEN 15000000
          WHEN o58_codigo = 189 THEN 15000000
          WHEN o58_codigo = 190 THEN 17540000
          WHEN o58_codigo = 191 THEN 17540000
          WHEN o58_codigo = 192 THEN 17550000
          WHEN o58_codigo = 193 THEN 18990000
          WHEN o58_codigo = 200 THEN 25000000
          WHEN o58_codigo = 201 THEN 25000001
          WHEN o58_codigo = 202 THEN 25000002
          WHEN o58_codigo = 203 THEN 28000000
          WHEN o58_codigo = 204 THEN 28010000
          WHEN o58_codigo = 205 THEN 28020000
          WHEN o58_codigo = 206 THEN 25760010
          WHEN o58_codigo = 207 THEN 25440000
          WHEN o58_codigo = 208 THEN 27080000
          WHEN o58_codigo = 212 THEN 26590020
          WHEN o58_codigo = 213 THEN 25990030
          WHEN o58_codigo = 216 THEN 27500000
          WHEN o58_codigo = 217 THEN 27510000
          WHEN o58_codigo = 218 THEN 25400007
          WHEN o58_codigo = 219 THEN 25400000
          WHEN o58_codigo = 220 THEN 25760000
          WHEN o58_codigo = 221 THEN 26220000
          WHEN o58_codigo = 222 THEN 25700000
          WHEN o58_codigo = 223 THEN 26310000
          WHEN o58_codigo = 224 THEN 27000000
          WHEN o58_codigo = 229 THEN 26600000
          WHEN o58_codigo = 230 THEN 28990040
          WHEN o58_codigo = 231 THEN 27590050
          WHEN o58_codigo = 232 THEN 26040000
          WHEN o58_codigo = 233 THEN 27150000
          WHEN o58_codigo = 234 THEN 27160000
          WHEN o58_codigo = 235 THEN 27170000
          WHEN o58_codigo = 236 THEN 27180000
          WHEN o58_codigo = 242 THEN 26650000
          WHEN o58_codigo = 243 THEN 25510000
          WHEN o58_codigo = 244 THEN 25520000
          WHEN o58_codigo = 245 THEN 25530000
          WHEN o58_codigo = 246 THEN 25690000
          WHEN o58_codigo = 247 THEN 25500000
          WHEN o58_codigo = 253 THEN 26010000
          WHEN o58_codigo = 254 THEN 26590000
          WHEN o58_codigo = 255 THEN 26210000
          WHEN o58_codigo = 256 THEN 26610000
          WHEN o58_codigo = 257 THEN 27520000
          WHEN o58_codigo = 258 THEN 28990060
          WHEN o58_codigo = 259 THEN 26000000
          WHEN o58_codigo = 260 THEN 27040000
          WHEN o58_codigo = 261 THEN 27070000
          WHEN o58_codigo = 262 THEN 27490120
          WHEN o58_codigo = 263 THEN 27130070
          WHEN o58_codigo = 264 THEN 27060000
          WHEN o58_codigo = 265 THEN 27490000
          WHEN o58_codigo = 266 THEN 25420007
          WHEN o58_codigo = 267 THEN 25420000
          WHEN o58_codigo = 268 THEN 27100100
          WHEN o58_codigo = 269 THEN 27100000
          WHEN o58_codigo = 270 THEN 25010000
          WHEN o58_codigo = 271 THEN 25710000
          WHEN o58_codigo = 272 THEN 25720000
          WHEN o58_codigo = 273 THEN 25750000
          WHEN o58_codigo = 274 THEN 25740000
          WHEN o58_codigo = 275 THEN 25730000
          WHEN o58_codigo = 276 THEN 26320000
          WHEN o58_codigo = 277 THEN 26330000
          WHEN o58_codigo = 278 THEN 26360000
          WHEN o58_codigo = 279 THEN 26340000
          WHEN o58_codigo = 280 THEN 26350000
          WHEN o58_codigo = 281 THEN 27010000
          WHEN o58_codigo = 282 THEN 27020000
          WHEN o58_codigo = 283 THEN 27030000
          WHEN o58_codigo = 284 THEN 27090000
          WHEN o58_codigo = 285 THEN 27530000
          WHEN o58_codigo = 286 THEN 27040000
          WHEN o58_codigo = 287 THEN 27050000
          WHEN o58_codigo = 288 THEN 25000000
          WHEN o58_codigo = 289 THEN 25000000
          WHEN o58_codigo = 290 THEN 27540000
          WHEN o58_codigo = 291 THEN 27540000
          WHEN o58_codigo = 292 THEN 27550000
          WHEN o58_codigo = 293 THEN 28990000
          ELSE o58_codigo
        END as o58_codigo " ;

        $sqlRestos = $this->query("select $sSqlCampos from empresto        
                                        join empempenho on (e91_numemp,e91_anousu) = (e60_numemp,2023) 
                                        join orcdotacao on o58_coddot = e60_coddot and o58_anousu = e60_anousu 
                                        where e91_anousu = 2023");
        $restos = $sqlRestos->fetchAll(\PDO::FETCH_ASSOC);    
       
        foreach ($restos as $dados){
            
            $oCodigoAcompanhamento  = new ControleOrcamentario();
            $oCodigoAcompanhamento->setTipoDespesa( $dados['e60_tipodespesa']);
            $oCodigoAcompanhamento->setFonte($dados['o58_codigo']);
            $oCodigoAcompanhamento->setEmendaParlamentar($dados['e60_emendaparlamentar']);
            $oCodigoAcompanhamento->setEsferaEmendaParlamentar($dados['e60_esferaemendaparlamentar']);
            $oCodigoAcompanhamento->setDeParaFonteCompleta();
            $e60_codco = $oCodigoAcompanhamento->getCodigoParaEmpenho();
           
            if ($e60_codco != '0000') {
                $this->atualizaCodCO($e60_codco,$dados['e60_numemp'],$dados['e60_anousu']);
            }
            
        }
    }
    
    public function atualizaCodCO($codco,$numemp,$ano){
        
        $sql = " 
            BEGIN;
            UPDATE empempenho SET 
            e60_codco = '$codco'
            WHERE e60_numemp =  $numemp and e60_anousu = $ano;
            COMMIT;
        ";
        
        $this->execute($sql);
    }

}