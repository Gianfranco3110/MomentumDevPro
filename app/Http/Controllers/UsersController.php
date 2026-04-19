<?php

namespace App\Http\Controllers;

use App\Models\PasswordReset;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\userCourses;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL as FacadesURL;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use PharIo\Manifest\Url;

class UsersController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $you = auth()->user()->id;
        // $users = DB::table('users')
        // ->select('users.id', 'users.name','users.number_document','users.type_document','users.adress_all', 'users.email', 'users.menuroles as roles', 'users.status', 'users.email_verified_at as registered')
        // ->whereNull('deleted_at')
        // ->get();
        // foreach ($users as $key => $value) {
        //     $users[$key]->count_cursos = userCourses::where('usuario_id', $value->id)->count();
        // }

        $users = User::select('id', 'name', 'number_document', 'type_document', 'adress_all', 'email', 'menuroles as roles', 'status', 'email_verified_at as registered')
        ->whereNull('deleted_at')
        ->withCount('userCourses')
        ->get();
        return response()->json( compact('users', 'you') );
    }

    public function userLogged()
    {
        $you = auth()->userOrFail()->id;
        $users = DB::table('users')
        ->select('users.name', 'users.email', 'users.menuroles as roles')
        ->where('users.id','=',$you)
        ->get();
        return response()->json( compact('users', 'you') );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $user = DB::table('users')
        ->select('users.id', 'users.name', 'users.email', 'users.menuroles as roles', 'users.status', 'users.email_verified_at as registered')
        ->where('users.id', '=', $id)
        ->first();
        return response()->json( $user );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = DB::table('users')
        ->select('users.id', 'users.name','users.email','users.stated', 'users.municipality','users.street', 'users.menuroles as roles', 'users.status','users.number_document','users.type_document','users.adress_all')
        ->where('users.id', '=', $id)
        ->first();
        return response()->json( $user );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    public function updatePassword(Request $request){
        $validate = Validator::make($request->all(), [
            'password'  => 'required|min:4|confirmed',
        ], [], [
            'password' => 'contraseña',
        ]);
        if ($validate->fails()){
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }
        $user_id = auth()->user()->id;
        $user = User::find($user_id);

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json(['status' => 'success'], 200);
    }


    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'name'       => 'required|min:1|max:256',
            'email'      => 'required|email|max:256',
            'adress'      => 'required',
            'type_document'      => 'required|max:1',
            'number_document'      => 'required|numeric',
            'street'      => 'required',
            'stated'      => 'required',
        ]);
        $user = User::find($id);
        $user->name       = $request->input('name');
        $user->email      = $request->input('email');
        $user->adress_all      = $request->input('adress');
        $user->type_document      = $request->input('type_document');
        $user->number_document      = $request->input('number_document');
        $user->street      = $request->input('street');
        $user->stated      = $request->input('stated');
        $user->municipality      = $request->input('municipality');
        $user->save();
        //$request->session()->flash('message', 'Successfully updated user');
        return response()->json( ['status' => 'success',"message"=>"Usuario editado correctamente."] );
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = User::find($id);
        if($user){
            $user->delete();
        }
        return response()->json( ['status' => 'success'] );
    }


    public function getOwnProfile()
    {
        $userId = auth()->user()->id;
        $user = DB::table('users')
            ->select(
                'users.id', 'users.name', 'users.email', 'users.country',
                'users.stated', 'users.municipality', 'users.street',
                'users.adress_all', 'users.type_document', 'users.number_document',
                'users.photo'
            )
            ->where('users.id', '=', $userId)
            ->first();
        return response()->json($user);
    }

    public function updateOwnProfile(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'name'            => 'required|min:1|max:256',
            'country'         => 'nullable|max:256',
            'stated'          => 'nullable|max:256',
            'municipality'    => 'nullable|max:256',
            'street'          => 'nullable|max:256',
            'adress_all'      => 'nullable',
            'type_document'   => 'nullable|max:1',
            'number_document' => 'nullable|numeric',
        ], [], [
            'name' => 'nombre',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }

        $userId = auth()->user()->id;
        $user   = User::find($userId);

        $user->name            = $request->input('name');
        $user->country         = $request->input('country');
        $user->stated          = $request->input('stated');
        $user->municipality    = $request->input('municipality');
        $user->street          = $request->input('street');
        $user->adress_all      = $request->input('adress_all');
        $user->type_document   = $request->input('type_document');
        $user->number_document = $request->input('number_document');
        $user->save();

        return response()->json(['status' => 'success', 'message' => 'Perfil actualizado correctamente.']);
    }

    public function uploadPhoto(Request $request)
    {
        $validate = Validator::make($request->all(), [
            'photo' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($validate->fails()) {
            return response()->json([
                'status' => 'error',
                'errors' => $validate->errors()
            ], 422);
        }

        $userId = auth()->user()->id;
        $user   = User::find($userId);

        $ext      = $request->file('photo')->getClientOriginalExtension();
        $fileName = 'user_' . $userId . '.' . $ext;
        $destDir  = public_path('imgprofile');

        if (!file_exists($destDir)) {
            mkdir($destDir, 0755, true);
        }

        $request->file('photo')->move($destDir, $fileName);

        $photoUrl    = '/imgprofile/' . $fileName;
        $user->photo = $photoUrl;
        $user->save();

        return response()->json(['status' => 'success', 'photo_url' => $photoUrl]);
    }

    public function forgetPassword(Request $request) {
        return response($request);
        try {
            $request->validate(['email' => 'required|email']);

            $user = User::where('email', $request->email)->first();

            if (!$user) {
                return response()->json(['error' => 'El email proporcionado no pertenece a ningún usuario'], 404);
            }

            $token = Str::random(60);
            $user->update(['remember_token' => $token]);

            $domain = FacadesURL::to('/');
            $url = $domain."/reset-password?token?=".$token;

            $data['url']= $url;
            $data['email']= $request->email;
            $data['title']= "Cambio de contraseña";
            $data['body']= "Porfavor haz click aqui para cambiar contraseña";

            Mail::send('emails.forgot_password', ['token' => $token], function ($message) use ($user) {
                $message->to($user->email)->subject('Recuperar contraseña');
            });

            $datetime = Carbon::row()->format('Y-m-d H:i:s');

            PasswordReset::updateOrCreate(['email'=>$request->email],[
                'email'=>$request->email,
                'token'=>$token,
                'created_ad'=>$datetime
            ]);

            return response()->json(['message' => 'Correo de recuperación de contraseña enviado']);


        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }
}
