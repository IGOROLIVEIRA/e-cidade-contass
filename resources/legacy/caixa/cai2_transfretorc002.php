<?php
/*
 *     E-cidade Software Publico para Gestao Municipal
 *  Copyright (C) 2014  DBSeller Servicos de Informatica
 *                            www.dbseller.com.br
 *                         e-cidade@dbseller.com.br
 *
 *  Este programa e software livre; voce pode redistribui-lo e/ou
 *  modifica-lo sob os termos da Licenca Publica Geral GNU, conforme
 *  publicada pela Free Software Foundation; tanto a versao 2 da
 *  Licenca como (a seu criterio) qualquer versao mais nova.
 *
 *  Este programa e distribuido na expectativa de ser util, mas SEM
 *  QUALQUER GARANTIA; sem mesmo a garantia implicita de
 *  COMERCIALIZACAO ou de ADEQUACAO A QUALQUER PROPOSITO EM
 *  PARTICULAR. Consulte a Licenca Publica Geral GNU para obter mais
 *  detalhes.
 *
 *  Voce deve ter recebido uma copia da Licenca Publica Geral GNU
 *  junto com este programa; se nao, escreva para a Free Software
 *  Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA
 *  02111-1307, USA.
 *
 *  Copia da licenca no diretorio licenca/licenca_en.txt
 *                                licenca/licenca_pt.txt
 */
require_once("fpdf151/pdf.php");
require_once("libs/db_utils.php");
require_once("libs/JSON.php");
require_once("classes/db_retencaoreceitas_classe.php");

$oJson       = new Services_JSON();
$oParametros = $oJson->decode(str_replace("\\","",$_GET["sFiltros"]));
$sWhere = "e60_instit = ".db_getsession("DB_instit");
$sHeaderTipo = "Pagamento";
$sWhere .= " and corrente.k12_estorn is false ";

if ($oParametros->datainicial != "" && $oParametros->datafinal == "") {
   $dataInicial  = implode("-", array_reverse(explode("/", $oParametros->datainicial)));
   $sWhere      .= " and corrente.k12_data = '{$dataInicial}'";
   $sHeaderData  = "{$oParametros->datainicial} a {$oParametros->datainicial}";

} else if ($oParametros->datainicial != "" && $oParametros->datafinal != "") {
  $dataInicial = implode("-", array_reverse(explode("/", $oParametros->datainicial)));
  $dataFinal   = implode("-", array_reverse(explode("/", $oParametros->datafinal)));
  $sWhere     .= "and corrente.k12_data between '{$dataInicial}' and '{$dataFinal}'";
  $sHeaderData  = "{$oParametros->datainicial} a {$oParametros->datafinal}";
}
if ($oParametros->sContas != "") {
   $sWhere .= " and corrente.k12_conta in({$oParametros->sContas})";
}
$sWhere .= " and e23_recolhido is true ";

$sWhere .= " and o57_fonte LIKE '411%' ";

