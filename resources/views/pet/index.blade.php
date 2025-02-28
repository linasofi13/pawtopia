@extends('layouts.app')
@section('title', $viewData["title"])
@section('subtitle', $viewData["subtitle"])
@section('content')
<div class="d-flex justify-content-center mb-4">
  <a href="{{ route('pet.create') }}" class="btn btn-success btn-lg">{{ __('Pet.create_new_pet_button') }}</a>
</div>
<div class="row">
  @foreach ($viewData["pets"] as $pet)
  <div class="col-md-4 col-lg-3 mb-2">
    <div class="card pet-card">
      <div class="card-body text-center">
        <img src="{{ $pet->getImage() }}" alt="{{ $pet->getName() }}" class="img-fluid mb-2" style="max-height: 150px; object-fit: cover;">

        <a href="{{ route('pet.show', ['id'=> $pet->getId()]) }}" class="btn text-white" style="background-color: #ffa500;">
          <strong>{{ $pet->getName() }}</strong>
          ({{ $pet->getAge() }} {{ __('Pet.years_old') }})
          - {{ $pet->species->getName() }}
        </a>
      </div>
    </div>
  </div>
  @endforeach
</div>
@endsection
