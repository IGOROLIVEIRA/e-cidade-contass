<?
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

require_once("dbforms/db_funcoes.php");
require_once("libs/db_stdlib.php");
require_once("libs/db_conecta.php");
require_once("libs/db_sessoes.php");
require_once("libs/db_usuariosonline.php");
require_once("libs/db_liborcamento.php");
require_once("libs/db_libcontabilidade.php");
require_once("libs/db_sql.php");
require_once("classes/db_cgm_classe.php");
require_once("classes/db_slip_classe.php");
require_once("classes/db_infocomplementaresinstit_classe.php");
require_once("classes/db_empresto_classe.php");
require_once("classes/db_empempenho_classe.php");
require_once("model/contabilidade/relatorios/ensino/RelatorioReceitaeDespesaEnsino.model.php");
$clrotulo = new rotulocampo;

db_postmemory($HTTP_POST_VARS);

$dtini = implode("-", array_reverse(explode("/", $DBtxt21)));
$dtfim = implode("-", array_reverse(explode("/", $DBtxt22)));

$clinfocomplementaresinstit = new cl_infocomplementaresinstit();
$clSlip = new cl_slip();
$instits = str_replace('-', ', ', $db_selinstit);
$aInstits = explode(",", $instits);
if (count($aInstits) > 1) {
    $oInstit = new Instituicao();
    $oInstit = $oInstit->getDadosPrefeitura();
} else {
    foreach ($aInstits as $iInstit) {
        $oInstit = new Instituicao($iInstit);
    }
}
db_inicio_transacao();

/**
 * pego todas as instituições;
 */
$rsInstits = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_instit,si09_tipoinstit", null, null));

$ainstitunticoes = array();
for ($i = 0; $i < pg_num_rows($rsInstits); $i++) {
    $odadosInstint = db_utils::fieldsMemory($rsInstits, $i);
    $ainstitunticoes[] = $odadosInstint->si09_instit;
}
$iInstituicoes = implode(',', $ainstitunticoes);

$rsTipoinstit = $clinfocomplementaresinstit->sql_record($clinfocomplementaresinstit->sql_query(null, "si09_sequencial,si09_tipoinstit", null, "si09_instit in( {$instits})"));

$oReceitaeDespesaEnsino = new RelatorioReceitaeDespesaEnsino();

/**
 * busco o tipo de instituicao
 */
$ainstitunticoes = array();
$aTipoistituicao = array();

for ($i = 0; $i < pg_num_rows($rsTipoinstit); $i++) {
    $odadosInstint = db_utils::fieldsMemory($rsTipoinstit, $i);
    $aTipoistituicao[] = $odadosInstint->si09_tipoinstit;
    $iCont = pg_num_rows($rsTipoinstit);
}


$sWhereDespesa      = " o58_instit in({$instits})";
db_query("drop table if exists work_dotacao");
criaWorkDotacao($sWhereDespesa,array($anousu), $dtini, $dtfim);

$aSubFuncao = array(122,272,271,361,365,366,367,843);
$sFuncao     = "12";
$aFontes      = array("'101','118','119','1101','1118','1119','15000001','15400007','15400000'");

$sWhereReceita      = "o70_instit in ({$instits})";
$rsReceitas = db_receitasaldo(11, 1, 3, true, $sWhereReceita, $anousu, $dtini, $dtfim, false, ' * ', true, 0);
$aReceitas = db_utils::getColectionByRecord($rsReceitas);
db_query("drop table if exists work_receita");
criarWorkReceita($sWhereReceita, array($anousu), $dtini, $dtfim);

