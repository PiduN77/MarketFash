<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\CustomerAddress;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AddressController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'kodepos' => 'required|string',
            'street_address' => 'required|string',
            'type' => 'required|string',
        ]);

        $address = Address::where([
            'provinsi' => $validatedData['provinsi'],
            'kabupaten' => $validatedData['kabupaten'],
            'kecamatan' => $validatedData['kecamatan'],
            'kelurahan' => $validatedData['kelurahan'],
            'kodepos' => $validatedData['kodepos'],
        ])->first();

        if (!$address) {
            $address = Address::create([
                'provinsi' => $validatedData['provinsi'],
                'kabupaten' => $validatedData['kabupaten'],
                'kecamatan' => $validatedData['kecamatan'],
                'kelurahan' => $validatedData['kelurahan'],
                'kodepos' => $validatedData['kodepos'],
            ]);
        }

        CustomerAddress::create([
            'customer_id' => Auth::user()->customers->customer_id,
            'fullName' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'address_id' => $address->address_id,
            'address_detail' => $validatedData['street_address'],
            'mark_as' => $validatedData['type'],
        ]);

        return redirect()->back()->with('success', 'Address added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $customerAddress = CustomerAddress::with('address')->findOrFail($id);

        if ($customerAddress->customer_id !== Auth::user()->customers->customer_id) {
            abort(403, 'Unauthorized action.');
        }

        return response()->json($customerAddress);
    }

    public function update(Request $request, $id)
    {
        $customerAddress = CustomerAddress::findOrFail($id);

        if ($customerAddress->customer_id !== Auth::user()->customers->customer_id) {
            abort(403, 'Unauthorized action.');
        }

        $validatedData = $request->validate([
            'name' => 'required|string',
            'phone' => 'required|string',
            'provinsi' => 'required|string',
            'kabupaten' => 'required|string',
            'kecamatan' => 'required|string',
            'kelurahan' => 'required|string',
            'kodepos' => 'required|string',
            'street_address' => 'required|string',
            'type' => 'required|string',
        ]);

        // Find or create address record
        $address = Address::firstOrCreate(
            [
                'provinsi' => $validatedData['provinsi'],
                'kabupaten' => $validatedData['kabupaten'],
                'kecamatan' => $validatedData['kecamatan'],
                'kelurahan' => $validatedData['kelurahan'],
                'kodepos' => $validatedData['kodepos'],
            ]
        );

        // Update customer address
        $customerAddress->update([
            'fullName' => $validatedData['name'],
            'phone' => $validatedData['phone'],
            'address_id' => $address->address_id,
            'address_detail' => $validatedData['street_address'],
            'mark_as' => $validatedData['type'],
        ]);

        return redirect()->back()->with('success', 'Address updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $customerAddress = CustomerAddress::findOrFail($id);

        $customerAddress->delete();

        return redirect()->back()->with('success', 'Address deleted successfully');
    }
}
