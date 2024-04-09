<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\Controller;
use App\Models\PasswordReset;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\URL as FacadesURL;
use Illuminate\Support\Str;


class AuthController extends Controller
{
    /**
     * Create a new AuthController instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register','forgetPassword','resetPassword']]);
    }

    /**
     * Register new user.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(Request $request){
        $validate = Validator::make($request->all(), [
            'name'      => 'required',
            'email'     => 'required|email|unique:users',
            'password'  => 'required|min:4|confirmed',
            'type_document'  => 'required',
            'number_document'  => 'required|numeric|unique:users',
            'adress_all'  => 'required',
            'stated'  => 'required',
            // 'municipality'  => 'required',
            'street'=>'required'
        ], [], [
            'name' => 'nombre',
            'email' => 'correo',
            'password' => 'contraseña',
            'type_document' => 'tipo de documento',
            'number_document' => 'numero de documento',
            'adress_all' => 'direccíon',
            'stated' => 'estado',
            'street' => 'calle',
            // 'municipality' => 'municipio',
        ]);
        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }
        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->status = 'Active';
        $user->email_verified_at = now();
        $user->adress_all = $request->adress_all;
        $user->type_document = $request->type_document;
        $user->number_document = $request->number_document;
        $user->stated = $request->stated;
        $user->municipality = $request->municipality;
        $user->street = $request->street;
        $user->save();
        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'email'     => 'required|email',
            'password'  => 'required',
        ], [], [
            'email' => 'correo',
            'password' => 'contraseña',
        ]);

        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }
        $credentials = request(['email', 'password']);

        if (! $token = auth()->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized','message'=>"Verifique sus datos"], 401);
        }

        return $this->respondWithToken($token, $request->email);
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $email)
    {
        $user = User::select('users.*','menuroles as roles')->where('email', '=', $email)->first();

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'roles' => $user->roles,
            'email' => $email,
            'name' => $user->name,
            'id' => $user->id,
        ]);
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function forgetPassword(Request $request) {
        // return response($request);
        try {

            $validate = Validator::make($request->all(), [
                'email'     => 'required|email',
            ], [], [
                'email' => 'correo',
            ]);

            if ($validate->fails()){
                return response()->json([
                    'status' => 'error',
                    'errors' => $validate->errors()
                ], 422);
            }

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['message' => 'El email proporcionado no pertenece a ningún usuario','return'=>false], 200);
            }

            $token = Str::random(100);

            // $user->update(['remember_token' => $token]);

            $domain = Controller::LINK_CLIENT;
            $url = $domain."#/reset-password/".$token."/".$user->id;

            $data['url']= $url;
            $data['user']= $user;
            $data['title']= "Cambio de contraseña";
            $data['body']= "Porfavor haz click aqui para cambiar contraseña";


            $data['adress_company']= "1912  Mcwhorter Road, FL 11223";
            $data['phone_company']= "+58412-000-00-00";
            $data['email_company']= "empresa@gmail.com";

            $data['link_facebook']= "#";
            $data['link_twitter']= "#";
            $data['link_instagram']= "#";
            $data['link_linkedin']= "#";


            Mail::send('email.forgot_password', $data, function ($message) use ($user) {
                $message->to($user->email)->subject('Recuperar contraseña');
            });

            $datetime = date('Y-m-d H:i:s');

            PasswordReset::updateOrCreate(['email'=>$request->email],[
                'email'=>$request->email,
                'token'=>$token,
                'created_at'=>$datetime
            ]);

            return response()->json(['message' => 'Correo de recuperación de contraseña enviado','return'=>true]);


        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }


     /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function resetPassword(Request $request){
        $validate = Validator::make($request->all(), [
            'password'  => 'required|min:4|confirmed',
            'password_confirmation'  => 'required|min:4',
        ], [], [
            'password' => 'contraseña',
            'password_confirmation' => 'confirmar contraseña',
        ]);
        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }



        $verificar_token = PasswordReset::where('token', $request->token)->first();

        if ($verificar_token) {
            $created_at = $verificar_token->created_at;
            $hora_expiracion = $created_at->addHour(); // Añade una hora a la hora de creación

            if (Carbon::now()->gt($hora_expiracion)) {
                // Token ha expirado
                return response()->json(['status' => 'error',"return"=>false,"message"=>"Link de cambio contraseña expió"], 200);
            } else {
                // Token válido
                $user = User::find($request->user_id);
                if (!$user) {
                    return response()->json(['message' => 'Usuario no encontrado'], 404);
                }

                $user->password = bcrypt($request->password);
                $user->save();

                PasswordReset::where('token', $request->token)->delete();

                return response()->json(['status' => 'success',"return"=>true,"message"=>"Contraseña actualizada con éxito."], 200);
            }
        } else {
            // Token no encontrado
            return response()->json(['message' => 'Link de cambio contraseña expió, o ya fue útilizado.'], 404);
        }





    }
}
