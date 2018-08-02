<div class="modal no-backdrop fade" id="myModalSearchByLocation" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg  modal-dialog-centered" role="document">
        <div class="modal-dialog-fix">
            <div>


                <div class="modal-content">
                    <div class="modal-header">

                        <div class="main-text">
                            <h3 class="h3">We've found <strong class="green">0</strong> volunteer opportunities near</h3>
                            <p class="light mt-5">Please type the full location name, e.g. New York, NY</p>
                        </div>

                        <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                            <span>&times;</span>
                        </a>

                    </div>
                    <div class="modal-body">



                        <form id="search_opportunity" role="form" method="get" action="{{url('volunteer/opportunity/search')}}" enctype="multipart/form-data">
                            {{csrf_field()}}

                            <div class="form-group">

                                <div class="wrapper-one-links clearfix">
                                    <div  class="wrapper_input">

                                        <input id="input_search_loc" type="text" name="input_search_loc" placeholder="Sample: City, State" value="{{$search_addr['city']}}, {{$search_addr['state']}}">
                                    </div>
                                    <a id="btn_search_loc" href="#" class="search"><i class="fa fa-search" aria-hidden="true"></i></a>
                                </div>

                            </div>

                        </form>



                    </div>
                    <div class="modal-footer pb-0">



                    </div>
                </div>

            </div>
        </div>
    </div>
</div>