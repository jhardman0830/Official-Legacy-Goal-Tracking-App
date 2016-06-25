<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Goal;
use Illuminate\Support\Facades\Validator;
use DB;

class GoalsController extends Controller
{
    public function viewAllGoals()
    {
        $strHeadTitle = 'View All Goals';
        $goals = Goal::all();

//        return view('goals.view_all_goals', compact('goals', 'strHeadTitle'));
        return view('goals.view_goals');
    }


    public function view_sub_goals( $goalId )
    {
        $strHeadTitle = 'View Sub Goals';

        $parentGoal = Goal::where( 'id', $goalId )->get()->first();

        $arrobjAncestors[] = $parentGoal;

        $intAncestorId = null;
        $intAncestorId = $parentGoal->parent_goal_id;

        while( false == is_null( $intAncestorId ) ) {
            $objAncestorGoal = Goal::where( 'id', $intAncestorId )->get()->first();
            array_unshift( $arrobjAncestors, $objAncestorGoal );
            $intAncestorId = $objAncestorGoal->parent_goal_id;
        }



        $subGoals = Goal::where('parent_goal_id', $goalId)->get();

//        $this->display( $arrobjAncestors );
//        return view( 'goals.view_sub_goals', compact( 'goalId', 'subGoals','strHeadTitle', 'parentGoal', 'arrobjAncestors' ) );
        return view('goals.view_goals');

    }

    public function viewGoals( $goalId ) {
//        Requires:

//        List of ancestors
//    $arrobjAncestors
//
//Goals for scope
//        if no goal_id,
//        then all without a parent_id
//    else
//        all goals where parent id matches selected goal id

//        $strHeadTitle = 'View Sub Goals';


        $arrobjAncestors = [];
        $arrobjGoals = [];

        if( 0 == $goalId ) {
            //vision level goals
            $strHeadTitle = 'View All Goals';
            $arrobjGoals = Goal::whereNull( 'parent_goal_id' )->get();
        } else {
            //broken down level goals
            $strHeadTitle = 'View Sub Goals';

            $parentGoal = Goal::where( 'id', $goalId )->get()->first();

            $arrobjAncestors[] = $parentGoal;

            $intAncestorId = null;
            $intAncestorId = $parentGoal->parent_goal_id;

            while( false == is_null( $intAncestorId ) ) {
                $objAncestorGoal = Goal::where( 'id', $intAncestorId )->get()->first();
                array_unshift( $arrobjAncestors, $objAncestorGoal );
                $intAncestorId = $objAncestorGoal->parent_goal_id;
            }



            $arrobjGoals = Goal::where('parent_goal_id', $goalId)->get();
        }


        return view( 'goals.view_goals', compact( 'arrobjGoals', 'arrobjAncestors', 'strHeadTitle' ) );
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

        $strTitle = $request->input('goal_title');

        $goal = new Goal;
        $goal->title = $strTitle;

        if( 0 != $parentGoalId ) {
            $goal->parent_goal_id = $parentGoalId;
        }

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


        $boolIsTopLevelGoal = 0 != count( Goal::where( 'id', $goalId )->whereNull( 'parent_goal_id' )->get() );

        if( $boolIsTopLevelGoal ) {
            $parentGoalId = 0;
        } else {
            $goal = Goal::where( 'id', $goalId )->get()->first();
            $parentGoalId = $goal->parent_goal_id;
            $this->display($parentGoalId);
        }

        $this->display($parentGoalId);


        $arrintDeleteGoalIds = [];
        $arrintDeleteGoalIds[] = $goalId;

//        while(  )

//        get all target is to delete


        $counter = 0;
        do{
            $counter++;

//            echo( '========' . $counter . '========');

            $arrintPreviousDeleteGoalIds = $arrintDeleteGoalIds;

            $arrLayerGoals = Goal::whereIn('parent_goal_id', $arrintDeleteGoalIds )->get(array('id'));

//            $this->display( implode( ',', $arrintDeleteGoalIds ) );
//            $this->display( $arrLayerGoals . 'count: ' . count($arrLayerGoals));

            foreach ($arrLayerGoals as $arrLayerGoal) {
                if( !in_array( $arrLayerGoal->id, $arrintDeleteGoalIds) ) {
                    $arrintDeleteGoalIds[] = $arrLayerGoal->id;
                }
            }


//            echo $this->display( $arrintPreviousDeleteGoalIds ) . $this->display( $arrintDeleteGoalIds );

        } while( $arrintPreviousDeleteGoalIds != $arrintDeleteGoalIds );
//            $this->display($arrintDeleteGoalIds);

        Goal::whereIn( 'id', $arrintDeleteGoalIds )->delete();

        return redirect( 'view_goals/' . $parentGoalId );
    }

    public function display( $variable )
    {
        echo '<pre>';
        print_r($variable);
        echo '</pre>';
        exit;
    }
}