$sHeaderOps  = "Todas";

  $sSqlRetencoes  = " select distinct c61_reduz,     ";
  $sSqlRetencoes .= " 
                      CASE
                        WHEN o15_codigo = 100 THEN 15000000
                        WHEN o15_codigo = 101 THEN 15000001
                        WHEN o15_codigo = 102 THEN 15000002
                        WHEN o15_codigo = 103 THEN 18000000
                        WHEN o15_codigo = 104 THEN 18010000
                        WHEN o15_codigo = 105 THEN 18020000
                        WHEN o15_codigo = 106 THEN 15760010
                        WHEN o15_codigo = 107 THEN 15440000
                        WHEN o15_codigo = 108 THEN 17080000
                        WHEN o15_codigo = 112 THEN 16590020
                        WHEN o15_codigo = 113 THEN 15990030
                        WHEN o15_codigo = 116 THEN 17500000
                        WHEN o15_codigo = 117 THEN 17510000
                        WHEN o15_codigo = 118 THEN 15400007
                        WHEN o15_codigo = 119 THEN 15400000
                        WHEN o15_codigo = 120 THEN 15760000
                        WHEN o15_codigo = 121 THEN 16220000
                        WHEN o15_codigo = 122 THEN 15700000
                        WHEN o15_codigo = 123 THEN 16310000
                        WHEN o15_codigo = 124 THEN 17000000
                        WHEN o15_codigo = 129 THEN 16600000
                        WHEN o15_codigo = 130 THEN 18990040
                        WHEN o15_codigo = 131 THEN 17590050
                        WHEN o15_codigo = 132 THEN 16040000
                        WHEN o15_codigo = 133 THEN 17150000
                        WHEN o15_codigo = 134 THEN 17160000
                        WHEN o15_codigo = 135 THEN 17170000
                        WHEN o15_codigo = 136 THEN 17180000
                        WHEN o15_codigo = 142 THEN 16650000
                        WHEN o15_codigo = 143 THEN 15510000
                        WHEN o15_codigo = 144 THEN 15520000
                        WHEN o15_codigo = 145 THEN 15530000
                        WHEN o15_codigo = 146 THEN 15690000
                        WHEN o15_codigo = 147 THEN 15500000
                        WHEN o15_codigo = 153 THEN 16010000
                        WHEN o15_codigo = 154 THEN 16590000
                        WHEN o15_codigo = 155 THEN 16210000
                        WHEN o15_codigo = 156 THEN 16610000
                        WHEN o15_codigo = 157 THEN 17520000
                        WHEN o15_codigo = 158 THEN 18990060
                        WHEN o15_codigo = 159 THEN 16000000
                        WHEN o15_codigo = 160 THEN 17040000
                        WHEN o15_codigo = 161 THEN 17070000
                        WHEN o15_codigo = 162 THEN 17490120
                        WHEN o15_codigo = 163 THEN 17130070
                        WHEN o15_codigo = 164 THEN 17060000
                        WHEN o15_codigo = 165 THEN 17490000
                        WHEN o15_codigo = 166 THEN 15420007
                        WHEN o15_codigo = 167 THEN 15420000
                        WHEN o15_codigo = 168 THEN 17100100
                        WHEN o15_codigo = 169 THEN 17100000
                        WHEN o15_codigo = 170 THEN 15010000
                        WHEN o15_codigo = 171 THEN 15710000
                        WHEN o15_codigo = 172 THEN 15720000
                        WHEN o15_codigo = 173 THEN 15750000
                        WHEN o15_codigo = 174 THEN 15740000
                        WHEN o15_codigo = 175 THEN 15730000
                        WHEN o15_codigo = 176 THEN 16320000
                        WHEN o15_codigo = 177 THEN 16330000
                        WHEN o15_codigo = 178 THEN 16360000
                        WHEN o15_codigo = 179 THEN 16340000
                        WHEN o15_codigo = 180 THEN 16350000
                        WHEN o15_codigo = 181 THEN 17010000
                        WHEN o15_codigo = 182 THEN 17020000
                        WHEN o15_codigo = 183 THEN 17030000
                        WHEN o15_codigo = 184 THEN 17090000
                        WHEN o15_codigo = 185 THEN 17530000
                        WHEN o15_codigo = 186 THEN 17040000
                        WHEN o15_codigo = 187 THEN 17050000
                        WHEN o15_codigo = 188 THEN 15000000
                        WHEN o15_codigo = 189 THEN 15000000
                        WHEN o15_codigo = 190 THEN 17540000
                        WHEN o15_codigo = 191 THEN 17540000
                        WHEN o15_codigo = 192 THEN 17550000
                        WHEN o15_codigo = 193 THEN 18990000
                        WHEN o15_codigo = 200 THEN 25000000
                        WHEN o15_codigo = 201 THEN 25000001
                        WHEN o15_codigo = 202 THEN 25000002
                        WHEN o15_codigo = 203 THEN 28000000
                        WHEN o15_codigo = 204 THEN 28010000
                        WHEN o15_codigo = 205 THEN 28020000
                        WHEN o15_codigo = 206 THEN 25760010
                        WHEN o15_codigo = 207 THEN 25440000
                        WHEN o15_codigo = 208 THEN 27080000
                        WHEN o15_codigo = 212 THEN 26590020
                        WHEN o15_codigo = 213 THEN 25990030
                        WHEN o15_codigo = 216 THEN 27500000
                        WHEN o15_codigo = 217 THEN 27510000
                        WHEN o15_codigo = 218 THEN 25400007
                        WHEN o15_codigo = 219 THEN 25400000
                        WHEN o15_codigo = 220 THEN 25760000
                        WHEN o15_codigo = 221 THEN 26220000
                        WHEN o15_codigo = 222 THEN 25700000
                        WHEN o15_codigo = 223 THEN 26310000
                        WHEN o15_codigo = 224 THEN 27000000
                        WHEN o15_codigo = 229 THEN 26600000
                        WHEN o15_codigo = 230 THEN 28990040
                        WHEN o15_codigo = 231 THEN 27590050
                        WHEN o15_codigo = 232 THEN 26040000
                        WHEN o15_codigo = 233 THEN 27150000
                        WHEN o15_codigo = 234 THEN 27160000
                        WHEN o15_codigo = 235 THEN 27170000
                        WHEN o15_codigo = 236 THEN 27180000
                        WHEN o15_codigo = 242 THEN 26650000
                        WHEN o15_codigo = 243 THEN 25510000
                        WHEN o15_codigo = 244 THEN 25520000
                        WHEN o15_codigo = 245 THEN 25530000
                        WHEN o15_codigo = 246 THEN 25690000
                        WHEN o15_codigo = 247 THEN 25500000
                        WHEN o15_codigo = 253 THEN 26010000
                        WHEN o15_codigo = 254 THEN 26590000
                        WHEN o15_codigo = 255 THEN 26210000
                        WHEN o15_codigo = 256 THEN 26610000
                        WHEN o15_codigo = 257 THEN 27520000
                        WHEN o15_codigo = 258 THEN 28990060
                        WHEN o15_codigo = 259 THEN 26000000
                        WHEN o15_codigo = 260 THEN 27040000
                        WHEN o15_codigo = 261 THEN 27070000
                        WHEN o15_codigo = 262 THEN 27490120
                        WHEN o15_codigo = 263 THEN 27130070
                        WHEN o15_codigo = 264 THEN 27060000
                        WHEN o15_codigo = 265 THEN 27490000
                        WHEN o15_codigo = 266 THEN 25420007
                        WHEN o15_codigo = 267 THEN 25420000
                        WHEN o15_codigo = 268 THEN 27100100
                        WHEN o15_codigo = 269 THEN 27100000
                        WHEN o15_codigo = 270 THEN 25010000
                        WHEN o15_codigo = 271 THEN 25710000
                        WHEN o15_codigo = 272 THEN 25720000
                        WHEN o15_codigo = 273 THEN 25750000
                        WHEN o15_codigo = 274 THEN 25740000
                        WHEN o15_codigo = 275 THEN 25730000
                        WHEN o15_codigo = 276 THEN 26320000
                        WHEN o15_codigo = 277 THEN 26330000
                        WHEN o15_codigo = 278 THEN 26360000
                        WHEN o15_codigo = 279 THEN 26340000
                        WHEN o15_codigo = 280 THEN 26350000
                        WHEN o15_codigo = 281 THEN 27010000
                        WHEN o15_codigo = 282 THEN 27020000
                        WHEN o15_codigo = 283 THEN 27030000
                        WHEN o15_codigo = 284 THEN 27090000
                        WHEN o15_codigo = 285 THEN 27530000
                        WHEN o15_codigo = 286 THEN 27040000
                        WHEN o15_codigo = 287 THEN 27050000
                        WHEN o15_codigo = 288 THEN 25000000
                        WHEN o15_codigo = 289 THEN 25000000
                        WHEN o15_codigo = 290 THEN 27540000
                        WHEN o15_codigo = 291 THEN 27540000
                        WHEN o15_codigo = 292 THEN 27550000
                        WHEN o15_codigo = 293 THEN 28990000
                        ELSE o15_codigo
                      END as codigo ," ;
  $sSqlRetencoes .= "   TO_ASCII(o15_descr) as descricao,   ";
  $sSqlRetencoes .= "conplano.c60_descr as c60_descr,";
  $sSqlRetencoes .= " sum(e23_valorretencao) as e23_valorretencao";

