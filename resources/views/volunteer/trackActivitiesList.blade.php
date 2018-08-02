<table class="table sortable" id="activity_table_del">
    <thead><tr>
        <th></th>
        <th></th></tr></thead>
    <tbody>


    @foreach($activity as $a)
        <tr class="pending-approval">
            <td>

                @if($a->opportunity != null and $a->opportunity->type != 2 and $a->opportunity->type != 3)


                        @if($a->opportunity->logo_img === null)
                            <div class="avatar" style="background-image:url('{{asset('front-end/img/org/001.png')}}')"></div>
                            <div class="main-text"><p class="normal">{{$a->content}}<a
                                            href="{{url('/')}}/volunteer/view_opportunity/{{$a->oppor_id}}">{{$a->oppor_title}}</a></p></div>

                        @else
                            <div class="avatar" style="background-image:url('{{asset('uploads') .'/'. $a->opportunity->logo_img}}')"></div>
                            <div class="main-text"><p class="normal">{{$a->content}}<a
                                            href="{{url('/')}}/volunteer/view_opportunity/{{$a->oppor_id}}">{{$a->oppor_title}}</a></p></div>

                        @endif

                @else
                    <div class="avatar" style="background-image:url('{{asset('front-end/img/org/001.png')}}')"></div>
                    <div class="main-text"><p class="normal">{{$a->content}} {{$a->oppor_title}}</p></div>

                @endif
            </td>

            <td>

                <div class="main-text block"><p class="light text-right">{{$a->updated_at}}</p></div>

            </td>

        </tr>
    @endforeach

    </tbody>
</table>
<!--<div class="wrapper-pagination pag">
    {{ $activity->links('components.pagination') }}
</div>-->