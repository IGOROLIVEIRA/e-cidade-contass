<?php

use App\Providers\RouteServiceProvider;
use DBSeller\Legacy\PHP53\Emulate;
use ECidade\Api\V1\APIServiceProvider;
use Silex\Application;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Silex\Provider\ServiceControllerServiceProvider;
use \ECidade\V3\Extension\Registry;
use \ECidade\V3\Extension\Front;
use \ECidade\V3\Extension\Request as EcidadeRequest;


require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . 'bootstrap.php');

// @todo Revisar essa logica
// Criamos um request fake para poder utilizar o recursos dos modifications.

$_SERVER['REQUEST_URI'] = preg_replace('/(.*?)\/w\/\d+(.*)/', '$1$2', $_SERVER['REQUEST_URI']);

$front = new Front();
$request = Request::createFromGlobals();
$ecidadeRequest = new EcidadeRequest($front->getPath());
Registry::set('app.request', $ecidadeRequest);
$front->createWindow();

$app = new Application();
$app['request'] = $request;
$app['debug'] = true;

$app['class.loader'] = Registry::get('app.loader');

// Registra eventos adicionado ao cache(metadado)
Registry::get('app.container')->get('app.configData')->loadEvents();

Emulate::registerLongArrays();

if (!ini_get('register_globals')) {
    Emulate::registerGlobals();
}

// app authentication
$app->before(function (Request $request, Application $app) {
    Registry::get('app.request')->session()->start();
    $_SESSION['DB_login'] = 'dbseller';
    $_SESSION['DB_id_usuario'] = 'dbseller';
    $_SESSION['DB_servidor'] = 'localhost';
    $_SESSION['DB_base'] = 'pmburitizeiro';
    $_SESSION['DB_user'] = 'dbportal';
    $_SESSION['DB_porta'] = '5432';
    $_SESSION['DB_senha'] = 'dbportal';
    $_SESSION['DB_administrador'] = '1';
    $_SESSION['DB_modulo'] = '578';
    $_SESSION['DB_nome_modulo'] = 'Configurações';
    $_SESSION['DB_anousu'] =  date('Y', time());
    $_SESSION['DB_uol_hora'] = time();
    $_SESSION['DB_instit'] = 1;

    /**
     * @see https://tools.ietf.org/html/rfc7235#section-3.1
     */
    if (empty($_SESSION) || empty($_SESSION['DB_login'])) {
        throw new AccessDeniedHttpException('Sessão invíalida ou expirada. Tente logar novamente.');
    }

    require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "libs/db_stdlib.php");
    require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "libs/db_conecta.php");
    require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "libs/db_sessoes.php");

    Registry::get('app.request')->session()->close();
});

// app api version1 routes
$app->register(new APIServiceProvider(), array(
    'ecidade_api.mount_prefix' => '/api/v1'
));

// app error handling
$app->error(function (\Exception $e, $code) use ($app) {

    $response = array(
        "statusCode" => $code,
        "message" => \DBString::utf8_encode_all($e->getMessage())
    );

    if ($app['debug']) {
        $response["stacktrace"] = $e->getTraceAsString();
    }

    return new JsonResponse($response);
});

$app->run();