if ($anousu >=2022){
$aReceitasImpostos = array(
    array('1 - Receita de impostos', 'title', '',''),
    array('1.1 - Receita resultante do Imposto sobre a Propriedade Predial e Territorial Urbana (IPTU)', 'subtitle', '41112500%', '49%1112500%'),
    array('1.1.1.2.50.0.1 - Imposto sobre a Propriedade Predial e Territorial Urbana - Principal', 'text', '411125001%', ''),
    array('1.1.1.2.50.0.2 - Imposto Sobre a Propriedade Predial e Territorial Urbana - Multas e Juros de Mora', 'text', '411125002%', ''),
    array('1.1.1.2.50.0.3 - Imposto Sobre a Propriedade Predial e Territorial Urbana - Dívida Ativa', 'text', '411125003%', ''),
    array('1.1.1.2.50.0.4 - Imposto Sobre a Propriedade Predial e Territorial Urbana -  Multas e Juros de Mora da Dívida Ativa', 'text', '411125004%', ''),
    array('1.1.1.2.50.0.5 - Imposto Sobre a Propriedade Predial e Territorial Urbana - Multas', 'text', '411125005%', ''),
    array('1.1.1.2.50.0.6 - Imposto Sobre a Propriedade Predial e Territorial Urbana - Juros de Mora', 'text', '411125006%', ''),
    array('1.1.1.2.50.0.7 - Imposto Sobre a Propriedade Predial e Territorial Urbana - Multas da Dívida Ativa', 'text', '411125007%', ''),
    array('1.1.1.2.50.0.8 - Imposto Sobre a Propriedade Predial e Territorial Urbana - Juros de Mora da Dívida Ativa', 'text', '411125008%', ''),
    array('(-) Deduções da Receita do IPTU', 'text', '49%111250%',''),
    array('1.2 - Receita resultante do Imposto sobre Transmissão Inter Vivos (ITBI)', 'subtitle', '41112530%', '49%1112530%'),
    array('1.1.1.2.53.0.1 - Impostos sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Principal', 'text', '411125301%',''),
    array('1.1.1.2.53.0.2 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Multas e Juros de Mora', 'text', '411125302%',''),
    array('1.1.1.2.53.0.3 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Dívida Ativa', 'text', '411125303%',''),
    array('1.1.1.2.53.0.4 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Multas e Juros de Mora da Dívida Ativa', 'text', '411125304%',''),
    array('1.1.1.2.53.0.5 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Multas', 'text', '411125305%',''),
    array('1.1.1.2.53.0.6 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Juros de Mora', 'text', '411125306%',''),
    array('1.1.1.2.53.0.7 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Multas da Dívida Ativa', 'text', '411125307%',''),
    array('1.1.1.2.53.0.8 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis -Juros de Mora da Dívida Ativa', 'text', '411125308%',''),
    array('(-) Deduções da Receita do ITBI', 'text', '49%111253%',''),
    array('1.3 - Receita resultante do Imposto sobre Serviços de Qualquer Natureza (ISS)', 'subtitle', '4111451%', '49%111451%'),
    array('1.1.1.4.51.1.1 - Imposto sobre Serviços de Qualquer Natureza - Principal', 'text', '411145111%',''),
    array('1.1.1.4.51.1.2 - Imposto sobre Serviços de Qualquer Natureza - Multas e Juros de Mora', 'text', '411145112%',''),
    array('1.1.1.4.51.1.3 - Imposto sobre Serviços de Qualquer Natureza - Dívida Ativa', 'text', '411145113%',''),
    array('1.1.1.4.51.1.4 - Imposto sobre Serviços de Qualquer Natureza - Multas e Juros de Mora da Dívida Ativa', 'text', '411145114%',''),
    array('1.1.1.4.51.1.5 - Imposto sobre Serviços de Qualquer Natureza - Multas', 'text', '411145115%',''),
    array('1.1.1.4.51.1.6 - Imposto sobre Serviços de Qualquer Natureza - Juros de Mora ', 'text', '411145116%',''),
    array('1.1.1.4.51.1.7 - Imposto sobre Serviços de Qualquer Natureza - Multas da Dívida Ativa', 'text', '411145117%',''),
    array('1.1.1.4.51.1.8 - Imposto sobre Serviços de Qualquer Natureza - Juros de Mora da Dívida Ativa', 'text', '411145118%',''),
    array('1.1.1.4.51.2.1 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Principal', 'text', '411145121%',''),
    array('1.1.1.4.51.2.2 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Multas e Juros de Mora', 'text', '411145122%',''),
    array('1.1.1.4.51.2.3 - Adicional ISS - Fundo Municipal de Combate à Pobreza -  Dívida Ativa', 'text', '411145123%',''),
    array('1.1.1.4.51.2.4 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Multas e Juros de Mora da Dívida Ativa', 'text', '411145124%',''),
    array('1.1.1.4.51.2.5 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Multas', 'text', '411145125%',''),
    array('1.1.1.4.51.2.6 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Juros de Mora', 'text', '411145126%',''),
    array('1.1.1.4.51.2.7 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Multas da Dívida Ativa', 'text', '411145127%',''),
    array('1.1.1.4.51.2.8 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Juros de Mora da Dívida Ativa', 'text', '411145128%',''),
    array('(-) Deduções da Receita do ISS', 'text', '49%111451%',''),
    array('1.4 - Receita resultante do Imposto de Renda Retido na Fonte (IRRF)', 'subtitle', '4111303%', '49%111303%',''),
    array('1.1.1.3.03.1.1 - Imposto sobre a Renda - Retido na Fonte - Trabalho - Principal', 'text', '411130311%',''),
    array('1.1.1.3.03.4.1 - Imposto sobre a Renda - Retido na Fonte - Outros Rendimentos - Principal', 'text', '411130341%',''),
    array('(-) Deduções da Receita do IRRF', 'text', '49%111303%',''),
    array('1.5 - Receita resultante do Imposto Territorial Rural (ITR) (CF, ART. 153, §4º, inciso III)	', 'subtitle', '41112011%', '49%1112011%'),
    array('1.1.1.2.01.1.1 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Principal', 'text', '411120111%',''),
    array('1.1.1.2.01.1.2 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Multas e Juros de Mora', 'text', '411120112%',''),
    array('1.1.1.2.01.1.3 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Dívida Ativa', 'text', '411120113%',''),
    array('1.1.1.2.01.1.4 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Multas e Juros de Mora da Dívida Ativa', 'text', '411120114%',''),
    array('1.1.1.2.01.1.5 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Multas', 'text', '411120115%',''),
    array('1.1.1.2.01.1.6 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Juros de Mora', 'text', '411120116%',''),
    array('1.1.1.2.01.1.7 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados -Multas da Dívida Ativa', 'text', '411120117%',''),
    array('1.1.1.2.01.1.8 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Juros de Mora da Dívida Ativa', 'text', '411120118%',''),
    array('(-) Deduções da Receita do ITR ', 'text', '49%111201%',''),
);

$aReceitasTransferencias = array(
    array('2 - Receita de transferências constitucionais e legais	', 'title', ''),
    array('1.7.1.1.51.1.1 - Cota-Parte do Fundo de Participação dos Municípios - Cota Mensal - Principal', 'text', '417115111%'),
    array('1.7.1.1.51.2.1 - Cota-Parte do Fundo de Participação do Municípios - 1% Cota entregue no mês de dezembro - Principal', 'text', '417115121%'),
    array('1.7.1.1.51.3.1 - Cota-Parte do Fundo de Participação dos Municípios - 1% Cota entregue no mês de julho - Principal', 'text', '417115131%'),
    array('1.7.1.1.52.0.1 - Cota-Parte do Imposto Sobre a Propriedade Territorial Rural - Principal', 'text', '417115201%'),
    array('1.7.1.1.55.0.1 - Cota-Parte do Imposto Sobre Operações de Crédito, Câmbio e Seguro, ou Relativas a Títulos ou Valores Mobiliários - Comercialização do Ouro - Principal', 'text', '417115501%'),
    array('1.7.1.9.51.0.1 - Transferência Financeira do ICMS - Desoneração - L.C. Nº 87/96 - Principal', 'text', '417195101%'),
    array('1.7.1.9.61.0.1 - Auxílio Financeiro - Outorga Crédito Tributário ICMS - Art. 5º, Inciso V, EC nº 123/2022 - Principal', 'text', '417196101%'),
    array('1.7.2.1.50.0.1 - Cota-parte do ICMS - Principal', 'text', '417215001%'),
    array('1.7.2.1.51.0.1 - Cota-parte do IPVA - Principal', 'text', '417215101%'),
    array('1.7.2.1.52.0.1 - Cota-Parte do IPI - Municípios - Principal', 'text', '417215201%'),

);
}else{
$aReceitasImpostos = array(
    array('1 - Receita de impostos', 'title', '',''),
    array('1.1 - Receita resultante do Imposto sobre a Propriedade Predial e Territorial Urbana (IPTU)', 'subtitle', '41118011%', '49%1118011%'),
    array('1.1.1.8.01.1.1 - Imposto sobre a Propriedade Predial e Territorial Urbana - Principal', 'text', '411180111%', ''),
    array('1.1.1.8.01.1.2 - Imposto Sobre a Propriedade Predial e Territorial Urbana - Multas e Juros de Mora', 'text', '411180112%', ''),
    array('1.1.1.8.01.1.3 - Imposto Sobre a Propriedade Predial e Territorial Urbana - Dívida Ativa', 'text', '411180113%', ''),
    array('1.1.1.8.01.1.4 - Imposto Sobre a Propriedade Predial e Territorial Urbana -  Multas e Juros de Mora da Dívida Ativa', 'text', '411180114%', ''),
    array('1.1.1.8.01.1.5 - Imposto Sobre a Propriedade Predial e Territorial Urbana - Multas', 'text', '411180115%', ''),
    array('1.1.1.8.01.1.6 - Imposto Sobre a Propriedade Predial e Territorial Urbana - Juros de Mora', 'text', '411180116%', ''),
    array('1.1.1.8.01.1.7 - Imposto Sobre a Propriedade Predial e Territorial Urbana - Multas da Dívida Ativa', 'text', '411180117%', ''),
    array('(-) Deduções da Receita do IPTU', 'text', '49%111801%',''),
    array('1.2 - Receita resultante do Imposto sobre Transmissão Inter Vivos (ITBI)', 'subtitle', '41118014%', '49%1118014%'),
    array('1.1.1.8.01.4.1 - Impostos sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Principal', 'text', '411180141%',''),
    array('1.1.1.8.01.4.2 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Multas e Juros de Mora', 'text', '411180142%',''),
    array('1.1.1.8.01.4.3 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Dívida Ativa', 'text', '411180143%',''),
    array('1.1.1.8.01.4.4 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Multas e Juros de Mora da Dívida Ativa', 'text', '411180144%',''),
    array('1.1.1.8.01.4.5 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Multas', 'text', '411180145%',''),
    array('1.1.1.8.01.4.6 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Juros de Mora', 'text', '411180146%',''),
    array('1.1.1.8.01.4.7 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis - Multas da Dívida Ativa', 'text', '411180147%',''),
    array('1.1.1.8.01.4.8 - Imposto sobre Transmissão Inter Vivos de Bens Imóveis e de Direitos Reais sobre Imóveis -Juros de Mora da Dívida Ativa', 'text', '411180148%',''),
    array('(-) Deduções da Receita do ITBI', 'text', '49%111801%',''),
    array('1.3 - Receita resultante do Imposto sobre Serviços de Qualquer Natureza (ISS)', 'subtitle', '4111802%', '49%111802%'),
    array('1.1.1.8.02.3.1 - Imposto sobre Serviços de Qualquer Natureza - Principal', 'text', '411180231%',''),
    array('1.1.1.8.02.3.2 - Imposto sobre Serviços de Qualquer Natureza - Multas e Juros de Mora', 'text', '411180232%',''),
    array('1.1.1.8.02.3.3 - Imposto sobre Serviços de Qualquer Natureza - Dívida Ativa', 'text', '411180233%',''),
    array('1.1.1.8.02.3.4 - Imposto sobre Serviços de Qualquer Natureza - Multas e Juros de Mora da Dívida Ativa', 'text', '411180234%',''),
    array('1.1.1.8.02.3.5 - Imposto sobre Serviços de Qualquer Natureza - Multas', 'text', '411180235%',''),
    array('1.1.1.8.02.3.6 - Imposto sobre Serviços de Qualquer Natureza - Juros de Mora ', 'text', '411180236%',''),
    array('1.1.1.8.02.3.7 - Imposto sobre Serviços de Qualquer Natureza - Multas da Dívida Ativa', 'text', '411180237%',''),
    array('1.1.1.8.02.3.8 - Imposto sobre Serviços de Qualquer Natureza - Juros de Mora da Dívida Ativa', 'text', '411180238%',''),
    array('1.1.1.8.02.4.1 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Principal', 'text', '411180241%',''),
    array('1.1.1.8.02.4.2 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Multas e Juros de Mora', 'text', '411180242%',''),
    array('1.1.1.8.02.4.3 - Adicional ISS - Fundo Municipal de Combate à Pobreza -  Dívida Ativa', 'text', '411180243%',''),
    array('1.1.1.8.02.4.4 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Multas e Juros de Mora da Dívida Ativa', 'text', '411180244%',''),
    array('1.1.1.8.02.4.5 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Multas', 'text', '411180245%',''),
    array('1.1.1.8.02.4.6 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Juros de Mora', 'text', '411180246%',''),
    array('1.1.1.8.02.4.7 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Multas da Dívida Ativa', 'text', '411180247%',''),
    array('1.1.1.8.02.4.8 - Adicional ISS - Fundo Municipal de Combate à Pobreza - Juros de Mora da Dívida Ativa', 'text', '411180248%',''),
    array('(-) Deduções da Receita do ISS', 'text', '49%111802%',''),
    array('1.4 - Receita resultante do Imposto de Renda Retido na Fonte (IRRF)', 'subtitle', '4111303%', '49%111303%',''),
    array('1.1.1.3.03.1.1 - Imposto sobre a Renda - Retido na Fonte - Trabalho - Principal', 'text', '411130311%',''),
    array('1.1.1.3.03.4.1 - Imposto sobre a Renda - Retido na Fonte - Outros Rendimentos - Principal', 'text', '411130341%',''),
    array('(-) Deduções da Receita do IRRF', 'text', '49%111303%',''),
    array('1.5 - Receita resultante do Imposto Territorial Rural (ITR) (CF, ART. 153, §4º, inciso III)	', 'subtitle', '41112011%', '49%1112011%'),
    array('1.1.1.2.01.1.1 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Principal', 'text', '411120111%',''),
    array('1.1.1.2.01.1.2 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Multas e Juros de Mora', 'text', '411120112%',''),
    array('1.1.1.2.01.1.3 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Dívida Ativa', 'text', '411120113%',''),
    array('1.1.1.2.01.1.4 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Multas e Juros de Mora da Dívida Ativa', 'text', '411120114%',''),
    array('1.1.1.2.01.1.5 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Multas', 'text', '411120115%',''),
    array('1.1.1.2.01.1.6 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Juros de Mora', 'text', '411120116%',''),
    array('1.1.1.2.01.1.7 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados -Multas da Dívida Ativa', 'text', '411120117%',''),
    array('1.1.1.2.01.1.8 - Imposto sobre a Propriedade Territorial Rural - Municípios Conveniados - Juros de Mora da Dívida Ativa', 'text', '411120118%',''),
    array('(-) Deduções da Receita do ITR ', 'text', '49%111201%',''),
);

$aReceitasTransferencias = array(
    array('2 - Receita de transferências constitucionais e legais	', 'title', ''),
    array('1.7.1.8.01.2.1 - Cota-Parte do Fundo de Participação dos Municípios - Cota Mensal - Principal', 'text', '417180121%'),
    array('1.7.1.8.01.3.1 - Cota-Parte do Fundo de Participação do Municípios - 1% Cota entregue no mês de dezembro - Principal', 'text', '417180131%'),
    array('1.7.1.8.01.4.1 - Cota-Parte do Fundo de Participação dos Municípios - 1% Cota entregue no mês de julho - Principal', 'text', '417180141%'),
    array('1.7.1.8.01.5.1 - Cota-Parte do Imposto Sobre a Propriedade Territorial Rural - Principal', 'text', '417180151%'),
    array('1.7.1.8.01.8.1 - Cota-Parte do Imposto Sobre Operações de Crédito, Câmbio e Seguro, ou Relativas a Títulos ou Valores Mobiliários - Comercialização do Ouro - Principal', 'text', '417180181%'),
    array('1.7.1.8.06.1.1 - Transferência Financeira do ICMS - Desoneração - L.C. Nº 87/96 - Principal', 'text', '417180611%'),
    array('1.7.2.8.01.1.1 - Cota-parte do ICMS - Principal', 'text', '417280111%'),
    array('1.7.2.8.01.2.1 - Cota-parte do IPVA - Principal', 'text', '417280121%'),
    array('1.7.2.8.01.3.1 - Cota-Parte do IPI - Municípios - Principal', 'text', '417280131%'),
);
}

