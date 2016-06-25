@extends('layout')

@section('content')

    <div class="well-lg master_wrapper margin_top">
        <div class="medium_dialog container">


            <div class="breadcrumb flat">
                <a class="arrow_box" href="/goals">All Goals</a>

                @foreach( $arrobjAncestors as $objAncestor )
                <a class="arrow_box" href="{{ url( 'goals/view_sub_goals/' . $objAncestor->id ) }}">
                    {{ $objAncestor->title }}
                </a>
                @endforeach
            </div>

            {{--<a href="/goals/delete_all">--}}
            {{--<button id="delete_all" class='btn btn-danger pull-right btn-sm'>Delete All</button>--}}
            {{--</a>--}}

            @if( 0 < count( $subGoals ) )

                <div class="container-fluid">
                    <table class="table">
                        <tbody>
                        @foreach( $subGoals as $goal )
                            @if( false == empty( $goal->parent_goal_id ) )
                                <tr>
                                    <td>
                                        <a href="{{ url( 'goals/view_sub_goals/' . $goal->id ) }}">
                                            <h4>{{ $goal->title }} <span class="label label-sub-goals">{{ count( $goal->getImmediateDescendantGoals() ) }}</span></h4>
                                        </a>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                                 aria-valuemin="0" aria-valuemax="100" style="width:20%">
                                                20%
                                            </div>
                                        </div>
                                    </td>
                                    <td><a class="btn btn-danger btn-xs inline-block pull-right" href="{{ url('goals/delete_goal/'.$goal->id) }}">x</a></td>
                                </tr>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>

            @endif
                <div class="container">
                    <a href="{{ url('goals/set_sub_goal/'.$parentGoal->id) }}">
                        <button class="btn btn-xs btn-info">+</button>
                    </a>
                </div>





            {{--@foreach( $subGoals as $goal )--}}
                {{--<a class="col-xs-9">--}}
                    {{--<div>--}}
                        {{--<h4>{{ $goal->title }}</h4>--}}
                    {{--</div>--}}
                {{--</a>--}}
                {{--<div class="col-xs-1">--}}
                    {{--<a href="{{ url('goals/add_sub_goal/'.$goal->id) }}">--}}
                        {{--<button type="submit" class="btn btn-info btn-xs pull-right">--}}
                            {{--Add Sub Goal <span class="badge badge-info">{{ DB::table('goals')->where( 'parent_goal_id', $goal->id )->count() }}</span>--}}
                        {{--</button>--}}
                    {{--</a>--}}
                {{--</div>--}}
                {{--<div class="col-xs-1">--}}
                    {{--<a href="{{ url('goals/delete_goal/'.$goal->id) }}">--}}
                        {{--<button type="submit" class="btn btn-danger btn-xs pull-right">--}}
                            {{--<i class="fa fa-trash"></i>X--}}
                        {{--</button>--}}
                    {{--</a>--}}
                {{--</div>--}}
            {{--@endforeach--}}
        </div>
    </div>
    </div>

@stop