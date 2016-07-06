
{{--
Requires:

List of ancestors
    $arrobjAncestors

Goals for scope
    if no goal_id,
        then all without a parent_id
    else
        all goals where parent id matches selected goal id


--}}

@extends('layout')

@section('content')

    <div class="well-lg master_wrapper margin_top">
        <div class="medium_dialog container">
            <div class="breadcrumb flat">
                <a class="arrow_box" href="/view_goals">All Goals</a>

                @foreach( $arrobjAncestors as $objAncestor )
                    <a class="arrow_box" href="{{ url( 'view_goals/' . $objAncestor->id ) }}">
                        {{ $objAncestor->title }}
                    </a>
                @endforeach
            </div>


                <div class="container-fluid">
                    <form class="checkbox-form-all" action="{{ url( 'goals/updateGoal' ) }}" method="get">
                        <table class="table">
                            <tbody>
                                @if( 0 < count( $arrobjGoals ) )
                                    @foreach( $arrobjGoals as $goal )
                                        @if( $goal->depth == 1 )
                                            <tr>
                                                <td class="checkbox-custom">
                                                    <form class="checkbox-form" action="{{ url( 'goals/updateGoal' ) }}" method="get">
                                                        <div class="checkbox-inline">
                                                            <input name="percent_completed" class="checkbox-complete" type="checkbox" {{ true == $goal->percent_complete ? 'checked' : '' }}>
                                                            <input type="hidden" name="goal_id" value="{{ $goal->id }}"/>
                                                            <input type="hidden" name="percent_completed" value="{{ $goal->percent_complete }}"/>
                                                        </div>
                                                    </form>
                                                </td>
                                                <td>
                                                    <a href="{{ url( 'view_goals/' . $goal->id ) }}">
                                                        <h4>{{ $goal->title }} <span class="label label-sub-goals">{{ count( DB::table('goals')->where('parent_goal_id', $goal->id)->get() ) }}</span></h4>
                                                    </a>
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                                             aria-valuemin="0" aria-valuemax="100" style="width:{{ true == $goal->percent_complete ? '100' : '0' }}%">
                                                            {{ true == $goal->percent_complete ? '100' : '0' }}%
                                                        </div>
                                                    </div>
                                                </td>
                                                <td><a class="btn btn-danger btn-xs inline-block pull-right" href="{{ url('goals/delete_goal/' . $goal->id) }}">x</a></td>
                                            </tr>
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </form>

                    {{--<a class="inline-block" href="{{ url( 'goals/view_sub_goals/' . $goal->id ) }}">--}}
                    {{--<h3>{{ $goal->title }}</h3>--}}
                    {{--</a>--}}
                    {{--<a class="btn btn-danger btn-xs inline-block pull-right" href="{{ url('goals/delete_goal/'.$goal->id) }}">x</a>--}}
                </div>

            <a href="{{ url( !$arrobjAncestors ? 'goals/set_goal/0' : 'goals/set_goal/' . end( $arrobjAncestors )->id ) }}">
                <button class="btn btn-xs btn-info">+</button>
            </a>
            {{--<a href="{{ url( 'goals/set_goal/' . $goalId ) }}">--}}
                {{--<button class="btn btn-xs btn-info">+</button>--}}
            {{--</a>--}}
        </div>
    </div>

@stop