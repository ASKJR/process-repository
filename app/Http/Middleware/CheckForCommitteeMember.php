<?php

namespace App\Http\Middleware;

use Closure;

class CheckForCommitteeMember
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$request->user()->isCommitteeMember()) {
            return redirect()->route('categories.index')
                ->with('type', 'alert-danger')
                ->with('msg', 'Somente os membros do comitê de gestão de processos podem realizar essa ação.');
        }
        return $next($request);
    }
}
