<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class ETag
{
    /**
     * Implement Etag support.
     *
     * @param \Illuminate\Http\Request $request The HTTP request.
     * @param \Closure                 $next    Closure for the response.
     *
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if (!$request->isMethod('get') && !$request->isMethod('head')) {
            return $next($request);
        }

        $initialMethod = $request->method();

        $request->setMethod('get');

        $response = $next($request);

        $content = $response->getContent();
        $content = json_decode($content, true);
        unset($content['meta']);
        $content = json_encode($content);

        $etag = md5(json_encode($response->headers->get('origin')) . $content);

        $requestEtag = str_replace('"', '', $request->getETags());

        if ($requestEtag && $requestEtag[0] === $etag) {
            $response->setNotModified();
        }

        $response->setEtag($etag);

        $request->setMethod($initialMethod);

        return $response;
    }
}