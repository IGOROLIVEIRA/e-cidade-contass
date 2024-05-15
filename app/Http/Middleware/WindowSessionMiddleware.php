<?php

namespace App\Http\Middleware;

use Closure;
use ECidade\Lib\Session\DefaultSession;
use ECidade\V3\Window\Session;
use Illuminate\Http\Request;

/**
 * Class SessionMiddleware
 * @package App\Http\Middleware
 */
class WindowSessionMiddleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     * @throws Exception
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->header('X-Window-Session', '') !== '') {
            $this->startSession($request->header('X-Window-Session'));
        }

        return $next($request);
    }

    /**
     * Restaura a sess�o da window
     *
     * @param integer $id
     * @return void
     */
    private function startSession($id)
    {
        $session = new Session($id);
        $session->writeable(true);
        $session->destroy();
        $session->create();
        $session->start();
        session($_SESSION);
        DefaultSession::getInstance()->addFromRequest($_SESSION);
    }
}
