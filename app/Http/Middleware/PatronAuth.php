<?php

namespace App\Http\Middleware;

use Closure;

class PatronAuth
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

        if(!\Auth::guard('patrons')->check()){
            config()->set('cas.cas_redirect_path', \Request::url());
            cas()->authenticate();


            $user = \App\Models\Patron::whereNetid(cas()->getCurrentUser())->first();

            if(is_null($user)){
                $user = \App\Models\Patron::create([
                    'netid' => cas()->getCurrentUser()
                ]);
            }

            auth()->guard('patrons')->login($user);

            if(\Route::currentRouteName() != 'register' && strlen(auth()->guard('patrons')->user()->email) < 3){
               return redirect()->to( route('register') );
            }
        }else{
            if(\Route::currentRouteName() != 'register' && strlen(auth()->guard('patrons')->user()->email) < 3){
                return redirect()->to( route('register') );
            }
        }

        return $next($request);
    }
}
