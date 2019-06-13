<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cidade;
use App\TrajetoIntermunicipal;

class VendaPassagemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cidades = new Cidade();
        $cidades = $cidades->getAll();
        return view('vendaPassagem.main.index', compact('cidades'));
    }

    public function search(Request $request) {
        $origem = $request->input('origem');
        $destino = $request->input('destino');

        $dataConverter = date_create_from_format('d/m/Y', $request->input('data'));
        $data = $dataConverter->format('Y-m-d');

        return redirect()
            ->route('vendaPassagem.list', ["origem" => $origem, "destino" => $destino, "data" => $data]);
    }

    public function list($origem, $destino, $data)
    {
        $cidades = new Cidade();
        $cidades = $cidades->getAll();

        $trajetos = new TrajetoIntermunicipal();
        $trajetosDisponiveis = $trajetos->getByFilter($origem, $destino, $data);
        $trajetos = $trajetosDisponiveis;


        $data_converter = date_create_from_format('Y-m-d', $data);
        $data = $data_converter->format('d/m/Y');
        return view('vendaPassagem.main.index', compact('cidades', 'trajetos', 'origem', 'destino', 'data'));
    }
}