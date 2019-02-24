<?php

namespace App\Http\Controllers;

use App\ProcessCategory;
use Illuminate\Http\Request;
use App\Group;
use App\User;

class ProcessCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('process.category.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('process.category.create', compact('groups', 'users'))->render();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProcessCategory  $processCategory
     * @return \Illuminate\Http\Response
     */
    public function show(ProcessCategory $processCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProcessCategory  $processCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcessCategory $processCategory)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProcessCategory  $processCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProcessCategory $processCategory)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProcessCategory  $processCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcessCategory $processCategory)
    {
        //
    }
}
