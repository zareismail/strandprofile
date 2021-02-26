<?php  

namespace Zareismail\Strandprofile\Http\Middleware;
 
use Laravel\Nova\Nova;
use Laravel\Nova\Http\Middleware\ServeNova;

class RedirectToNova extends ServeNova
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        if(! $this->isNovaRequest($request) && $this->shoudRedirectToNova($request)) {
            return redirect(Nova::path());
        }

        return $next($request);
    }

    /**
     * Determine if the path should redirect to nova.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return boolean          
     */
    public function shoudRedirectToNova($request)
    {
        return collect($this->exceptedPaths())->filter(function($path) use ($request) {
            return $request->is($path) || $request->is("{$path}/*");
        })->isEmpty();
    }

    public function exceptedPaths()
    {
        return [
            'user', 'references', '_debugbar'
        ];
    }
}
