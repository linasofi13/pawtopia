@extends('layouts.app')
@section("title", $viewData["title"])
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">{{ __('Pet.edit_pet_title') }}</div>
                    <div class="card-body">
                        @if($errors->any())
                            <ul id="errors" class="alert alert-danger list-unstyled">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        @endif
                        <form method="POST" action="{{ route('pet.update', ['id' => $viewData['pet']->getId()]) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group mb-2">
                                <label for="name">{{ __('Pet.enter_name_field') }}</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $viewData['pet']->getName()) }}" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="image">{{ __('Pet.pet_image_field') }}</label>
                                <input type="file" class="form-control" id="image" name="image">
                                <input type="hidden" name="current_image" value="{{ $viewData['pet']->getImage() }}">
                                <small>{{ __('Pet.alert_upload_image') }}</small>
                                <div class="mt-2">
                                    <img id="imagePreview" src="{{ asset($viewData['pet']->getImage()) }}" alt="Current Image" class="img-fluid" style="max-height: 150px;">
                                </div>
                            </div>

                            <div class="form-group mb-2">
                                <label for="storage_type">{{ __('Pet.select_storage_type') }}</label>
                                <select id="storage_type" name="storage_type" class="form-control" required>
                                    <option value="gcp" {{ old('storage_type', 'gcp') == 'gcp' ? 'selected' : '' }}>{{ __('Pet.cloud_storage') }}</option>
                                    <option value="local" {{ old('storage_type', 'gcp') == 'local' ? 'selected' : '' }}>{{ __('Pet.local_storage') }}</option>
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="species_id">{{ __('Pet.enter_species_field') }}</label>
                                <select id="species_id" name="species_id" class="form-control" required>
                                    <option value="">{{ __('Pet.select_species') }}</option>
                                    @foreach ($viewData['species'] as $species)
                                        <option value="{{ $species->getId() }}" {{ $viewData['pet']->getSpecies()->getId() == $species->getId() ? 'selected' : '' }}>
                                            {{ $species->getName() }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group mb-2">
                                <label for="breed">{{ __('Pet.enter_breed') }}</label>
                                <input type="text" class="form-control" id="breed" name="breed" value="{{ old('breed', $viewData['pet']->getBreed()) }}" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="birthDate">{{ __('Pet.enter_birth_date') }}</label>
                                <input type="date" class="form-control" id="birthDate" name="birthDate" value="{{ old('birthDate', $viewData['pet']->getBirthDate()) }}" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="characteristics">{{ __('Pet.select_characteristics') }}</label>
                                <div class="form-group mb-2">
                                    <label for="color">{{ __('Pet.color') }}</label>
                                    <select class="form-control" id="color" name="characteristics[color]">
                                        <option value="">{{ __('Pet.select_color') }}</option>
                                        <option value="green" {{ old('characteristics.color', $viewData['pet']->getCharacteristics()['color']) == 'green' ? 'selected' : '' }}>{{ __('Pet.green') }}</option>
                                        <option value="brown" {{ old('characteristics.color', $viewData['pet']->getCharacteristics()['color']) == 'brown' ? 'selected' : '' }}>{{ __('Pet.brown') }}</option>
                                        <option value="black" {{ old('characteristics.color', $viewData['pet']->getCharacteristics()['color']) == 'black' ? 'selected' : '' }}>{{ __('Pet.black') }}</option>
                                        <option value="white" {{ old('characteristics.color', $viewData['pet']->getCharacteristics()['color']) == 'white' ? 'selected' : '' }}>{{ __('Pet.white') }}</option>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="size">{{ __('Pet.size') }}</label>
                                    <select class="form-control" id="size" name="characteristics[size]">
                                        <option value="">{{ __('Pet.select_size') }}</option>
                                        <option value="Small" {{ old('characteristics.size', $viewData['pet']->getCharacteristics()['size']) == 'Small' ? 'selected' : '' }}>{{ __('Pet.small') }}</option>
                                        <option value="Medium" {{ old('characteristics.size', $viewData['pet']->getCharacteristics()['size']) == 'Medium' ? 'selected' : '' }}>{{ __('Pet.medium') }}</option>
                                        <option value="Large" {{ old('characteristics.size', $viewData['pet']->getCharacteristics()['size']) == 'Large' ? 'selected' : '' }}>{{ __('Pet.large') }}</option>
                                    </select>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="temperament">{{ __('Pet.temperament') }}</label>
                                    <select class="form-control" id="temperament" name="characteristics[temperament]">
                                        <option value="">{{ __('Pet.select_temperament') }}</option>
                                        <option value="Friendly" {{ old('characteristics.temperament', $viewData['pet']->getCharacteristics()['temperament']) == 'Friendly' ? 'selected' : '' }}>{{ __('Pet.friendly') }}</option>
                                        <option value="Aggressive" {{ old('characteristics.temperament', $viewData['pet']->getCharacteristics()['temperament']) == 'Aggressive' ? 'selected' : '' }}>{{ __('Pet.aggressive') }}</option>
                                        <option value="Calm" {{ old('characteristics.temperament', $viewData['pet']->getCharacteristics()['temperament']) == 'Calm' ? 'selected' : '' }}>{{ __('Pet.calm') }}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group mb-2">
                                <label for="medications">{{ __('Pet.medications') }}</label>
                                <input type="text" class="form-control" id="medications" name="medications" value="{{ old('medications', $viewData['pet']->getMedications()) }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="feeding">{{ __('Pet.feeding') }}</label>
                                <input type="text" class="form-control" id="feeding" name="feeding" value="{{ old('feeding', $viewData['pet']->getFeeding()) }}">
                            </div>
                            <div class="form-group mb-2">
                                <label for="veterinaryNotes">{{ __('Pet.enter_veterinary_notes') }}</label>
                                <input type="text" class="form-control" id="veterinaryNotes" name="veterinaryNotes" value="{{ old('veterinaryNotes', $viewData['pet']->getVeterinaryNotes()) }}">
                            </div>
                            <div class="form-group">
                                <input type="submit" class="btn btn-custom" value="{{ __('Pet.update') }}">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="{{ asset('js/product/image_preview.js') }}"></script>
@endsection
