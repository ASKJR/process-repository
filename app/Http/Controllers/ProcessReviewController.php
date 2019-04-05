<?php

namespace App\Http\Controllers;

use App\Process;
use App\User;
use App\ProcessReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProcessReviewController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('process.permission');
        $this->middleware('committee')->except('index', 'show', 'downloadReviewFile');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Process $process)
    {
        $isCommitteeMember = auth()->user()->isCommitteeMember();
        $reviewCount = $process->reviews->count();
        return view('process.review.index', compact('process', 'isCommitteeMember', 'reviewCount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Process $process)
    {
        $users = User::vip()
            ->orWhere('is_process_committee_member', 1)
            ->orWhereIn('id', $process->category->permission['users'])
            ->orderBy('name')
            ->get();
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
        $request->validate([
            'comments' => 'required',
            'processFile' => 'required|file|mimes:jpeg,png,rar|max:2048',
            'owner_id' => 'required|numeric',
            'review_due_date' => 'required|date_format:d/m/Y'
        ]);

        $filename = $request->processFile->store('process/reviews');
        $reviewDate =  \Carbon\Carbon::createFromFormat('d/m/Y H:i:s', $request->review_due_date . " 23:59:59");

        ProcessReview::create([
            'comments' => $request->comments,
            'filename' => $filename,
            'process_id' => $process->id,
            'created_by' => auth()->user()->id,
            'owner_id' => $request->owner_id,
            'review_due_date' => $reviewDate->format('Y-m-d H:i:s')
        ]);

        return redirect()->route('reviews.index', $process->id)
            ->with('type', 'alert-success')
            ->with('msg', 'Revisão criada com sucesso');
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
    public function destroy(Process $process, ProcessReview $review)
    {
        if ($review->delete()) {
            return json_encode(['success' => 'true']);
        }

        return json_encode(['error' => 'true']);
    }

    public function downloadReviewFile(Process $process, ProcessReview $review)
    {
        return Storage::download($review->filename);
    }
}
