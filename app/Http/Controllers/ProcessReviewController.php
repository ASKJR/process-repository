<?php

namespace App\Http\Controllers;

use App\Process;
use App\User;
use App\ProcessReview;
use Illuminate\Http\Request;

class ProcessReviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('process.permission');
        $this->middleware('committee')->except('index', 'show');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Process $process)
    {
        $isCommitteeMember = auth()->user()->isCommitteeMember();
        return view('process.review.index', compact('process', 'isCommitteeMember'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Process $process)
    {
        $users = User::orderBy('name')->get();
        return view('process.review.create', compact('process', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Process $process)
    {
        dd('store');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\ProcessReview  $processReview
     * @return \Illuminate\Http\Response
     */
    public function show(ProcessReview $processReview)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProcessReview  $processReview
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcessReview $processReview)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProcessReview  $processReview
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProcessReview $processReview)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\ProcessReview  $processReview
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcessReview $processReview)
    {
        //
    }
}
