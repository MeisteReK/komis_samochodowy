@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <div class="card mx-auto" style="max-width: 800px;">
        @if ($offer->image)
            <div class="card-img-container">
                <img src="{{ asset('storage/' . $offer->image) }}" class="card-img-top" alt="{{ $offer->car_model }}">
            </div>
        @endif
        <div class="card-body">
            <h5 class="card-title fw-bold fs-4">{{ $offer->car_model }}</h5>
            <p class="card-text">{{ $offer->description }}</p>
            @if ($offer->discount > 0)
                <h3 class="card-text text-danger">
                    <strong>{{ number_format($offer->price * (1 - $offer->discount / 100), 0, ',', ' ') }} PLN</strong>
                    <span class="text-decoration-line-through ms-3">{{ number_format($offer->price, 0, ',', ' ') }} PLN</span>
                    <span class="badge bg-success ms-3">{{ $offer->discount }}% OFF</span>
                </h3>
            @else
                <h3 class="card-text text-danger"><strong>{{ number_format($offer->price, 0, ',', ' ') }} PLN</strong></h3>
            @endif

            <p class="card-text">Liczba rezerwacji: {{ $reservationCount }}</p>

            @if ($offer->carSpecification)
                <ul class="list-group list-group-flush mt-3">
                    <li class="list-group-item">Silnik: {{ $offer->carSpecification->engine }}</li>
                    <li class="list-group-item">Skrzynia biegów: {{ $offer->carSpecification->transmission }}</li>
                    <li class="list-group-item">Kolor: {{ $offer->carSpecification->color }}</li>
                    <li class="list-group-item">Rok produkcji: {{ $offer->carSpecification->year }}</li>
                    <li class="list-group-item">Przebieg: {{ $offer->carSpecification->mileage }} km</li>
                    <li class="list-group-item">Wyświetlenia: {{ $offer->views_count }}</li>
                </ul>
            @endif
        </div>
    </div>
</div>
@endsection
