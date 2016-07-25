@extends('layouts.app')

@section('title', 'Edit')

@section('content')

	<div class="col-md-8 col-md-offset-2">
		
		<div class="panel panel-info">
		  <div class="panel-heading">
		    <h3 class="panel-title">Edit the Tag</h3>
		  </div>
		  <div class="panel-body">
		    <form action="{!! route('tag.update', $tag->id) !!}" method= 'POST' >
		    	{{csrf_field() }}
		    	{{method_field('PUT')}}
		    	<div class="form-group {{ ($errors->first('name')) ? 'has-error' : ''   }} ">
		    		<label for="name">Title</label>
		    		<input type="text" class="form-control" name="name" id="name" value="{{$tag->name}}" >
		    		@if($errors->first('name') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('name')}}
					</div>
					@endif

		    	</div>
		    	<div class="form-group {{ ($errors->first('description')) ? 'has-error' : ''   }} ">
		    		<label for="detail">description</label>
		    		<textarea  class="form-control" rows="10" name="detail" id="detail" >{{$tag->description}}</textarea>
		    		@if($errors->first('description') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('description')}}
					</div>
					@endif

		    	</div>
		    	<input type="submit" class="btn btn-primary btn-block" value="update">
		    	
		    </form>
		  </div>
		</div>

	</div>

@endsection