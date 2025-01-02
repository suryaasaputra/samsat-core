<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:create-permission|edit-permission|delete-permission', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-permission', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-permission', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-permission', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the permissions.
     */
    public function index(): View
    {
        return view('page.permissions.index', [
            'permissions' => Permission::orderBy('id', 'DESC')->paginate(10),
            'page_title' => 'Permissions',
        ]);
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create(): View
    {
        return view('page.permissions.create', [
            'page_title' => 'Create Permission',
        ]);
    }

    /**
     * Store a newly created permission in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name|max:255',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()->route('permissions.index')
            ->withSuccess('Permission created successfully.');
    }

    /**
     * Show the specified permission.
     */
    public function show(Permission $permission): View
    {
        return view('page.permissions.show', [
            'permission' => $permission,
        ]);
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Permission $permission): View
    {
        return view('page.permissions.edit', [
            'permission' => $permission,
            'page_title' => 'Edit Permission',
        ]);
    }

    /**
     * Update the specified permission in storage.
     */
    public function update(Request $request, Permission $permission): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|unique:permissions,name,' . $permission->id . '|max:255',
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()->route('permissions.index')
            ->withSuccess('Permission updated successfully.');
    }

    /**
     * Remove the specified permission from storage.
     */
    public function destroy(Permission $permission): RedirectResponse
    {
        if ($permission->roles()->count() > 0) {
            return redirect()->back()
                ->with('error', 'Cannot delete a permission assigned to roles.');
        }

        $permission->delete();

        return redirect()->route('permissions.index')
            ->withSuccess('Permission deleted successfully.');
    }
}
