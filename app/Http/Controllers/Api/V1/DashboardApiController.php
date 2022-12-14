<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class DashboardApiController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = $request->user();

        return view('dashboard', [
            'tokens' => $user->tokens
        ]);
    }

    public function showTokenForm()
    {
        return view('token.token-create');
    }

    public function createToken(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);
        $tokenName = $request->post('name');

        $user = $request->user();
        $token = $user->createToken($tokenName);

        return view('token.token-show', [
            'tokenName' => $tokenName,
            'token' => $token->plainTextToken
        ]);
    }

    public function deleteToken(PersonalAccessToken $token)
    {
        $token->delete();

        return redirect('dashboard');
    }
}
