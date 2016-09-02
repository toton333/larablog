@extends('layouts.app')

@push('css')
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
@endpush('css')

@push('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
<script type="text/javascript">
  $('.selectTags').select2().val({!! json_encode($post->tags()->getRelatedIds()) !!}).trigger('change');
  $('.selectTags').select2({tags:true});
</script>
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
		    <h3 class="panel-title">Edit the Post</h3>
		  </div>
		  <div class="panel-body">
		    <form action="{!! route('post.update', $post->id) !!}" method= 'POST' enctype="multipart/form-data" >
		    	{{csrf_field() }}
		    	{{method_field('PUT')}}
		    	<div class="form-group {{ ($errors->first('featured_image')) ? 'has-error' : ''   }} ">
		    		<label for="title">Featured Image</label>
                    @if($post->image)
		    		<img src="{{asset('images/'.$post->image)}}" alt=""  width="700" height="300"  >
                    @endif
		    		<input type="file" class="form-control" name="featured_image" id="featured_image"  >
		    		@if($errors->first('featured_image') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('featured_image')}}
					</div>
					@endif

		    	</div>
		    	<div class="form-group {{ ($errors->first('title')) ? 'has-error' : ''   }} ">
		    		<label for="title">Title</label>
		    		<input type="text" class="form-control" name="title" id="title" value="{{$post->title}}" >
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
		    		<textarea  class="form-control" rows="10" name="body" id="body" >{{$post->body}}</textarea>
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
			    			@if($post->category)
	                        <option value="{{$category->id}}"  {{($category->name == $post->category->name)? 'selected': ''  }} >{{$category->name}}</option>
	                        @else
                            <option value="{{$category->id}}"  {{($category->name == 'Uncategorized')? 'selected': ''  }} >{{$category->name}}</option>

	                        @endif
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
		    	<input type="submit" class="btn btn-primary btn-block" value="update">
		    	
		    </form>
		  </div>
		</div>

	</div>

@endsection