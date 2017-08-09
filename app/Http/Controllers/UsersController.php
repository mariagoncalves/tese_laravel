<?php

namespace App\Http\Controllers;

use App\Entity;
use App\EntType;
use App\Language;
use App\Role;
use App\RoleHasActor;
use App\RoleHasUser;
use App\User;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use phpDocumentor\Reflection\Types\Null_;
use Response;
use Auth;


class UsersController extends Controller{



    public function index()
    {
        return view('users');
    }



    public function getAll(Request $request, $id = null){
        if ($id == null) {
            if (auth()->user()) {
                $langid = auth()->user()->language_id;
            }else{
                $langid = 1;
            }
            if ($request->has('input_sort')) {
                    $orderThese = $request->input('input_sort') . ' ' . $request->input('type');
            }
            else {
                $orderThese = 'users.id desc';
            }
            $matchThese = [];
            if ($request->has('s_id')) {
                $matchThese[] = array('users.id','LIKE','%'.$request->input('s_id').'%');
            }
            if ($request->has('s_name')) {
                $matchThese[] = array('users.name','LIKE','%'.$request->input('s_name').'%');
            }
            if ($request->has('s_email')) {
                $matchThese[] = array('users.email','LIKE','%'.$request->input('s_email').'%');
            }
            if ($request->has('s_user_name')) {
                $matchThese[] = array('users.user_name','LIKE','%'.$request->input('s_user_name').'%');
            }
            if ($request->has('s_languageslug')) {
                $matchThese[] = array('language.slug','LIKE','%'.$request->input('s_languageslug').'%');
            }
            if ($request->has('s_user_type')) {
                $matchThese[] = array('users.user_type','LIKE','%'.$request->input('s_user_type').'%');
            }
            if ($request->has('s_entity')) {
                $matchThese[] = array('entity_name.name','LIKE','%'.$request->input('s_entity').'%');
            }
            if ($request->has('s_updated_at')) {
                $matchThese[] = array('users.updated_at','LIKE','%'.$request->input('s_updated_at').'%');
            }

                $users = DB::table('users')
                    ->leftjoin('language', 'users.language_id', '=', 'language.id')
                    ->leftjoin('entity', 'users.entity_id', '=', 'entity.id')
                    ->leftJoin('entity_name', function ($leftjoin) use ($langid){
                    $leftjoin->on('entity.id', '=','entity_name.entity_id' )
                        ->where('entity_name.language_id', '=',$langid);
                })
                    ->select('users.*',"entity.id as entity_id","entity_name.name as selentity","language.slug as languageslug")
                    ->where($matchThese)->whereNull('users.deleted_at')
                    ->orderByRaw($orderThese)
                    ->paginate(20);
            return response()->json($users);
        }else{
            return $this->getSpec($id);
        }
    }



    public function getSpec($id){
        $users = User::where('id',$id)->first();
        return response()->json($users);
    }



    public function insert(Request $request){
        $user = new User;

        $user->name = $request->input('name');
            $user->email = $request->input('email');
            $user->password = bcrypt($request->input('password'));
            $user->language_id = $request->input('language_id');
            $user->user_name = $request->input('user_name');
            $user->user_type = $request->input('user_type');
            if($request->input('entity_id')){
                $user->entity_id = $request->input('entity_id');
            }
            $user->save();

    }



    public function update(Request $request, $id){
        $user = User::find($id);
        $user->update([
            'name' => $request->input('name'),
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'language_id' => $request->input('language_id'),
            'user_name' => $request->input('user_name'),
            'user_type' => $request->input('user_type'),
        ]);
        if($request->input('user_type') == "internal"){
        $user->update([
        'entity_id' => null,
        ]);}else{
            $user->update([
                'entity_id' => $request->input('entity_id'),
            ]);
        }
        if($request->input('password')){
            $user->update([
                'password' => bcrypt($request->input('password')),
            ]);
        }
        if (auth()->user()) {
            $user->update([
                'updated_by' => auth()->user()->id
            ]);
        }
    }



    public function remove(Request $request, $id){
        $user = User::find($id)->delete();
    }



    public function getLangs(){
            $languages = Language::all();
            return response()->json($languages);
    }



    public function getEntities(){
        if (Auth::check()) {
            $langid = Auth::user()->language_id;
        }else{
            $langid = 1;
        }
        $entities = Entity::all();
        foreach ($entities as $entity){
            if($entity->entityName->where('language_id',$langid)->first()){
            $entity->name = $entity->entityName->where('language_id',$langid)->first()->name;
            } else {
                $entity->name = $entity->entityName->first()->name;
            }
        }
        return response()->json($entities);
    }

    public function getRoles()
    {
        if(auth()->user()){
            $langid = auth()->user()->language_id;
        } else {
            $langid = 1;
        }
        $roles = Role::all();
        foreach ($roles as $role) {
            if($role->roleName){
                if($role->roleName->where('language_id',$langid)->first() != null){
                    $role->name = $role->roleName->where('language_id',$langid)->first()->name;
                } else{
                    $role->name = $role->roleName->first()->name;
                }
            }
            if(!$role->name){
                $role->name = "Undefined";
            }
        }
        return response()->json($roles);
    }

    public function getSelRoles($id)
    {
        if (auth()->user()) {
            $langid = auth()->user()->language_id;
        } else {
            $langid = 1;
        }
        $uroles = collect();

        $roles = Role::has('roleUser')->get();
        foreach ($roles as $role) {
            if ($role->roleUser->where('user_id', $id)->first() != null) {
                if ($role->roleName) {
                    if ($role->roleName->where('language_id', $langid)->first() != null) {
                        $role->name = $role->roleName->where('language_id', $langid)->first()->name;
                    } else {
                        $role->name = $role->roleName->first()->name;
                    }
                }
                if (!$role->name) {
                    $role->name = "Undefined";
                }
//                    $aroles->put('name',$role->name);
//                    $aroles->put('id',$role->id);
                $uroles->push($role);
            }
        }

        return response()->json($uroles);
    }

    public function updateRoles(Request $request, $id)
    {
        if($request->input('selectedRoles')){
            $user = User::where('id', $id)->first();
            foreach($request->input('selectedRoles') as $selrole){
                $roleid = str_replace('number:', '', $selrole);
                $relation = $user->userRole()->where('role_id', $roleid)->first();

                if (is_null($relation)) {
                    $roleuser = new RoleHasUser();
                    $roleuser->role_id = $roleid;
                    $roleuser->user_id = $request->input('user_id');
                    $roleuser->updated_by = 1;
                    $roleuser->save();
                }
            }
        }
    }

    public function removeRole(Request $request)
    {
        RoleHasUser::where('user_id', '=' ,$request->input('user_id'))-> where('role_id', '=' ,$request->input('role_id'))->delete();
    }



}
