@extends('organization.layout.master')

@section('css')
    <link href="<?=asset('css/plugins/footable/footable.core.css')?>" rel="stylesheet">
    <style>
        img{width: 70px;}
    </style>
@endsection

@section('content')
    <div class="content-panel">
         <div class="wrapper wrapper-content">
            <div class="row">
               <div class="col-lg-12 animated fadeInRight impact-panel" style="margin-top: 0">

                  <div class="groupWrapper clearfix">

                        <div id="parentVerticalTab">
                            <ul class="resp-tabs-list hor_1">
                              @if(count($groupList)>0)
                                @foreach($groupList as $lists)
                                  <li>{{ $lists->name }}</li>
                                @endforeach
                              @endif
                            </ul>
                            <div class="resp-tabs-container hor_1">

                            @if(count($groupList)>0)
                                @foreach($groupList as $key => $lists)
                                <div>
                                @if(Session::has('success'))
                                    <div class="alert alert-success">{{Session::get('success')}}</div>
                                @endif
                                @if(Session::has('error'))
                                    <div class="alert alert-danger">{{Session::get('error')}}</div>
                                @endif
                                   <div class="groupBanner">
                                       <div class="content">
                                           <h4>Impact</h4>
                                           {{round($lists->tracked_hours/60)}}
                                           <p>hour(s)</p>
                                       </div>
                                       @if($lists->banner_image!='')
                                        <img src="{{url('/uploads/volunteer_group_banner/thumb/'.$lists->banner_image)}}" alt="">
                                       @else
                                        <img src="{{url('/uploads/no_group_banner.jpg')}}" alt="">
                                       @endif
                                   </div>
                                   <div class="vlWrapper">
                                       <div class="Vl_header clearfix">
                                       <h2>{{$lists->name}}<h2>
                                        @if($lists->role_id==1)
                                          <span>[Group Administrator]</span>
                                        @else
                                          <span>[Group Member]</span>
                                        @endif
                                       </h2>
                                       @if($lists->role_id==1)
                                        <a class="btn btn-primary" href="{{url('organization/group/group_add/'.$lists->id)}}">Edit Group</a>

                                       @else
                                         <a onclick="return confirm('Are you sure to leave ?')" class="btn btn-primary" href="{{url('organization/leave_group/'.$lists->id)}}">Leave Group</a>
                                       @endif
                                   </div>

                                    <ul class="nav nav-tabs">
                                        <li><a data-toggle="tab" href="#members{{$key}}">Members</a></li>
                                        <li class="active"><a data-toggle="tab" href="#impact{{$key}}">Impact</a></li>
                                    </ul>
                                    <div class="tab-content">
                                        <div id="members{{$key}}" class="tab-pane fade">
                                          <h3>Members</h3>




                                            @if(count($lists->members)>0)
                                              <table id="example3" class="table">
                                                <thead>
                                                  <td>Name</td>
                                                  <td>Location</td>
                                                  <td>Rank</td>
                                                </thead>
                                                <tbody>
                                                  @foreach($lists->members as $members)
                                                  <tr>
                                                      <td>{{($members->user_role == 'organization') ? $members->org_name : $members->first_name.' '.$members->last_name}}</td>
                                                      <td>{{$members->city .','.$members->state}}</td>
                                                      <td>{{empty($members->mark) ? 0 : $members->mark}}</td>
                                                  </tr>
                                                  @endforeach
                                                </tbody>
                                              </table>
                                            @endif
                                        </div>


                                        <div id="impact{{$key}}" class="tab-pane fade active in">
                                          <h3></h3>
                                          <div class="row">
                                            <div class="col-sm-12">
                                                <a class="print" href="javascript:void(0)" onclick="window.print()"><i class="fa fa-print"></i></a>
                                            </div>
                                              <div class="col-sm-6">
                                                  <div class="borderBox">
                                                      <h4>{{round($lists->tracked_hours/60)}} hour(s)</h4>
                                                      <small>contributed since creation</small>
                                                  </div>
                                                  <div class="borderBox">
                                                  <small>Ranked</small>
                                                      <h4>{{$lists->rank}}@if($lists->rank==1) st @elseif($lists->rank==2) nd @elseif($lists->rank==3) rd @else th @endif</h4>
                                                      <small>in {{$lists->creatorDetails->country}}</small>
                                                  </div>
                                              </div>
                                              <div class="col-sm-6">
                                                <ul class="nav nav-tabs chartsTab">
                                                    <li class="active"><a data-toggle="tab" href="#lastMonth{{$key}}">Last Month</a></li>
                                                    <li><a data-toggle="tab" href="#last6Month{{$key}}">Last 6 Month</a></li>
                                                    <li><a data-toggle="tab" href="#lastYear{{$key}}">Last Year</a></li>
                                                    <li><a data-toggle="tab" href="#lastdate{{$key}}">Year To Date</a></li>
                                                </ul>
                                                <div class="tab-content">
                                                  <div id="lastMonth{{$key}}" class="tab-pane fade active in">

                                                      @if(count($lists->datewise)>0)
                                                      <div id="chart">
                                                          <ul id="numbers">
                                                            <li><span>100</span></li>
                                                            <li><span>90</span></li>
                                                            <li><span>80</span></li>
                                                            <li><span>70</span></li>
                                                            <li><span>60</span></li>
                                                            <li><span>50</span></li>
                                                            <li><span>40</span></li>
                                                            <li><span>30</span></li>
                                                            <li><span>20</span></li>
                                                            <li><span>10</span></li>
                                                            <li><span>0</span></li>
                                                          </ul>
                                                          <ul id="bars">

                                                              @foreach($lists->datewise as $date)
                                                                  <li><div data-percentage="{{round($date->SUM/60)}}" class="bar"></div><span style="left: -13px; bottom: -33px; width: 50px" >{{date('d M',strtotime($date->logged_date))}}</span></li>
                                                              @endforeach

                                                          </ul>
                                                        </div>
                                                        @endif
                                                    </div>

                                                  <div id="last6Month{{$key}}" class="tab-pane fade">

                                                    @if(count($lists->sixmonthwise)>0)
                                                      <div id="chart">
                                                          <ul id="numbers">
                                                            <li><span>100</span></li>
                                                            <li><span>90</span></li>
                                                            <li><span>80</span></li>
                                                            <li><span>70</span></li>
                                                            <li><span>60</span></li>
                                                            <li><span>50</span></li>
                                                            <li><span>40</span></li>
                                                            <li><span>30</span></li>
                                                            <li><span>20</span></li>
                                                            <li><span>10</span></li>
                                                            <li><span>0</span></li>
                                                          </ul>
                                                          <ul id="bars">

                                                              @foreach($lists->sixmonthwise as $sixmonth)
                                                                  <li><div data-percentage="{{round($sixmonth->SUM/60)}}" class="bar"></div><span>{{date('M',strtotime($sixmonth->logged_date))}}</span></li>
                                                              @endforeach

                                                          </ul>
                                                        </div>
                                                        @endif
                                                    </div>
                                                  <div id="lastYear{{$key}}" class="tab-pane fade">

                                                      @if(count($lists->lastYearwise)>0)
                                                      <div id="chart">
                                                          <ul id="numbers">
                                                            <li><span>100</span></li>
                                                            <li><span>90</span></li>
                                                            <li><span>80</span></li>
                                                            <li><span>70</span></li>
                                                            <li><span>60</span></li>
                                                            <li><span>50</span></li>
                                                            <li><span>40</span></li>
                                                            <li><span>30</span></li>
                                                            <li><span>20</span></li>
                                                            <li><span>10</span></li>
                                                            <li><span>0</span></li>
                                                          </ul>
                                                          <ul id="bars">

                                                              @foreach($lists->lastYearwise as $lastYear)
                                                                  <li><div data-percentage="{{round($lastYear->SUM/60)}}" class="bar"></div><span>{{date('M',strtotime($lastYear->logged_date))}}</span></li>
                                                              @endforeach

                                                          </ul>
                                                        </div>
                                                        @endif
                                                  </div>
                                                  <div id="lastdate{{$key}}" class="tab-pane fade">

                                                        @if(count($lists->Yearwise)>0)
                                                      <div id="chart">
                                                          <ul id="numbers">
                                                            <li><span>100</span></li>
                                                            <li><span>90</span></li>
                                                            <li><span>80</span></li>
                                                            <li><span>70</span></li>
                                                            <li><span>60</span></li>
                                                            <li><span>50</span></li>
                                                            <li><span>40</span></li>
                                                            <li><span>30</span></li>
                                                            <li><span>20</span></li>
                                                            <li><span>10</span></li>
                                                            <li><span>0</span></li>
                                                          </ul>
                                                          <ul id="bars">

                                                              @foreach($lists->Yearwise as $year)
                                                                  <li><div data-percentage="{{round($year->SUM/60)}}" class="bar"></div><span style="color: #999; position: absolute; bottom: -26px; left: 0; text-align: center; transform: rotate(-60deg); min-width: 30px; margin: 0px -10px;">{{date('Y',strtotime($year->logged_date))}}</span></li>
                                                              @endforeach

                                                          </ul>
                                                        </div>
                                                        @endif
                                                  </div>
                                                </div>
                                              </div>
                                          </div>

                                          <h5 class="reconrdTitle">Past Records</h5>
                                          <ul class="recordList list-unstyled">
                                              @if(in_array($lists->group_id,$lists->arr5))
                                                <li>Top 5 Groups in the State (number of hours contributed during the last year)</li>
                                              @endif
                                              @if(in_array($lists->group_id,$lists->arr))
                                                <li>Top 10 Groups in the Country (number of hours contributed during the last year)</li>
                                              @endif
                                              @if(in_array($lists->group_id,$lists->month5))
                                                <li>Top 5 Groups in the State (number of hours contributed during the last month)</li>
                                              @endif
                                              @if(in_array($lists->group_id,$lists->month))
                                                <li>Top 10 Groups in the Country (number of hours contributed during the last month)</li>
                                              @endif
                                              @if(in_array($lists->group_id,$lists->volun5))
                                                <li>Top 5 Groups in the State (number of volunteers)</li>
                                              @endif
                                              @if(in_array($lists->group_id,$lists->volun))
                                                <li>Top 10 Groups in the Country (number of volunteers)</li>
                                              @endif
                                          </ul>
                                        </div>


                                      </div>


                                   </div>
                                </div>
                                @endforeach
                              @endif

                            </div>
                        </div>


                  </div>
               </div>
            </div>
         </div>

