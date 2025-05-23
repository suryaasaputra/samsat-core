<?php
namespace App\Http\Controllers;

use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use App\Models\NamaLokasi;
use App\Models\Printer;
use App\Models\Role;
use App\Models\User;
use App\Models\Wilayah;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class UserController extends Controller
{
    /**
     * Instantiate a new UserController instance.
     */
    public function __construct()
    {
        $this->middleware('permission:create-user|edit-user|delete-user', ['only' => ['index', 'show']]);
        $this->middleware('permission:create-user', ['only' => ['create', 'store']]);
        $this->middleware('permission:edit-user', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete-user', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('page.users.index', [
            'users'      => User::orderBy('created_at', 'desc')->get(),
            'page_title' => 'Users',
            'action'     => 'table_datatable_basic',
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {

        return view('page.users.create', [
            'page_title' => 'Create User',
            'roles'      => Role::pluck('name')->all(),
            'wilayah'    => Wilayah::all(),
            'lokasi'     => NamaLokasi::orderBy('kd_lokasi')->get(),
            'printer'    => Printer::all(),

        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        $input = $request->all();
        // dd($input);
        $input['password'] = Hash::make($request->password);

        $user = User::create($input);
        $user->assignRole($request->roles);

        return redirect()->route('users.index')
            ->withSuccess('New user is added successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user): View
    {

        return view('page.users.show', [
            'user'       => $user,
            'page_title' => 'Detail User ' . $user->username,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user): View
    {
        // Check Only Super Admin can update his own Profile
        if ($user->hasRole('Super Admin')) {
            if ($user->id != auth()->user()->id) {
                abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
            }
        }
        // dd($user->kd_lokasi);
        return view('page.users.edit', [
            'user'       => $user,
            'roles'      => Role::pluck('name')->all(),
            'userRoles'  => $user->roles->pluck('name')->all(),
            'page_title' => 'Edit User ' . $user->username,
            'wilayah'    => Wilayah::all(),
            'lokasi'     => NamaLokasi::all(),
            'printer'    => Printer::all(),
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        $input = $request->all();

        if (! empty($request->password)) {
            $input['password'] = Hash::make($request->password);
        } else {
            $input = $request->except('password');
        }

        $user->update($input);

        $user->syncRoles($request->roles);

        return redirect()->back()
            ->withSuccess('User is updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user): RedirectResponse
    {
        // About if user is Super Admin or User ID belongs to Auth User
        if ($user->hasRole('Super Admin') || $user->id == auth()->user()->id) {
            abort(403, 'USER DOES NOT HAVE THE RIGHT PERMISSIONS');
        }

        $user->syncRoles([]);
        $user->delete();
        return redirect()->route('users.index')
            ->withSuccess('User is deleted successfully.');
    }
}
