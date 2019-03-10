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
        $this->middleware('committee')->except('index');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = ProcessCategory::getCategoriesAllowedToUser();
        $isCommitteeMember = auth()->user()->isCommitteeMember();
        return view('process.category.index', compact('categories', 'isCommitteeMember'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $groups = Group::orderBy('name')->get();
        return view('process.category.create', compact('groups'))->render();
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
                'permission' => [],
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
                    ->with('msg', 'Você deve selecionar retrições de setor e/ou usuários, quando a categoria for restrita.');
            } else {
                ProcessCategory::create([
                    'name' => $name,
                    'permission' => $this->getPermissionsFormatted($permissions),
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
    public function show(ProcessCategory $category)
    {
        if ($category->visibility == ProcessCategory::PUBLIC_PERMISSION) {
            return view('process.category.show', compact('category'));
        } else {
            $groupIds = $category->permission['groups'];
            $userIds = $category->permission['users_selected'];
            $groups = empty($groupIds) ? 'Não disponível' : Group::wherein('id', $groupIds)->pluck('name')->implode(', ');
            $users = empty($userIds) ? 'Não disponível' : User::wherein('id', $userIds)->pluck('name')->implode(', ');

            return view('process.category.show', compact('category', 'groups', 'users'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\ProcessCategory  $processCategory
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcessCategory $category)
    {
        $groups = Group::orderBy('name')->get();
        return view('process.category.edit', compact('groups', 'category'))->render();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\ProcessCategory  $processCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, ProcessCategory $category)
    {
        $request->validate([
            'name' => 'required|max:255',
            'visibility' => 'required',
        ]);

        $name = $request->input('name');

        if ($request->input('visibility') == ProcessCategory::PUBLIC_PERMISSION) {
            $category->name = $name;
            $category->permission = [];
            $category->visibility = ProcessCategory::PUBLIC_PERMISSION;

            if ($category->update()) {
                return redirect()->route('categories.index')
                    ->with('type', 'alert-success')
                    ->with('msg', 'Categoria atualizada com sucesso.');
            }

            return redirect()->route('categories.index')
                ->with('type', 'alert-danger')
                ->with('msg', 'Não foi possível atualizar essa categoria.');
        } else {

            $permissions = (empty($request->input('permissions'))) ? [] : $request->input('permissions');

            if (empty($permissions)) {
                return redirect()->route('categories.index')
                    ->with('type', 'alert-danger')
                    ->with('msg', 'Você deve selecionar retrições de setor e/ou usuários, quando a categoria for restrita.');
            }

            $category->name = $name;
            $category->permission = $this->getPermissionsFormatted($permissions);
            $category->visibility = ProcessCategory::RESTRICTED_PERMISSION;

            if ($category->update()) {
                return redirect()->route('categories.index')
                    ->with('type', 'alert-success')
                    ->with('msg', 'Categoria atualizada com sucesso.');
            }

            return redirect()->route('categories.index')
                ->with('type', 'alert-danger')
                ->with('msg', 'Não foi possível atualizar essa categoria.');
        }
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

    private function getPermissionsFormatted($permissions)
    {
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

        return $permission;
    }
}
