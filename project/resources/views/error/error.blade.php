

@if ($errors->any())  
@foreach ($errors->all() as $error)
   <div class="alert alert-danger"> <i class="fas fa-exclamation-triangle"></i> {{$error}}</div>
@endforeach
@endif



 @if (Session::has('rmessage'))
	<div class="alert alert-success">
		<i class="fas fa-check-circle"></i>
		{{Session::get('rmessage')}}
	</div>
@endif



@if (Session::has('errormessage'))
	 <div class="alert alert-danger"> <i class="fas fa-exclamation-triangle"></i> {{Session::get('errormessage')}}</div>
@endif





