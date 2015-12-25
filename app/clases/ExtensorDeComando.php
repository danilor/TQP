<?php namespace App\clases;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;

class ExtensorDeComando extends Command {

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public $stared = null;
    public $aspectW = 0,$aspectWE = 0;
    public $endText = "Comando Finalizado";
    public function __construct()
    {
        parent::__construct();
    }
    public function header(){
        $this->stared = new \DateTime();
        if(isset($this->name) && $this->name != ""){
            $this->aspectW = 60;
            if(strlen($this->name) % 2 == 1){
                $this->aspectW = 51;
            }
            $spaces = (($this->aspectW-4) - strlen($this->name))/2;
            $this->info(str_repeat("=",$this->aspectW));
            $this->info("**". str_repeat(" ",$spaces) . str_repeat(" ",strlen($this->name)) .str_repeat(" ",$spaces)  ."**");
            $this->info("**". str_repeat(" ",$spaces) . $this->name .str_repeat(" ",$spaces)  ."**");
            $this->info("**". str_repeat(" ",$spaces) . str_repeat(" ",strlen($this->name)) .str_repeat(" ",$spaces)  ."**");
            $this->info(str_repeat("=",$this->aspectW));
            $this->cleanLine(1);
            $this->instruction("Bienvenido a $this->name Comando de Artisan.");
            if(isset($this->description) && $this->description != "") $this->instruction($this->description);


        }
    }

    public function endCommand(){
        $this->cleanLine();
        $this->aspectWE = $this->aspectW-20;
        if(strlen($this->endText) % 2 == 1){
            $this->aspectWE = 51;
        }
        $spaces = (($this->aspectWE-4) - strlen($this->endText))/2;
        $this->info(str_repeat("=",$this->aspectWE));
        $this->info("**". str_repeat(" ",$spaces) . $this->endText .str_repeat(" ",$spaces)  ."**");
        $this->info(str_repeat("=",$this->aspectWE));
        $endDate = new \DateTime();
        $d = $this->stared->diff(new \DateTime());
        $this->comment("Al comando le tomó ".$d->s." segundos para terminar");
    }

    public function cleanLine($n = 1){
        for($i=1;$i<=$n;$i++){
            $this->info(" ");
        }

    }
    public function instruction($t){
        $this->info("== ".$t);
    }
    public function line($t){
        $this->info("- ".$t);
    }

}
