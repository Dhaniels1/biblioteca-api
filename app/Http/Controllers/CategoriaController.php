<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoriaRequest;
use App\Models\Categoria;
use Illuminate\Http\JsonResponse;

class CategoriaController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Categoria::query()->orderBy('idcategoria')->get());
    }

    public function store(CategoriaRequest $request): JsonResponse
    {
        $categoria = Categoria::create($request->validated());

        return response()->json($categoria, 201);
    }

    public function show(Categoria $categoria): JsonResponse
    {
        return response()->json($categoria);
    }

    public function update(CategoriaRequest $request, Categoria $categoria): JsonResponse
    {
        $categoria->update($request->validated());

        return response()->json($categoria);
    }

    public function destroy(Categoria $categoria): JsonResponse
    {
        if ($categoria->livros()->exists()) {
            return response()->json(['message' => 'Remova ou transfira os livros vinculados antes de excluir.'], 409);
        }
        $categoria->delete();

        return response()->json(['message' => 'Registro excluído com sucesso.']);
    }
}
