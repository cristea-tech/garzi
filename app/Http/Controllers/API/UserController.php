<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{

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
        return User::all();

       // return User::latest()->paginate(100);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users',
            'password' => 'required|string|min:3',
            'tip' => 'required'
        ]);

        return User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => Hash::make($request['password']),
            'tip'  => $request['tip'],
            'descriere' => $request['descriere']
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // return $request->all();
    }
    public function updateProfile(Request $request)
    {
        $user = auth('api')->user();

        $this->validate($request,[
            // existenta numelui este importanta dar nu este de tip unic
            'name' => 'required|string|max:100',
            // verific existenta emailului dar nu pentru userul curent !!! important
            // emailul este de tip unic
            'email' => 'required|string|email|max:100|unique:users,email,'.$user->id,
            // verific existenta parolei ... si specific ca uneori nu este necesara daca nu s-a momdificat
            'password' => 'sometimes|required|min:3'
        ]);

        // return ['message' => "Success"];
        // definesc o variabila in care stochez poza initiala pentru a o verifica ulterior cu cea incarcata
        // si pentru a putea stabili daca a fost modificata sau nu
        $currentPhoto = $user->photo;
        if($request->photo != $currentPhoto){
            // creez un string unic cu numele pozei
            // pentru asta folosesc functia time ce genereaza un string unic la data curenta
            // apoi concatenez cu extensia fisierului pe care o extrag din request
            // folosesc functia explode pentru a sparge textul photo in substringuri
            // intai caut dupa ';' si fac un string dintre pozitia 0 si pozitia lui ';'
            // apoi sparg stringul in elemente cu despartitor ':' si iau primul element gasit
            // apoi sparg stringul in elemente cu despartitor '/' si iau primul element gasit
            // rezultatul va fi de genul time_value.extension

            $name = time().'.'.explode('/', explode(':', substr($request->photo, 0, strpos($request->photo, ';')))[1])[1];
            // folosim image.intervention pentru a prelucra poza
            \Image::make($request->photo)->save(public_path('img/profile/').$name);

            // initializez valoarea transmisa prin request cu noul nume de fisier stocat pe server si prelucrat cu nume unic
            // si dupa iesirea din if, fac update pe campurile din tabela users

            // pentru a modifica o valoare din request folosesc functia merge
            $request->merge(['photo' => $name]);
            // daca userul a schimbat poza de profil o stergem pe cea veche
            // stochez numele si calea intro variabila
            $userPhoto = public_path('img/profile/').$currentPhoto;
            // verific daca fisierul exista in folder si i-l sterg
            if(file_exists($userPhoto)){
                @unlink($userPhoto);
            }

        };

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());
        return ['message'=> 'Success'];
    }

    public function profile()
    {
        return auth('api')->user();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $this->validate($request,[
            'name' => 'required|string|max:100',
            'email' => 'required|string|email|max:100|unique:users,email,'.$user->id,
            'password' => 'sometimes|min:3',
            'tip' => 'required'
        ]);

        if(!empty($request->password)){
            $request->merge(['password' => Hash::make($request['password'])]);
        }

        $user->update($request->all());

        return ['message' => 'updated informatii user'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authorize('isAdmin');

        // verific daca userul exista
        $user = User::findOrFail($id);
        // sterg userul
        $user->delete();
        return ['message' => 'Userul a fost sters!'];
    }
}
