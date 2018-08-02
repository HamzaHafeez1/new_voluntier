<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>
	<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">
   @include('include.header')
</head>
<body>
   
	
    <div class="flex-center position-ref full-height">
		 <div class="col-xs-8">
    		 <div class="box-body">
                {!! Form::open(array('url' => '/admin/edit-post')) !!}

                    {!! Form::label('first_name', 'First Name: ') !!}
                    {!! Form::text('first_name', isset($usermodel->first_name)?$usermodel->first_name:'', ['id' => 'first_name']) !!}
                    <br/>
                    {!! Form::label('last_name', 'Last Name: ') !!}
                    {!! Form::text('last_name', isset($usermodel->last_name)?$usermodel->last_name:'', ['id' => 'last_name']) !!}
                    <br/>
                    {!! Form::label('birth_date', 'DOB: ') !!}
                    {!! Form::text('birth_date', isset($usermodel->birth_date)?$usermodel->birth_date:'', ['id' => 'birth_date']) !!}

                    <br/>
                    {!! Form::label('gender', 'Gender: ') !!}
                    {{ Form::radio('gender', 'Male',true, ['class' => 'field']) }} {{ Form::radio('gender', 'Female', true, ['class' => 'field']) }}

                    <br/>
                    {!! Form::label('zipcode', 'Zipcode: ') !!}
                    {!! Form::text('zipcode', isset($usermodel->zipcode)?$usermodel->zipcode:'', ['id' => 'zipcode']) !!}
                    
                    <br/>
                    {!! Form::label('location', 'Location: ') !!}
                    {!! Form::text('location', isset($usermodel->location)?$usermodel->location:'', ['id' => 'location']) !!}
                    
                    <br/>
                    {!! Form::label('city', 'City: ') !!}
                    {!! Form::text('city', isset($usermodel->city)?$usermodel->city:'', ['id' => 'city']) !!}
                    <br/>
                    {!! Form::label('state', 'State: ') !!}
                    {!! Form::text('state', isset($usermodel->state)?$usermodel->state:'', ['id' => 'state']) !!}
                    <br/>   
                    {!! Form::label('country', 'Country: ') !!}
                    {!! Form::text('country', isset($usermodel->country)?$usermodel->country:'', ['id' => 'country']) !!}
                    <br/>
                    {!! Form::label('lat', 'lat: ') !!}
                    {!! Form::text('lat', isset($usermodel->lat)?$usermodel->lat:'', ['id' => 'lat']) !!}
                    <br/>
                    {!! Form::label('lng', 'lng: ') !!}
                    {!! Form::text('lng', isset($usermodel->lng)?$usermodel->lng:'', ['id' => 'lng']) !!}
                    <br/>
                    {!! Form::label('contact_number', 'Contact Number: ') !!}
                    {!! Form::text('contact_number', isset($usermodel->contact_number)?$usermodel->contact_number:'', ['id' => 'contact_number']) !!}
                    <br/>
                    {!! Form::label('website', 'Website: ') !!}
                    {!! Form::text('website', isset($usermodel->website)?$usermodel->website:'', ['id' => 'website']) !!}
                    <br/>
                    {!! Form::label('facebook_url', 'Facebook url: ') !!}
                    {!! Form::text('facebook_url', isset($usermodel->facebook_url)?$usermodel->facebook_url:'', ['id' => 'facebook_url']) !!}
                    <br/>
                    {!! Form::label('twitter_url', 'Twitter url: ') !!}
                    {!! Form::text('twitter_url', isset($usermodel->twitter_url)?$usermodel->twitter_url:'', ['id' => 'twitter_url']) !!}
                    <br/>
                    {!! Form::label('linkedin_url', 'Linkedin url: ') !!}
                    {!! Form::text('linkedin_url', isset($usermodel->linkedin_url)?$usermodel->linkedin_url:'', ['id' => 'linkedin_url']) !!}
                    <br/>
                    {!! Form::label('website', 'Website: ') !!}
                    {!! Form::text('website', isset($usermodel->website)?$usermodel->website:'', ['id' => 'website']) !!}
                    <br/>
                    {!! Form::label('status', 'Status: ') !!}
                    {{ Form::select('status', [ '1' => 'Active', '0' => 'Inactive'], isset($usermodel->status)?$usermodel->status:0, ['id' => 'status']) }}

                    <br/>

                 {!! csrf_field() !!}

                 {{ Form::hidden('hid', $usermodel->id) }}
                 {{ Form::submit('Save', array('class' => 'btn')) }}
                {!! Form::close() !!}
             </div>
        </div>
    </div>
</body>
</html>