<?php

namespace App\Http\Controllers;

use App\Process;
use App\ProcessCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ProcessController extends Controller
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
    public function index(ProcessCategory $category)
    {
        $isCommitteeMember = auth()->user()->isCommitteeMember();
        return view('process.index', compact('category', 'isCommitteeMember'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(ProcessCategory $category)
    {
        return view('process.create', compact('category'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, ProcessCategory $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'cover' => 'required|file|mimes:jpeg,png|max:1024'
        ]);

        $cover = $request->cover->store('process/covers', 'public');

        Process::create([
            'name' => $request->name,
            'description' => $request->description,
            'cover' => $cover,
            'process_category_id' => $category->id,
            'created_by' => auth()->user()->id
        ]);

        return redirect()->route('processes.index', $category->id)
            ->with('type', 'alert-success')
            ->with('msg', 'Processo criado com sucesso.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function show(ProcessCategory $category, Process $process)
    {
        $imgSrc = Storage::url($process->cover);
        return view('process.show', compact('category', 'process', 'imgSrc'))->render();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcessCategory $category, Process $process)
    {
        $categories = ProcessCategory::orderBy('name')->get();
        return view('process.edit', compact('category', 'process', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProcessCategory $category, Process $process)
    {

        $request->validate([
            'name' => 'required|max:255',
            'description' => 'required',
            'cover' => 'nullable|file|mimes:jpeg,png|max:1024',
            'category' => 'required'
        ]);

        $process->name = $request->name;
        $process->description = $request->description;
        $process->process_category_id = $request->category;

        if (!empty($request->cover)) {
            //removing last cover
            Storage::disk('public')->delete($process->cover);
            $newCover = $request->cover->store('process/covers', 'public');
            $process->cover = $newCover;
        }

        if ($process->update()) {
            return redirect()->route('processes.index', $category->id)
                ->with('type', 'alert-success')
                ->with('msg', 'Processo atualizado com sucesso.');
        }

        return redirect()->route('processes.index', $category->id)
            ->with('type', 'alert-danger')
            ->with('msg', 'Não foi possível atualizar esse processo.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Process  $process
     * @return \Illuminate\Http\Response
     */
    public function destroy(Process $process)
    {
        //
    }
}
