@extends('layouts.app')

@push('css')
<link rel="stylesheet" href="{{URL::asset('css/style.css')}}">
@endpush

@push('script')
<script src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js" integrity="sha256-eGE6blurk5sHj+rmkfsGYeKyZx3M4bG+ZlFyA7Kns7E=" crossorigin="anonymous"></script>
<script src="//cdn.tinymce.com/4/tinymce.min.js"></script>
<script>
tinymce.init({ 
	selector:'textarea', menubar: false, plugins: 'link',  
});
jQuery(document).ready(function($){
  
  //deleting post
  	$('.delete-post').click(function(e){
          e.preventDefault();
           var deleteUrl = $(this).attr('href');
           var token = $(this).data('token');

          $('<div id="dialog" class="pull-center"></div>').appendTo('body').html('<div"><h4>Are you sure you want to delete this post?</h4></div>')
          .dialog({
          	
              autoOpen: true,
              modal   : true,
              title   : 'Confirm',
              buttons: {
              	"Yes" : function(){
              		
              		$(this).dialog('close');

              		$.ajaxSetup({
              		       headers: {
              		           'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
              		       }
              		   });

              		//Delete request
              		   $.ajax({
              		       type:   'DELETE',
              		       url:    deleteUrl,
              		       data:   { _token :token },
              		       success: function(data){
              		           if (data == "true") {
              		           	
              		           	$(location).attr('href', "{{URL::to('post')}}");
              		           }
              		       }
              		   });


              	},
              	"No" : function(){
                      $(this).dialog('close');
              	}
              }
          });
          

  	});

  
  //deleting comment
	$('.edit-delete  .js-ajax-delete').click(function(e){
        e.preventDefault();
         var deleteUrl = $(this).attr('href');
         var token = $(this).data('token');

        $('<div id="dialog" class="pull-center"></div>').appendTo('body').html('<div"><h4>Are you sure you want to delete this comment?</h4></div>')
        .dialog({
        	
            autoOpen: true,
            modal   : true,
            title   : 'Confirm',
            buttons: {
            	"Yes" : function(){
            		
            		$(this).dialog('close');

            		$.ajaxSetup({
            		       headers: {
            		           'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
            		       }
            		   });

            		//Delete request
            		   $.ajax({
            		       type:   'DELETE',
            		       url:    deleteUrl,
            		       data:   { _token :token },
            		       success: function(data){
            		           if (data == "true") {
            		           	window.location.href=window.location.href;
            		           };
            		       }
            		   });


            	},
            	"No" : function(){
                    $(this).dialog('close');
            	}
            }
        });
        

	});

});
</script>
@endpush

@section('title', $post->title)

@section('content')

<div class="row">
	<div class="col-md-8">
		  <div class="panel panel-info">
		  <!-- Default panel contents -->
			  <div class="panel-heading">
			  	<h3 >{{$post->title}}</h3>
                @if($post->category)
			  	Category : <a href="{{route('category.show', $post->category->slug)}}"><span class="label label-default">{{$post->category->name}}</span></a> 
                @endif
                &nbsp; &nbsp; &nbsp;
                @if($post->tags->first())

                       Tags :
                   @foreach($post->tags as $tag)
                       <a href="{{route('tag.show', $tag->slug)}}"><span class="label label-default">{{$tag->name}}</span></a>

                   @endforeach
                
                @endif
             
			  	
			  </div>

			  <div class="panel-body">
			  	{!! $post->body !!}
			  </div>
			  <div class="panel-footer">
          <h6>Posted by: {{$post->user->name}}</h6>
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
			
			<a href="{{route('post.edit', $post->slug)}}"  type="button" class="btn btn-success pull-right ">Edit</a>		     

	</div>


    <div class="col-md-2">
    	<a href="{{route('post.destroy', $post->slug)}}" data-token="{{csrf_token()}}" class="btn btn-danger delete-post"  >Delete</a>


    	<?php
    	/*
    	<form action="{{route('post.destroy', $post->slug)}}" method="POST"  >
				{{csrf_field()}}
				{{method_field('DELETE')}}
			   <input type="submit" class="btn btn-danger" value="Delete" >
			</form>
		*/
		?>
    </div>

</div>

<div class="row">
	
	<div class="col-md-8">
		
		<div class="panel panel-info">
		  <div class="panel-heading">
		    <h3 class="panel-title">
		    	<?php
		    	echo ($comments->all())? "Comments <span class='badge'>". $comments->count()."</span>" : "Be the first to comment";

		    	?>	    	
		    </h3>
		  </div>
		  <div class="panel-body">
		  	
		  		@foreach($comments as $comment)
		  		<div class="comment">
		  			<div class="author-info clearfix">
		  				<img src="{{'https://www.gravatar.com/avatar/'.md5(strtolower(trim($comment->user->email))).'?s=50&d=mm' }}" class="author-image pull-left" alt="">

		  				<div class="author-name pull-left">
		  					<h4>{{$comment->user->name}}</h4>
		  					<p class="author-time">{{ ($comment->created_at == $comment->updated_at)? '' : 'Last updated : ' }}
                	        {{ date('M j, Y \a\t H:i a', strtotime($comment->updated_at))}}</p>
		  				    
		  				</div>
		  				<div class="edit-delete pull-right">
		  					<a href="{{route('comment.edit', $comment->id)}}"><span class="glyphicon glyphicon-pencil edit"></span></a>
		  					
		  					<a data-token="{{csrf_token()}}" class="js-ajax-delete" href="{{route('comment.destroy', $comment->id)}}" ><span class="glyphicon glyphicon-trash"></span></a>
		  				</div>

		  			</div>
		  			<div class="comment-content">
		  				
		  				{!!$comment->comment!!}
		  			</div>
		  		</div>
		  		
		  		@endforeach
		  	
		    <form action="{!! route('comment.store') !!}" method="POST">
               {{csrf_field()}}

               <input type="hidden" name="post_id" value="{{$post->id}}" >
               <input type="hidden" name="post_slug" value="{{$post->slug}}" >
		    	
		    	<div class="form-group {{ ($errors->first('comment')) ? 'has-error' : ''   }} ">
		    		<label for="body">Comment</label>
		    		<textarea  class="form-control" rows="10" name="comment" id="comment" placeholder="Enter your comment here..." ></textarea>
		    		@if($errors->first('comment') )
		    		<div class="alert alert-danger" role="alert">
					  <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span>
					  <span class="sr-only">Error:</span>
					  {{$errors->first('comment')}}
					</div>
					@endif

		    	</div>

		    	<input type="submit" class="btn btn-primary btn-block" value="Submit">
		    	
		    </form>
		  </div>
		</div>
	</div>
</div>



@endsection