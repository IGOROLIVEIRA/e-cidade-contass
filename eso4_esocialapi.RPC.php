<?php
require_once ('libs/db_stdlib.php');
require_once ('libs/db_utils.php');
require_once ('libs/db_app.utils.php');
require_once ('libs/db_conecta.php');
require_once ('libs/db_sessoes.php');
require_once ('dbforms/db_funcoes.php');
require_once ('libs/JSON.php');

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
            'url' => 'http://172.16.212.213/sped-esocial-master/run.php', // informe a api do eSocial
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
    'app.request.session.attachOn' => '*.php',

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
    db_inicio_transacao();

    switch ($oParam->exec) {
        case "getEmpregadores":
            $campos = ' distinct z01_numcgm as cgm, z01_cgccpf as documento, z01_nome as nome, r70_instit as instituicao';
            $dao = new cl_rhlota();
            $sql = $dao->sql_query_lota_cgm(null, $campos, 'z01_numcgm');

            $rs = db_query($sql);

            if (!$rs) {
                throw new DBException("Ocorreu um erro ao consultar os CGM vinculados as lotações.\nContate o suporte.");
            }

            if (pg_num_rows($rs) == 0) {
                throw new Exception("Não existe empregadores cadastrados na base.");
            }

            $oRetorno->empregadores = db_utils::getCollectionByRecord($rs);
            break;

        case "empregador":
            if (!file_exists($oParam->sPath)) {
                throw new Exception("Houve um erro ao realizar upload do arquivo. Tente novamente.");
            }

            $empregador = new \stdClass();
            $empregador->inscricao = $oParam->documento;
            $empregador->razao_social = $oParam->razao_social;
            $empregador->tipo_inscricao = strlen($oParam->documento) == 11 ? 'cpf' : 'cnpj';
            $empregador->senha = $oParam->senha;
            $empregador->certificado = base64_encode(file_get_contents($oParam->sPath));

            $exportar = new ESocial(Registry::get('app.config'), Recurso::CADASTRO_EMPREGADOR);
            $exportar->setDados(array($empregador));
            $retorno = $exportar->request();
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
    }
    db_fim_transacao(false);
} catch (Exception $eErro) {
    db_fim_transacao(true);
    $oRetorno->iStatus  = 2;
    $oRetorno->sMessage = $eErro->getMessage();
}

$oRetorno->erro = $oRetorno->iStatus == 2;
echo JSON::create()->stringify($oRetorno);
