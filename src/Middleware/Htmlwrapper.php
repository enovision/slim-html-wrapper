<?php

namespace Enovision\Slim\HTMLWrapper\Middleware;

use Psr\Http\Message\ServerRequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Htmlwrapper
{
    public function __invoke(Request $request, Response $response, callable $next)
    {
        $before = "
           <!DOCTYPE html PUBLIC \"-//W3C//DTD XHTML 1.0 Transitional//EN\" \"http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd\">
           <html>
           <head>
           <script src=\"https://code.jquery.com/jquery-3.1.1.min.js\"
                   integrity=\"sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=\"
                   crossorigin=\"anonymous\">
           </script>
           </head>
           <body>";

        $after = '</body></html>';

        if (!$this->isAjax()) {
            $response->getBody()->write($before);
        }

        $response = $next($request, $response);

        if (!$this->isAjax()) {
            $response->withHeader('Content-Type', 'text/html');
            $response->getBody()->write($after);
        }

        return $response;
    }

    private static function isAjax()
    {
        return (
            !empty($_SERVER['HTTP_X_REQUESTED_WITH'])
            && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');
    }
}
