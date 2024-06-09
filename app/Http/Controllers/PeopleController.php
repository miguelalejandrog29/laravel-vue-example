<?php

namespace App\Http\Controllers;

use App\Models\People;
use App\Http\Requests\StorePeopleRequest;
use App\Http\Requests\UpdatePeopleRequest;
use Inertia\Inertia;

class PeopleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return Inertia::render('People', ['tableData' => People::all(), 'people' => People::find(session('person_id'))]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePeopleRequest $request)
    {
        People::create([
            'dni' => $request->dni,
            'name' => $request->name,
            'last_name' => $request->last_name,
            'phone' => $request->phone,
            'address' => $request->address
        ]);

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show($person)
    {
        return back()->with('person_id', $person);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePeopleRequest $request, People $person)
    {
        $person->dni =  $request->dni;
        $person->name =  $request->name;
        $person->last_name =  $request->last_name;
        $person->phone =  $request->phone;
        $person->address =  $request->address;

        $person->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(People $person)
    {
        try {
            $person->delete();

            return back();
        } catch (\Throwable $th) {
            return abort(__('messages.parent_content_locked'));
        }
    }
}
