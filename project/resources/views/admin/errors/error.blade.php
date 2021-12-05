 @if ($errors->any())
    <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
               <p><i class="fas fa-times"></i> {{ $error }}</p>
            @endforeach
    </div>
@endif

 @if (Session::has('rmessage'))
	<div class="alert alert-success">
		{{Session::get('rmessage')}}
	</div>
@endif

@if (Session::has('errormessage'))
	<div class="alert alert-danger">
		{!! Session::get('errormessage') !!}
	</div>
@endif

