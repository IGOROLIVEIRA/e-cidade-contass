<?php

use DBSeller\Legacy\PHP53\Emulate;
use ECidade\Api\V1\APIServiceProvider;
use Silex\Application;
use Symfony\Component\Debug\ErrorHandler;
use Symfony\Component\Debug\ExceptionHandler;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
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
$app['debug'] = false;

/**
 * Converting Errors to Exceptions
 * @see https://github.com/silexphp/Silex/blob/master/doc/cookbook/error_handler.rst#converting-errors-to-exceptions
 */
ExceptionHandler::register($app['debug']);

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
    $_SESSION['DB_id_usuario'] = '1';
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
    $_SESSION['DB_acessado'] = '1325613';
    $_SESSION['DB_datausu'] = time();
    $_SESSION['DB_ip'] = '127.0.0.1';

    $eloquent = new EloquentBootstrap(
        $_SESSION['DB_servidor'],
        $_SESSION['DB_base'],
        $_SESSION['DB_user'],
        $_SESSION['DB_senha'],
        $_SESSION['DB_porta']
    );

    $eloquent->bootstrap();

    /**
     * End Eloquent bootstrap
     */

    /**
     * @see https://tools.ietf.org/html/rfc7235#section-3.1
     */
    if (empty($_SESSION) || empty($_SESSION['DB_login'])) {
        throw new AccessDeniedHttpException('Sessão invíalida ou expirada. Tente logar novamente.');
    }

    require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "libs/db_stdlib.php");
    require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "libs/db_conecta.php");
    require_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "libs/db_sessoes.php");

    global $conn;
    $conn = pg_connect("host={$_SESSION['DB_servidor']} dbname={$_SESSION['DB_base']} port={$_SESSION['DB_porta']} user={$_SESSION['DB_user']} password={$_SESSION['DB_senha']}");
    Registry::get('app.request')->session()->close();
});

/**
 * Parsing the request body
 * @see https://github.com/silexphp/Silex/blob/master/doc/cookbook/json_request_body.rst#parsing-the-request-body
 */
$app->before(function (Request $request) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
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
