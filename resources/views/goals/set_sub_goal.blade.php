@extends('layout')

@section('content')

    <div class="well-lg master_wrapper">
        <div class="medium_dialog container">

            <div class="row">
                <div class="col-xs-12" style="margin-bottom: 30px;">
                    <h1>{{$parentGoal->title}}</h1>
                    <h3>How can you accomplish this goal?</h3>
                </div>
            </div>
            <div class="row">
                <form action="/goals/insert_sub_goal/{{$parentGoal->id}}">
                    <div class="col-xs-12 col-sm-8 col-md-9 col-lg-10">
                        <input type="text" name="goal_title" class="btn-block input-lg" id="new_goal">
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-3 col-lg-2">
                        <input type="submit" class="btn btn-info btn-lg btn-block" id="submit_goal"/>
                    </div>
                </form>
            </div>
        </div>
    </div>
    </div>


    {{--<h1>All goals</h1>--}}

    {{--@foreach( $goals as $goal )--}}
    {{--<div style="border: solid black 2px; width: 600px;">--}}
    {{--<h2>{{ $goal->title }}</h2>--}}
    {{--<p>{{ $goal->description }}</p>--}}
    {{--</div>--}}
    {{--@endforeach--}}
@stop