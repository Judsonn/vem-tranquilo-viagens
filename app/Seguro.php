<?php

namespace App;

use Validator;
use DateTime;
use Illuminate\Database\Eloquent\Model;

class Seguro extends Model
{
    protected $table = 'seguro';

    public function onibus() {
        return $this->belongsToMany('App\Onibus', 'seguro_onibus', 'seguro_id', 'onibus_id');
    }

    public function getAll()
    {
        return $this->all();
    }

    public function get(int $id){
        return $this->find($id);
    }

    public function verificarValidade(array $listaOnibus){
        foreach ($listaOnibus as $itemOnibus) {
            if($itemOnibus->seguro()->vigente){
                return $itemOnibus + " Possui um seguro vigente!";
            }
        }
    }

    public function add(array $input)
    {

        $validator = Validator::make($input, [
            'empresa' => 'required|string',
            'valor' => 'required|numeric|min:0.01',
            'assegura' => 'required|string',
            'data_vigencia' => 'required|date_format:d/m/Y|after:'. now()->format('d/m/Y'),
            'data_inicio' => 'required|date_format:d/m/Y|before:data_vigencia',
            'onibus' => 'required|array',
            'onibus' => 'unique:seguro_onibus,onibus_id'//Esta verificação não pode ser feita aqui
        ]);

        if ($validator->fails()) {
            return $validator;
        }

        $this->empresa = $input['empresa'];
        $this->valor = $input['valor'];
        $this->assegura = $input['assegura'];

        $dataConverterInicio = date_create_from_format('d/m/Y', $input['data_inicio']);
        $this->data_inicio = now()->format('Y-m-d');

        $dataConverter = date_create_from_format('d/m/Y', $input['data_vigencia']);
        $this->data_vigencia = $dataConverter->format('Y-m-d');

        $this->vigente = true;

        $this->save();
        $this->onibus()->attach($input['onibus']);
    }

    public function edit(int $id, array $input)
    {
        $seguro = $this->get($id);

        $validator = Validator::make($input, [
            'empresa' => 'required|string',
            'valor' => 'required|numeric|min:0.01',
            'assegura' => 'required|string',
            'data_vigencia' => 'required|date_format:d/m/Y|after:'. now()->format('d/m/Y'),
            'data_inicio' => 'required|date_format:d/m/Y|before:data_vigencia',
            'onibus' => 'required|array',
            'onibus' => 'unique:seguro_onibus,onibus_id'//Não pode ser feita aqui
        ]);

        if ($validator->fails()) {
            return $validator;
        }

        $seguro->empresa = $input['empresa'];
        $seguro->valor = $input['valor'];
        $seguro->assegura = $input['assegura'];

        $dataConverterInicio = date_create_from_format('d/m/Y', $input['data_inicio']);
        $seguro->data_inicio = $dataConverterInicio->format('Y-m-d');

        $dataConverter = date_create_from_format('d/m/Y', $input['data_vigencia']);
        $seguro->data_vigencia = $dataConverter->format('Y-m-d');

        $seguro->vigente = true;

        $seguro->update();
        $seguro->onibus()->attach($input['onibus']);

    }
    public function disable(int $id)
    {
        $seguro = new Seguro();
        $item = $seguro->find($id);
        if($item->data_vigencia == now()->format('Y-m-d')){
            $item->vigente = false;

        }

        $item->save();

        return $item;
    }

}
