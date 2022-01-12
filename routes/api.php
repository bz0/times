<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\OAuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:api')->get('/me', function (Request $request) {
    return $request->user();
});

Route::get('/login/{provider}', [OAuthController::class, 'getProviderOAuthURL'])
            ->where('provider', 'github')->name('oauth.request');

Route::get('/auth/{provider}/callback', [OAuthController::class, 'handleProviderCallback'])
            ->where('provider', 'github')->name('oauth.callback');