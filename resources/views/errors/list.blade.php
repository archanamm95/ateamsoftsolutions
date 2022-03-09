@if($errors->any())
  <div class="alert alert-danger">
             <ul class="error-list">
			@foreach ($errors->all() as $error)
				<li class="error-list-each">{{ $error }}</li>
			@endforeach
		</ul>
          </div>
@endif