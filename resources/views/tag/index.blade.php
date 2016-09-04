@extends('layouts.app')

@section('title', 'Tag List')

@section('content')

<div class="row">
	<div class="col-md-8">
		  <div class="panel panel-info">
		  <!-- Default panel contents -->
			  <div class="panel-heading"><h3 >List of Tags</h3></div>

			  <!-- Table -->
			  <table class="table table-striped table-bordered"> 
			  	<thead> 
			  		<tr> <th >#</th> <th>Tag Name</th> </tr>
			  	 </thead>
			  	 <tbody>
			  	 	<?php $i =1; ?>
                   @foreach($tags as $tag)
			  	  <tr> <th scope="row">{{$i}}</th> <td ><a href="{{route('tag.show', $tag->slug)}}">{{$tag->name}}</a></td></tr> 	
			  	  <?php $i++; ?>
                   @endforeach
			  	</tbody> 
			  </table>
		</div>
	</div>

	@if(Auth::user()->role != 'subscriber')
	<div class="col-md-2 col-md-offset-1 well">
		<form action="{{route('tag.index')}}" method="POST" >
			{{csrf_field()}}
			<div class="form-group {{ ($errors->first('name')) ? 'has-error' : ''   }} ">
		    		<label for="name">Name</label>
		    		<input type="text" class="form-control" name="name" id="name" placeholder="Enter name here..." >
		    		@if($errors->first('name') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('name')}}
					</div>
					@endif

		    	</div>
		    	<div class="form-group {{ ($errors->first('description')) ? 'has-error' : ''   }} ">
		    		<label for="description">Description</label>
		    		<textarea  class="form-control" rows="5" name="description" id="description" placeholder="Enter description here..." ></textarea>
		    		@if($errors->first('description') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('description')}}
					</div>
					@endif

		    	</div>
		    	<input type="submit" class="btn btn-primary btn-block" value="Create new tag">

		</form>
	</div>
	@endif
</div>

@endsection