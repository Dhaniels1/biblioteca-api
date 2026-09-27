<?php

namespace App\Http\Controllers;

use App\Http\Requests\AutorRequest;
use App\Models\Autor;
use Illuminate\Http\JsonResponse;

class AutorController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json(Autor::query()->orderBy('idautor')->get());
    }

    public function store(AutorRequest $request): JsonResponse
    {
        $autor = Autor::create($request->validated());

        return response()->json($autor, 201);
    }

    public function show(Autor $autor): JsonResponse
    {
        return response()->json($autor);
    }

    public function update(AutorRequest $request, Autor $autor): JsonResponse
    {
        $autor->update($request->validated());

        return response()->json($autor);
    }

    public function destroy(Autor $autor): JsonResponse
    {
        if ($autor->livros()->exists()) {
            return response()->json(['message' => 'Remova ou transfira os livros vinculados antes de excluir.'], 409);
        }
        $autor->delete();

        return response()->json(['message' => 'Registro excluído com sucesso.']);
    }
}
