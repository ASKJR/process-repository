<?php

namespace App\Http\Controllers;

use App\ProcessCategory;
use Illuminate\Http\Request;
use App\Group;
use App\User;

class ProcessCategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

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
            'visibility' => 'required',
        ]);
        $name = $request->input('name');
        if ($request->input('visibility') == ProcessCategory::PUBLIC_PERMISSION) {
            ProcessCategory::create([
                'name' => $name,
                'permission' => json_encode([]),
                'visibility' => ProcessCategory::PUBLIC_PERMISSION
            ]);
            return redirect()->route('categories.index')
                ->with('type', 'alert-success')
                ->with('msg', 'Categoria criada com sucesso.');
        } else {

            $permissions = (empty($request->input('permissions'))) ? [] : $request->input('permissions');

            if (empty($permissions)) {
                return redirect()->route('categories.index')
                    ->with('type', 'alert-danger')
                    ->with('msg', 'Você deve selecionar retrições para o setor e/ou usuários.');
            } else {
                $usersIds = [];
                $usersSelected = [];
                $groupIds = [];

                foreach ($permissions as $permission) {
                    if ($permission[0] == 'g') {
                        $groupId = explode("_", $permission)[1];
                        $group = Group::findOrFail($groupId);
                        $usersIds = array_merge($usersIds, $group->users->pluck('id')->all());
                        $groupIds[] = $groupId;
                    } else {
                        $userId = explode("_", $permission)[1];

                        if (!in_array($userId, $usersIds)) {
                            $usersIds[] = $userId;
                        }
                        $usersSelected[] = $userId;
                    }
                }
                $permission = [
                    'users' => $usersIds,
                    'users_selected' => $usersSelected, //usuários selecionados individualmente
                    'groups' => $groupIds
                ];
                ProcessCategory::create([
                    'name' => $name,
                    'permission' => json_encode($permission),
                    'visibility' => ProcessCategory::RESTRICTED_PERMISSION
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
