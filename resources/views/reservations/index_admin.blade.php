@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Wszystkie rezerwacje</h1>
    <div class="table-responsive">
        <table class="table table-bordered table-hover">
            <thead class="thead-light">
                <tr>
                    <th>Model samochodu</th>
                    <th>Użytkownik</th>
                    <th>Zarezerwowane</th>
                    <th>Status</th>
                    <th>Akcje</th>
                </tr>
            </thead>
            <tbody>
                @foreach($reservations as $reservation)
                    <tr>
                        <td>{{ $reservation->offer->car_model }}</td>
                        <td>{{ $reservation->user->name }}</td>
                        <td>{{ $reservation->reserved_at }}</td>
                        <td>
                            <form action="{{ route('reservations.update_status', $reservation->id) }}" method="POST">
                                @csrf
                                @method('PATCH')
                                <select name="status" class="form-select">
                                    <option value="pending" {{ $reservation->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="processed" {{ $reservation->status == 'processed' ? 'selected' : '' }}>Processed</option>
                                    <option value="completed" {{ $reservation->status == 'completed' ? 'selected' : '' }}>Completed</option>
                                </select>
                                <button type="submit" class="btn btn-sm btn-primary mt-2">Zaktualizuj status</button>
                            </form>
                        </td>
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
</div>
@endsection
