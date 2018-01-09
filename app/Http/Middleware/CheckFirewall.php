<?php

namespace App\Http\Middleware;

use App\Firewall;
use Closure;
use Illuminate\Support\Facades\Auth;
use Session;
use App\FirewallPrivileges;

class CheckFirewall
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
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        $acces = Firewall::where('ip_address', $ip)->first();

        // if (preg_match('/^10\.200\.46\..*$/', $ip))  {
        // 	   $acces = 1;
        // }

        $firewall_privileges_check = FirewallPrivileges::where('user_id', '=', Auth::user()->id)->first();

        if ($firewall_privileges_check == null)
        {
            if(is_null($acces)) {
                Auth::logout();
                Session::flash('message', 'Logujesz się ze złej lokalizacji!');
                return redirect('login');
            }else{
                return $next($request);
            }
        }else{
            return $next($request);
        }

    }
}
