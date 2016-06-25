<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

class Goal extends Model
{
    public function getImmediateDescendantGoals()
    {
        $arrintDescendantGoals = [];
        

        $arrintGoals = Goal::where( 'parent_goal_id', $this->id )->lists('id')->toArray();

        foreach( $arrintGoals as $intGoal ) {

            $arrintDescendantGoals[] = Goal::where( 'parent_goal_id', $intGoal )->lists('title')->toArray();

        }
        
        return $arrintDescendantGoals;
    }

    public function display( $variable )
    {
        echo '<pre>';
        var_dump($variable);
        echo '</pre>';
    }
}
