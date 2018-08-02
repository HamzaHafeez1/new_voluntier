@include('admin.include.admin_header')

@include('admin.include.admin_head_nav')
<!-- Left side column. contains the logo and sidebar -->
@include('admin.include.admin_side_nav')

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            Upload Excel
           <!--  <small>advanced tables</small> -->
        </h1>
        <ol class="breadcrumb">
            <li><a href="{{url('/admin/dashboard')}}"><i class="fa fa-dashboard"></i> Home</a></li>
            <!-- <li><a href="#">Tables</a></li>
            <li class="active">Data tables</li> -->
        </ol>
    </section>

    <section class="content">
        <div class="row">
            <div class="col-xs-12">

                <div class="box">
                	
				    <div class="tips-wrapper">
				    	<h3 class="text-success">Tip</h3>
				    	<p>Upload a list of new users to autometically create new account for them.</p>
				    	<p>Download the example file to check the data format.</p>
				    	<a href="{{ URL::to('/') }}/example_data.xls" class="text-success"><h3>Download Example File</h3></a>
				    </div>
						

					<section class="content">
				        <div class="row">
				            <div class="col-sm-6">
				            	<div id="wrapper">
								 	<div id="drop-area">
								  	<h3 class="drop-text">Drag and Drop File Here</h3>
								  	<p class="text-success" style="cursor:pointer">Browse file</p>
								 	</div>
								</div>
							    {!! Form::open(array('url' => '/admin/import-csv-excel', 'method'=>'post', 'enctype'=>'multipart/form-data', 'style'=>'display:none')) !!}
							      
							           <div class="col-sm-12 col-sm-offset-3">
							                <div class="form-group">
							                    {!! Form::label('sample_file','Select File to Import:',['class'=>'col-md-3']) !!}
							                    <div class="col-md-9">
							                    {!! Form::file('sample_file', array('class' => 'form-control')) !!}
							                    {!! $errors->first('sample_file', '<p class="alert alert-danger">:message</p>') !!}
							                    </div>
							                </div>
							            </div>
							            <div class="col-xs-12 col-sm-12 col-md-12 text-center">
							            	{!! csrf_field() !!}
							            {!! Form::submit('Upload',['class'=>'btn btn-primary']) !!}
							            </div>
							        
							       {!! Form::close() !!}
							</div>
						</div>	
					</section>
                </div><!-- /.box -->
                </div><!-- /.col -->
            </div><!-- /.row -->
        </section><!-- /.content -->

        

    </div><!-- /.content-wrapper -->
	    
@include('admin.include.admin_footer')

<script type="text/javascript">
	$(document).ready(function()
	{
		$("#drop-area").on('dragenter', function (e){
		  e.preventDefault();
		  $(this).css('background', '#BBD5B8');
		});

		$("#drop-area").on('dragover', function (e){
		  e.preventDefault();
		});

		$("#drop-area").on('drop', function (e){
		  $(this).css('background', '#D8F9D3');
		  e.preventDefault();
		  var image = e.originalEvent.dataTransfer.files;
		  createFormData(image);
		});

		$("#sample_file").on('change', function (e){
		  e.preventDefault();
		  var image = [];
		  image[0] = $("#sample_file").prop("files")[0];   
		  createFormData(image);
		});
	
		$('#drop-area').click(function(){
			$('#sample_file').click();
		})

		function createFormData(image)
		{
			var formImage = new FormData();
			formImage.append('sample_file', image[0]);
			formImage.append('_token', '{{ csrf_token() }}');
			uploadFormData(formImage);
		}

		function uploadFormData(formData) 
		{
			//console.log(formData);
			$.ajax({
				url: "{{ url('/admin/import-csv-excel') }}",
				type: "POST",
				data: formData,
				contentType:false,
				cache: false,
				processData: false,
				success: function(data){
				   //$('#drop-area').html(data);
				    if(data!=0)
				    {
				   	    var url = SITE_URL+'admin/showusertemdata/'+btoa(data);
				   	    window.location.href=url;
				    }
				    else
				    {
				    	alert('Problem occured');
				    }
				}
			});
		}
	});
</script>