<?php

namespace App\Http\Controllers;

use App\Models\Categories;
use App\Models\Customers;
use Cassandra\Custom;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class CustomersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|alpha_dash|min:3|max:15',
            'last_name' => 'required|alpha_dash|min:2|max:20',
            'email' => 'required|email|unique:customers',
            'phone' => 'numeric|nullable|unique:customers',
            'category' => 'required|numeric',
        ], $messages = [
            'first_name.required' => 'Your first name is required.',
            'last_name.required' => 'Your last name is required.',
            'first_name.min' => 'Your full name is required.',
            'first_name.max' => 'Your full name is required.',
            'last_name.min' => 'Your real last name is required.',
            'last_name.max' => 'Your real last name is required.',
            'email.required' => 'Your full email is required.',
            'email.email' => 'Your full email is required',
            'email.unique' => 'Sorry, the email you just wrote is already taken.',
            'phone.numeric' => 'The phone number you entered has to be only numbers.',
            'phone.max' => 'Please provide us with a single phone number only.',
            'phone.unique' => 'Sorry, the phone number you provided is already taken.',
            'category.required' => 'Your category is required.'
        ]);

        $customer = new Customers();
        $customer->first_name = $request->first_name;
        $customer->last_name = $request->last_name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->category = $request->category;
        $customer->save();

        return redirect()->route('form')->with('status', 'Form created for '. $request->first_name . ' ' . $request->last_name . ' successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param Customers $customers
     * @return Response
     */
    public function show(Customers $customers)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Customers $customers
     * @return Application|Factory|View
     */
    public function edit(Customers $customer)
    {
        $categories = Categories::all();
        $customer = Customers::find($customer->id);

        return view('welcome', compact('categories', 'customer'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Customers $customers
     * @return RedirectResponse
     */
    public function update(Request $request, Customers $customer)
    {
        $validated = $request->validate([
            'first_name' => 'required|alpha_dash|min:3|max:15',
            'last_name' => 'required|alpha_dash|min:2|max:20',
            'email' => ['required', 'email', Rule::unique('customers')->ignore($customer->id)],
            'phone' => ['numeric', 'nullable', Rule::unique('customers')->ignore($customer->id)],
            'category' => 'required|numeric',
        ], $messages = [
            'first_name.required' => 'Your first name is required.',
            'last_name.required' => 'Your last name is required.',
            'first_name.min' => 'Your full name is required.',
            'first_name.max' => 'Your full name is required.',
            'last_name.min' => 'Your real last name is required.',
            'last_name.max' => 'Your real last name is required.',
            'email.required' => 'Your full email is required.',
            'email.email' => 'Your full email is required',
            'email.unique' => 'Sorry, the email you just wrote is already taken.',
            'phone.numeric' => 'The phone number you entered has to be only numbers.',
            'phone.max' => 'Please provide us with a single phone number only.',
            'phone.unique' => 'Sorry, the phone number you provided is already taken.',
            'category.required' => 'Your category is required.'
        ]);

        Customers::where('id', $request->id)->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'email' => $request->email,
            'category' => $request->category
        ]);

        return redirect()->route('dashboard');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customers $customers
     * @return string
     */
    public function destroy(Customers $customers)
    {
        return $customers->id . ' deleted successfully!';
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customers $customer
     * @return RedirectResponse
     */
    public function delete(Customers $customer) {
        $customer->delete();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Customers $customer
     * @return RedirectResponse
     */
    public function restore($customer) {
        //Customers::where('id', $customer)->update(['deleted_at' => null, 'first_name' => 'Andrew']);
        DB::table('customers')
            ->where('id', $customer)
            ->update(['deleted_at' => null]);
        return back();
    }
}
