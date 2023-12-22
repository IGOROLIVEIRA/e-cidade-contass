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

require_once ("libs/db_stdlib.php");
require_once ("libs/db_utils.php");
require_once ("libs/db_app.utils.php");
require_once ("libs/db_conecta.php");
require_once ("libs/db_sessoes.php");
require_once ("libs/JSON.php");
require_once ("libs/exceptions/BusinessException.php");
require_once ("libs/exceptions/DBException.php");
require_once ("libs/exceptions/ParameterException.php");
require_once ("dbforms/db_funcoes.php");
require_once("classes/db_matestoque_classe.php");
require_once("classes/db_matestoqueitem_classe.php");
require_once("classes/db_matestoqueini_classe.php");
require_once("classes/db_matestoqueinimei_classe.php");
require_once("classes/db_db_depart_classe.php");
require_once("classes/db_transmater_classe.php");
require_once("classes/db_empempitem_classe.php");
require_once("classes/db_empparametro_classe.php");
require_once("classes/db_matestoqueitemnotafiscalmanual_classe.php");
require_once("classes/materialestoque.model.php");
require_once("model/configuracao/DBDepartamento.model.php");
require_once("model/configuracao/DBDivisaoDepartamento.model.php");

require_once("model/CgmFactory.model.php");

require_once("classes/db_inventariomaterial_classe.php");
require_once ("std/db_stdClass.php");

require_once("std/DBNumber.php");
require_once("model/contabilidade/contacorrente/ContaCorrenteFactory.model.php");
require_once("model/contabilidade/contacorrente/ContaCorrenteBase.model.php");
require_once("model/financeiro/ContaBancaria.model.php");
require_once("model/contabilidade/planoconta/ContaPlano.model.php");
require_once("model/contabilidade/planoconta/ClassificacaoConta.model.php");
require_once("model/contabilidade/planoconta/ContaCorrente.model.php");
require_once("model/contabilidade/planoconta/ContaOrcamento.model.php");
require_once("model/contabilidade/planoconta/ContaPlanoPCASP.model.php");

db_app::import("exceptions.*");
db_app::import("contabilidade.*");
db_app::import("contabilidade.lancamento.*");
db_app::import("estoque.*");
db_app::import("Acordo");
db_app::import("AcordoComissao");
db_app::import("CgmFactory");
db_app::import("financeiro.*");
db_app::import("contabilidade.*");
db_app::import("contabilidade.lancamento.*");
db_app::import("Dotacao");

db_app::import("contabilidade.contacorrente.*");
$clempparametro     = new cl_empparametro;
$clmatestoque       = new cl_matestoque;
$clmatestoqueitem   = new cl_matestoqueitem;
$clmatestoqueini    = new cl_matestoqueini;
$clmatestoqueinimei = new cl_matestoqueinimei;
$cldb_depart        = new cl_db_depart;
$cltransmater       = new cl_transmater;
$clempempitem       = new cl_empempitem;
$oDaoMatEstoqueItemNotaFiscal = db_utils::getDao("matestoqueitemnotafiscalmanual");

$oInventarioMaterial     = new cl_inventariomaterial();
$oJson                  = new services_json();
$oParam                 = $oJson->decode(str_replace("\\","",$_POST["json"]));
$oRetorno               = new stdClass();
$oRetorno->iStatus      = 1;
$oRetorno->sMessage     = '';

