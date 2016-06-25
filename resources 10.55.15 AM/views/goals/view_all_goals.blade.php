@extends('layout')

@section('content')

    <div class="well-lg master_wrapper margin_top">
        <div class="medium_dialog container">
            <h1>
                <h1>Vision Board</h1>
                <a href="/goals/delete_all">
                    {{--<button id="delete_all" class='btn btn-danger pull-right btn-sm'>Delete All</button>--}}
                </a>
            </h1>
            @if( 0 < count( $goals ) )


                    <div class="container-fluid">
                        <form class="checkbox-form-all" action="{{ url( 'goals/updateGoal' ) }}" method="get">
                            <table class="table">
                                <tbody>
                                @foreach( $goals as $goal )
                                    @if( !$goal->parent_goal_id )
                                    <tr>
                                        <td class="checkbox-custom">
                                            <form class="checkbox-form" action="{{ url( 'goals/updateGoal' ) }}" method="get">
                                                <div class="checkbox-inline">
                                                    <input name="is_completed" class="checkbox-complete" type="checkbox" {{ true == $goal->is_complete ? 'checked' : '' }}>
                                                    <input type="hidden" name="goal_id" value="{{ $goal->id }}"/>
                                                    <input type="hidden" name="is_completed" value="{{ $goal->is_complete }}"/>
                                                </div>
                                            </form>
                                        </td>
                                        <td>
                                            <a href="{{ url( 'goals/view_sub_goals/' . $goal->id ) }}">
                                                <h4>{{ $goal->title }} <span class="label label-sub-goals">{{ count( $goal->getImmediateDescendantGoals() ) }}</span></h4>
                                            </a>
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-info" role="progressbar" aria-valuenow="20"
                                                     aria-valuemin="0" aria-valuemax="100" style="width:{{ true == $goal->is_complete ? '100' : '30' }}%">
                                                    {{ true == $goal->is_complete ? '100' : '30' }}%
                                                </div>
                                            </div>
                                        </td>
                                        <td><a class="btn btn-danger btn-xs inline-block pull-right" href="{{ url('goals/delete_goal/'.$goal->id) }}">x</a></td>
                                    </tr>
                                    @endif
                                @endforeach
                                </tbody>
                            </table>
                        </form>

                        {{--<a class="inline-block" href="{{ url( 'goals/view_sub_goals/' . $goal->id ) }}">--}}
                            {{--<h3>{{ $goal->title }}</h3>--}}
                        {{--</a>--}}
                        {{--<a class="btn btn-danger btn-xs inline-block pull-right" href="{{ url('goals/delete_goal/'.$goal->id) }}">x</a>--}}
                    </div>

            @endif
            <a href="{{ url('goals/set_goal') }}">
                <button class="btn btn-xs btn-info">+</button>
            </a>
        </div>
    </div>

@stop