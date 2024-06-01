<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Offer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReservationController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware(\App\Http\Middleware\AdminMiddleware::class)->only(['indexAdmin']);
    }

    public function index()
    {
        $reservations = Reservation::with('offer')->where('user_id', Auth::id())->get();
        return view('reservations.index', compact('reservations'));
    }

    public function indexAdmin()
    {
        $reservations = Reservation::with('offer', 'user')->get();
        return view('reservations.index_admin', compact('reservations'));
    }

    public function create()
    {
        $offers = Offer::all();
        return view('reservations.create', compact('offers'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'offer_id' => 'required|exists:offers,id',
        ]);

        Reservation::create([
            'user_id' => Auth::id(),
            'offer_id' => $request->offer_id,
            'reserved_at' => now(),
        ]);

        return redirect()->route('reservations.index')->with('success', 'Reservation created successfully.');
    }

    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservations.index')->with('success', 'Reservation deleted successfully.');
    }

    public function processReservations()
    {
        DB::statement('CALL ProcessReservations()');
        return redirect()->route('reservations.index_admin')->with('success', 'Reservations processed successfully.');
    }

    public function updateStatus(Request $request, Reservation $reservation)
    {
        $request->validate([
            'status' => 'required|string',
        ]);

        $reservation->update(['status' => $request->status]);

        return redirect()->route('reservations.index_admin')->with('success', 'Reservation status updated successfully.');
    }

    public function totalCost($userId)
    {
        // Wywołanie funkcji użytkownika
        $totalCost = DB::select('SELECT CalculateTotalReservationCost(?) AS total_cost', [$userId]);

        return view('reservations.total_cost', ['totalCost' => $totalCost[0]->total_cost]);
    }
}
