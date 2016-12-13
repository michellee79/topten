<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use App\MySession;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @var Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param  Guard  $auth
     * @return void
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = 0)
    {
        if ($this->auth->guest()) {
            return redirect()->guest('/login?redirect=' . $request->path());
        } else{
            if ($this->auth->user()->role < $role){
                return redirect()->guest('/login?redirect=' . $request->path());
            }
        }
        $response = $next($request);

        $path = $request->path();
        if (strpos($path, 'ajax') == false){
            MySession::set('prev_context', $request->path());
        }

        return $response;
    }
}
