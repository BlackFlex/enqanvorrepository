@extends('front.layout')
@section('content')	
    <!-- slider ends -->
    <div class="container offers">
        <div class="row">
		{{$user->screen_name}} <br>
		{{$user->email}} <br>
		{{$user->brief_intro}} <br>
		{{$user->my_service}} <br>
		{{$user->horo_sign}} <br>
		
        </div>
    </div>
    

    
@endsection
  