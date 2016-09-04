@extends('layouts.app')

@section('title', 'Blog List')

@section('content')

<div class="row">
  <div class="col-md-10">
      <div class="panel panel-info">
      <!-- Default panel contents -->
        <div class="panel-heading"><h3 >Welcome to Larablog</h3></div>

        <!-- Table -->
        <table class="table table-striped table-bordered"> 
          
           <tbody>
            
                   @foreach($posts as $post)
            <tr>  
              <td >
                <h3>{{$post->title}}</h3>
                {!!substr($post->body,0, 100)!!} <a href="{{route('post.show', $post->slug)}}"><span class="more"> Read More...</span></a>

              </td>
            </tr>  
            
                   @endforeach
          </tbody> 
        </table>
    </div>
  </div>
  <div class="col-md-2">
    <ul>
      <li>section 1</li>
      <li>section 2</li>
      <li>section</li>
      <li>section</li>
    </ul>
  </div>
</div>

@endsection