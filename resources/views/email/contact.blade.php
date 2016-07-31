@extends('layouts.app')

@section('title', 'Contact')

@section('content')

	<div class="col-md-8 col-md-offset-2">
		
		<div class="panel panel-info">
		  <div class="panel-heading">
		    <h3 class="panel-title">Contact us</h3>
		  </div>
		  <div class="panel-body">
		    <form action="{!! route('email.post') !!}" method="POST">
               {{csrf_field()}}
		    	<div class="form-group {{ ($errors->first('name')) ? 'has-error' : ''   }} ">
		    		<label for="name">Name</label>
		    		<input type="text" class="form-control" name="name" id="name" placeholder="Enter your name..." >
		    		@if($errors->first('name') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('name')}}
					</div>
					@endif

		    	</div>

		    	<div class="form-group {{ ($errors->first('email')) ? 'has-error' : ''   }} ">
		    		<label for="email">Email</label>
		    		<input type="email" class="form-control" name="email" id="email" placeholder="Enter your email..." >
		    		@if($errors->first('email') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('email')}}
					</div>
					@endif

		    	</div>

		    	<div class="form-group {{ ($errors->first('detail')) ? 'has-error' : ''   }} ">
		    		<label for="detail">Message</label>
		    		<textarea  class="form-control" rows="10" name="detail" id="detail" placeholder="Enter your message..." ></textarea>
		    		@if($errors->first('detail') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('detail')}}
					</div>
					@endif

		    	</div>
		    	<input type="submit" class="btn btn-primary btn-block" value="Send Message">
		    	
		    </form>
		  </div>
		</div>

	</div>

@endsection