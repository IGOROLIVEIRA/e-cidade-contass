<?php
require_once('libs/db_stdlib.php');
require_once('libs/db_utils.php');
require_once('libs/db_app.utils.php');
require_once('libs/db_conecta.php');
require_once('libs/db_sessoes.php');
require_once('dbforms/db_funcoes.php');
require_once('libs/JSON.php');

use \ECidade\V3\Extension\Registry;
use \ECidade\Core\Config as AppConfig;
use ECidade\RecursosHumanos\ESocial\DadosESocial;
use ECidade\RecursosHumanos\ESocial\Model\Formulario\Tipo;
use ECidade\RecursosHumanos\ESocial\Integracao\ESocial;
use ECidade\RecursosHumanos\ESocial\Integracao\Recurso;
use ECidade\RecursosHumanos\ESocial\Integracao\FormatterFactory;
use ECidade\RecursosHumanos\ESocial\Agendamento\Evento;

Registry::set('app.config', new AppConfig());

\ECidade\V3\Extension\Registry::get('app.config')->merge(array(

    /**
     * Charset do projeto
     * @type string
     */
    'charset' => 'UTF-8',

    /**
     * Exibir erros
     * @type boolean
     */
    'php.display_errors' => true,

    /**
     * Tipos de erros para capturar
     */
    'php.error_reporting' => E_ALL & ~E_DEPRECATED & ~E_STRICT,

    /**
     * Lista de URL's de api's usadas pelo ecidade
     */
    'app.api' => array(
        'centraldeajuda' => 'http://centraldeajuda.dbseller.com.br/help/api/index.php/',
        'esocial' => array(
            'url' => 'http://34.95.213.240/sped-esocial/run.php', // informe a api do eSocial. ESTE IP E DA MAQUINA DE ROBSON. LEMBRAR DE MUDAR.
            //'url' => 'http://10.251.27.76/sped-esocial-2.5/run.php',
            'login' => '', // login do cliente
            'password' => '' // senha do cliente
        )
    ),

    /**
     * Configuração de proxy para o e-cidade
     */
    'app.proxy' => array(
        'http'  => '172.16.212.254:3128', // e.g. 172.16.212.254:3128
        'https' => '172.16.212.254:3128', // e.g. 192.168.0.1:3128
        'tcp'   => '172.16.212.254:3128'  // e.g. 192.168.0.1:3128
    ),

    /**
     * Requisicoes que usaram sessao
     * @type string - glob pattern
     */
    'app.request.session.   ' => '*.php',

    /**
     * Requisicoes que usaram sessao somente leitura
     * @type string - glob pattern
     */
    'app.request.session.readOnlyOn' => '{skins/*,*.js,*.css}',

    /**
     * Extensoes de arquivos para cachear - 304
     * @type array
     */
    'app.request.asset.cacheable.extension' => array('js', 'css', 'jpg', 'jpeg', 'png', 'bmp', 'ttf', 'gif'),

    /**
     * Log de erros do php
     * @type boolean
     */
    'app.error.log' => true,

    /**
     * Caminho do arquivo para gravar erros do php
     * @type string
     */


    /**
     * @type string
     */
    'app.error.log.mask' => "{type} - {message} in {file} on line {line}\n{trace}",

    /**
     * @type string
     */
    'app.error.log.mask.trace' => "#{index} {file}:{line} - {class}{type}{function}({args})\n",

    /**
     * Eventos
     * - app.error: executado a cada erro, respeitando a config php.error_reporting
     * - app.shutdown: executado ao final de cada requisicao
     * @type Array
     */
    'app.events' => array('app.error' => '\ECidade\V3\Error\EventHandler'),

    /**
     * @type Integer
     * 0 : quiet
     * 1 : info    [info]
     * 2 : notice  [info, notice]
     * 3 : warning [info, notice, warning]
     * 4 : error   [info, notice, warning, error]
     * 5 : debug   [info, notice, warning, error, debug]
     */
    'app.log.verbosity' => \ECidade\V3\Extension\Logger::ERROR,

    /**
     * @type String
     */


    /**
     * @type String
     */


    /**
     * UTF8 -> UNICODE
     * ISO-8859-1 -> LATIN1
     * @see https://secure.php.net/manual/pt_BR/function.pg-set-client-encoding.php
     * @type string
     **/
    'db.client_encoding' => 'LATIN1',

));



$oJson = new services_json();
$oParam = JSON::create()->parse(str_replace('\\', "", $_POST["json"]));
$oRetorno = new stdClass();
$oRetorno->iStatus = 1;
$oRetorno->sMessage = '';

