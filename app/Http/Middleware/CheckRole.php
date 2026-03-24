<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Middleware CheckRole
 *
 * Verifica que el usuario autenticado tenga al menos uno de los roles
 * recibidos como parámetro. Si no tiene sesión redirige al login.
 * Si tiene sesión pero no el rol requerido retorna error 403.
 */
class CheckRole
{
    /**
     * Maneja la solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  ...$roles  Roles permitidos separados por coma (ej: 'admin', 'trabajador')
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function handle(Request $request, Closure $next, string ...$roles): Response
    {
        // Si el usuario no está autenticado, redirige al login
        if (!$request->user()) {
            return redirect()->route('login');
        }

        $usuario = $request->user();

        // Obtiene los nombres de roles del usuario autenticado
        // La relación 'roles' devuelve una colección de objetos Rol
        $rolesUsuario = $usuario->roles->pluck('nombre')->toArray();

        // Verifica si el usuario tiene al menos uno de los roles requeridos
        foreach ($roles as $rolRequerido) {
            if (in_array($rolRequerido, $rolesUsuario)) {
                // El usuario tiene el rol, permite el acceso
                return $next($request);
            }
        }

        // El usuario no tiene ninguno de los roles requeridos → error 403 Forbidden
        abort(403, 'No tienes los permisos necesarios para acceder a esta sección.');
    }
}
