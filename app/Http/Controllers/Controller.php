<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Date;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Controller as BaseController;
use stdClass;

class Controller extends BaseController
{
    protected $request;
    private $output;

    public function __construct(Request $request)
    {
        $this->request = $request;
        $this->output = new stdClass();
        $this->output->responseCode = '';
        $this->output->responseDesc = '';
    }

    public function setIfNotEmpty($object, $key, $value)
    {
        if (!empty($value)) {
            $object->$key = $value;
        }
    }

    public function login(Request $request)
    {
        $credentials = $request->only('username', 'password');

        if (auth()->attempt($credentials)) {
            $user = auth()->user();

            if ($user && Hash::check($request->password, $user->password)) {
                $cookieName = $request->username;
                $cookieValue = Cookie::get($cookieName);

                if (!$cookieValue || empty($user->api_token)) {
                    $user->api_token = Str::random(60); // Cookie is expired or not set, generate a new API token
                    $user->save();

                    Cookie::queue(Cookie::make($cookieName, Date::now(), 1440));
                }

                $token = $user->api_token;
                unset($user->api_token);

                $this->output->responseCode = "00";
                $this->output->responseDesc = "Sukses login";
                $this->output->responseData = ['token' => $token, 'user' => $user];
                return response()->json($this->output);
            }
        }

        $this->output->responseCode = "01";
        $this->output->responseDesc = "Unauthorized";
        return response()->json($this->output);
    }

    public function user(Request $request)
    {
        return response()->json(auth()->user());
    }
}
