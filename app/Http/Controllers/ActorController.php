<?php

namespace App\Http\Controllers;

use App\Actor;
use App\ActorName;
use App\Role;
use App\RoleHasActor;
use DB;
use Illuminate\Http\Request;
use Response;


class ActorController extends Controller{

    public function index()
    {
        return view('actors');
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
                $orderThese = 'actor.id desc';
            }

            $matchThese = [];
            if ($request->has('s_id')) {
                $matchThese[] = array('actor.id','LIKE','%'.$request->input('s_id').'%');
            }
            if ($request->has('s_name')) {
                $matchThese[] = array('actor_name.name','LIKE','%'.$request->input('s_name').'%');
            }
            if ($request->has('s_updated_at')) {
                $matchThese[] = array('actor.updated_at','LIKE','%'.$request->input('s_updated_at').'%');
            }

            $actors = DB::table('actor')
                ->join('actor_name', 'actor.id', '=', 'actor_name.actor_id')
                ->join('language', 'actor_name.language_id', '=', 'language.id')
                ->select('actor_name.*','actor.*')
                ->where('language.id','=',$langid)->whereNull('actor.deleted_at')->where($matchThese)
                ->orderByRaw($orderThese)
                ->paginate(20);

//            foreach ($actors as $actor) {
//                if($actor->actorName){
//                    if($actor->actorName->where('language_id',$langid)->first() != null){
//                        $actor->name = $actor->actorName->where('language_id',$langid)->first()->name;
//                    } else{
//                        $actor->name = $actor->actorName->first()->name;
//                    }
//                }
//                if(!$actor->name){
//                    $actor->name = "Undefined";
//                }
//                if ($actor->updated_at) {
//                    $actor->updated_on = $actor->updated_at->format('d M Y');
//                } else {
//                    $actor->updated_on = "Undefined";
//                }
//            }
            return response()->json($actors);
        }else{
            return $this->getSpec($id);
        }
    }

    public function getSpec($id)
    {
        $actors = Actor::where('id',$id)->first();
        if(auth()->user()){
            $langid = auth()->user()->language_id;
        } else {
            $langid = 1;
        }
        if($actors->actorName) {
            if ($actors->actorName->where('language_id', $langid)->first() != null) {
                $actors->name = $actors->actorName->where('language_id', $langid)->first()->name;
            } else {
                $actors->name = $actors->actorName->first()->name;
            }
        }
        if(!$actors->name){
            $actors->name = "Undefined";
        }

        return response()->json($actors);
    }

    public function insert(Request $request)
    {
        $actor = new Actor;
        $actor_name = new ActorName;


        DB::beginTransaction();

        try {
            if (auth()->user()) {
                $actor->updated_by = auth()->user()->id;
            }else{
                $actor->updated_by = 1;
            }
            $actor->save();

            $actor_name->actor_id = $actor->id;
            $actor_name->language_id = 1;
            $actor_name->name = $request->input('name');
            if (auth()->user()) {
                $actor_name->updated_by = auth()->user()->id;
            }else{
                $actor_name->updated_by = 1;
            }
            $actor_name->save();


            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }

    }

    public function update(Request $request, $id)
    {
        $actor = Actor::find($id);
        if (auth()->user()) {
            $actor->update([
                'updated_by' => auth()->user()->id
            ]);
        }

        $langid = 1;

        $query = ['actor_id' => $actor->id, 'language_id' => $langid];
        $actor_name = ActorName::where($query)->first();


        if($actor_name != null){
            $actor_name = ActorName::where($query);
            $actor_name->update([
                'name' => $request->input('name')
            ]);
            if (auth()->user()) {
                $actor_name->update([
                    'updated_by' => auth()->user()->id
                ]);
            }
        } else {
            $actor_name = new ActorName;
            DB::beginTransaction();

            try {
                $actor_name->actor_id = $actor->id;
                $actor_name->language_id = 1;
                $actor_name->name = $request->input('name');
                if (auth()->user()) {
                    $actor_name->updated_by = auth()->user()->id;
                }else{
                    $actor_name->updated_by = 1;
                }
                $actor_name->save();
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
        $actor = Actor::find($id)->delete();
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
        $aroles = collect();

        $roles = Role::has('roleActor')->get();
        foreach ($roles as $role) {
            if ($role->roleActor->where('actor_id', $id)->first() != null) {
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
                $aroles->push($role);
            }
        }

        return response()->json($aroles);
    }



    public function updateRoles(Request $request, $id)
    {
        if($request->input('selectedRoles')){
            $actor = Actor::where('id', $id)->first();
            foreach($request->input('selectedRoles') as $selrole){
                $roleid = str_replace('number:', '', $selrole);
                $relation = $actor->actorRole()->where('role_id', $roleid)->first();

                if (is_null($relation)) {
                    $roleactor = new RoleHasActor();
                    $roleactor->role_id = $roleid;
                    $roleactor->actor_id = $request->input('actor_id');
                    $roleactor->updated_by = 1;
                    $roleactor->save();
                }
            }
        }
    }

    public function removeRole(Request $request)
    {
        RoleHasActor::where('actor_id', '=' ,$request->input('actor_id'))-> where('role_id', '=' ,$request->input('role_id'))->delete();
    }

}
