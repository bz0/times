<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Enums\Provider;

use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Cookie;

class OAuthController extends Controller
{
    /**
     * （各認証プロバイダーの）OAuth認可画面URL取得API
     * @param string $provider 認証プロバイダーとなるサービス名
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProviderOAuthURL(string $provider)
    {
        $redirectUrl = Socialite::driver($provider)
                            ->scopes(['read:user', 'public_repo'])
                            ->redirect()
                            ->getTargetUrl();
        
        return response()->json([
            'redirect_url' => $redirectUrl,
        ]);
    }

    public static function generateToken()
    {
        return Str::random(80);
    }

     /**
     * ソーシャルログイン処理
     * @return App\User
     */
    public static function handleProviderCallback()
    {
        $githubUser = Socialite::driver('github')->stateless()->user();

        $user  = User::where('github_id', $githubUser->id)->first();
        $token = self::generateToken();
        
        if ($user) {
            $user->update([
                'name' => $githubUser->name,
                'email' => $githubUser->email,
                'bio' => $githubUser->user['bio'],
                'avatar_url' => $githubUser->user['avatar_url'],
                'github_token' => $githubUser->token,
                'github_refresh_token' => $githubUser->refreshToken,
                'api_token' => hash('sha256', $token)
            ]); //プロフィール変更したら更新されるようにするため
        } else {
            $user = User::create([
                'name' => $githubUser->name,
                'email' => $githubUser->email,
                'provider' => Provider::GITHUB,
                'bio' => $githubUser->user['bio'],
                'avatar_url' => $githubUser->user['avatar_url'],
                'github_id' => $githubUser->id,
                'github_token' => $githubUser->token,
                'github_refresh_token' => $githubUser->refreshToken,
                'api_token' => hash('sha256', $token)
            ]);
        }
    
        Auth::login($user);
    
        $cookie = cookie('api_token', $token, '10000000', null, null, null, false);
        return redirect('http://localhost:3000')->cookie($cookie);
    }
}

