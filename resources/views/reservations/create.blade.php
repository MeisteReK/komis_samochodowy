@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Nowa rezerwacja</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('reservations.store') }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label for="offer_id" class="form-label">Wybierz ofertę</label>
                    <select name="offer_id" id="offer_id" class="form-control" required>
                        @foreach($offers as $offer)
                            <option value="{{ $offer->id }}">{{ $offer->car_model }} - {{ $offer->price }} PLN</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Zarezerwuj</button>
            </form>
        </div>
    </div>
</div>
@endsection
