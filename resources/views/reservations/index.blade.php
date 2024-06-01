@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Moje rezerwacje</h1>
    <a href="{{ route('reservations.create') }}" class="btn btn-primary mb-4">Dodaj nową rezerwację</a>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Model samochodu</th>
                    <th>Zarezerwowane</th>
                    <th>Status</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->offer->car_model }}</td>
                        <td>{{ $reservation->reserved_at }}</td>
                        <td>{{ $reservation->status }}</td>
                        <td>
                            <form action="{{ route('reservations.destroy', $reservation->id) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger">Usuń</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <a href="{{ route('reservations.total_cost', auth()->user()->id) }}" class="btn btn-secondary mt-4">Zobacz całkowity koszt rezerwacji</a>
</div>
@endsection
