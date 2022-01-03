<?php

use Illuminate\Support\Facades\Route;
use Laravel\Socialite\Facades\Socialite;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});



Route::get('/login/github', function () {
    return Socialite::driver('github')
        ->scopes(['read:user', 'public_repo'])
        ->redirect();
});

Route::get('/auth/github/callback', function () {
    $githubUser = Socialite::driver('github')->user();

    var_dump($githubUser);
});