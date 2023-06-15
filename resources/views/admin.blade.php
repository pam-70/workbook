@extends('layouts.year')

@section('content')


<nav>



  <div class="nav nav-tabs" id="nav-tab" role="tablist">
    <button class="nav-link active" id="nav-home-tab" data-bs-toggle="tab" data-bs-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true">Просмотр результатов</button>
    <button class="nav-link" id="nav-profile-tab" data-bs-toggle="tab" data-bs-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false">Просмотр заданий</button>
    <button class="nav-link" id="nav-contact-tab" data-bs-toggle="tab" data-bs-target="#nav-contact" type="button" role="tab" aria-controls="nav-contact" aria-selected="false">Школы классы</button>
    <button class="nav-link" id="nav-install-tab" data-bs-toggle="tab" data-bs-target="#nav-install" type="button" role="tab" aria-controls="nav-install" aria-selected="false">Устаноки</button>
    <button class="nav-link" id="nav-adds-tab" data-bs-toggle="tab" data-bs-target="#nav-adds" type="button" role="tab" aria-controls="nav-adds" aria-selected="false">+ учеников</button>
    <button class="nav-link" id="nav-addts-tab" data-bs-toggle="tab" data-bs-target="#nav-addts" type="button" role="tab" aria-controls="nav-addts" aria-selected="false">+ задания</button>
    <a href="/logout" class="btn btn-danger" role="button" >X</a> 
  </div>
</nav>
<div class="container">

  <div class="tab-content" id="nav-tabContent">

    <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab"><viewingratings-component></viewingratings-component></div>
    <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab"><viewingtasks-component></viewingtasks-component></div>
    <div class="tab-pane fade" id="nav-contact" role="tabpanel" aria-labelledby="nav-contact-tab"><schoolklass-component></schoolklass-component></div>
    <div class="tab-pane fade" id="nav-install" role="tabpanel" aria-labelledby="nav-installtab"><installbaza-component></installbaza-component></div>
    <div class="tab-pane fade" id="nav-adds" role="tabpanel" aria-labelledby="nav-exit-tab"><addstudent-component> </addstudent-component></div>
    <div class="tab-pane fade" id="nav-addts" role="tabpanel" aria-labelledby="nav-exit-tab">Добавить задания</div>
   
  </div>
</div>

@endsection