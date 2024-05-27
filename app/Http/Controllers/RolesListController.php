<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;



class RolesListController extends Controller{

    public function list(){
        $roles = Role::all();
        return view('pages.roles-management', ["roles"=>$users]);
    }

    public function delete(Request $request){
        $id = $request->input('id');
        $user = User::where('id', $id)->get()->first();
        if(is_null($user)){
            return redirect()->back()->with('danger', "Ce compte n'existe pas.");   
            return;
        }
        if($user->id == Auth::user()->id){
            return redirect()->back()->with('danger', "Impossible de se supprimer soi-même.");   

        }
        if(!Auth::user()->hasPermissionTo("delete users") && !Auth::user()->hasPermissionTo("admin")){
            return redirect()->back()->with('danger', "Vous n'avez pas la permission d'effectuer cette action.");   
        }
        if($user->hasPermissionTo("bypass") && !Auth::user()->hasPermissionTo("admin")){
            return redirect()->back()->with('danger', "Vous n'avez pas la permission d'effectuer cette action.");   

        }

        $user->delete();
        return redirect()->back()->with('success', "Le compte de <b>$user->firstname $user->lastname</b> ($user->username) a bien été supprimé.");   


    }
    public function add(Request $req){
        $pseudo = $req->input("username");
        $email = $req->input("email");
        $firstname = $req->input("firstname");
        $lastname = $req->input("lastname");
        
        $attributes = request()->validate([
            'username' => 'required|max:255|min:2|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'firstname' => 'required|max:255|min:3',
            'lastname' => 'required|max:255|min:3',
            'password' => 'required|min:5|max:255'
        ]);

        if(Auth::user()->hasPermissionTo("create users") || Auth::user()->hasPermissionTo("admin")){
            User::create($attributes);
            $newUser = User::where("email", $email)->first()->assignRole("Membre");
            return redirect()->back()->with('success', "Le compte de <b>$firstname $lastname</b> ($pseudo) a bien été enregistré !");   

        }else{
            return redirect()->back()->with('danger', "Vous n'avez pas la permission d'effectuer cette action.");   
        }
    }

    public function edit(Request $req){
        $pseudo = $req->input("username");
        $firstname = $req->input("firstname");
        $lastname = $req->input("lastname");
        $attributes = [];

        if($req->input("password") != null){
            $attributes = request()->validate([
                'username' => ['required','max:255', 'min:2'],
                'firstname' => ['required', 'max:100'],
                'lastname' => ['required', 'max:100'],
                'email' => ['required', 'email', 'max:255',  Rule::unique('users')->ignore($req->input("id")),],
                'password' => 'required|min:5|max:255'
            ]);
            $attributes['password'] = bcrypt($req->input("password"));
        }else{
            $attributes = request()->validate([
                'username' => ['required','max:255', 'min:2'],
                'firstname' => ['required', 'max:100'],
                'lastname' => ['required', 'max:100'],
                'email' => ['required', 'email', 'max:255',  Rule::unique('users')->ignore($req->input("id")),],
            ]);
        }

        if(Auth::user()->hasPermissionTo("edit users") || Auth::user()->hasPermissionTo("admin")){
            $user = User::where("id", $req->input("id"));
            $user->update($attributes);
            return redirect()->back()->with('success', "Les modifications ont bien étées prises en compte !");   

        }else{
            return redirect()->back()->with('danger', "Vous n'avez pas la permission d'effectuer cette action.");   
        }
    }
    
}
