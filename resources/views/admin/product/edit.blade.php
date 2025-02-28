@extends('layouts.admin')
@section('title', $viewData["title"])
@section('content')
    <div class="card mb-4">
        <div class="card-header">
            {{ __('admin/Product.edit_product') }}
        </div>
        <div class="card-body">
            @if($errors->any())
                <ul class="alert alert-danger list-unstyled">
                    @foreach($errors->all() as $error)
                        <li>- {{ $error }}</li>
                    @endforeach
                </ul>
            @endif
            <form method="POST" action="{{ route('admin.product.update', ['id'=> $viewData['product']->getId()]) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{ __('admin/Product.name') }}:</label>
                            <div class="col-lg-10 col-md-6 col-sm-12">
                                <input name="name" value="{{ $viewData['product']->getName() }}" type="text"
                                       class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{ __('admin/Product.price') }}:</label>
                            <div class="col-lg-10 col-md-6 col-sm-12">
                                <input name="price" value="{{ $viewData['product']->getPrice() }}" type="number"
                                       class="form-control" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3 row">
                            <label class="col-lg-2 col-md-6 col-sm-12 col-form-label">{{ __('admin/Product.image') }}:</label>
                            <div class="col-lg-10 col-md-6 col-sm-12">
                                <input class="form-control" type="file" name="image" id="imageInput">
                                <input type="hidden" name="current_image" value="{{ $viewData['product']->getImage() }}">
                                <img id="imagePreview" src="{{ asset($viewData['product']->getImage()) }}"
                                     alt="Current Image" class="img-fluid mt-2" style="max-height: 150px;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('admin/Product.storage_type') }}:</label>
                    <select name="storage_type" class="form-control" required>
                        <option value="gcp" {{ old('storage_type', 'gcp') == 'gcp' ? 'selected' : '' }}>
                            {{ __('admin/Product.cloud_storage') }}
                        </option>
                        <option value="local" {{ old('storage_type') == 'local' ? 'selected' : '' }}>
                            {{ __('admin/Product.local_storage') }}
                        </option>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('admin/Product.description') }}</label>
                    <textarea class="form-control" name="description" rows="3" required>{{ $viewData['product']->getDescription() }}</textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('admin/Product.species') }}:</label>
                    <select name="species_id" class="form-control" required>
                        @foreach($viewData['species'] as $species)
                            <option value="{{ $species->getId() }}" {{ $viewData['product']->getSpecies()->getId() == $species->getId() ? 'selected' : '' }}>
                                {{ $species->getName() }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">{{ __('admin/Product.category') }}:</label>
                    <select name="category_id" class="form-control" required>
                        @foreach($viewData['categories'] as $category)
                            <option value="{{ $category->getId() }}" {{ $viewData['product']->getCategory()->getId() == $category->getId() ? 'selected' : '' }}>
                                {{ $category->getName() }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">{{ __('admin/Product.edit_button') }}</button>
            </form>
        </div>
    </div>
     <script src="{{ asset('js/product/image_preview.js') }}"></script>
@endsection
