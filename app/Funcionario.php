<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Validator;
use Exception;

class Funcionario extends Model
{
    protected $table = 'funcionarios';

    public function tipo() {
        return $this->hasOne('App\TipoFuncionario', 'id', 'tipo_id');
    }

    public function getAll()
    {
        return $this->all();
    }

    public function getByTipoId(int $tipo_id) {
        return $this->where('tipo_id', $tipo_id)->get();
    }

    public function get(int $id){
        $funcionario = $this->find($id);
        return $funcionario;
    }

    public function add(array $input)
    {
        $validator = Validator::make($input, [
            'nome' => 'required|string',
            'tipo' => 'required|exists:tipos_funcionario,id'
        ]);

        if ($validator->fails()) {
            return $validator;
        }
        //Funcionario::where('id', $id)->first();

        $this->nome = $input['nome'];
        $this->tipo_id = $input['tipo'];

        $this->save();
    }

    public function edit(int $id, array $input)
    {
        $funcionario = $this->find($id);

        $validator = Validator::make($input, [
            'nome' => 'required|string',
            'tipo_id' => 'required|exists:tipos_funcionario,id'

        ]);
        if ($validator->fails()) {
            return $validator;
        }
        $funcionario->nome = $input['nome'];
        $funcionario->tipo = $input['tipo_id'];

        $funcionario->save();
    }

    public function remove(int $id)
    {
        return $this->destroy($id);
    }
}