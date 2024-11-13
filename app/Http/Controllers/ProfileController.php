<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Cart;
use App\Models\CustomerAddress;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpKernel\Profiler\Profile;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $customer = $user->customers;

        if ($customer->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $provinces = Address::select('provinsi')
            ->distinct()
            ->orderBy('provinsi')
            ->get();

        $addresses = CustomerAddress::with('address')
            ->where('customer_id', $customer->customer_id)
            ->get();

        return view('profile.index', compact('user', 'provinces', 'addresses'));
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
        //
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
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'FName' => 'required',
            'LName' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'date_of_birth' => 'required',
        ]);

        $user = Auth::user();
        $customer = $user->customers;

        if ($customer->user_id !== $user->id) {
            abort(403, 'Anda tidak memiliki akses ke data ini.');
        }

        $user->update([
            'name' => $request->name,
        ]);

        $customer->update([
            'FName' => $request->FName,
            'LName' => $request->LName,
            'phone' => $request->phone,
            'gender' => $request->gender,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->back()->with('success', 'Profile updated successfully');
    }
}