if ($oParametros->iTipo == 's'){
  $sGrupby = " group by  c61_reduz, codigo, descricao, c60_descr ";
}
if ($oParametros->iTipo == 'a'){
  $sGrupby = " group by  c61_reduz, codigo,descricao, c60_descr,e21_descricao, e21_sequencial ";
  $sSqlRetencoes .= ", e21_descricao, e21_sequencial ";
}
$sSqlRetencoes .= "  from retencaoreceitas retencao";
$sSqlRetencoes .= "       inner join retencaopagordem on e20_sequencial = e23_retencaopagordem ";
$sSqlRetencoes .= "       inner join pagordem         on e50_codord     = e20_pagordem         ";

$sSqlRetencoes .= "       left join pagordemconta on e49_codord = e20_pagordem         ";
$sSqlRetencoes .= "       inner join pagordemele  on e50_codord = e53_codord           ";
$sSqlRetencoes .= "       inner join empempenho   on e60_numemp = e50_numemp           ";
$sSqlRetencoes .= "       inner join orcdotacao   on e60_coddot = o58_coddot           ";  
$sSqlRetencoes .= "                               and e60_anousu = o58_anousu          ";
$sSqlRetencoes .= "       inner join cgm          on e60_numcgm = cgm.z01_numcgm       ";
$sSqlRetencoes .= "       left join cgm cgmordem  on e49_numcgm = cgmordem.z01_numcgm  ";
$sSqlRetencoes .= "       inner join pagordemnota on e71_codord = e50_codord           ";
$sSqlRetencoes .= "                               and e71_anulado is false             ";
$sSqlRetencoes .= "       inner join empnota      on e71_codnota = e69_codnota         ";
$sSqlRetencoes .= " inner join retencaotiporec on e21_sequencial = e23_retencaotiporec ";
$sSqlRetencoes .= "       inner join tabrec       on e21_receita = k02_codigo          ";
$sSqlRetencoes .= "      inner join taborc on    tabrec.k02_codigo = taborc.k02_codigo ";
$sSqlRetencoes .= "       and taborc.k02_anousu = o58_anousu                                   ";
$sSqlRetencoes .= "       inner join orcreceita ON (k02_anousu, k02_codrec) = (o70_anousu, o70_codrec)                  ";
$sSqlRetencoes .= " inner join orcfontes ON (o70_codfon, o70_anousu) = (o57_codfon, o57_anousu)";
$sSqlRetencoes .= " inner join orctiporec ON o15_codigo = o70_codigo                           ";
$sSqlRetencoes .= "       left join retencaocorgrupocorrente on e47_retencaoreceita = e23_sequencial       ";
$sSqlRetencoes .= "       left join corgrupocorrente         on k105_sequencial     = e47_corgrupocorrente ";
$sSqlRetencoes .= "       left join corrente                 on k105_id             = corrente.k12_id      ";
$sSqlRetencoes .= "                                          and k105_autent         = corrente.k12_autent  ";
$sSqlRetencoes .= "                                          and k105_data           = corrente.k12_data    ";
$sSqlRetencoes .= "       left join conplanoreduz            on corrente.k12_conta  = c61_reduz            ";
$sSqlRetencoes .= "                                          and c61_anousu          = ".db_getsession("DB_anousu");
$sSqlRetencoes .= "       left join conplano                 on c60_codcon          = c61_codcon           ";
$sSqlRetencoes .= "                                          and c60_anousu          = c61_anousu           ";
$sSqlRetencoes .= " where e23_ativo is true ";
$sSqlRetencoes .= "   and {$sWhere} ";
$sSqlRetencoes .= "   {$sGrupby} ";

