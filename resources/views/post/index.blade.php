@extends('layouts.app')

@section('title', 'Blog List')

@section('content')

<div class="row">
	<div class="col-md-8">
		  <div class="panel panel-info">
		  <!-- Default panel contents -->
			  <div class="panel-heading"><h3 >List of posts</h3></div>

			  <!-- Table -->
			  <table class="table table-striped table-bordered"> 
			  	<thead> 
			  		<tr> <th >#</th> <th>Post Title</th> </tr>
			  	 </thead>
			  	 <tbody>
			  	 	<?php $i =1; ?>
                   @foreach($posts as $post)
			  	  <tr> <th scope="row">{{$i}}</th> <td ><a href="{{route('post.show', $post->slug)}}">{{$post->title}}</a></td></tr> 	
			  	  <?php $i++; ?>
                   @endforeach
			  	</tbody> 
			  </table>
		</div>
	</div>
	<div class="col-md-4">
		@if(Auth::user()->role != 'subscriber')
		<a href="{{route('post.create')}}" type="button" class="btn btn-primary pull-right">Create new post</a>
		@endif
	</div>
</div>

@endsection