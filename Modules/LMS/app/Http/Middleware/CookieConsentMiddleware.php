<?php

namespace Modules\LMS\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CookieConsentMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */

    public function handle($request, Closure $next)
    {
        $response = $next($request);
        if (!config('lms.cookie_enabled')) {
            return $response;
        }

        if (! $response instanceof Response) {
            return $response;
        }

        if (! $this->containsBodyTag($response)) {
            return $response;
        }



        return $this->addCookieConsentScriptToResponse($response);
    }

    protected function containsBodyTag(Response $response): bool
    {

        return $this->getLastClosingBodyTagPosition($response->getContent()) !== false;
    }

    protected function addCookieConsentScriptToResponse(Response $response): Response
    {
        $content = $response->getContent();



        $closingBodyTagPosition = $this->getLastClosingBodyTagPosition($content);

        $content = ''
            . substr($content, 0, $closingBodyTagPosition) . view('theme::cookie.index')->render()
            . substr($content, $closingBodyTagPosition);



        return $response->setContent($content);
    }

    protected function getLastClosingBodyTagPosition(string $content = ''): bool | int
    {


        return strripos($content, '<p class="d-none cookie"></p>');
    }
}
