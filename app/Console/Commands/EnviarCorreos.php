<?php namespace Tiqueso\Console\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use App\clases\ExtensorDeComando;
use App\clases\Correo;



class EnviarCorreos extends ExtensorDeComando {

    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'EnviarCorreos';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Esta función toma los correos no enviados y los empieza a enviar en bloques de 10 correos como máximo';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function fire(){
        $this->header();
        $this->main();
        $this->endCommand();
    }

    public function main(){
        $res = Correo::obtenerCorreosParaEnviar(10);
        if(count($res) == 0){
            $this->line("No se encontraron correos");
            return;
        }
        $this->line(count($res)." correos para enviar");

        foreach($res AS $r){
            $this->cleanLine();
            $this->line("INICIO------------------------");
            $this->line("-- ID: ".$r->id);
            $this->line("-- Tema: ".$r->tema);
            $this->line("-- Cuerpo: "."Sin mostrar");
            $this->line("-- Plantilla: ".$r->plantilla);
            $this->line("-- Para Correo: ".$r->para_correo);
            $this->line("-- Para Nombre: ".$r->para_nombre);
            $this->line("-- Creado: ".$r->created_at);
            $this->line("");
            $this->line("Preparando para enviar el correo");
            $r = Correo::enviarDesdeRegistro($r);
            if($r){
                $this->line("FIN--------------------------");
            }else{
                $this->line("ERROR DE CORREO");
            }

            $this->cleanLine();
        }

    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            //['example', InputArgument::REQUIRED, 'An example argument.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            //['example', null, InputOption::VALUE_OPTIONAL, 'An example option.', null],
        ];
    }

}
