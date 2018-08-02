@if($user->user_role !== 'organization')

    @if(!(Auth::user()->post_status))
    <form action="{{url('/status_post')}}" method="post">
        <div class="form-group">
            <textarea class="form-control" rows="5" id="comment" name="comment" required></textarea><br>
            <div class="dropdown">
                Choose Oppurtunity:
                <select class="btn btn-success" style="width:100%" name="select">
                @foreach($keywords as $k)
                <option value="{{$k->title}}">
                    {{$k->title}}
                </option>
                @endforeach
                </select>
            </div>
        </div>
        <input type="submit" name="submit" value="Post Status" class="btn btn-success" style="float: right;">
        <input type="hidden" name="_token" value="{{csrf_token()}}">
    </form>
    @else
    <form action="{{url('/status_delete')}}" method="post">
        <div class="form-group">
            <b>Status:</b><br>
            <b>{{$user->post_status}}</b><small> is posted by</small> <b>{{$user->user_name}}</b><small> in oppurtunity</small> <b>{{$user->selection}}</b>
            <input type="submit" name="submit" value="Delete Status" class="btn btn-danger" style="float: right;">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
        </div>
    </form>
    <br><br>
    <hr>
    <b>Comments:</b><br>
        @foreach($comments as $c)
            @if($c->status_user_id == $user->id)
                <i>{{$c->commenter_name}}</i>: {{$c->body}} <br><br>
            @endif
        @endforeach
    <hr>
    <form action="{{url('/volunteer/commentStatus')}}" method="post">
        <div class="form-group">
            <p class="bold">Add Comment:</p>
            <input type="text" name="comment" class="form-control" required><br>
            <input type="submit" value="Add comment" name="add_comment" class="btn btn-success" style="float:right;">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <input type="hidden" value="{{$user->post_status}}" name="status">
            <input type="hidden" value="{{$user->id}}" name="friend_id">
        </div>
    </form>
    <br><br>
    @endif
    <div class="wrapper-friends">
        <div class="search-friends">
            <div class="container">
                <div class="search">
                    <label><span class="gl-icon-search"></span></label>
                    <input id="filter" type="text" placeholder="Search in table">
                </div>
            </div>
        </div>
        <div class="wrapper-friends-list wrapper-track">
            <div class="wrapper-sort-table">
                <div>
                    @include('components.trackProfile.pendingApprovalsActivity', ['tracks' => $tracks])
                </div>
            </div>
        </div>
    </div>
    
@endif