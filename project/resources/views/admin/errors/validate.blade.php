 @if ($errors->any())
    <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
               <p><i class="fas fa-times"></i> {{ $error }}</p>
            @endforeach
    </div>
@endif


