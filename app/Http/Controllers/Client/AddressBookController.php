<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\AddressBook;
use App\User;
use Illuminate\Http\Request;

class AddressBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $userAddress = User::find(auth()->user()->id)->addressBooks;
        return response()->json($userAddress);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required|max:80',
            'lastName' => 'required|max:80',
            'address' => 'required|max:80',
            'postalCode' => 'required|max:6',
            'city' => 'required|max:80',
            'country' => 'required|max:80',
            'phone' => 'required|max:80',
        ]);

        $newAddress = new AddressBook();

        $newAddress->firstName = $request->get('firstName');
        $newAddress->lastName = $request->get('lastName');
        $newAddress->address = $request->get('address');
        $newAddress->additionalAddress = $request->get('additionalAddress') ? $request->get('additionalAddress') : '';
        $newAddress->postalCode = $request->get('postalCode');
        $newAddress->city = $request->get('city');
        $newAddress->country = $request->get('country');
        $newAddress->phone = $request->get('phone');

        $newAddress->user_id = auth()->user()->id;

        $newAddress->save();

        return response()->json($newAddress);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\AddressBook  $addressBook
     * @return \Illuminate\Http\Response
     */
    public function show(AddressBook $addressBook)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\AddressBook  $addressBook
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, AddressBook $addressBook)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\AddressBook  $addressBook
     * @return \Illuminate\Http\Response
     */
    public function destroy(AddressBook $addressBook)
    {
        //
    }
}
