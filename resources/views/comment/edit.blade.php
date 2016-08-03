@extends('layouts.app')
@push('script')
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
tinymce.init({ 
	selector:"textarea", menubar: false, plugins: "link textcolor colorpicker",  
});
</script>
@endpush('script')

@section('title', 'Edit')

@section('content')

	<div class="col-md-8 col-md-offset-2">
		
		<div class="panel panel-info">
		  <div class="panel-heading">
		    <h3 class="panel-title">Edit the Comment</h3>
		  </div>
		  <div class="panel-body">
            <div class="well">
			  	<dl class="dl-horizontal">
			  	  <dt>Name</dt>
			  	  <dd>{{$comment->user->name}}</dd>
			  	</dl>
			  	<dl class="dl-horizontal ">
			  	  <dt>Email</dt>
			  	  <dd>{{$comment->user->email}}</dd>
			  	</dl>
		     </div>
		        
                
		    	<form action="{!! route('comment.update', $comment->id) !!}" method= 'POST' >
		    	  {{csrf_field() }}
		    	  {{method_field('PUT')}}

		    	<div class="form-group {{ ($errors->first('comment')) ? 'has-error' : ''   }} ">
		    		<label for="comment">Comment</label>
		    		<textarea  class="form-control" rows="10" name="comment" id="comment" >{{$comment->comment}}</textarea>
		    		@if($errors->first('comment') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('comment')}}
					</div>
					@endif

		    	</div>
		    	<input type="hidden" name="post_slug" value="{{$comment->post->slug}}" >
		    	<input type="submit" class="btn btn-primary btn-block" value="update">
		    	
		    </form>
		  </div>
		</div>

	</div>

@endsection