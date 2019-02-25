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
        $categories = ProcessCategory::orderBy('name')->get();
        return view('process.category.index', compact('categories'));
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
        $request->validate([
            'name' => 'required|max:255',
            'permission' => 'required',
        ]);
        $name = $request->input('name');
        if ($request->input('permission') == ProcessCategory::PUBLIC_PERMISSION) {
            $permission = [
                'security' => ProcessCategory::PUBLIC_PERMISSION,
                'groups' => [],
                'users' => []
            ];
            ProcessCategory::create([
                'name' => $name,
                'permission' => json_encode($permission)
            ]);
            return redirect()->route('categories.index')
                ->with('type', 'alert-success')
                ->with('msg', 'Categoria criada com sucesso.');
        } else {

            $departments = (empty($request->input('departments'))) ? [] : $request->input('departments');
            $users = (empty($request->input('users'))) ? [] : $request->input('users');

            if (empty($departments) && empty($users)) {
                return redirect()->route('categories.index')
                    ->with('type', 'alert-danger')
                    ->with('msg', 'Você deve selecionar ao menos uma restrição para categorias privadas');
            } else {
                $permission = [
                    'security' => ProcessCategory::RESTRICTED_PERMISSION,
                    'groups' => $departments,
                    'users' => $users
                ];
                ProcessCategory::create([
                    'name' => $name,
                    'permission' => json_encode($permission)
                ]);
                return redirect()->route('categories.index')
                    ->with('type', 'alert-success')
                    ->with('msg', 'Categoria criada com sucesso.');
            }
        }
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
