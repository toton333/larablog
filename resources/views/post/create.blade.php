@extends('layouts.app')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endpush('css')

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
  $('.selectTags').select2({tags:true});
</script>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
tinymce.init({ 
	selector:'textarea', menubar: false, plugins: 'link',  
});
</script>
@endpush

@section('title', 'Create')

@section('content')

	<div class="col-md-8 col-md-offset-2">
		
		<div class="panel panel-info">
		  <div class="panel-heading">
		    <h3 class="panel-title">Create New Post</h3>
		  </div>
		  <div class="panel-body">
		    <form action="{!! route('post.store') !!}" method="POST">
               {{csrf_field()}}
		    	<div class="form-group {{ ($errors->first('title')) ? 'has-error' : ''   }} ">
		    		<label for="title">Title</label>
		    		<input type="text" class="form-control" name="title" id="title" placeholder="Enter title here..." >
		    		@if($errors->first('title') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('title')}}
					</div>
					@endif

		    	</div>
		    	<div class="form-group {{ ($errors->first('body')) ? 'has-error' : ''   }} ">
		    		<label for="body">Body</label>
		    		<textarea  class="form-control" rows="10" name="body" id="body" placeholder="Enter content here..." ></textarea>
		    		@if($errors->first('body') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('body')}}
					</div>
					@endif

		    	</div>

		    	<div class="form-group {{ ($errors->first('category')) ? 'has-error' : ''   }} ">
		    		<label for="category">Category</label>

		    		<select class="form-control" name="category" id="category">
		    			@foreach($categories as $category)
                        <option value="{{$category->id}}"  {{($category->name == 'Uncategorized')? 'selected': ''  }} >{{$category->name}}</option>

		    			@endforeach


		    		</select>


		    		@if($errors->first('category') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('category')}}
					</div>
					@endif

		    	</div>
		    	<div class="form-group {{ ($errors->first('tag')) ? 'has-error' : ''   }} ">
		    		<label for="tag">Tag</label>

		    		<select class="selectTags form-control" name="tag[]" id="tag" multiple="multiple">
		    			@foreach($tags as $tag)
                        <option value="{{$tag->id}}"  >{{$tag->name}}</option>

		    			@endforeach


		    		</select>


		    		@if($errors->first('tag') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('tag')}}
					</div>
					@endif

		    	</div>




		    	<input type="submit" class="btn btn-primary btn-block" value="Submit">
		    	
		    </form>
		  </div>
		</div>

	</div>

@endsection