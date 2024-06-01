<?php

namespace App\Http\Controllers;

use App\Models\Offer;
use App\Models\CarSpecification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class OfferController extends Controller
{
    public function index(Request $request)
    {
        $offers = Offer::with('carSpecification')
        ->when($request->filled('car_model'), function ($query) use ($request) {
            $query->where('car_model', 'like', '%' . $request->car_model . '%');
        })
        ->when($request->filled('min_price'), function ($query) use ($request) {
            $query->whereRaw('price * (1 - discount / 100) >= ?', [$request->min_price]);
        })
        ->when($request->filled('max_price'), function ($query) use ($request) {
            $query->whereRaw('price * (1 - discount / 100) <= ?', [$request->max_price]);
        })
        ->when($request->filled('year'), function ($query) use ($request) {
            $query->whereHas('carSpecification', function ($query) use ($request) {
                $query->where('year', $request->year);
            });
        })
        ->when($request->filled('transmission'), function ($query) use ($request) {
            $query->whereHas('carSpecification', function ($query) use ($request) {
                $query->where('transmission', 'like', '%' . $request->transmission . '%');
            });
        })
        ->when($request->filled('color'), function ($query) use ($request) {
            $query->whereHas('carSpecification', function ($query) use ($request) {
                $query->where('color', 'like', '%' . $request->color . '%');
            });
        })
        ->orderBy('featured', 'desc') // Add this line
        ->orderBy('created_at', 'desc')
        ->get();

    return view('offers.index', compact('offers'));
}

    public function show($id)
    {
        $offer = Offer::findOrFail($id);
        DB::statement('CALL increment_views_count(?)', [$offer->id]);

        // Uzyskaj liczbę rezerwacji dla danej oferty
        $reservationCount = DB::table('reservations')
            ->where('offer_id', $id)
            ->count();

        return view('offers.show', compact('offer', 'reservationCount'));
    }

    public function create()
    {
        return view('offers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'car_model' => 'required',
            'description' => 'required',
            'price' => 'required|numeric',
            'discount' => 'nullable|numeric|min:0|max:100',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'engine' => 'required|string|max:255',
            'transmission' => 'required|string|max:255',
            'color' => 'required|string|max:255',
            'year' => 'required|integer',
            'mileage' => 'required|integer',
            'featured' => 'sometimes|boolean',
            'is_new' => 'sometimes|boolean',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('offers', 'public');
        }

        $offer = Offer::create([
            'car_model' => $request->input('car_model'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'discount' => $request->input('discount'),
            'image' => $imagePath,
            'featured' => $request->input('featured', false),
            'is_new' => $request->input('is_new', false),
        ]);

        CarSpecification::create([
            'offer_id' => $offer->id,
            'engine' => $request->input('engine'),
            'transmission' => $request->input('transmission'),
            'color' => $request->input('color'),
            'year' => $request->input('year'),
            'mileage' => $request->input('mileage'),
        ]);

        return redirect()->route('offers.index')->with('success', 'Oferta i specyfikacja samochodu zostały dodane.');
    }

    public function edit(Offer $offer)
    {
        return view('offers.edit', compact('offer'));
    }

    public function update(Request $request, $id)
    {
        $offer = Offer::findOrFail($id);
        $carSpecification = $offer->carSpecification;


        $imagePath = $offer->image;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('offers', 'public');
        }

        $offer->update([
            'car_model' => $request->input('car_model'),
            'description' => $request->input('description'),
            'price' => $request->input('price'),
            'image' =>$imagePath,
            'discount' => $request->input('discount'),
            'featured' => $request->has('featured'),
            'is_new' => $request->has('is_new'),
        ]);

        $carSpecification->update([
            'transmission' => $request->input('transmission'),
            'color' => $request->input('color'),
            'year' => $request->input('year'),
            'mileage' => $request->input('mileage'),
        ]);

        return redirect()->route('offers.index')->with('success', 'Oferta zaktualizowana pomyślnie');
    }

    public function destroy(Offer $offer)
    {
        if ($offer->image) {
            Storage::delete('public/' . $offer->image);
        }
        $offer->delete();
        return redirect()->route('offers.index')->with('success', 'Oferta usunięta pomyślnie.');
    }
}
