@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-default">
                <div class="panel-heading">Hello, {{Auth::user()->name}}</div>

                    <div class="panel-body">
                        <div class="well well-lg">
                            <h4>Name: {{Auth::user()->name}}</h4>
                            <h4>Email: {{Auth::user()->email}}</h4>
                            <h4>Role : {{Auth::user()->role}}</h4>
                        </div>
                   
                     @if(Auth::user()->role != 'subscriber')
                       @if(!$posts->isEmpty())
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
                       @else

                       <h4>You didn't create any post yet</h4>

                       @endif
                      @endif
         
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
