<?php

namespace App\Http\Controllers;

use App\Actor;
use App\Role;
use App\RoleHasActor;
use App\RoleHasUser;
use App\RoleName;
use App\User;
use DB;
use Illuminate\Http\Request;
use Response;


class RoleController extends Controller{

    public function index()
    {
        return view('roles');
    }

    public function getAll(Request $request, $id = null)
    {
        if ($id == null) {
            if(auth()->user()){
                $langid = auth()->user()->language_id;
            } else {
                $langid = 1;
            }

            if ($request->has('input_sort')) {
                $orderThese = $request->input('input_sort') . ' ' . $request->input('type');
            }
            else {
                $orderThese = 'role.id desc';
            }

            $matchThese = [];
            if ($request->has('s_id')) {
                $matchThese[] = array('role.id','LIKE','%'.$request->input('s_id').'%');
            }
            if ($request->has('s_name')) {
                $matchThese[] = array('role_name.name','LIKE','%'.$request->input('s_name').'%');
            }
            if ($request->has('s_updated_at')) {
                $matchThese[] = array('role.updated_at','LIKE','%'.$request->input('s_updated_at').'%');
            }

            $roles = DB::table('role')
                ->join('role_name', 'role.id', '=', 'role_name.role_id')
                ->join('language', 'role_name.language_id', '=', 'language.id')
                ->select('role_name.*','role.*')
                ->where('language.id','=',$langid)->whereNull('role.deleted_at')->where($matchThese)
                ->orderByRaw($orderThese)
                ->paginate(20);
            return response()->json($roles);
        }else{
            return $this->getSpec($id);
        }
    }

    public function getSpec($id)
    {
        $roles = Role::where('id',$id)->first();
        if(auth()->user()){
            $langid = auth()->user()->language_id;
        } else {
            $langid = 1;
        }
        if($roles->roleName) {
            if ($roles->roleName->where('language_id', $langid)->first() != null) {
                $roles->name = $roles->roleName->where('language_id', $langid)->first()->name;
            } else {
                $roles->name = $roles->roleName->first()->name;
            }
        }
        if(!$roles->name){
            $roles->name = "Undefined";
        }

        return response()->json($roles);
    }

    public function insert(Request $request)
    {
        $role = new Role;
        $role_name = new RoleName;


        DB::beginTransaction();

        try {
            if (auth()->user()) {
                $role->updated_by = auth()->user()->id;
            }else{
                $role->updated_by = 1;
            }
            $role->save();

            $role_name->role_id = $role->id;
            $role_name->language_id = 1;
            $role_name->name = $request->input('name');
            if (auth()->user()) {
                $role_name->updated_by = auth()->user()->id;
            }else{
                $role_name->updated_by = 1;
            }
            $role_name->save();


            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

    }

    public function update(Request $request, $id)
    {
        $role = Role::find($id);
        if (auth()->user()) {
            $role->update([
            'updated_by' => auth()->user()->id
        ]);
        }

        $langid = 1;

        $query = ['role_id' => $role->id, 'language_id' => $langid];
        $role_name = RoleName::where($query)->first();


        if($role_name != null){
            $role_name = RoleName::where($query);
            $role_name->update([
                'name' => $request->input('name')
            ]);
            if (auth()->user()) {
                $role_name->update([
                    'updated_by' => auth()->user()->id
                ]);
            }
        } else {
            $role_name = new RoleName;
            DB::beginTransaction();

            try {
                $role_name->role_id = $role->id;
                $role_name->language_id = 1;
                $role_name->name = $request->input('name');
                if (auth()->user()) {
                    $role_name->updated_by = auth()->user()->id;
                }else{
                    $role_name->updated_by = 1;
                }
                $role_name->save();
                DB::commit();
                // all good
            } catch (\Exception $e) {
                DB::rollback();
                // something went wrong
            }

        }
    }


    public function remove(Request $request, $id)
    {
        $role = Role::find($id)->delete();
    }


    public function getActors()
    {
        if(auth()->user()){
            $langid = auth()->user()->language_id;
        } else {
            $langid = 1;
        }
        $actors = Actor::all();
        foreach ($actors as $actor) {
            if($actor->actorName){
                if($actor->actorName->where('language_id',$langid)->first() != null){
                    $actor->name = $actor->actorName->where('language_id',$langid)->first()->name;
                } else{
                    $actor->name = $actor->actorName->first()->name;
                }
            }
            if(!$actor->name){
                $actor->name = "Undefined";
            }
        }
        return response()->json($actors);
    }

    public function getUsers()
    {
        $users = User::all();
        return response()->json($users);
    }

    public function getSelActors($id)
    {
        if (auth()->user()) {
            $langid = auth()->user()->language_id;
        } else {
            $langid = 1;
        }
        $aroles = collect();

        $actors = Actor::has('actorRole')->get();
        foreach ($actors as $actor) {
            if ($actor->actorRole->where('role_id', $id)->first() != null) {
                if ($actor->actorName) {
                    if ($actor->actorName->where('language_id', $langid)->first() != null) {
                        $actor->name = $actor->actorName->where('language_id', $langid)->first()->name;
                    } else {
                        $actor->name = $actor->actorName->first()->name;
                    }
                }
                if (!$actor->name) {
                    $actor->name = "Undefined";
                }
//                    $aroles->put('name',$role->name);
//                    $aroles->put('id',$role->id);
                $aroles->push($actor);
            }
        }
        return response()->json($aroles);
    }

    public function getSelUsers($id)
    {
        $uroles = collect();
        $users = User::has('userRole')->get();
        foreach ($users as $user) {
            if ($user->userRole->where('role_id', $id)->first() != null) {
                $uroles->push($user);
            }
        }
        return response()->json($uroles);
    }


    public function updateActors(Request $request, $id)
    {
        if($request->input('selectedActors')){
            $role = Role::where('id', $id)->first();
            foreach($request->input('selectedActors') as $selactor){
                $actorid = str_replace('number:', '', $selactor);
                $relation = $role->roleActor()->where('actor_id', $actorid)->first();

                if (is_null($relation)) {
                    $roleactor = new RoleHasActor();
                    $roleactor->role_id = $request->input('role_id');
                    $roleactor->actor_id = $actorid;
                    $roleactor->updated_by = 1;
                    $roleactor->save();
                }
            }
        }
    }

    public function updateUsers(Request $request, $id)
    {
        if($request->input('selectedUsers')){
            $role = Role::where('id', $id)->first();
            foreach($request->input('selectedUsers') as $seluser){
                $userid = str_replace('number:', '', $seluser);
                $relation = $role->roleUser()->where('user_id', $userid)->first();

                if (is_null($relation)) {
                    $roleuser = new RoleHasUser();
                    $roleuser->role_id = $request->input('role_id');
                    $roleuser->user_id = $userid;
                    $roleuser->updated_by = 1;
                    $roleuser->save();
                }
            }
        }
    }

    public function removeActors(Request $request)
    {
        RoleHasActor::where('actor_id', '=' ,$request->input('actor_id'))-> where('role_id', '=' ,$request->input('role_id'))->delete();
    }

    public function removeUsers(Request $request)
    {
        RoleHasUser::where('user_id', '=' ,$request->input('user_id'))-> where('role_id', '=' ,$request->input('role_id'))->delete();
    }

}