//echo "<pre>";print_r($relatorioReceitas);exit;


/**
 * mPDF
 * @param string $mode | padrão: BLANK
 * @param mixed $format | padrão: A4
 * @param float $default_font_size | padrão: 0
 * @param string $default_font | padrão: ''
 * @param float $margin_left | padrão: 15
 * @param float $margin_right | padrão: 15
 * @param float $margin_top | padrão: 16
 * @param float $margin_bottom | padrão: 16
 * @param float $margin_header | padrão: 9
 * @param float $margin_footer | padrão: 9
 *
 * Nenhum dos parâmetros é obrigatório
 */

$mPDF = new \Mpdf\Mpdf([
    'mode' => '',
    'format' => 'A4',
    'orientation' => 'L',
    'margin_left' => 10,
    'margin_right' => 10,
    'margin_top' => 20,
    'margin_bottom' => 10,
    'margin_header' => 5,
    'margin_footer' => 11,
]);
// DEFINE O FUSO HORARIO COMO O HORARIO DE BRASILIA
date_default_timezone_set('America/Sao_Paulo');
// CRIA UMA VARIAVEL E ARMAZENA A HORA ATUAL DO FUSO-HORÀRIO DEFINIDO (BRASÍLIA)
$dataLocal = date('d/m/Y H:i:s', time());
$header = "
<header>
    <div style=\"font-family:Arial\">
        <div style=\"width:33%;float:left;padding:5px;font-size:10px;\">
            <b><i>{$oInstit->getDescricao()}</i></b><br/>
            <i>{$oInstit->getLogradouro()}, {$oInstit->getNumero()}</i><br/>
            <i>{$oInstit->getMunicipio()} - {$oInstit->getUf()}</i><br/>
            <i>{$oInstit->getTelefone()} - CNPJ: " . db_formatar($oInstit->getCNPJ(), "cnpj") . "</i><br/>
            <i>{$oInstit->getSite()}</i>
        </div>
        <div style=\"width:25%; float:right\" class=\"box\">
            <b>Relatório Ensino - Anexo II</b><br/>
            <b>INSTITUIÇÕES:</b> ";
            foreach ($aInstits as $iInstit) {
                $oInstituicao = new Instituicao($iInstit);
                $header .= "(" . trim($oInstituicao->getCodigo()) . ") " . $oInstituicao->getDescricao() . " ";
            }
            $header .= "<br/> <b>PERÍODO:</b> {$DBtxt21} A {$DBtxt22} <br/>
        </div>
    </div>
