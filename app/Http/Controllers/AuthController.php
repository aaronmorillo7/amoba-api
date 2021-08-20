<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use App\Models\User;
use App\Models\Profile;
use Illuminate\Support\Carbon;
use Validator;
class AuthController extends ApiController
{
    //create user
    public function store(Request $request){
        
        $validator = Validator::make($request->all(),[
            'first_name'=>'required',
            'last_name'=>'required',
            'description' => 'required',
            'photo' => 'required'
        ]);

        if ($validator->fails()) {  
            // return "Error";
            return $this->sendError(
                    'Error de validacion',
                    $validator->errors(),
                    422);
        }

        $user = new User;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->description = $request->description;
        $user->save();

        $profile = new Profile;
        $profile->ima_profile = $request->photo;
        $profile->user_id = $user->id;

        $profile->save();

        $data = [
            'user'=>$user
        ];

        return $this->sendRespons($data, "Usuario creado exitosamente");
    }
    //update users
    public function update(Request $request){
        $user = User::where(['id' => $request->id, 'deleted_at' => null] )->first();

        if( is_null($user) ){
            return $this->sendError('No se encontro el usuario');
        }

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->description = $request->description;
        $user->save();

        $data = [
            'user'=>$user
        ];

        return $this->sendRespons($data, "Usuario " . $user->id . " actualizado");

    }
    //show users
    public function show(){
        $users = User::where(['deleted_at' => null])->get();

        if(is_null($users)){
            return $this->sendError('No usuarios disponibles');
        }
        foreach($users as $user){
            $user->photo = $user->profile();
        }

        $data = [
            'users'=>$users           
        ];

        return $this->sendRespons($data, "Lista de usuarios mostrada");
    }
    //update user
    public function delete($id){
        $user = User::where(['id' => $id])->first();
        $user->delete();

        if(is_null($user)){
            return $this->sendError('El usuario no existe, o ya fue borrado.');
        }

        $data = [
            'user'=>$user
        ];

        return $this->sendRespons($data, "Usuario eliminado");
    }
}
