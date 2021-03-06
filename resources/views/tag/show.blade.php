@extends('layouts.app')
@section('title', $tag->name)
@section('content')

<div class="row">
	<div class="col-md-4">
		  <div class="panel panel-info">
		  <!-- Default panel contents -->
			  <div class="panel-heading">
			  	<h3 >{{$tag->name}}</h3>
			  	
			  </div>

			  <div class="panel-body">

			  	
			  	{!!  nl2br(e($tag->description))  !!}
			    </pre>
			  </div>
			  <div class="panel-footer">
			  	<h6>
			  		@if($tag->created_at == $tag->updated_at)
			  		Created at: {{date('M j, Y | h:ia', strtotime($tag->created_at)  )}}

			  		@else
			  		Last updated at: {{date('M j, Y | h:ia', strtotime($tag->updated_at)  )}}

			  		@endif
			  	</h6>
			  </div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-info">
			<div class="panel-heading">
				<h3>Related posts</h3>
			</div>
			<div class="panel-body">
				@if($posts->all())

					@foreach($posts as $post)
	                  <a href="{{route('post.show', $post->slug)}}"><span class="label label-default"  >{{$post->title}}</span></a>
					@endforeach

				@else

				    There is no related post

				@endif
			</div>

		</div>
		
	</div>

	@if(Auth::user()->role != 'subscriber')
	
	<div class="col-md-2 ">
			
			<a href="{{route('tag.edit', $tag->slug)}}" type="button" class="btn btn-success pull-right ">Edit</a>		     

	</div>

    <div class="col-md-2">
    	
    	<form action="{{route('tag.destroy', $tag->slug)}}" method="POST"  >
				{{csrf_field()}}
				{{method_field('DELETE')}}
			   <input type="submit" class="btn btn-danger" value="Delete" >
			</form>
    </div>
    @endif

</div>
@endsection