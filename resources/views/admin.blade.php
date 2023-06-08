@extends('layouts.year')

@section('content')


<nav>



  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Просмотр результатов</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Просмотр заданий</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Школы классы</button>
    <button class="nav-link" id="nav-exit-tab" data-bs-toggle="tab" data-bs-target="#nav-exit" type="button" role="tab" aria-controls="nav-exit" aria-selected="false">99999999</button>
  
  </div>
</nav>
<div class="container">

  <div class="tab-content" id="nav-tabContent">

    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><viewingratings-component></viewingratings-component></div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab">Просмотр заданий</div>
    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"><schoolklass-component></schoolklass-component></div>
    <div class="tab-pane fade" id="nav-exit" role="tabpanel" aria-labelledby="nav-exit-tab">999999999999999</div>
  </div>
</div>

@endsection