</header>";

$footer = "
<footer>
    <div style='border-top:1px solid #000;width:100%;font-family:sans-serif;font-size:10px;height:10px;'>
        <div style='text-align:left;font-style:italic;width:90%;float:left;'>
            Financeiro>Contabilidade>Relatórios de Acompanhamento>Receita Ensino - Anexo II
            Emissor: " . db_getsession("DB_login") . " Exerc: " . db_getsession("DB_anousu") . " Data:" . $dataLocal . "
        <div style='text-align:right;float:right;width:10%;'>
            {PAGENO}
        </div>
    </div>
</footer>";


$mPDF->WriteHTML(file_get_contents('estilos/tab_relatorio.css'), 1);
$mPDF->setHTMLHeader(utf8_encode($header), 'O', true);
$mPDF->setHTMLFooter(utf8_encode($footer), 'O', true);
$mPDF->shrink_tables_to_fit = 1;

ob_start();
?>
<html>

<head>
    <style type="text/css">
        .ritz .waffle a {
            color: inherit;
            font-family: 'Arial';
            font-size: 12px;
            width: 100%;
        }

        .title-relatorio {
            text-align: center;
        }

        .th-receita {
            height: 20px;
            background-color: #d8d8d8;
            width: 80%;
            border: 1px SOLID #000000;
            font-family: 'Arial';
            font-size: 10px;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: center;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .th-valor {
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-top: 1px SOLID #000000;
            border-bottom: 1px SOLID #000000;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: center;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .footer-row {
            height: 20px;
            background-color: #d8d8d8;
            width: 80%;
            border: 1px SOLID #000000;
            font-family: 'Arial';
            font-size: 10px;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .footer-row-valor {
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-top: 1px SOLID #000000;
            border-bottom: 1px SOLID #000000;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .footer-total-row {
            height: 20px;
            background-color: #d8d8d8;
            width: 80%;
            border: 1px SOLID #000000;
            font-family: 'Arial';
            font-size: 10px;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .footer-total-row-valor {
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-top: 1px SOLID #000000;
            border-bottom: 1px SOLID #000000;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            font-weight: bold;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .title-row-valor {
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-bottom: 1px SOLID #d8d8d8;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .subtitle-row-valor {
            height: 20px;
            background-color: #d8d8d8;
            width: 20%;
            border-right: 1px SOLID #000000;
            border-bottom: 1px SOLID #d8d8d8;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .text-row-valor {
            height: 20px;
            background-color: #ffffff;
            width: 20%;
            font-family: 'Arial', Calibre;
            border-right: 1px SOLID #000000;
            font-size: 10px;
            padding: 2px 3px 2px 3px;
            text-align: right;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .title-row {
            background-color: #d8d8d8;
            color: #000000;
            direction: ltr;
            border-left: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            border-bottom: 1px SOLID #d8d8d8;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            padding: 2px 3px 2px 3px;
            text-align: left;
        }

        .ritz .subtitle-row {
            background-color: #d8d8d8;
            color: #000000;
            direction: ltr;
            border-left: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            border-bottom: 1px SOLID #d8d8d8;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            padding: 2px 3px 2px 30px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .text-row {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            border-left: 1px SOLID #000000;
            border-right: 1px SOLID #000000;
            font-family: 'Arial', Calibre;
            font-size: 10px;
            padding: 2px 3px 2px 60px;
            text-align: left;
            vertical-align: bottom;
            white-space: nowrap;
        }

        .ritz .waffle .clear {
            background-color: #ffffff;
            color: #000000;
            direction: ltr;
            font-size: 10pt;
            padding: 2px 3px 2px 3px;
            white-space: nowrap;
        }
    </style>
</head>

<body>
    <div class="ritz " >
        <div class="title-relatorio">
            <br/>
            <strong>Anexo II</strong><br />
            <strong>Demonstrativo das Receitas e Despesas com Manutenção e Desenvolvimento do Ensino</strong><br />
            <strong>(Art.212 da C.F; Emenda Constitucional nº 53/06, leis nº 9.394/96 e 11.494/07)</strong><br /><br />
        </div>
        <table class="waffle" width="600px" cellspacing="0" cellpadding="0" style="border: 1px #000" autosize="1">
            <thead>
                <tr>
                    <th id="0C0" style="width:100%"  class="column-headers-background">&nbsp;</th>

                </tr>
            </thead>
            <tbody>
                <tr>
                    <td class="th-receita" colspan="8">Receitas</td>
                    <td class="th-valor">Valor</td>
                </tr>
                <?php
                $nTotalReceitaImpostos = 0;
                foreach ($aReceitasImpostos as $receita) {
                    echo "<tr style='height:20px;'>";
                    echo "<td class='{$receita[1]}-row' colspan='8'>{$receita[0]}</td>";
                    echo "    <td class='{$receita[1]}-row-valor'>";
                    $aReceitas = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '{$receita[2]}'");
                    $nReceita = count($aReceitas) > 0 ? $aReceitas[0]->saldo_arrecadado_acumulado : 0;

                    $nTotalReceitaDeducao = 0;
                    if($receita[3] != ''){
                        $aReceitasDeducao = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '{$receita[3]}'");
                        $nTotalReceitaDeducao = count($aReceitasDeducao) > 0 ? $aReceitasDeducao[0]->saldo_arrecadado_acumulado : 0;
                    }
                    $nTotalReceita = $nReceita + $nTotalReceitaDeducao;
                    $receita[1] == 'subtitle' ? $nTotalReceitaImpostos += $nTotalReceita : $nTotalReceitaImpostos += 0;
                    if ($receita[1] == 'title') {
                        echo "";
                    } else {
                        echo db_formatar(($nTotalReceita), "f");
                    }
                    echo "    </td>";
                    echo " </tr>";
                }
                ?>
                <tr style='height:20px;'>
                    <td class="footer-row" colspan="8">Subtotal</td>
                    <td class="footer-row-valor"><?php echo db_formatar($nTotalReceitaImpostos, "f"); ?></td>
                </tr>
                <?php
                    $nTotalReceitaTransferencia = 0;
                    foreach ($aReceitasTransferencias as $receitaTransferencia) {
                        echo "<tr style='height:20px;'>";
                        echo "    <td class='{$receitaTransferencia[1]}-row' colspan='8'>{$receitaTransferencia[0]}</td>";
                        echo "    <td class='{$receitaTransferencia[1]}-row-valor'>";
                            $aReceitas = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '{$receitaTransferencia[2]}'");
                            $nTotalReceita = count($aReceitas) > 0 ? $aReceitas[0]->saldo_arrecadado_acumulado : 0;
                            if ($receitaTransferencia[1] == 'title') {
                                echo "";
                            } else {
                                echo db_formatar($nTotalReceita, "f");
                                $nTotalReceitaTransferencia += $nTotalReceita;
                            }
                        echo "    </td>";
                        echo " </tr>";
                    }
                ?>
                <tr style='height:20px;'>
                    <td class="footer-row" colspan="8">Subtotal</td>
                    <td class="footer-row-valor"><?php echo db_formatar($nTotalReceitaTransferencia, "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="footer-total-row" colspan="8">Total das Receitas (A)</td>
                    <td class="footer-total-row-valor"><?php echo db_formatar($nTotalReceitaTransferencia + $nTotalReceitaImpostos, "f"); ?></td>
                </tr>
                 <?php
                    $nTotalAplicadoEntrada = 0;
                    $nTotalAplicadoSaida   = 0;
                    $nValorTotalPago       = 0;
                    $aFontes      = array("'101','1101','15000001','201','25000001'");
                    if ($anousu > 2022) {
                        $sFuncao = "12, 28";
                    }
                    foreach ($aSubFuncao as $iSubFuncao) {
                        $oReceitaeDespesaEnsino->setAnousu($anousu);
                        $oReceitaeDespesaEnsino->setSubFuncao($iSubFuncao);
                        $oReceitaeDespesaEnsino->setFuncao($sFuncao);
                        $oReceitaeDespesaEnsino->setFontes($aFontes);
                        $oReceitaeDespesaEnsino->setInstits($instits);
                        $dadosLinha1 = $oReceitaeDespesaEnsino->getLinha1FuncaoeSubfuncao();
                        if (count($dadosLinha1['1']) > 0) {
                            foreach ($dadosLinha1['1'] as $oDespesaPrograma) {
                                $oReceitaeDespesaEnsino->setDespesaPrograma($oDespesaPrograma);
                                $oReceitaeDespesaEnsino->setSubTotal($fSubTotal);
                                $oReceitaeDespesaEnsino->setValorTotalPago($nValorTotalPago);
                                $oReceitaeDespesaEnsino->setValorTotalEmpenhadoENaoLiquidado($nValorTotalEmpenhadoENaoLiquidado);
                                $oReceitaeDespesaEnsino->setValorTotalLiquidadoAPagar($nValorTotalLiquidadoAPagar);
                                $oReceitaeDespesaEnsino->setValorTotalGeral($nValorTotalGeral);
                                $dadoslinha2                  = $oReceitaeDespesaEnsino->getLinha2FuncaoeSubfuncao();
                                $nValorTotalPago             += $dadoslinha2['6'];
                        }
                    }
                   }
                   $aFonte2      = array("'136','17180000'");
                   $aSubFuncoes2 = array(122,272,271,361,365,366,367,843);
                   $sFuncao2     = "12";
                   foreach ($aSubFuncoes2 as $iSubFuncao) {
                        $oReceitaeDespesaEnsino->setAnousu($anousu);
                        $oReceitaeDespesaEnsino->setSubFuncao($iSubFuncao);
                        $oReceitaeDespesaEnsino->setFuncao($sFuncao);
                        $oReceitaeDespesaEnsino->setFontes($aFonte2);
                        $oReceitaeDespesaEnsino->setInstits($instits);
                        $dadosLinha1 = $oReceitaeDespesaEnsino->getLinha1FuncaoeSubfuncao();
                        if (count($dadosLinha1['1']) > 0) {
                            foreach ($dadosLinha1['1'] as $oDespesaPrograma) {
                                $oReceitaeDespesaEnsino->setDespesaPrograma($oDespesaPrograma);
                                $oReceitaeDespesaEnsino->setSubTotal($fSubTotal);
                                $oReceitaeDespesaEnsino->setValorTotalPago($nValorTotalPago);
                                $oReceitaeDespesaEnsino->setValorTotalEmpenhadoENaoLiquidado($nValorTotalEmpenhadoENaoLiquidado);
                                $oReceitaeDespesaEnsino->setValorTotalLiquidadoAPagar($nValorTotalLiquidadoAPagar);
                                $oReceitaeDespesaEnsino->setValorTotalGeral($nValorTotalGeral);
                                $dadoslinha2                  = $oReceitaeDespesaEnsino->getLinha2FuncaoeSubfuncao();
                                $nValorTotalPago             += $dadoslinha2['6'];
                            }
                        }
                   }
                   if ($anousu > 2022) {
                       $aFonteFundeb = array("'15020001'");
                   } else {
                       $aFonteFundeb = array("'118','119','1118','1119','15400007','15400000'");
                   }
                   $aSubFuncoes = array(122,272,271,361,365,366,367,843);
                   foreach ($aSubFuncoes as $iSubFuncao) {
                        $oReceitaeDespesaEnsino->setSubFuncao($iSubFuncao);
                        $oReceitaeDespesaEnsino->setFuncao($sFuncao);
                        $oReceitaeDespesaEnsino->setFonteFundeb($aFonteFundeb);
                        $oReceitaeDespesaEnsino->setInstits($instits);
                        $dadoslinha3 =  $oReceitaeDespesaEnsino->getLinha1FuncaoFundeb();
                        $aDespesasProgramas = $dadoslinha3['1'];
                        if (count($aDespesasProgramas) > 0) {
                            foreach ($aDespesasProgramas as $oDespesaPrograma) {
                                $oReceitaeDespesaEnsino->setDespesaPrograma($oDespesaPrograma);
                                $oReceitaeDespesaEnsino->setValorTotalPago($nValorTotalPago);
                                $oReceitaeDespesaEnsino->setValorTotalEmpenhadoENaoLiquidado($nValorTotalEmpenhadoENaoLiquidado);
                                $oReceitaeDespesaEnsino->setValorTotalLiquidadoAPagar($nValorTotalLiquidadoAPagar);
                                $oReceitaeDespesaEnsino->setValorTotalGeral($nValorTotalGeral);
                                $dadoslinha3                  =  $oReceitaeDespesaEnsino->getLinha2FuncaoFundeb();
                                $nValorTotalPago             += $dadoslinha3['5'];
                            }
                        }
                   }
                   $nTotalAplicadoEntrada  = $nValorTotalPago;
                   $oReceitaeDespesaEnsino->setDataInicial($dtini);
                   $oReceitaeDespesaEnsino->setDataFinal($dtfim);
                   $oReceitaeDespesaEnsino->setInstits($instits);
                   $nTotalAplicadoEntrada += $oReceitaeDespesaEnsino->getLinha7DespesasCusteadaSuperavitDoFundeb();
                   $nTotalAplicadoEntrada += $oReceitaeDespesaEnsino->getLinha8RestosaPagarInscritosFonte101();
                   $nTotalAplicadoEntrada += $oReceitaeDespesaEnsino->getLinha10RestoaPagarSemDis();

                   $nTotalReceitasRecebidasFundeb = 0;
                   $nContribuicaoFundeb = 0;

                   $nDevolucaoRecursoFundeb = 0;
                   $rsSlip = $clSlip->sql_record($clSlip->sql_query_fundeb($dtini, $dtfim, $aInstits));
                   $nDevolucaoRecursoFundeb = db_utils::fieldsMemory($rsSlip, 0)->k17_valor;

                   $nTransferenciaRecebidaFundeb = 0;

                   $aTransferenciasRecebidasFundeb = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '417515001%'");

                   $nTransferenciaRecebidaFundeb = count($aTransferenciasRecebidasFundeb) > 0 ? $aTransferenciasRecebidasFundeb[0]->saldo_arrecadado_acumulado : 0;

                   $aTotalContribuicaoFundeb = getSaldoReceita(null, "sum(saldo_arrecadado_acumulado) as saldo_arrecadado_acumulado", null, "o57_fonte like '495%'");
                   $nTotalContribuicaoFundeb = count($aTotalContribuicaoFundeb) > 0 ? $aTotalContribuicaoFundeb[0]->saldo_arrecadado_acumulado : 0;

                   $nTotalReceitasRecebidasFundeb = abs($nDevolucaoRecursoFundeb) + abs($nTransferenciaRecebidaFundeb);
                   $nResulatadoLiquidoTransfFundeb = $nTotalReceitasRecebidasFundeb-abs($nTotalContribuicaoFundeb);
                   $nTotalAplicadoSaida = $nTotalContribuicaoFundeb;

                   $dadosLinha9 = $oReceitaeDespesaEnsino->getLinha9RestosaPagarInscritoSemDis();
                   $nRPIncritosSemDesponibilidade101     = $dadosLinha9['0'];
                   $nRPIncritosSemDesponibilidade136     = $dadosLinha9['1'];
                   $nRPIncritosSemDesponibilidade118_119 = $dadosLinha9['2'];
                   $nTotalAplicadoSaida = $nTotalAplicadoSaida + $nRPIncritosSemDesponibilidade101 + $nRPIncritosSemDesponibilidade136 + $nRPIncritosSemDesponibilidade118_119;

                   $nTotalDespesaLiquidaFundeb = 0;
                   foreach ($aSubFuncoes as $iSubFuncao) {
                       $oReceitaeDespesaEnsino->setSubFuncao($iSubFuncao);
                       $oReceitaeDespesaEnsino->setFuncao($sFuncao);
                       $oReceitaeDespesaEnsino->setFonteFundeb(array("'15400007', '15400000'"));
                       $oReceitaeDespesaEnsino->setInstits($instits);
                       $dadoslinha3 =  $oReceitaeDespesaEnsino->getLinha1FuncaoFundeb();
                       $aDespesasProgramas = $dadoslinha3['1'];
                       if (count($aDespesasProgramas) > 0) {
                           $nTotalDespesaLiquidaFundeb += $dadoslinha3['5'];
                       }
                   }
                   $nFundebNaoUtilizadasExercicio = ($nTotalReceitasRecebidasFundeb * 0.1) - ($nTotalReceitasRecebidasFundeb - $nTotalDespesaLiquidaFundeb);
                   if ($nFundebNaoUtilizadasExercicio < 0 ) {
                       $nFundebNaoUtilizadasExercicio = abs($nFundebNaoUtilizadasExercicio);
                   } else {
                       $nFundebNaoUtilizadasExercicio = 0;
                   }

                   $nTotalAplicadoSaida += $nFundebNaoUtilizadasExercicio;

                   $dadosLinha11 = $oReceitaeDespesaEnsino->getLinha11CancelamentodeRestoaPagar();
                   $nValorRecursoTotal101 = $dadosLinha11['0'];
                   $nValorRecursoTotal136 = $dadosLinha11['1'];
                   $nValorRecursoTotal118 = $dadosLinha11['2'];
                   $nValorRecursoTotal1502 = $dadosLinha12['3'];
                   $nTotalAplicadoSaida = $nTotalAplicadoSaida + $nValorRecursoTotal101 + $nValorRecursoTotal136 + $nValorRecursoTotal118 + $nValorRecursoTotal1502;

                   $nValorAplicado =  $nTotalAplicadoEntrada + ($nTotalAplicadoSaida * -1);
                   $valorAplicacaoDevida = ($nTotalReceitaTransferencia + $nTotalReceitaImpostos)*0.25 ;
                   $nDiferencaAplicacao = $nValorAplicado - $valorAplicacaoDevida;
                   $nPercentualAplicado = ($nValorAplicado/ ($nTotalReceitaTransferencia + $nTotalReceitaImpostos))*100;
                 ?>
                <tr style='height:20px;'>
                    <td class="footer-total-row" colspan="8">B - Aplicação Devida (art. 212 da CF/88) 25%</td>
                    <td class="footer-total-row-valor"><?php echo db_formatar($valorAplicacaoDevida, "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="footer-total-row" colspan="8"><?php echo "C - Valor da Aplicação ".db_formatar($nPercentualAplicado, "f")."%"; ?></td>
                    <td class="footer-total-row-valor"><?php echo db_formatar($nValorAplicado, "f"); ?></td>
                </tr>
                <tr style='height:20px;'>
                    <td class="footer-total-row" colspan="8">D - Diferença entre o Valor Aplicado e o Limite Constitucional ( D = C - B)</td>
                    <td class="footer-total-row-valor">
                        <?php
                            if($nDiferencaAplicacao > 0){
                                echo db_formatar($nDiferencaAplicacao, "f");
                            } else{
                                echo "(".db_formatar(abs($nDiferencaAplicacao), "f")." )";
                            }
                        ?>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

</body>

</html>

<?php

$html = ob_get_contents();
ob_end_clean();
//echo $html;

$mPDF->WriteHTML(utf8_encode($html));
$mPDF->Output();

/* ---- */


db_query("drop table if exists work_dotacao");
db_query("drop table if exists work_receita");

db_fim_transacao();
