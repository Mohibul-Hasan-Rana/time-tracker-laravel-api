<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\ClientRequest;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ClientController extends Controller
{
    use AuthorizesRequests;

    public function index(Request $request)
    {
        return $request->user()->clients()->get();
    }

    public function store(ClientRequest $request, Client $client)
    {
        $this->authorize('create', $client);

        $client = $request->user()->clients()->create($request->validated());
        return response()->json($client, 201);
    }

    public function update(ClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);       

        $client->update($request->validated());
        return response()->json($client);
    }

    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        $client->delete();
        return response()->json(['message' => 'Client deleted']);
    }

    public function show(Client $client)
    {
        $this->authorize('view', $client);
         return response()->json($client);
    }

   
}
