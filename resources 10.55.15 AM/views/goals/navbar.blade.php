{{--<nav class="navbar navbar-default navbar-fixed-top">--}}
    {{--<div class="container-fluid">--}}
        {{--<div class="navbar-header">--}}
            {{--<a class="navbar-brand" href="#">Legacy</a>--}}
        {{--</div>--}}
        {{--<ul class="nav navbar-nav">--}}
            {{--<li><a href="/view_goals">View All Goals</a></li>--}}
            {{--<li><a href="/goals/set_goal">Set Goal</a></li>--}}
        {{--</ul>--}}
        {{--<ul class="nav navbar-nav navbar-right">--}}
            {{--<li><a href="#"><span class=""></span> Sign Up</a></li>--}}
            {{--<li><a href="#"><span class=""></span> Login</a></li>--}}
        {{--</ul>--}}
    {{--</div>--}}
{{--</nav>--}}
<script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Legacy</a>
        </div>
        <div class="collapse navbar-collapse" id="myNavbar">
            <ul class="nav navbar-nav">
                {{--<li class="active"><a href="#">View All</a></li>--}}
                {{--<li class="dropdown">--}}
                    {{--<a class="dropdown-toggle" data-toggle="dropdown" href="#">Page 1 <span class="caret"></span></a>--}}
                    {{--<ul class="dropdown-menu">--}}
                        {{--<li><a href="#">Page 1-1</a></li>--}}
                        {{--<li><a href="#">Page 1-2</a></li>--}}
                        {{--<li><a href="#">Page 1-3</a></li>--}}
                    {{--</ul>--}}
                {{--</li>--}}
                <li><a href="/view_goals">View All</a></li>
                <li><a href="/goals/set_goal/0">New Goal</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="#"> Sign Up</a></li>
                <li><a href="#"> Login</a></li>
            </ul>
        </div>
    </div>
</nav>