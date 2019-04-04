<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Funcionario;

class FuncionarioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $funcionario = new AlocarFuncionario();
        $listaDeFuncionarios = $funcionario->getAll();
        return view('funcionario', compact('listaDeFuncionarios'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('cadastroFuncionario');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {

            $funcionario = new AlocarFuncionario();
            $funcionario->add($request->input());
            return response(["status" => "Funcionário cadastrado com sucesso"], 201);

        } catch (Exception $e) {
            return response($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $funcionario = new AlocarFuncionario();
        $funcionario = $funcionario->get($id);
        return response($funcionario->toJson(), 200);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $funcionario = new AlocarFuncionario();
        $listaDeFuncionarios = $funcionario->getAll();
        $funcionarioEditado = $listaDeFuncionarios[$id];
        return "Formulario de edição para o".$funcionarioEditado->toJson();
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {

            $funcionarioEditado = new AlocarFuncionario();
            $funcionarioEditado->edit($id);
            return response(["status" => "Funcionário atualizado com sucesso"], 202);

        } catch (Exception $e) {
            return response($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $funcionario = Funcionario::where('id', $id)->first();
            if($funcionario) {
                return $funcionario->delete();
            }

        } catch (Exception $e) {
            return response($e->getMessage(), 400);
        }
    }
}
