<?php

// Legacy Goals App

Route::get('/', function() {
    return 'it works';
});

Route::get('goals', 'GoalsController@viewAllGoals');
Route::get('view_goals/{goal}', 'GoalsController@viewGoals');
Route::get('view_goals', function() {
    return redirect( url( 'view_goals/0' ) );
});

Route::get('goals/set_goal/{goal}', 'GoalsController@setGoal');
Route::get('insert_goal/{parent_goal_id}', 'GoalsController@insertGoal');


Route::get('goals/set_sub_goal/{goal}', 'GoalsController@setSubGoal');
Route::get('goals/insert_sub_goal/{goal}', 'GoalsController@insertSubGoal');


Route::get('goals/view_sub_goals/{goal}', 'GoalsController@view_sub_goals');


Route::get('/goals/delete_goal/{goal}', 'GoalsController@deleteGoal' );

Route::get('goals/delete_all', 'GoalsController@deleteAllGoals');
Route::get('goals/updateGoal', 'GoalsController@updateGoal');








// CARD TUTORIAL
Route::get('cards', 'CardsController@index');
Route::get('cards/{card}', 'CardsController@show');