@endsection

@section('script')
    <script src="<?=asset('js/plugins/footable/footable.all.min.js')?>"></script>
    <script src="{{asset('admin/plugins/datatables/jquery.dataTables.min.js')}}"></script>
    <script src="{{asset('admin/plugins/datatables/dataTables.bootstrap.min.js')}}"></script>
    <script>
        $(document).ready(function() {
             /*$('.group-table').footable({
                 limitNavigation: 5,
                 firstText: '1'
             });
            $('ul.pagination').each(function(){
                if (Math.abs((parseInt($(this).find('.footable-page:last a').data('page')) + 1) - parseInt($(this).find('.footable-page-arrow:last a').text())) < 0.01) $(this).find('.footable-page-arrow:last').hide();
                else $(this).find(' .footable-page-arrow:last').show();
            });

            $('.pagination').on('click', 'li a[data-page]', function () { //, .footable-page-arrow
                var pagination = $(this).parents('.tab-pane.active .pagination');
                if (pagination.find('.footable-page:first a').data('page') == 0) pagination.find('.footable-page-arrow:first').hide();
                else pagination.find('.footable-page-arrow:first').show();
                if (Math.abs((parseInt(pagination.find('.footable-page:last a').data('page')) + 1) - parseInt(pagination.find('.footable-page-arrow:last a').text())) < 0.01) pagination.find('.footable-page-arrow:last').hide();
                else pagination.find('.footable-page-arrow:last').show();
            });*/
            $('.example3').dataTable({
                "paging": true,
                "lengthChange": false,
                "searching": false,
                "ordering": true,
                "info": false,
                "autoWidth": true,
                "pageLength": 10,
                "pagingType": "full_numbers",
                "language": {
                    "paginate": {
                        "first": "",
                        "next": '',
                        "previous": '',
                        "last": ''
                    }
                }
            });
              $('body').on('click','.send',function(){
                if($("input[type='checkbox']:checked").length > 0)
                {
                  $('#sendFrm').submit();
                }
              })
        });
    </script>
        <script type="text/javascript">
    $(document).ready(function() {

        //Vertical Tab

        $('#parentVerticalTab').easyResponsiveTabs({
            type: 'vertical', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function(event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo2');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });

        $('.invite_name').keyup(function(){
          if($(this).val().length>2)
          {//alert($(this).val().length);
            var this1 = $(this);
            $.ajax({
              url: "{{ url('/api/organization/group/get_user') }}",
              data:'keyword='+$(this).val()+'&groupId='+$(this).parent().data('id'),
              type: 'POST',
              success: function(res)
              {
                this1.parent().next().html(res);
              }
            })
          }
          else
          {
            $(this).parent().next().html('');
          }
        })


    });
    $(function(){
      $("#bars li .bar").each(function(key, bar){
        var percentage = $(this).data('percentage');

        $(this).animate({
          'height':percentage+'%'
        }, 1000);
      })
    });

    $('.invi_link').click(function(){
      var dis = $(this).data('id');
      if($('#invi_div'+dis).hasClass('hide')) {
        $('#invi_div'+dis).removeClass('hide');
      } else {
        $('#invi_div'+dis).addClass('hide')
      }
    });
</script>

@endsection
