<?php

namespace App\Http\Middleware;


use Closure;
use App\ProcessCategory;

class CheckForProcessesPermission
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
        $c = $request->route('category');
        $p = $request->route('process');

        $category = ((!empty($c)) ? $c : ((!empty($p)) ? $p->category : null));


        $user = $request->user();

        if (empty($category)) {
            return redirect()->route('categories.index')
                ->with('type', 'alert-danger')
                ->with('msg', 'Categoria inválida');
        }

        if ($category->visibility != ProcessCategory::PUBLIC_PERMISSION && !in_array($user->id, $category->permission['users']) && !$user->isVIP() && !$user->isCommitteeMember()) {
            return redirect()->route('categories.index')
                ->with('type', 'alert-danger')
                ->with('msg', 'Você não possuí autorização para acessar os processos/reviões dessa categoria.');
        }

        return $next($request);
    }
}
