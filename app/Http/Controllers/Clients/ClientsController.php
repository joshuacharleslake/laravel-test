<?php

namespace App\Http\Controllers\Clients;

use App\Http\Controllers\Controller;
use App\Http\Requests\Clients\ClientsStoreRequest;
use App\Models\Client;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $clients = Client::where([
            ['name', '!=', null],
            [function ($query) use ($request) {
                if ( ($search = $request->search) ) {
                    $query->orWhere('name', 'LIKE', '%' . $search . '%')->get();
                }
            }]
        ])
        ->orderBy('id', 'desc')
        ->paginate(10);

        return view('clients.index')
            ->with([
                'clients' => $clients
            ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        return view('clients.edit')->with([
            'client' => new Client()
        ]);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request\Users $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClientsStoreRequest $request)
    {

        $client = new Client();

        $client->name = $request->input('name');
        $client->description = $request->input('description');

        if ( $client->save() ) {

            return redirect()->route('clients.edit', ['client' => $client])
                ->with('message', __('client.added'));

        }

        return redirect()->route('clients.create')
        ->withErrors([__('client.failed_to_add')]);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return redirect()->route('clients.edit', ['client' => Client::find($id)]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {

        $client = Client::where('id', $id)->first();

        return view('clients.edit')->with([
            'client' => $client
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClientsStoreRequest $request, $id)
    {

        $client = Client::findOrFail($id);

        $client->name = $request->input('name');
        $client->description = $request->input('description');

        if (!empty($request->input('password'))) {
            $client->password = bcrypt($request->input('password'));
        }

        if ( $client->update() ) {

            return redirect()->route('clients.edit', ['client' => $client])
                ->with('message', __('client.updated'));

        }

        return redirect()->route('clients.edit', ['client' => $client])
            ->withErrors([__('client.failed_to_update')]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $client = Client::find($id);

        if ( $client->delete() ) {
            return redirect()->route('clients.index')
                ->with('message', __('client.deleted'));
        }

        return redirect()->route('clients.index')
            ->withErrors([__('client.failed_to_delete')]);

    }
}