try {

    switch ($oParam->exec) {
        case "getEmpregadores":
            $campos = ' distinct z01_numcgm as cgm, z01_cgccpf as documento, nomeinst as nome, codigo as instituicao,
            (select count(*) as certificado from esocialcertificado where rh214_cgm = z01_numcgm) as certificado';
            $oDaoDbConfig = db_utils::getDao("db_config");
            $sql = $oDaoDbConfig->sql_query(null, $campos, 'z01_numcgm', 'codigo = ' . db_getsession("DB_instit"));

            $rs = db_query($sql);

            if (!$rs) {
                throw new DBException("Ocorreu um erro ao consultar os CGM vinculados as lotações.\nContate o suporte.");
            }

            if (pg_num_rows($rs) == 0) {
                throw new Exception("Não existe empregadores cadastrados na base.");
            }

            $oRetorno->empregador = db_utils::fieldsMemory($rs, 0);
            break;

        case "empregador":
            if (!file_exists($oParam->sPath)) {
                throw new Exception("Houve um erro ao realizar upload do arquivo. Tente novamente.");
            }

            db_inicio_transacao();
            $oDaoEsocialcertificado = db_utils::getDao("esocialcertificado");
            $oDaoEsocialcertificado->rh214_cgm = $oParam->empregador;
            $oDaoEsocialcertificado->rh214_senha = base64_encode($oParam->senha);
            $oDaoEsocialcertificado->rh214_certificado = base64_encode(file_get_contents($oParam->sPath));
            $oDaoEsocialcertificado->rh214_instit = db_getsession("DB_instit");
            $oDaoEsocialcertificado->save();
            if ($oDaoEsocialcertificado->erro_status == 0) {
                throw new \Exception("Erro ao enviar certificado. " . $oDaoEsocialcertificado->erro_msg);
            }

            db_fim_transacao(false);
            $oRetorno->sMessage = "Certificado enviado com sucesso.";

            unlink($oParam->sPath);
            break;

        case "agendarEmpregadorEObras":
            $dadosESocial = new DadosESocial();

            $dadosESocial->setReponsavelPeloPreenchimento($oParam->cgm);
            $dadosDoPreenchimento = $dadosESocial->getPorTipo(Tipo::EMPREGADOR);

            $formatter = FormatterFactory::get(Tipo::S1000);
            $dadosDoEmpregador = $formatter->formatar($dadosDoPreenchimento);

            $formatter = FormatterFactory::get(Tipo::S1005);
            $dadosObras = $formatter->formatar($dadosDoPreenchimento);

            $eventoFila = new Evento(TIPO::S1000, $oParam->cgm, $oParam->cgm, $dadosDoEmpregador[0]);
            $eventoFila->adicionarFila();

            $eventoFila = new Evento(TIPO::S1005, $oParam->cgm, $oParam->cgm, $dadosObras[0]);
            $eventoFila->adicionarFila();

            $oRetorno->sMessage = "Dados do empregador agendado para envio.";
            break;

        case Tipo::RUBRICA:

            $dadosESocial = new DadosESocial();

            $dao = new cl_db_config();
            $sql = $dao->sql_query_file(null, "numcgm", null, "codigo = " . db_getsession("DB_instit"));

            $rs = db_query($sql);
            $iCgm = db_utils::fieldsMemory($rs, 0)->numcgm;

            $dadosESocial->setReponsavelPeloPreenchimento($iCgm);
            $dadosDoPreenchimento = $dadosESocial->getPorTipo(Tipo::RUBRICA);

            $formatter = FormatterFactory::get(Tipo::S1010);
            $dadosTabelaRubricas = $formatter->formatar($dadosDoPreenchimento);

            /**
             * Limitado array em 50 pois e o maximo que um lote pode enviar
             */
            foreach (array_chunk($dadosTabelaRubricas, 50) as $aTabelaRubricas) {
                $eventoFila = new Evento(Tipo::S1010, $iCgm, $iCgm, $aTabelaRubricas);
                $eventoFila->adicionarFila();
            }

            $oRetorno->sMessage = "Dados das Rúbricas agendados para envio.";
            break;

        case "agendarLotacaoTributaria":

            $dadosESocial = new DadosESocial();

            $dadosESocial->setReponsavelPeloPreenchimento($oParam->cgm);
            $dadosDoPreenchimento = $dadosESocial->getPorTipo(Tipo::LOTACAO_TRIBUTARIA);

            $formatter = FormatterFactory::get(Tipo::S1020);
            $dadosLotacaoTributaria = $formatter->formatar($dadosDoPreenchimento);

            $eventoFila = new Evento(TIPO::S1020, $oParam->cgm, $oParam->cgm, $dadosLotacaoTributaria[0]);
            $eventoFila->adicionarFila();


            $oRetorno->sMessage = "Dados das Lotações Tributárias agendados para envio.";
            break;

        case "transmitir":

            $dadosESocial = new DadosESocial();

            db_inicio_transacao();

            $iCgm = $oParam->empregador;

            foreach ($oParam->arquivos as $arquivo) {

                $dadosESocial->setReponsavelPeloPreenchimento($iCgm);
                $dadosDoPreenchimento = $dadosESocial->getPorTipo(Tipo::getTipoFormulario($arquivo));
                // var_dump($dadosDoPreenchimento);
                // exit;
                $formatter = FormatterFactory::get($arquivo);
                $dadosTabela = $formatter->formatar($dadosDoPreenchimento);
                // var_dump($dadosTabela);
                // exit;
                /**
                 * Limitado array em 50 pois e o maximo que um lote pode enviar
                 */
                foreach (array_chunk($dadosTabela, 50) as $aTabela) {
                    $eventoFila = new Evento($arquivo, $iCgm, $iCgm, $aTabela, $oParam->tpAmb, "{$oParam->iAnoValidade}-{$oParam->iMesValidade}");
                    $eventoFila->adicionarFila();
                }
            }

            db_fim_transacao(false);
            ob_start();
            $response = system("php -q filaEsocial.php");
            ob_end_clean();
            $oRetorno->sMessage = "Dados agendados para envio.";
            break;

        case "consultar":

            $clesocialenvio = db_utils::getDao("esocialenvio");
            $oRetorno->lUpdate = $clesocialenvio->checkQueue();
            break;
    }
} catch (Exception $eErro) {
    if (db_utils::inTransaction()) {
        db_fim_transacao(true);
    }
    $oRetorno->iStatus  = 2;
    $oRetorno->sMessage = $eErro->getMessage();
}

$oRetorno->erro = $oRetorno->iStatus == 2;
echo JSON::create()->stringify($oRetorno);