$aDadosRetorno          = array();
try {

    switch ($oParam->exec) {

        case "getMateriaisVinculados" :
            //verifica se ja esta processado
            $sSql = "SELECT * FROM inventariomaterial WHERE i77_inventario = {$oParam->iInventario} AND i77_dataprocessamento IS NOT NULL";
            $oInventarioMaterial->sql_record($sSql);

            if($oInventarioMaterial->numrows > 0){
                throw new BusinessException('Inventario já foi processado.');
            }else{
                $campos_ = "inventariomaterial.*,db_depart.*,matestoque.*,inventario.*,db_config.*,db_depart.*,
                            translate(matmater.m60_descr,'ÁÂÉÊÍÓÔÇ','AAEEIOOC') m60_descr";
                $oResult = $oInventarioMaterial->sql_query(null,$campos_," m60_descr,m70_codmatmater ","i77_inventario = {$oParam->iInventario}");
                $oResult = $oInventarioMaterial->sql_record($oResult);
//                if($oInventarioMaterial->numrows == 0){
//                    throw new BusinessException('Inventario não possui materiais vinculados.');
//                }
                $oRetorno->aDados = db_utils::getCollectionByRecord($oResult);
            }
            break;

        case "getMateriaisVinculadosProcessados":
            //verifica se ja esta processado
            $sSql = "SELECT * FROM inventariomaterial WHERE i77_inventario = {$oParam->iInventario} AND i77_dataprocessamento IS NOT NULL";
            $oInventarioMaterial->sql_record($sSql);

            if($oInventarioMaterial->numrows == 0){
                throw new BusinessException('Inventario não processado.');
            }else{

                $campos_ = "inventariomaterial.*,db_depart.*,matestoque.*,inventario.*,db_config.*,db_depart.*,
                            translate(matmater.m60_descr,'ÁÂÉÊÍÓÔÇ','AAEEIOOC') m60_descr";
                $oResult = $oInventarioMaterial->sql_query(null,$campos_," m60_descr,m70_codmatmater ","i77_inventario = {$oParam->iInventario}");
                $oResult = $oInventarioMaterial->sql_record($oResult);

//                if($oInventarioMaterial->numrows == 0){
//                    throw new BusinessException('Inventario não possui materiais vinculados.');
//                }
                $oRetorno->aDados = db_utils::getCollectionByRecord($oResult);

            }

            break;

        case "excluirMateriais" :

            db_inicio_transacao();
            //pega os inventariosmateriais
            $oResult = $oInventarioMaterial->sql_query(null,'*',null,"m70_codmatmater in ({$oParam->sListaMateriais}) and i77_inventario = {$oParam->iInventario}");
            $oResult = $oInventarioMaterial->sql_record($oResult);
            $oResult = db_utils::getCollectionByRecord($oResult);

            foreach ($oResult as $aResult) {
                $oInventarioMaterial->excluir($aResult->i77_sequencial);
                if($oInventarioMaterial->erro_status == "0"){
                    throw new BusinessException('Erro ao desvincular material.');
                }
            }
            db_fim_transacao(false);
            $oRetorno->sMessage = "Materiais desvinculados";
            break;

        case 'getMateriais':

            $sSql = "SELECT * FROM inventariomaterial WHERE i77_inventario = {$oParam->inventario} AND i77_dataprocessamento IS NOT NULL";
            $oInventarioMaterial->sql_record($sSql);
            if($oInventarioMaterial->numrows > 0){
                throw new BusinessException('Inventario já foi processado.');
            }
            $aWhere   = array();
            $aWhere[] = " coddepto in (select m91_depto from db_almox where db_depart.coddepto = m91_depto) ";

            if(!empty($oParam->filtrosaldo)){
                if($oParam->filtrosaldo == 2){
                    $aWhere[] = " (m70_quant = 0 or m70_quant is null)";
                    if(!empty($oParam->lancadormaterial)){
                        $aWhere[] = " m60_codmater in (".$oParam->lancadormaterial.") ";
                    }else{
                        if (!empty($oParam->material)&&!empty($oParam->material2)){
                            $aWhere[] = " (m60_codmater BETWEEN ".$oParam->material." AND ".$oParam->material2.") ";
                        }
                    }
                }
                if($oParam->filtrosaldo == 1){
                    $aWhere[] = " m70_quant > 0 ";
                }
            }else{
                if (!empty($oParam->material)&&!empty($oParam->material2)){
                    $aWhere[] = " (m60_codmater BETWEEN ".$oParam->material." AND ".$oParam->material2.") ";
                }
            }


            if (!empty($oParam->departamento1)){
                $aWhere[] = "m70_coddepto = {$oParam->departamento1}";
            }

            if (!empty($oParam->departamento2) && !empty($oParam->departamento3)){
                $aWhere[] = " (m70_coddepto BETWEEN ".$oParam->departamento2." AND ".$oParam->departamento3.") ";
            }

            $sWhereMat = implode(" and ",$aWhere);

            $sData = date("Y-m-d", db_getsession("DB_datausu"));
            $sHora = date("H:i:s");
            $sSql = "SELECT DISTINCT ON (m60_descr,m70_codmatmater, m70_codigo) m70_codigo, m70_codigo AS codigo,
m70_codmatmater AS codigo_material,
translate(m60_descr,'ÁÂÉÊÍÓÔÇ','AAEEIOOC') AS descricao,
m70_quant AS estoque,
i77_valormedio AS valormedio,
i77_contagem as contagem,
i77_inventario as inventario,
descrdepto AS departamento,
coddepto,
i77_dataprocessamento AS dataprocessamento,
(SELECT m85_precomedio
  FROM matmaterprecomedio
  WHERE m85_precomedio > 0
  AND to_timestamp(m85_data || ' ' || m85_hora, 'YYYY-MM-DD HH24:MI:SS') < to_timestamp('{$sData}' || ' ' || '{$sHora}', 'YYYY-MM-DD HH24:MI:SS')
  AND m85_matmater = m70_codmatmater
  AND m85_coddepto = coddepto
  ORDER BY to_timestamp(m85_data || ' ' || m85_hora, 'YYYY-MM-DD HH24:MI:SS') DESC LIMIT 1) as valor_original
  FROM matestoque
  JOIN db_depart ON m70_coddepto = coddepto
  inner JOIN matmater ON m70_codmatmater = m60_codmater
  LEFT JOIN inventariomaterial ON i77_estoque = m70_codigo
  WHERE ".$sWhereMat." and  m60_ativo = 't' ORDER BY m60_descr,m70_codmatmater,m70_codigo, (case when i77_inventario = {$oParam->inventario}
  then 1 else 2 end )  ";

            $oResult = $oInventarioMaterial->sql_record($sSql);
            /*if($oInventarioMaterial->numrows > 2000){
             throw new BusinessException('Muitos registros, refine a busca.');
           }*/
            if($oInventarioMaterial->numrows == 0){
                throw new BusinessException('Nenhum registro encontrado.');
            }else{

                $oResult = db_utils::getCollectionByRecord($oResult);
                $oRetorno->aMateriais = $oResult;
            }
            break;

        case "salvarMaterial":

            //verifica se ja existe o material vinculado ao inventario
            //informacoes sobre o estoque

            $sSql = "SELECT * FROM matmater
                     INNER JOIN matestoque ON m70_codmatmater = m60_codmater
                     INNER JOIN matmaterprecomedio on m85_matmater = m60_codmater
                     WHERE m70_codigo = {$oParam->iCodigoEstoque}
                     ORDER BY m85_sequencial DESC LIMIT 1";

            $oEstoque = db_utils::fieldsMemory(db_query($sSql));
            //informacoes sobre o inventario
            $sSql = "SELECT * FROM inventariomaterial WHERE i77_inventario = {$oParam->iCodigoInventario} AND i77_estoque = {$oParam->iCodigoEstoque}";
            $oResult = $oInventarioMaterial->sql_record($sSql);
            //lancamento
            $sSqlLanc = "SELECT m80_codigo FROM matestoqueini INNER JOIN matestoquetipo ON m80_codtipo = m81_codtipo INNER JOIN matestoqueinimei ON m82_matestoqueini = m80_codigo INNER JOIN db_depart ON m80_coddepto = coddepto INNER JOIN matestoqueitem ON m82_matestoqueitem = m71_codlanc INNER JOIN matestoque ON m71_codmatestoque = m70_codigo LEFT JOIN matestoqueitemoc ON m71_codlanc = m73_codmatestoqueitem AND m73_cancelado IS FALSE LEFT JOIN matordemitem ON m52_codlanc = m73_codmatordemitem WHERE m70_codmatmater = {$oParam->iCodigoMaterial} GROUP BY m80_data, m80_codigo, m81_descr, descrdepto, m80_hora, m80_codtipo ORDER BY m80_data DESC, m80_codigo DESC LIMIT 1";
            $oLanc = db_utils::fieldsMemory(db_query($sSqlLanc));
            //seta as alteracoes
            $oInventarioMaterial->i77_ultimolancamento = ($oLanc->m80_codigo == '' || $oLanc->m80_codigo == null)?'null':$oLanc->m80_codigo;
            $oInventarioMaterial->i77_contagem = str_replace(",",".",str_replace(".", "", $oParam->iContagem));
            $oInventarioMaterial->i77_valormedio = $oEstoque->m85_precomedio;
            //caso exista, atualize
            if($oInventarioMaterial->numrows > 0){

                $aInventarioMaterial = db_utils::fieldsMemory($oResult);
                $oInventarioMaterial->i77_sequencial = $aInventarioMaterial->i77_sequencial;
                $oInventarioMaterial->i77_inventario = $aInventarioMaterial->i77_inventario;
                $oInventarioMaterial->i77_db_depart = $aInventarioMaterial->i77_db_depart;
                $oInventarioMaterial->i77_estoque = $aInventarioMaterial->i77_estoque;
                $oInventarioMaterial->i77_vinculoinventario = 't';
                $oInventarioMaterial->alterar($aInventarioMaterial->i77_sequencial);
                if($oInventarioMaterial->erro_status == '0'){

                    throw new BusinessException($oInventarioMaterial->erro_msg);
                }else{

                }

            }else{
                $oInventarioMaterial->i77_inventario = $oParam->iCodigoInventario;
                $oInventarioMaterial->i77_estoque = $oParam->iCodigoEstoque;
                $oInventarioMaterial->i77_db_depart = $oParam->iDepartamento;
                $oInventarioMaterial->i77_estoqueinicial = $oParam->iValorEstoqueInicial;
                $oInventarioMaterial->i77_vinculoinventario = 't';
                $oInventarioMaterial->i77_valorinicial =  $oEstoque->m70_quant * $oEstoque->m85_precomedio;
                $oInventarioMaterial->i77_datainclusao = date('Y-m-d');
                $oInventarioMaterial->incluir();
                if($oInventarioMaterial->erro_status == '0'){
                    throw new BusinessException($oInventarioMaterial->erro_msg);
                }
            }

            $oRetorno->statusInventarioMaterial = $oParam;

            break;



        case "processaInventario":

            db_inicio_transacao();

            $oDaoMatestoque                 = db_utils::getDao("matestoque");
            //verifica se os materiais estao com o estoque real diferente do estoque salvo no ato da manutencao
            $sql = $oInventarioMaterial->sql_query(null,'*',null,"i77_inventario = {$oParam->iInventario} and m70_quant <> i77_estoqueinicial ");

            $orsResult = $oInventarioMaterial->sql_record($sql);

            if(pg_num_rows($orsResult) > 0){
                $oResultado = db_utils::getCollectionByRecord($orsResult);
                $materiais = "";
                foreach ($oResultado as $mat) {
                    $materiais .= $mat->m70_codmatmater.' - '.$mat->m60_descr."\n";
                }
                throw new ParameterException("Usuário, foram realizadas movimentações nos seguintes itens durante o levantamento do inventário do estoque: \n\n$materiais \nDesvincule estes materiais e atualize a sua contagem novamente!");

            }

            $oResult = $oInventarioMaterial->sql_query(null,'*',null,"i77_inventario = {$oParam->iInventario}");
            $oResult = $oInventarioMaterial->sql_record($oResult);
            $oResult = db_utils::getCollectionByRecord($oResult);

            foreach ($oResult as $aResult) {

                if($aResult->i77_contagem > $aResult->i77_estoqueinicial){
                    $valorEstoque = $aResult->i77_valorinicial + ($aResult->i77_valormedio * ($aResult->i77_contagem - $aResult->i77_estoqueinicial));
                }
                if($aResult->i77_contagem < $aResult->i77_estoqueinicial){
                    $valorEstoque = $aResult->i77_valorinicial - ($aResult->i77_valormedio * $aResult->i77_estoqueinicial - $aResult->i77_contagem);
                }else{
                    $valorEstoque = $aResult->i77_valormedio * $aResult->i77_contagem;
                }
                //atualiza o estoque item a item
                $oDaoMatestoque->m70_quant = $aResult->i77_contagem;
                $oDaoMatestoque->m70_valor = $valorEstoque;
                $oDaoMatestoque->m70_codigo = $aResult->i77_estoque;
                $oDaoMatestoque->alterar($oDaoMatestoque->m70_codigo);

                //pega o codigo do material
                $oEstoque = $oDaoMatestoque->sql_query(null,'m70_codmatmater, m70_coddepto',null,"m70_codigo = {$aResult->i77_estoque} and m70_coddepto = {$aResult->i77_db_depart}");
                $oEstoque = $oDaoMatestoque->sql_record($oEstoque);
                $oEstoque = db_utils::fieldsMemory($oEstoque);

                //faz verifica se foi entrada ou saída
                if($aResult->i77_contagem > $aResult->i77_estoqueinicial){
                    //realiza entrada

                    $clmatestoqueini->m80_login          = db_getsession("DB_id_usuario");
                    $clmatestoqueini->m80_data           = date("Y-m-d",db_getsession("DB_datausu"));
                    $clmatestoqueini->m80_hora           = date('H:i:s');
                    $clmatestoqueini->m80_obs            = 'Lançamento decorrente de processamento de inventário';
                    $clmatestoqueini->m80_codtipo        = 23;
                    $clmatestoqueini->m80_coddepto       = $aResult->i77_db_depart;
                    $clmatestoqueini->incluir(@$m80_codigo);
                    if($clmatestoqueini->erro_status==0){
                        throw new ParameterException($clmatestoqueini->erro_msg);
                    }

                    $iCodidoMovimentacaoEstoque = $clmatestoqueini->m80_codigo;
                    $m82_matestoqueini          = $clmatestoqueini->m80_codigo;
                    //
                    $clmatestoqueitem->m71_codmatestoque = $aResult->i77_estoque;
                    $clmatestoqueitem->m71_data          = date("Y-m-d",db_getsession("DB_datausu"));
                    $clmatestoqueitem->m71_valor         = ($aResult->i77_contagem - $aResult->i77_estoqueinicial) * $aResult->i77_valormedio;
                    $clmatestoqueitem->m71_quant         = $aResult->i77_contagem - $aResult->i77_estoqueinicial;
                    $clmatestoqueitem->m71_quantatend    = '0';
                    $clmatestoqueitem->incluir(null);
                    if($clmatestoqueitem->erro_status==0){
                        throw new ParameterException($clmatestoqueitem->erro_msg . "CODIGO MATMATER = " . $oEstoque->m70_codmatmater);
                    }
                    $m80_matestoqueitem = $clmatestoqueitem->m71_codlanc;

                    $clmatestoqueinimei->m82_matestoqueitem = $m80_matestoqueitem;
                    $clmatestoqueinimei->m82_matestoqueini  = $m82_matestoqueini;
                    $clmatestoqueinimei->m82_quant          = $aResult->i77_contagem - $aResult->i77_estoqueinicial;
                    $clmatestoqueinimei->incluir(@$m82_codigo);
                    if($clmatestoqueinimei->erro_status==0){
                        throw new ParameterException($clmatestoqueinimei->erro_msg . "CODIGO MATMATER = " . $oEstoque->m70_codmatmater);
                    }

                    $oDataImplantacao = new DBDate(date("Y-m-d", db_getsession('DB_datausu')));

                    $oInstituicao     = new Instituicao(db_getsession('DB_instit'));

                    /**
                     * Efetua os Lancamentos Contabeis de entrada no estoque
                     * - valida parametro de integracao da contabilidade com material
                     */
                    if ( USE_PCASP && ParametroIntegracaoPatrimonial::possuiIntegracaoMaterial($oDataImplantacao, $oInstituicao) ) {

                        try {

                            $oDadosEntrada                       = new stdClass();
                            $oDadosEntrada->iMovimentoEstoque    = $clmatestoqueinimei->m82_codigo;
                            $oDadosEntrada->sObservacaoHistorico = 'Lançamento decorrente de processamento de inventário';
                            $oDadosEntrada->nValorLancamento     = ($aResult->i77_contagem - $aResult->i77_estoqueinicial) * $aResult->i77_valormedio;

                            $getConta = db_query("SELECT m66_codcon
              FROM materialestoquegrupoconta
              JOIN materialestoquegrupo ON materialestoquegrupo.m65_sequencial = materialestoquegrupoconta.m66_materialestoquegrupo
              JOIN matmatermaterialestoquegrupo ON m68_materialestoquegrupo =m65_sequencial
              JOIN matmater ON m68_matmater = m60_codmater
              WHERE m60_codmater =
              (SELECT m70_codmatmater
              FROM inventariomaterial
              JOIN matestoque ON m70_codigo=i77_estoque
              AND m70_coddepto=i77_db_depart
              WHERE i77_sequencial = $aResult->i77_sequencial)
              AND m66_anousu = ".db_getsession('DB_anousu'));

                            $Conta = db_utils::fieldsMemory($getConta);
                            $oDadosEntrada->iContaPCASP          = $Conta->m66_codcon;
                            $oDadosEntrada->iCodigoMaterial      = $oEstoque->m70_codmatmater;
                            $oAlmoxarifado = new Almoxarifado($aResult->i77_db_depart);
                            $oAlmoxarifado->entradaManual($oDadosEntrada);

                        } catch (BusinessException $eErro) {

                            $sqlerro  = true;
                            $erro_msg = $eErro->getMessage();
                            throw new ParameterException($erro_msg);

                        } catch (ParameterException $eErro) {

                            $sqlerro  = true;
                            $erro_msg = ($eErro->getMessage());
                            /**
                             * Erro Originado por conta corrente:
                             */
                            if ($eErro->getCode() == '1010') {

                                $erro_msg .= "\nDicas: Verifique o cadastro das contas do grupo do material.";
                            }
                            throw new ParameterException($erro_msg);

                        } catch (Exception $eErro) {

                            $sqlerro  = true;
                            $erro_msg = ($eErro->getMessage());
                            throw new ParameterException($erro_msg);
                        }

                    }

                }
                if($aResult->i77_contagem < $aResult->i77_estoqueinicial){
                    //realiza saída
                    //echo $oEstoque->m70_codmatmater;
                    $oMaterialEstoque = new materialEstoque($oEstoque->m70_codmatmater);
                    $oMaterialEstoque->setCodDepto($oEstoque->m70_coddepto);
                    $oMaterialEstoque->setTipoSaida(1);
                    //db_getsession("DB_coddepto")
                    MaterialEstoque::bloqueioMovimentacaoItem($oEstoque->m70_codmatmater, $oEstoque->m70_coddepto);
                    //$oMaterialEstoque->setCriterioRateioCusto(1);
                    $oMaterialEstoque->saidaMaterial(($aResult->i77_estoqueinicial - $aResult->i77_contagem), 'Lançamento decorrente de processamento de inventário',false,24);
                }

                if ($oDaoMatestoque->erro_status == "0"){
                    throw new ParameterException($oDaoMatestoque->erro_msg);

                }
                /*atualiza inventariomaterial setando ultimo codigo de lancamento*/
                //pega o código de lancamento
                $oLanc = $oInventarioMaterial->sql_record("SELECT m80_codigo,
        m82_codigo,

        (SELECT m86_codigo
        FROM matestoqueinil
        WHERE m86_matestoqueini = m80_codigo order by m80_codigo desc limit 1) AS m86_codigo,
        m80_codtipo,
        m70_codigo,
        m71_codlanc
        FROM matestoqueini
        INNER JOIN matestoquetipo ON m80_codtipo = m81_codtipo
        INNER JOIN matestoqueinimei ON m82_matestoqueini = m80_codigo
        INNER JOIN db_depart ON m80_coddepto = coddepto
        INNER JOIN matestoqueitem ON m82_matestoqueitem = m71_codlanc
        INNER JOIN matestoque ON m71_codmatestoque = m70_codigo
        LEFT JOIN matestoqueitemoc ON m71_codlanc = m73_codmatestoqueitem
        AND m73_cancelado IS FALSE
        LEFT JOIN matordemitem ON m52_codlanc = m73_codmatordemitem
        WHERE m70_codigo = {$aResult->i77_estoque}
        GROUP BY m80_data,
        m80_codigo,
        m70_codigo,
        m80_codtipo,
        m82_codigo,
        m86_codigo,
        m71_codlanc,
        m81_descr,
        descrdepto,
        m80_hora,
        m80_codtipo
        ORDER BY m80_data DESC,
        m80_codigo DESC LIMIT 1");

                $oLanc = db_utils::fieldsMemory($oLanc);

                //atualiza a tabela inventariomaterial
                $oInventarioMaterial->i77_dataprocessamento = date('Y-m-d');

                $oInventarioMaterial->i77_ultimolancamento = $oLanc->m80_codigo;
                $oInventarioMaterial->alterar($aResult->i77_sequencial);
                if($oInventarioMaterial->erro_status == '0'){
                    throw new ParameterException($oInventarioMaterial->erro_msg);
                }
            }

            //atualiza o inventario
            $oDaoInventari                 = db_utils::getDao("inventario");
            $oDaoInventari->t75_sequencial = $oParam->iInventario;
            $oDaoInventari->t75_situacao   = 3;
            $oDaoInventari->alterar($oDaoInventari->t75_sequencial);

            if ($oDaoInventari->erro_status == "0"){
                throw new ParameterException($oDaoInventari->erro_msg);
            }

            db_fim_transacao(false);
            $oRetorno->sMessage = "Inventário processado";


            break;

        case "desprocessaInventario":

            db_inicio_transacao();

            $oDaoMatestoque                 = db_utils::getDao("matestoque");
            $oResult = $oInventarioMaterial->sql_query(null,'*',null,"i77_inventario = {$oParam->iInventario}");
            $oResult = $oInventarioMaterial->sql_record($oResult);
            $oResult = db_utils::getCollectionByRecord($oResult);

            foreach ($oResult as $aResult) {
                //pega o código de lancamento
                $oLanc = $oInventarioMaterial->sql_record("SELECT m80_codigo,
    m82_codigo,

    (SELECT m86_codigo
    FROM matestoqueinil
    WHERE m86_matestoqueini = m80_codigo order by m80_codigo desc limit 1) AS m86_codigo,
    m80_codtipo,
    m70_codigo,
    m71_codlanc
    FROM matestoqueini
    INNER JOIN matestoquetipo ON m80_codtipo = m81_codtipo
    INNER JOIN matestoqueinimei ON m82_matestoqueini = m80_codigo
    INNER JOIN db_depart ON m80_coddepto = coddepto
    INNER JOIN matestoqueitem ON m82_matestoqueitem = m71_codlanc
    INNER JOIN matestoque ON m71_codmatestoque = m70_codigo
    LEFT JOIN matestoqueitemoc ON m71_codlanc = m73_codmatestoqueitem
    AND m73_cancelado IS FALSE
    LEFT JOIN matordemitem ON m52_codlanc = m73_codmatordemitem
    WHERE m70_codigo = {$aResult->i77_estoque}
    GROUP BY m80_data,
    m80_codigo,
    m70_codigo,
    m80_codtipo,
    m82_codigo,
    m86_codigo,
    m71_codlanc,
    m81_descr,
    descrdepto,
    m80_hora,
    m80_codtipo
    ORDER BY m80_data DESC,
    m80_codigo DESC LIMIT 1");
                $oLanc = db_utils::fieldsMemory($oLanc);
                if($oLanc->m80_codigo!=$aResult->i77_ultimolancamento){
                    throw new ParameterException('Erro ao desprocessar inventário, houve movimentações de materiais.');
                }
                //atualiza o estoque item a item
                if($aResult->i77_contagem > $aResult->i77_estoqueinicial){
                    $valorEstoque = $aResult->i77_valorinicial + ($aResult->i77_valormedio * ($aResult->i77_contagem - $aResult->i77_estoqueinicial));
                }
                if($aResult->i77_contagem < $aResult->i77_estoqueinicial){
                    $valorEstoque = $aResult->i77_valorinicial - ($aResult->i77_valormedio * $aResult->i77_estoqueinicial - $aResult->i77_contagem);
                }else{
                    $valorEstoque = $aResult->i77_valormedio * $aResult->i77_contagem;
                }
                $oDaoMatestoque->m70_quant = $aResult->i77_contagem;
                $oDaoMatestoque->m70_valor = $valorEstoque;
                $oDaoMatestoque->m70_codigo = $aResult->i77_estoque;
                $oDaoMatestoque->alterar($oDaoMatestoque->m70_codigo);

                // \d matestoque
                //pega o codigo do material
                $oEstoque = $oDaoMatestoque->sql_query(null,'m70_codmatmater, m70_coddepto',null,"m70_codigo = {$aResult->i77_estoque} and m70_coddepto = {$aResult->i77_db_depart}");
                $oEstoque = $oDaoMatestoque->sql_record($oEstoque);
                $oEstoque = db_utils::fieldsMemory($oEstoque);
                //
                //faz verifica se foi entrada ou saída
                if($aResult->i77_contagem < $aResult->i77_estoqueinicial){
                    //realiza entrada


                    $clmatestoqueini->m80_login          = db_getsession("DB_id_usuario");
                    $clmatestoqueini->m80_data           = date("Y-m-d",db_getsession("DB_datausu"));
                    $clmatestoqueini->m80_hora           = date('H:i:s');
                    $clmatestoqueini->m80_obs            = 'Lançamento decorrente de processamento de inventário';
                    $clmatestoqueini->m80_codtipo        = 23;
                    $clmatestoqueini->m80_coddepto       = $aResult->i77_db_depart;
                    $clmatestoqueini->incluir(@$m80_codigo);
                    if($clmatestoqueini->erro_status==0){
                        throw new ParameterException($clmatestoqueini->erro_msg);
                    }

                    $iCodidoMovimentacaoEstoque = $clmatestoqueini->m80_codigo;
                    $m82_matestoqueini          = $clmatestoqueini->m80_codigo;
                    //
                    $clmatestoqueitem->m71_codmatestoque = $aResult->i77_estoque;
                    $clmatestoqueitem->m71_data          = date("Y-m-d",db_getsession("DB_datausu"));
                    $clmatestoqueitem->m71_valor         = ( $aResult->i77_estoqueinicial - $aResult->i77_contagem) * $aResult->i77_valormedio;
                    $clmatestoqueitem->m71_quant         =  $aResult->i77_estoqueinicial - $aResult->i77_contagem;
                    $clmatestoqueitem->m71_quantatend    = '0';
                    $clmatestoqueitem->incluir(null);
                    if($clmatestoqueitem->erro_status==0){
                        throw new ParameterException($clmatestoqueitem->erro_msg);
                    }
                    $m80_matestoqueitem = $clmatestoqueitem->m71_codlanc;
                    //
                    $clmatestoqueinimei->m82_matestoqueitem = $m80_matestoqueitem;
                    $clmatestoqueinimei->m82_matestoqueini  = $m82_matestoqueini;
                    $clmatestoqueinimei->m82_quant          = $aResult->i77_estoqueinicial-$aResult->i77_contagem;
                    $clmatestoqueinimei->incluir(@$m82_codigo);
                    if($clmatestoqueinimei->erro_status==0){
                        throw new ParameterException($clmatestoqueinimei->erro_msg);
                    }
                    //


                    $oDataImplantacao = new DBDate(date("Y-m-d", db_getsession('DB_datausu')));
                    $oInstituicao     = new Instituicao(db_getsession('DB_instit'));

                    /**
                     * Efetua os Lancamentos Contabeis de entrada no estoque
                     * - valida parametro de integracao da contabilidade com material
                     */
                    if ( USE_PCASP && ParametroIntegracaoPatrimonial::possuiIntegracaoMaterial($oDataImplantacao, $oInstituicao) ) {

                        try {

                            $oDadosEntrada                       = new stdClass();
                            $oDadosEntrada->iMovimentoEstoque    = $clmatestoqueinimei->m82_codigo;
                            $oDadosEntrada->sObservacaoHistorico = 'Lançamento decorrente de processamento de inventário';
                            $oDadosEntrada->nValorLancamento     = ($aResult->i77_estoqueinicial-$aResult->i77_contagem) * $aResult->i77_valormedio;
                            $getConta = db_query("
              SELECT m66_codcon
              FROM materialestoquegrupoconta
              JOIN materialestoquegrupo ON materialestoquegrupo.m65_sequencial = materialestoquegrupoconta.m66_materialestoquegrupo
              JOIN matmatermaterialestoquegrupo ON m68_materialestoquegrupo =m65_sequencial
              JOIN matmater ON m68_matmater = m60_codmater
              WHERE m60_codmater = (select m70_codmatmater from inventariomaterial join matestoque on m70_codigo=i77_estoque and
              m70_coddepto=i77_db_depart where i77_sequencial = $aResult->i77_sequencial)
              AND m66_anousu = ".db_getsession('DB_anousu'));

                            $Conta = db_utils::fieldsMemory($getConta);


                            $oDadosEntrada->iContaPCASP          = $Conta->m66_codcon;
                            $oDadosEntrada->iCodigoMaterial      = $oEstoque->m70_codmatmater;

                            $oAlmoxarifado = new Almoxarifado($aResult->i77_db_depart);


                            $oAlmoxarifado->entradaManual($oDadosEntrada);



                        } catch (BusinessException $eErro) {

                            $sqlerro  = true;
                            $erro_msg = $eErro->getMessage();

                        } catch (ParameterException $eErro) {

                            $sqlerro  = true;
                            $erro_msg = ($eErro->getMessage());
                            /**
                             * Erro Originado por conta corrente:
                             */
                            if ($eErro->getCode() == '1010') {

                                $erro_msg .= "\nDicas: Verifique o cadastro das contas do grupo do material.";
                            }

                        } catch (Exception $eErro) {

                            $sqlerro  = true;
                            $erro_msg = ($eErro->getMessage());
                        }

                    }

                }
                if($aResult->i77_contagem > $aResult->i77_estoqueinicial){
                    //realiza saída
                    //echo $oEstoque->m70_codmatmater;
                    $oMaterialEstoque = new materialEstoque($oEstoque->m70_codmatmater);
                    $oMaterialEstoque->setCodDepto($oEstoque->m70_coddepto);
                    $oMaterialEstoque->setTipoSaida(1);
                    //db_getsession("DB_coddepto")
                    MaterialEstoque::bloqueioMovimentacaoItem($oEstoque->m70_codmatmater, $oEstoque->m70_coddepto);
                    //$oMaterialEstoque->setCriterioRateioCusto(1);
                    $oMaterialEstoque->saidaMaterial(($aResult->i77_contagem - $aResult->i77_estoqueinicial), 'Lançamento decorrente de processamento de inventário',false,24);
                }

                if ($oDaoMatestoque->erro_status == "0"){
                    throw new ParameterException($oDaoMatestoque->erro_msg);

                }
                /*atualiza inventariomaterial setando ultimo codigo de lancamento*/

                //atualiza a tabela inventariomaterial
                $oInventarioMaterial->i77_dataprocessamento = null;
                $oInventarioMaterial->i77_ultimolancamento = $oLanc->m80_codigo;
                $oInventarioMaterial->alterar($aResult->i77_sequencial);

            }
            if($oInventarioMaterial->erro_status==0){

                throw new ParameterException($oInventarioMaterial->erro_msg);
            }
            $oDaoInventario                 = db_utils::getDao("inventario");
            $oDaoInventario->t75_sequencial = $oParam->iInventario;
            $oDaoInventario->t75_situacao   = 1;

            $oDaoInventario->alterar($oDaoInventario->t75_sequencial);
            if ($oDaoInventario->erro_status == "0"){
                throw new ParameterException("Erro ao desprocessar inventário.");
            }
            db_fim_transacao(false);
            $oRetorno->sMessage = "Inventário desprocessado";

            break;

        default:
            throw new ParameterException("Opcao inválida");
            break;


    }
    $oRetorno->sMessage = urlencode($oRetorno->sMessage);

} catch (Exception $eErro){

    $oRetorno->iStatus  = 2;

    $oRetorno->sMessage = urlencode($eErro->getMessage());
    db_fim_transacao(true);
} catch (BusinessException $eBusinessErro){

    $oRetorno->iStatus  = 2;
    $oRetorno->sMessage = urlencode($eBusinessErro->getMessage());
    db_fim_transacao(true);
}
echo $oJson->encode($oRetorno);
