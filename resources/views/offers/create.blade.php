@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Dodaj nową ofertę</h1>
    <form action="{{ route('offers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="form-group mb-3">
            <label for="car_model" class="form-label">Model samochodu</label>
            <input type="text" name="car_model" id="car_model" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="description" class="form-label">Opis</label>
            <textarea name="description" id="description" class="form-control" required></textarea>
        </div>
        <div class="form-group mb-3">
            <label for="price" class="form-label">Cena</label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>
        <div class="mb-3">
    <label for="discount" class="form-label">Discount (%)</label>
    <input type="number" name="discount" class="form-control" id="discount" value="{{ old('discount', $offer->discount ?? 0) }}">
         </div>

        <div class="form-group mb-3">
            <label for="image" class="form-label">Zdjęcie</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>
        <div class="form-group mb-3">
            <label for="engine" class="form-label">Silnik</label>
            <input type="text" name="engine" id="engine" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="transmission" class="form-label">Skrzynia biegów</label>
            <input type="text" name="transmission" id="transmission" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="color" class="form-label">Kolor</label>
            <input type="text" name="color" id="color" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="year" class="form-label">Rok produkcji</label>
            <input type="number" name="year" id="year" class="form-control" required>
        </div>
        <div class="form-group mb-3">
            <label for="mileage" class="form-label">Przebieg</label>
            <input type="number" name="mileage" id="mileage" class="form-control" required>
        </div>
        <div class="form-check">
    <input class="form-check-input" type="checkbox" name="is_new" id="is_new" {{ old('is_new', $offer->is_new ?? false) ? 'checked' : '' }}>
    <label class="form-check-label" for="is_new">
        Nowość!
    </label>
</div>
        <div class="form-check mb-3">
            <input type="checkbox" name="featured" class="form-check-input" id="featured">
            <label class="form-check-label" for="featured">Wyróżniona oferta</label><br><br>
        <button type="submit" class="btn btn-primary">Dodaj ofertę</button>
    </form>

</div>

@endsection
