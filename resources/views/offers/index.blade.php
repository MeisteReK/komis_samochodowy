@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Oferty</h1>

    <!-- Formularz filtrowania -->
    <form action="{{ route('offers.index') }}" method="GET" class="mb-4">
        <div class="row">
            <div class="col-md-3">
                <input type="text" name="car_model" class="form-control" placeholder="Model samochodu" value="{{ request('car_model') }}">
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="number" name="min_price" id="min_price" class="form-control" placeholder="Min. cena" value="{{ request('min_price') }}">
                    <span class="input-group-text">PLN</span>
                </div>
            </div>
            <div class="col-md-3">
                <div class="input-group">
                    <input type="number" name="max_price" id="max_price" class="form-control" placeholder="Max. cena" value="{{ request('max_price') }}">
                    <span class="input-group-text">PLN</span>
                </div>
            </div>
            <div class="col-md-3">
                <input type="number" name="year" class="form-control" placeholder="Rok produkcji" value="{{ request('year') }}">
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-3">
                <input type="text" name="transmission" class="form-control" placeholder="Skrzynia biegów" value="{{ request('transmission') }}">
            </div>
            <div class="col-md-3">
                <input type="text" name="color" class="form-control" placeholder="Kolor" value="{{ request('color') }}">
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Filtruj</button>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-6">
                <label for="minPriceRange" class="form-label">Minimalna cena</label>
                <input type="range" class="form-range" id="minPriceRange" min="0" max="1000000" step="1000" value="{{ request('min_price', 0) }}" oninput="updateMinPrice(this.value)">
                <p>Minimalna cena: <span id="minPriceValue">{{ request('min_price', 0) }}</span> PLN</p>
            </div>
            <div class="col-md-6">
                <label for="maxPriceRange" class="form-label">Maksymalna cena</label>
                <input type="range" class="form-range" id="maxPriceRange" min="0" max="1000000" step="1000" value="{{ request('max_price', 1000000) }}" oninput="updateMaxPrice(this.value)">
                <p>Maksymalna cena: <span id="maxPriceValue">{{ request('max_price', 1000000) }}</span> PLN</p>
            </div>
        </div>
    </form>

    <h2 class="mb-4">Wyróżnione Oferty</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($offers->where('featured', true) as $offer)
            <div class="col">
                <div class="card h-100">
                    @if ($offer->image)
                        <a href="{{ route('offers.show', $offer->id) }}">
                            <img src="{{ asset('storage/' . $offer->image) }}" class="card-img-top" alt="{{ $offer->car_model }}" style="height: 200px; object-fit: cover;">
                        </a>
                    @else
                        <a href="{{ route('offers.show', $offer->id) }}">
                            <img src="{{ asset('path/to/default/image.jpg') }}" class="card-img-top" alt="{{ $offer->car_model }}" style="height: 200px; object-fit: cover;">
                        </a>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title fw-bold fs-4">
                            {{ $offer->car_model }}
                            @if ($offer->is_new)
                                <span class="badge bg-primary">Nowość</span>
                            @endif
                        </h5>
                        <p class="card-text">{{ Str::limit($offer->description, 100) }}</p>
                        <p class="card-text text-muted">
                            {{ $offer->carSpecification->year ?? 'Rok nieznany' }} •
                            {{ number_format($offer->carSpecification->mileage ?? 0, 0, ',', ' ') }} km •
                            {{ $offer->carSpecification->transmission ?? 'Nieznana skrzynia' }} •
                            {{ $offer->carSpecification->engine ?? 'Nieznany silnik' }}
                        </p>


                        @if ($offer->discount > 0)
                        <h3 class="card-text text-danger">
                            <strong>{{ number_format($offer->price * (1 - $offer->discount / 100), 0, ',', ' ') }} PLN</strong>
                            <span class="text-decoration-line-through ms-3">{{ number_format($offer->price, 0, ',', ' ') }} PLN</span>
                            <span class="badge bg-success ms-3">{{ $offer->discount }}% OFF</span>
                        </h3>
                        @else
                            <h3 class="card-text text-danger"><strong>{{ number_format($offer->price, 0, ',', ' ') }} PLN</strong></h3>
                        @endif

                    </div>
                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-sm btn-outline-secondary">Zobacz</a>
                            @auth
                                @if (auth()->user()->role == 'admin')
                                    <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-sm btn-primary">Edytuj</a>
                                    <form action="{{ route('offers.destroy', $offer->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Usuń</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <h2 class="mt-5 mb-4">Wszystkie Oferty</h2>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($offers->where('featured', false) as $offer)
            <div class="col">
                <div class="card h-100">
                    @if ($offer->image)
                        <a href="{{ route('offers.show', $offer->id) }}">
                            <img src="{{ asset('storage/' . $offer->image) }}" class="card-img-top" alt="{{ $offer->car_model }}" style="height: 200px; object-fit: cover;">
                        </a>
                    @else
                        <a href="{{ route('offers.show', $offer->id) }}">
                            <img src="{{ asset('path/to/default/image.jpg') }}" class="card-img-top" alt="{{ $offer->car_model }}" style="height: 200px; object-fit: cover;">
                        </a>
                    @endif
                    <div class="card-body">
                        <h5 class="card-title fw-bold fs-4">
                            {{ $offer->car_model }}
                            @if ($offer->is_new)
                                <span class="badge bg-primary">Nowość</span>
                            @endif
                        </h5>
                        <p class="card-text">{{ Str::limit($offer->description, 100) }}</p>
                        <p class="card-text text-muted">
                            {{ $offer->carSpecification->year ?? 'Rok nieznany' }} •
                            {{ number_format($offer->carSpecification->mileage ?? 0, 0, ',', ' ') }} km •
                            {{ $offer->carSpecification->transmission ?? 'Nieznana skrzynia' }} •
                            {{ $offer->carSpecification->engine ?? 'Nieznany silnik' }}
                        </p>
                        @if ($offer->discount > 0)
                            <h3 class="card-text text-danger">
                                <strong>{{ number_format($offer->price * (1 - $offer->discount / 100), 0, ',', ' ') }} PLN</strong>
                                <span class="text-decoration-line-through ms-3">{{ number_format($offer->price, 0, ',', ' ') }} PLN</span>
                                <span class="badge bg-success ms-3">{{ $offer->discount }}% OFF</span>
                            </h3>
                        @else
                            <h3 class="card-text text-danger"><strong>{{ number_format($offer->price, 0, ',', ' ') }} PLN</strong></h3>
                        @endif

                    </div>
                    <div class="card-footer">
                        <div class="btn-group">
                            <a href="{{ route('offers.show', $offer->id) }}" class="btn btn-sm btn-outline-secondary">Zobacz</a>
                            @auth
                                @if (auth()->user()->role == 'admin')
                                    <a href="{{ route('offers.edit', $offer->id) }}" class="btn btn-sm btn-primary">Edytuj</a>
                                    <form action="{{ route('offers.destroy', $offer->id) }}" method="POST" style="display:inline-block;">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">Usuń</button>
                                    </form>
                                @endif
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const minPriceRange = document.getElementById('minPriceRange');
        const maxPriceRange = document.getElementById('maxPriceRange');
        const minPriceValue = document.getElementById('minPriceValue');
        const maxPriceValue = document.getElementById('maxPriceValue');
        const minPriceInput = document.getElementById('min_price');
        const maxPriceInput = document.getElementById('max_price');

        function updateMinPrice(value) {
            minPriceValue.textContent = value;
            minPriceInput.value = value;
        }

        function updateMaxPrice(value) {
            maxPriceValue.textContent = value;
            maxPriceInput.value = value;
        }

        minPriceRange.addEventListener('input', function(e) {
            updateMinPrice(e.target.value);
        });

        maxPriceRange.addEventListener('input', function(e) {
            updateMaxPrice(e.target.value);
        });

        // Initialize the ranges with current input values
        updateMinPrice(minPriceInput.value);
        updateMaxPrice(maxPriceInput.value);
    });
</script>
@endsection
