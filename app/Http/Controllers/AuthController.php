<?php

namespace App\Http\Controllers;

use App\Models\RelacGrupoUsuarios;
use App\Models\User;
use App\Traits\HttpResponse;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    use HttpResponse;

    public function login(Request $request)
    {
        //dd($request);

        if (Auth::attempt($request->only('login', 'password'))) {

            /*$query = RelacGrupoUsuarios::query();
            $query->select(
                'grupo_usuarios.nome',
                'grupo_usuarios.obra',
                'relac_grupo_usuarios.perfil',
                'relac_grupo_usuarios.tipoPedido',
                'relac_grupo_usuarios.subGrupo',
                'relac_grupo_usuarios.valorMin',
                'relac_grupo_usuarios.valorMax')->
            join('grupo_usuarios', 'grupo_usuarios.id', '=', 'relac_grupo_usuarios.grupo_id')->
            where('relac_grupo_usuarios.usuario_id', '=', $request->user()->id);
            $dados = $query->get();*/

            $user = auth()->user();
            $autenticacao = 'solicitante,';
            if ($user) {
                $autenticacao = $user->autenticacao ?? null;
            }
            $habilidade = explode(',', $autenticacao);
            return $this->response('Autorizado', 200, [
                'token' => $request->user()->createToken('TokenLogin', $habilidade)->plainTextToken,
                'user' => $request->user(),
                //'grupo' => $dados,
            ]);
        }

        return $this->response('Não Autorizado', 403);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return $this->response('Token Revogado', 200);
    }

    public function autenticacao(Request $request)
    {

        $teste = Auth::check();

        return $this->response('Token Autorizado', 200, [$teste]);
    }

    public function redefinirSenha(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:6|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));

                $user->save();

                event(new PasswordReset($user));
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('status', __($status))
            : back()->withErrors(['email' => [__($status)]]);
    }
}
