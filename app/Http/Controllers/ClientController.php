<?php

namespace App\Http\Controllers;

use App\DTOs\ClientDTO;
use App\Models\Client;
use Illuminate\Http\Request;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse;

class ClientController extends Controller
{
    public function __construct(protected ClientService $service)
    {
    }
    public function index(Request $request): JsonResponse
    {
        return response()->json([
            'data' => [
                'clientes' => $this->service->list()->map(function ($cliente) {
                    return [
                        'info' => [
                            'nomeCompleto' => $cliente->name,
                            'detalhes' => [
                                'email' => $cliente->email,
                                'nascimento' => $cliente->birthdate,
                            ]
                        ],
                        'estatisticas' => [
                            'vendas' => $cliente->sales->map(function ($venda) {
                                return [
                                    'data' => $venda->date,
                                    'valor' => $venda->amount
                                ];
                            })
                        ]
                    ];
                })
            ]
        ]);
    }
    public function store(Request $request): JsonResponse
    {
        $dto = new ClientDTO(
            $request->input('name'),
            $request->input('email'),
            $request->input('birthdate')
        );
        return response()->json($this->service->create($dto), 201);
    }

    public function update(Request $request, Client $client): JsonResponse
    {
        $dto = new ClientDTO(...$request->only('name', 'email', 'birthdate'));
        return response()->json($this->service->update($client, $dto));
    }

    public function destroy(Client $client): JsonResponse
    {
        $this->service->delete($client);
        return response()->json(null, 204);
    }
}
