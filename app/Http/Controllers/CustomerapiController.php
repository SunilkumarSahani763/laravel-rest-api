<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
// use Illuminate\Support\Facades\Auth; 

class CustomerapiController extends Controller
{
    /**
     * Protect all routes in this controller with the 'auth' middleware.
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Get all customers
     */
    public function index()
{
    // Fetch all customers from the database
    $customers = Customer::all();

    // Return the list of customers in JSON format
    return response()->json([
        'message' => 'Customers retrieved successfully',
        'data' => $customers,
    ], 200);
}


    /**
     * Store a new customer
     */
    public function store(Request $request)
{
    // Validate the request
    $validated = $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'age' => 'required|integer|min:0',
        'dob' => 'required|date',
        'email' => 'required|email|unique:customers,email',
    ]);

    // Create a new customer and return a response
    $customer = Customer::create($validated);

    if ($customer) {
        return response()->json([
            'message' => 'Customer added successfully',
            'data' => $customer,
        ], 201);
    }

    return response()->json(['message' => 'Customer not inserted'], 400);
}


    /**
     * Get a single customer by ID
     */
    public function show($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        return response()->json($customer, 200);
    }

    /**
     * Update a customer
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        // Validate input data
        $validated = $request->validate([
            'first_name' => 'sometimes|string|max:255',
            'last_name' => 'sometimes|string|max:255',
            'age' => 'sometimes|integer|min:1|max:120',
            'dob' => 'sometimes|date',
            'email' => 'sometimes|email|unique:customers,email,' . $id,
        ]);

        // Update the customer record
        $customer->update($validated);

        return response()->json([
            'message' => 'Customer updated successfully',
            'customer' => $customer,
        ], 200);
    }

    /**
     * Delete a customer
     */
    public function destroy($id)
    {
        $customer = Customer::find($id);

        if (!$customer) {
            return response()->json(['message' => 'Customer not found'], 404);
        }

        $customer->delete();

        return response()->json(['message' => 'Customer deleted successfully'], 200);
    }
}
