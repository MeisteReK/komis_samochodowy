@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h1 class="mb-4">Edytuj użytkownika</h1>
    <div class="card">
        <div class="card-body">
            <form action="{{ route('users.update', $user->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="form-group mb-3">
                    <label for="name" class="form-label">Nazwa</label>
                    <input type="text" name="name" id="name" class="form-control" value="{{ $user->name }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" name="email" id="email" class="form-control" value="{{ $user->email }}" required>
                </div>
                <div class="form-group mb-3">
                    <label for="role" class="form-label">Rola</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="client" {{ $user->role == 'client' ? 'selected' : '' }}>Client</option>
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Zaktualizuj użytkownika</button>
            </form>
        </div>
    </div>
</div>
@endsection
