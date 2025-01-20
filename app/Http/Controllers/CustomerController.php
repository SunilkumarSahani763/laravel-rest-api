<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;


class CustomerController extends Controller
{
    // Display a list of customers//*
    public function index()
    {
        $response = DB::table('customers')->get();
        return view('dashboard', compact('response'));

       
    }

    
    public function create()
    {
        return view('create');
    }

  
    

public function store(Request $request)
{
    // Validate the request//*
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'age' => 'required|integer|min:0',
        'dob' => 'required|date',
        'email' => 'required|email|unique:customers,email',
    ]);

    // Store customer data using DB facade//*
    DB::table('customers')->insert([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'age' => $request->input('age'),
        'dob' => $request->input('dob'),
        'email' => $request->input('email'),
        'created_at' => now(),
        'updated_at' => now(),
    ]);

    return redirect()->route('dashboard')->with('success', 'Customer created successfully.');
}


   
public function edit($id)
{
    $customer = DB::table('customers')->where('id', $id)->first();
    if (!$customer) {
        return redirect()->route('dashboard')->with('error', 'Customer not found.');
    }

    return view('edit', compact('customer'));
}

   
public function update(Request $request, $id)
{
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'age' => 'required|integer|min:0',
        'dob' => 'required|date',
        'email' => 'required|email|unique:customers,email,' . $id,
    ]);

    // Update the customer data//*
    $updated = DB::table('customers')->where('id', $id)->update([
        'first_name' => $request->input('first_name'),
        'last_name' => $request->input('last_name'),
        'age' => $request->input('age'),
        'dob' => $request->input('dob'),
        'email' => $request->input('email'),
        'updated_at' => now(),
    ]);

    // Check if the update was successful//*
    if ($updated) {
        return redirect()->route('dashboard')->with('success', 'Customer updated successfully.');
    } else {
        return redirect()->route('dashboard')->with('error', 'Failed to update customer.');
    }
}


public function destroy($id)
{
    // Find and delete the customer by ID
    $deleted = DB::table('customers')->where('id', $id)->delete();

    // Check if the deletion was successful
    if ($deleted) {
        return redirect()->route('dashboard')->with('success', 'Customer deleted successfully.');
    } else {
        return redirect()->route('dashboard')->with('error', 'Failed to delete customer.');
    }
}

}
