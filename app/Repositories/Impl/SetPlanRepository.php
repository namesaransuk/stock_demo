<?php


namespace App\Repositories\Impl;

use App\Models\SetPlan;
use App\Models\Supply;
use App\Repositories\SetPlanInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class SetPlanRepository extends BaseRepository implements SetPlanInterface
{

    protected $model;

    public function __construct(SetPlan $model)
    {
       parent::__construct($model);
    }

    public function crud($request)
    {
        // dd($request->all());

        // create
        if($request->type == 'add')
        {
            $event = SetPlan::create([
                'user_add'		=>	Auth::user()->id,
                'event'		=>	$request->title,
                'start'		=>	$request->start,
                'end'		=>	$request->end,
                'color'		=>	$request->color
            ]);

            return response()->json($event);
        }
        // update
        if($request->type == 'edit')
        {
            $event = SetPlan::find($request->id)->update([
                'user_add'		=>	Auth::user()->id,
                'event'		=>	$request->title,
                'start'		=>	$request->start,
                'end'		=>	$request->end
            ]);

            return response()->json($event);
        }
        // delete
        if($request->type == 'delete')
        {
            $event = SetPlan::find($request->id)->delete();

            return response()->json($event);
        }
    }

}
