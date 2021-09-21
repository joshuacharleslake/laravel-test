<?php

namespace App\Http\Controllers\ClientUsers;

use App\Http\Controllers\Controller;
use App\Http\Requests\Users\UsersStoreRequest;
use App\Http\Requests\Users\UsersUpdateRequest;
use App\Models\Client;
use App\Models\User;
use Illuminate\Http\Request;

class ClientUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $users = User::where([
            ['name', '!=', null],
            [function ($query) use ($request) {
                if ( ($search = $request->search) ) {
                    $query->orWhere('name', 'LIKE', '%' . $search . '%')->get();
                    $query->orWhere('email', 'LIKE', '%' . $search . '%')->get();
                }
            }]
        ])
        ->where('role', User::ROLE_CLIENT)
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('client-users.index')
            ->with([
                'users' => $users
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $clients = Client::orderBy('name', 'asc')->get()->map->only('id', 'name');

        return view('client-users.edit')->with([
            'client_user' => new User,
            'clients' => $clients
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\Users $request
     * @return \Illuminate\Http\Response
     */
    public function store(UsersStoreRequest $request)
    {

        $user = new User();

        $user->name = $request->input('name');
        $user->email = $request->input('email');
        $user->password = bcrypt($request->input('password'));
        $user->role = User::ROLE_CLIENT;
        $user->client_id = $request->input('client_id');

        if ( $user->save() ) {

            return redirect()->route('client-users.edit', ['client_user' => $user])
                ->with('message', __('user.added'));

        }

        return redirect()->route('client-users.create')
        ->withErrors([__('user.failed_to_add')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('client-users.edit', ['client_user' => User::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $user = User::where('id', $id)->first();
        $clients = Client::orderBy('name', 'asc')->get()->map->only('id', 'name');

        return view('client-users.edit')->with([
            'client_user' => $user,
            'clients' => $clients
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UsersUpdateRequest $request, $id)
    {

        $user = User::findOrFail($id);

        $user->name = $request->input('name');
        $user->email = $request->input('email');

        if (!empty($request->input('password'))) {
            $user->password = bcrypt($request->input('password'));
        }

        $user->client_id = $request->input('client_id');

        if ( $user->update() ) {

            return redirect()->route('client-users.edit', ['client_user' => $user])
                ->with('message', __('user.updated'));

        }

        return redirect()->route('client-users.edit', ['client_user' => $user])
            ->withErrors([__('user.failed_to_update')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $user = User::find($id);

        if ( $user->delete() ) {
            return redirect()->route('client-users.index')
                ->with('message', __('user.deleted'));
        }

        return redirect()->route('client-users.index')
            ->withErrors([__('user.failed_to_delete')]);

    }
}
