<?php

namespace Tiqueso;

use Illuminate\Database\Eloquent\Model;

class proceso extends Model
{
    public $timestamps = false;

    private $usuario_iniciado = null;
    private $usuario_finalizado = null;
    private $participantes = null;

    /*
     * Esta función devuelve en un array la lista de códigos de procesos
     * */
    public function obtenerCodigos(){
        return explode(',',$this->productos_proceso);

    }

    public function usuario_inicial(){
        if($this->usuario_iniciado == null){
            $this->usuario_iniciado = usuario::find($this->iniciado_por);
        }
        return $this->usuario_iniciado;
    }

    public function usuario_final(){
        if($this->usuario_finalizado == null){
            $this->usuario_finalizado = usuario::find($this->finalizado_por);
        }
        return $this->usuario_finalizado;
    }

    public function obtenerDuracion(){
        $inicio = new \DateTime($this->iniciado_fecha);
        $fin    = new \DateTime($this->finalizado_fecha);
        return date_diff($inicio,$fin);
    }

    public function obtenerParticipantes(){
        if($this->participantes == null){
            $this->participantes = [];
            $res = \DB::table('usuario_proceso')->where('proceso_id',$this->id)->get();
            foreach($res AS $r){
                    $aux_u = usuario::find($r->usuario_id);
                    if($aux_u != null){
                        $this->participantes[] = $aux_u;
                    }
            }
        }
        return $this->participantes;
    }

}
