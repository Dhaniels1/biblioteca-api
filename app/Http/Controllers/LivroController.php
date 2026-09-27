<?php

namespace App\Http\Controllers;

use App\Http\Requests\LivroRequest;
use App\Models\Livro;
use Illuminate\Http\JsonResponse;

class LivroController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Livro::with(['autor', 'categoria'])->orderBy('idlivro')->get());
    }

    public function store(LivroRequest $request): JsonResponse
    {
        $livro = Livro::create($request->validated());

        return response()->json($livro->load(['autor', 'categoria']), 201);
    }

    public function show(Livro $livro): JsonResponse
    {
        return response()->json($livro->load(['autor', 'categoria']));
    }

    public function update(LivroRequest $request, Livro $livro): JsonResponse
    {
        $livro->update($request->validated());

        return response()->json($livro->load(['autor', 'categoria']));
    }

    public function destroy(Livro $livro): JsonResponse
    {

        $livro->delete();

        return response()->json(['message' => 'Registro excluído com sucesso.']);
    }
}