$sValorCompararQuebra = "";
$sValorCompararFonte  = "";
$sCampoQuebrar        = "";
$sNomeQuebra          = "";
$sCampoQuebrar        = "c61_reduz";
$sNomeQuebra          = "c60_descr";
$rsRetencoes          = db_query($sSqlRetencoes);
$iTotalRetencoes      = pg_num_rows($rsRetencoes);

if ($iTotalRetencoes  == 0 || !$rsRetencoes) {
  db_redireciona("db_erros.php?fechar=true&db_erro=Nenhum foram encontradas retenções.");
}

$aRetencoes          = array();
$iTotalRetencoes     = pg_num_rows($rsRetencoes);

for ($i = 0; $i < $iTotalRetencoes; $i++) {

   $oRetencao = db_utils::fieldsMemory($rsRetencoes, $i);
   
   if ($sValorCompararQuebra == $oRetencao->$sCampoQuebrar) {
       $aRetencoes[$oRetencao->$sCampoQuebrar]->total    += $oRetencao->e23_valorretencao;
       $aRetencoes[$oRetencao->$sCampoQuebrar]->itens[]   = $oRetencao;
   } else {
       $aRetencoes[$oRetencao->$sCampoQuebrar]->texto    = $oRetencao->$sCampoQuebrar." - ".$oRetencao->$sNomeQuebra;
       $aRetencoes[$oRetencao->$sCampoQuebrar]->total    = $oRetencao->e23_valorretencao;
       $aRetencoes[$oRetencao->$sCampoQuebrar]->itens[]  = $oRetencao;
   }
     $sValorCompararQuebra = $oRetencao->$sCampoQuebrar;
}

