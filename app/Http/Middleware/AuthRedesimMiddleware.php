<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Support\Facades\Log;

/**
 * Class AuthRedesimMiddleware
 * @package App\Http\Middleware
 */
class AuthRedesimMiddleware
{

    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle($request, Closure $next)
    {
        Log::useDailyFiles(storage_path()."/logs/redesim/autenticacao/log.log");

        if (!$request->headers->get("accessKeyId")) {
            Log::warning("[REDESIM Middleware] Header accessKeyId n�o informado.");
            throw new Exception("Header accessKeyId n�o informado.");
        }

        if (!env("REDESIM_ACCESS_KEY_ID")) {
            Log::warning("[REDESIM Middleware] Chave REDESIM_ACCESS_KEY_ID n�o configurada no arquivo .env!");
            throw new Exception("Chave accessKeyId n�o configurada.");
        }

        if ($request->headers->get("accessKeyId") != env("REDESIM_ACCESS_KEY_ID")) {
            $sLogMessage = "[REDESIM Middleware] Credenciais inv�lidas ";
            $sLogMessage .= "[header accessKeyId: {$request->headers->get("accessKeyId")}";
            $sLogMessage .= " / Chave REDESIM_ACCESS_KEY_ID: ".env("REDESIM_ACCESS_KEY_ID")."]";

            Log::warning($sLogMessage);
            throw new Exception("Credenciais inv�lidas.", 401);
        }

        return $next($request);
    }
}
