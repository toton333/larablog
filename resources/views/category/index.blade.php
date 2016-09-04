@extends('layouts.app')

@section('title', 'Category List')

@section('content')

<div class="row">
	<div class="col-md-8">
		  <div class="panel panel-info">
		  <!-- Default panel contents -->
			  <div class="panel-heading"><h3 >List of categories</h3></div>

			  <!-- Table -->
			  <table class="table table-striped table-bordered"> 
			  	<thead> 
			  		<tr> <th >#</th> <th>Category Name</th> </tr>
			  	 </thead>
			  	 <tbody>
			  	 	<?php $i =1; ?>
                   @foreach($categories as $category)
			  	  <tr> <th scope="row">{{$i}}</th> <td ><a href="{{route('category.show', $category->slug)}}">{{$category->name}}</a></td></tr> 	
			  	  <?php $i++; ?>
                   @endforeach
			  	</tbody> 
			  </table>
		</div>
	</div>
	<div class="col-md-4">
		@if(Auth::user()->role == 'admin')
		<a href="{{route('category.create')}}" type="button" class="btn btn-primary pull-right">Create new category</a>
	    @endif
	</div>
</div>

@endsection