$oPdf  = new PDF("L","mm","A4");
$oPdf->Open();
$oPdf->SetAutoPageBreak(false);
$oPdf->AliasNbPages();
$oPdf->SetFillColor(240);

$head2           = "Transferências de Retenções Orçamentárias";
$head4           = "Período  : {$sHeaderData}";
$sFonte          = "Arial";
$lEscreverHeader = true;
$lAddPage        = false;
$nTamanhoTotalCelulas = 255;
$nTotalGeralRetido = 0;
$nTotalGeralTransf = 0;
$nSaldoGeralaTransf = 0;
$nValorTotalTransferido = 0;
$nSaldoTotalTransfer = 0;
$nImprimirFonte = 0;
$nImprimirCabecalho = 0;
$nDadosCabecalho  = 0;

$oPdf->AddPage();

$iTamCell  = 0;
$iTamFonte = 5;
$iTamCell  = (39/5);
$iTamFonte = 6;
foreach ($aRetencoes as $oQuebra) {

  $oPdf->SetFont($sFonte, "b",$iTamFonte+2);
  $lEscreverHeader     = true;
  $sValorCompararFonte = '';
  $aRetencoes[$oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->codigo]->totalfonte = 0;
  foreach ($oQuebra->itens as $oRetencaoAtiva) {
      if ($sValorCompararFonte == $oRetencaoAtiva->codigo){
        $aRetencoes[$oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->codigo]->totalfonte  += $oRetencaoAtiva->e23_valorretencao;
      } else {
        $aRetencoes[$oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->codigo]->totalfonte = $oRetencaoAtiva->e23_valorretencao;
      }
      $sValorCompararFonte = $oRetencaoAtiva->codigo;
  }
  foreach ($oQuebra->itens as $oRetencaoAtiva) {
  
    $sSqlSlip   = " select round(sum(k17_valor),2) as k17_valor 
                          from slip 
                          inner join sliprecurso on k29_slip = k17_codigo
                          where k17_credito = $oRetencaoAtiva->c61_reduz and 
                        
                          k17_tiposelect in ('04','4') and
                          k17_data between '{$dataInicial}' and '{$dataFinal}' and 
                          (k17_dtanu > '{$dataFinal}' or k17_dtanu is null)  
                          
                          ";
                          // and k29_recurso = $oRetencaoAtiva->codigo
    $rsSlip     = db_query($sSqlSlip);
    $iTotalSlip = pg_num_rows($rsSlip); 
    if ($iTotalSlip > 0) {
      $oSlip = db_utils::fieldsMemory($rsSlip, 0);             
    }  
   
    if ($oPdf->Gety() > $oPdf->h - 27 || $lEscreverHeader) {

      if ($oPdf->Gety() > $oPdf->h - 27) {
        $oPdf->AddPage();
        if ($nDadosCabecalho == $oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->codigo) {
            $nImprimirCabecalho = 1;
        }
      }

      if ($oQuebra->texto != "") {
          
        $oPdf->SetFont('Times', "",$iTamFonte+4);
        $oPdf->cell(0,5, 'CONTA : '.$oQuebra->texto,0,1);
        $nValorTotalTransferido = 0;
        $nSaldoTotalTransfer = 0;
      }

      $oPdf->SetFont($sFonte, "b",$iTamFonte+1);
      $oPdf->cell(143+$iTamCell,5,"FONTE DE RECURSOS",1,0,"C",1);
      $oPdf->cell(35+$iTamCell,5,"VALOR RETIDO",1,0,"C",1);
      $oPdf->cell(35+$iTamCell,5,"VALOR TRANSFERIDO",1,0,"C",1);
      $oPdf->cell(35+$iTamCell,5,"SALDO A TRANSFERIR",1,1,"C",1);
      
      $lEscreverHeader = false;
      $nImprimirFonte = 0;
    }
  
    if ($oParametros->iTipo == 'a'){
      if ($nImprimirCabecalho == 0 && ( $nImprimirFonte != $oRetencaoAtiva->codigo || $nImprimirFonte == 0 )){
        $oPdf->SetFont($sFonte, "b",$iTamFonte+1);
        $oPdf->cell(143+$iTamCell,5,$oRetencaoAtiva->codigo ." - ". $oRetencaoAtiva->descricao,1,0,"L");
        $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($aRetencoes[$oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->codigo]->totalfonte,"f"),1,0,"C");
        $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($oSlip->k17_valor - $nValorTotalTransferido,"f"),1,0,"C");
        $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($aRetencoes[$oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->codigo]->totalfonte - $oSlip->k17_valor + $nValorTotalTransferido,"f"),1,1,"C");
        $nTotalGeralTransf  += $oSlip->k17_valor - $nValorTotalTransferido;
        $nValorTotalTransferido += $oSlip->k17_valor - $nValorTotalTransferido;
        $nSaldoTotalTransfer = $oQuebra->total - $nValorTotalTransferido;
      }
      $oPdf->SetFont($sFonte, "",$iTamFonte);
      $oPdf->cell(143+$iTamCell,5,$oRetencaoAtiva->e21_sequencial ." - ". $oRetencaoAtiva->e21_descricao,1,0,"L"); 
      $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($oRetencaoAtiva->e23_valorretencao,"f"),1,0,"C");
      $oPdf->cell(35+$iTamCell,5," - ",1,0,"C");
      $oPdf->cell(35+$iTamCell,5," - ",1,1,"C");
      $nTotalGeralRetido  += $oRetencaoAtiva->e23_valorretencao;
      $nSaldoGeralaTransf = $nValorTotalTransferido + $nTotalGeralRetido - $nTotalGeralTransf;
      $nDadosCabecalho = $oRetencaoAtiva->c61_reduz.$oRetencaoAtiva->codigo;
      $nImprimirCabecalho = 0;
    } 
    if ($oParametros->iTipo == 's'){
      $nSaldoTotalTransfer += $nValorTotalTransferido + $oRetencaoAtiva->e23_valorretencao - $oSlip->k17_valor;
      $oPdf->SetFont($sFonte, "",$iTamFonte);
      $oPdf->cell(143+$iTamCell,5,$oRetencaoAtiva->codigo ." - ". $oRetencaoAtiva->descricao,1,0,"L");
      $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($oRetencaoAtiva->e23_valorretencao,"f"),1,0,"C");
      $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($oSlip->k17_valor - $nValorTotalTransferido,"f"),1,0,"C");
      $oPdf->cell(35+$iTamCell,5,"R$ ".db_formatar($oRetencaoAtiva->e23_valorretencao - $oSlip->k17_valor + $nValorTotalTransferido,"f"),1,1,"C");      
      $nTotalGeralRetido += $oRetencaoAtiva->e23_valorretencao;
      $nTotalGeralTransf +=  $oSlip->k17_valor - $nValorTotalTransferido;
      $nSaldoGeralaTransf = $nTotalGeralRetido - $nTotalGeralTransf;
      $nValorTotalTransferido += $oSlip->k17_valor - $nValorTotalTransferido;
    }   
    $nImprimirFonte = $oRetencaoAtiva->codigo;
  }
  $oPdf->SetFont($sFonte, "b",$iTamFonte);
  $oPdf->cell(143+$iTamCell, 5, 'Total:', 1, 0, "R");
  $oPdf->cell(35+$iTamCell, 5,"R$ ". db_formatar($oQuebra->total, "f"), 1, 0, "C");
  $oPdf->cell(35+$iTamCell, 5,"R$ ". db_formatar($nValorTotalTransferido, "f"), 1, 0, "C");
  $oPdf->cell(35+$iTamCell, 5,"R$ ". db_formatar($nSaldoTotalTransfer, "f"), 1, 1, "C");
}
$oPdf->SetFont($sFonte, "b",$iTamFonte);
$oPdf->cell(143+$iTamCell,5,"Total Geral:",1,0,"R");
$oPdf->cell(35+$iTamCell, 5,"R$ ".db_formatar($nTotalGeralRetido,"f"),1,0,"C");
$oPdf->cell(35+$iTamCell, 5,"R$ ".db_formatar($nTotalGeralTransf,"f"),1,0,"C");
$oPdf->cell(35+$iTamCell, 5,"R$ ".db_formatar($nSaldoGeralaTransf,"f"),1,1,"C");
$oPdf->Output();

