@extends('layouts.static')
  
@section('content')
<main class="login-form">
  <div class="cotainer">
      <div class="row justify-content-center">
          <div class="col-md-12">

              <div class="card">
                  <h3 class="p-2 text-center">{!!$page->title!!}</h3>
                  <div class="card-body">
  
  {!!$page->page_content!!}
                        
                  </div>
              </div>
          </div>
      </div>
  </div>
</main>
@endsection
