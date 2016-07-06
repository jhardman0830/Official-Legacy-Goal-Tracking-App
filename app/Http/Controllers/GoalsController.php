<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Goal;
use Illuminate\Support\Facades\Validator;
use DB;

class GoalsController extends Controller
{
//    public function viewAllGoals()
//    {
//        $strHeadTitle = 'View All Goals';
//        $goals = Goal::all();
//
////        return view('goals.view_all_goals', compact('goals', 'strHeadTitle'));
//        return view('goals.view_goals');
//    }
//
//
//    public function view_sub_goals( $goalId )
//    {
//        $strHeadTitle = 'View Sub Goals';
//
//        $parentGoal = Goal::where( 'id', $goalId )->get()->first();
//
//        $arrobjAncestors[] = $parentGoal;
//
//        $intAncestorId = null;
//        $intAncestorId = $parentGoal->parent_goal_id;
//
//        while( false == is_null( $intAncestorId ) ) {
//            $objAncestorGoal = Goal::where( 'id', $intAncestorId )->get()->first();
//            array_unshift( $arrobjAncestors, $objAncestorGoal );
//            $intAncestorId = $objAncestorGoal->parent_goal_id;
//        }
//
//
//
//        $subGoals = Goal::where('parent_goal_id', $goalId)->get();
//
////        $this->display( $arrobjAncestors );
////        return view( 'goals.view_sub_goals', compact( 'goalId', 'subGoals','strHeadTitle', 'parentGoal', 'arrobjAncestors' ) );
//        return view('goals.view_goals');
//
//    }

    public function viewGoals( $goalId ) {

        $arrobjUserGoals = DB::table( 'goals' )->get();

        if( 0 == count( $arrobjUserGoals ) ) {
            // create the master goal
            $objMasterGoal = new Goal;
            $objMasterGoal->title = 'user_id' . ' master goal placeholder';

            $objMasterGoal->save();
        }





        $arrobjAncestors = [];
        $arrobjGoals = [];

        if( 0 == $goalId ) {
            //vision level goals
            // get master goal id
            $intMasterGoalId = Goal::whereNull( 'parent_goal_id' )->get()->first()->id;
            $goalId = $intMasterGoalId;
//            $strHeadTitle = 'View All Goals';
//            //Make sure to include condition for user id
//            $arrobjGoals = Goal::where( 'parent_goal_id', 0 )->get();
        }

        //broken down level goals
        $strHeadTitle = 'View Sub Goals';

//            $parentGoal = Goal::where( 'id', $goalId )->get()->first();
//
        $arrobjGoals = $this->fetchAllDescendantsFromParentGoalId( $goalId );
        $arrobjAncestors = $this->fetchAllAncestorsFromGoalId( $goalId);
//            show( $this->fetchAllAncestorsFromGoalId( $goalId) );


//        display( $this->fetchAllDescendantsFromParentGoalId( $goalId ) );

//        show( $arrobjGoals );



        return view( 'goals.view_goals', compact( 'arrobjGoals', 'arrobjAncestors', 'strHeadTitle', 'goalId' ) );
    }


    ////////

    public function setGoal( $goalId )
    {
        $strHeadTitle = 'Set Goal';
        $goals = Goal::all();
        return view('goals.set_goal', compact('goals', 'goalId', 'strHeadTitle'));
    }

    public function insertGoal( $parentGoalId, Request $request)
    {
        if( 0 == $parentGoalId ) {
            $intMasterGoalId = Goal::whereNull('parent_goal_id')->get()->first()->id;
            $parentGoalId = $intMasterGoalId;
        }

        $strTitle = $request->input('goal_title');

        $goal = new Goal;

        $goal->title = $strTitle;
        $goal->parent_goal_id = $parentGoalId;

        $goal->save();

        return redirect('/view_goals/' . $parentGoalId);
    }

    public function setSubGoal( $goalId )
    {
        $strHeadTitle = 'Add new sub goal';
        $parentGoal = Goal::where( 'id', $goalId )->get()->first();
        return view('goals.set_sub_goal', compact('parentGoal', 'strHeadTitle'));
    }

    public function insertSubGoal( Request $request, $goalId ) {

        $strTitle = $request->input('goal_title');

        $goal = new Goal;
        $goal->title = $strTitle;
        $goal->parent_goal_id = $goalId;

        $goal->save();

        return redirect('/goals/view_sub_goals/' . $goalId);

    }

    public function updateGoal( Request $request ) {
        $goalId = $request->input('goal_id');
//        $this->display($goalId);
        $boolIsComplete = $request->input('is_completed');
        $setIsComplete = false;

        if( 1 != $boolIsComplete ) {
            $setIsComplete = true;
        }

        $goal = Goal::where( 'id', $goalId )->get()->first();
        $goal->is_complete = $setIsComplete;
        $goal->save();

        return redirect('/view_goals/' . $goal->parent_goal_id);

    }

    public function deleteAllGoals()
    {
        DB::table('goals')->truncate();
        return redirect('/view_goals');
    }

    public function deleteGoal( $goalId ) {

        $intParentGoalId = Goal::where( 'parent_goal_id', $goalId )->get()->first()->id;

        $arrobjGoals = $this->fetchAllDescendantsFromParentGoalId( $goalId, true );
//        show( $arrobjGoals);

        $arrintDeleteGoalIds = [];

        foreach( $arrobjGoals as $objGoal ) {
            $arrintDeleteGoalIds[] = $objGoal->id;
        }

        DB::table('goals')->whereIn('id', $arrintDeleteGoalIds)->delete();


        return redirect( 'view_goals/' . $intParentGoalId );
    }

    public function fetchAllDescendantsFromParentGoalId($intGoalId, $boolIncludeSelf=false )
    {
        $arrstrData = DB::select( DB::raw('
            WITH RECURSIVE descendants AS (
                SELECT id, parent_goal_id, 0 depth
                FROM goals
                WHERE id = ' . $intGoalId . '
              UNION
                SELECT g.id, g.parent_goal_id, g2.depth+ 1
                FROM goals g
                INNER JOIN descendants g2
                ON g.parent_goal_id = g2.id
            )
            SELECT 
                g.id, 
                COALESCE( g.parent_goal_id, 0 ) AS parent_goal_id,
                g.title,
                g.percent_complete, 
                depth
            FROM 
                descendants g2
            INNER JOIN 
                goals g ON g2.id = g.id
            ' . ( $boolIncludeSelf ? '' : 'WHERE g.id <> ' . $intGoalId  )
        ) );

        return $arrstrData;
    }

    public function fetchAllAncestorsFromGoalId( $intGoalId )
    {
        $arrstrData = DB::select( DB::raw('
            WITH RECURSIVE ancestors AS (
                SELECT id, parent_goal_id, 0 depth
                FROM goals
                WHERE id = ' . $intGoalId . '
            UNION
                SELECT g.id, g.parent_goal_id, g2.depth+ 1
                FROM goals g
                JOIN ancestors g2
                ON g.id = g2.parent_goal_id
            )
            SELECT 
                g.id,
                COALESCE( g.parent_goal_id, 0 ) AS parent_goal_id,
                g.title,
                g.percent_complete, 
                depth
            FROM 
                ancestors g2
            INNER JOIN 
                goals g ON g2.id = g.id
            WHERE 
                g.parent_goal_id IS NOT NULL
            ;'
        ) );

        return $arrstrData;
    }

}
