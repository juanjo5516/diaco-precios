<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class adminMiddleware
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

        $userId = auth()->user()->id_usuario;
        $Permiso = DB::table('diaco_usuario_perfil')
                    ->join('diaco_perfiles_puesto','diaco_perfiles_puesto.id_perfil_puesto','=','diaco_usuario_perfil.id_perfil_puesto')
                    ->select('diaco_perfiles_puesto.perfil')
                    ->where('diaco_usuario_perfil.id_usuario','=',$userId)
                    ->get();
        // if(auth()->check())

        foreach ($Permiso as $key ) {
            if ($key->perfil == 'Administrador') {
                // $admin = 'Administrador2';
                $admin = $key->perfil;
            }else{
                $admin = '';
            }
        }

        
        if($admin == 'Administrador'){
            return $next($request);
        }else{
            return redirect('/');
        }
    }
}
