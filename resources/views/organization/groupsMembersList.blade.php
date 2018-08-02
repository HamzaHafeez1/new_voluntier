@foreach($lists as $members)
    <tr class="search-members-tr">
        <td>{{($members->user_role == 'organization') ? $members->org_name : $members->first_name.' '.$members->last_name}}</td>
        <td>{{$members->city .','.$members->state}}</td>
        <td><p class="green">2 hour(s)</p></td>
        <td>{{empty($members->mark) ? 0 : $members->mark}}</td>
    </tr>
@endforeach