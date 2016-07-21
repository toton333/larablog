@extends('layouts.app')
@section('title', $post->title)
@section('content')

<div class="row">
	<div class="col-md-8">
		  <div class="panel panel-info">
		  <!-- Default panel contents -->
			  <div class="panel-heading">
			  	<h3 >{{$post->title}}</h3>
                @if($post->category)
			  	<h6> Category : <a href="{{route('category.show', $post->category->slug)}}"><span class="label label-default">{{$post->category->name}}</span></a></h6>
                @endif
			  	
			  </div>

			  <div class="panel-body">
			  	{!!  nl2br(e($post->body))  !!}
			  </div>
			  <div class="panel-footer">
			  	<h6>
			  		@if($post->created_at == $post->updated_at)
			  		Created at: {{date('M j, Y | h:ia', strtotime($post->created_at)  )}}

			  		@else
			  		Last updated at: {{date('M j, Y | h:ia', strtotime($post->updated_at)  )}}

			  		@endif
			  		
			  	</h6>
			  </div>
		</div>
	</div>
	
	<div class="col-md-2 ">
			
			<a href="{{route('post.edit', $post->slug)}}" type="button" class="btn btn-success pull-right ">Edit</a>		     

	</div>


    <div class="col-md-2">
    	
    	<form action="{{route('post.destroy', $post->slug)}}" method="POST"  >
				{{csrf_field()}}
				{{method_field('DELETE')}}
			   <input type="submit" class="btn btn-danger" value="Delete" >
			</form>
    </div>




</div>



@endsection