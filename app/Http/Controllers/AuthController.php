<?php

namespace App\Http\Controllers;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Tymon\JWTAuth\Facades\JWTAuth;


class AuthController extends Controller
{

    use ResponseTrait;
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'role' => 'required'
        ]);

        if ($validator->fails()) {
         return response()->json($validator->errors()->toJson(), 400);
        }


        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $token = JWTAuth::fromUser($user);

        return response()->json(['token' => $token, 'user' => $user], 201);
    }


    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (!$token = Auth::attempt($credentials)) {
            return $this->responseErrorWithCode(404, "Foydalanuvchi topilmadi");
        }

        $email = $request->email;
        $password = $request->password;
        $user = User::query()
            ->where('email', $email)
            ->first();

        if(!$user)
        {
            return $this->responseErrorWithCode(404, "Foydalanuvchi topilmadi");
        }

        if (Hash::check($password, $user->password)) {
            $token = JWTAuth::fromUser($user);
        }

        return $this->responseSuccess(['token' => $token, 'user' => $user]);

    }


    public function me()
    {
        return response()->json(Auth::user());
    }


    public function logout()
    {
        Auth::logout();
        return response()->json(['message' => 'Successfully logged out']);
    }


    public function refresh()
    {
        return response()->json([
            'token' => Auth::refresh()
        ]);
    }
}
