@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1>Edytuj Ofertę</h1>
    <form action="{{ route('offers.update', $offer->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="car_model" class="form-label">Model Samochodu</label>
            <input type="text" class="form-control" id="car_model" name="car_model" value="{{ $offer->car_model }}" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Opis</label>
            <textarea class="form-control" id="description" name="description" required>{{ $offer->description }}</textarea>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Cena</label>
            <input type="number" class="form-control" id="price" name="price" value="{{ $offer->price }}" required>
        </div>
        <div class="mb-3">
            <label for="discount" class="form-label">Rabat (%)</label>
            <input type="number" class="form-control" id="discount" name="discount" value="{{ $offer->discount }}" min="0" max="100">
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Zdjęcie</label>
            <input type="file" class="form-control" id="image" name="image">
            @if($offer->image)
                <img src="{{ asset('storage/' . $offer->image) }}" alt="{{ $offer->car_model }}" style="height: 100px;">
            @endif
        </div>
        <div class="mb-3">
            <label for="engine" class="form-label">Silnik</label>
            <input type="text" class="form-control" id="engine" name="engine" value="{{ $offer->carSpecification->engine }}" required>
        </div>
        <div class="mb-3">
            <label for="transmission" class="form-label">Skrzynia Biegów</label>
            <input type="text" class="form-control" id="transmission" name="transmission" value="{{ $offer->carSpecification->transmission }}" required>
        </div>
        <div class="mb-3">
            <label for="color" class="form-label">Kolor</label>
            <input type="text" class="form-control" id="color" name="color" value="{{ $offer->carSpecification->color }}" required>
        </div>
        <div class="mb-3">
            <label for="year" class="form-label">Rok Produkcji</label>
            <input type="number" class="form-control" id="year" name="year" value="{{ $offer->carSpecification->year }}" required>
        </div>
        <div class="mb-3">
            <label for="mileage" class="form-label">Przebieg</label>
            <input type="number" class="form-control" id="mileage" name="mileage" value="{{ $offer->carSpecification->mileage }}" required>
        </div>
        <input class="form-check-input" type="checkbox" name="is_new" id="is_new" {{ old('is_new', $offer->is_new ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_new">
        Nowość!
    </label>
        <div class="form-check mb-3">
            <input type="checkbox" class="form-check-input" id="featured" name="featured" {{ $offer->featured ? 'checked' : '' }}>
            <label class="form-check-label" for="featured">Wyróżniona</label>
        </div>
        <button type="submit" class="btn btn-primary">Zaktualizuj Ofertę</button>
    </form>
</div>
@endsection
