<?php
abstract class Kontroler
{
    //Pole, jeho indexy jsou pak v pohledu jako bìné promìnné
    protected array $data = array();
    //Název pohledu
    protected string $pohled = "";
    
    //hlavní metoda kontroleru
    abstract function zpracuj(array $parametry) : void;
    
    //Vypíše pohled
    public function vypisPohled() : void
    {
        if ($this->pohled)
        {
            extract($this->osetri($this->data));
            require("pohledy/" . $this->pohled . ".phtml");
        }
    }
    //Pøesmìruje na danou URL
    public function presmeruj(string $url) : never
    {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }
    
    //Metoda pro automatizaci ošetøení všech string promìnnıch proti XSS útoku
    private function osetri($x = null)
    {
        if (!isset($x))
            return null;
        elseif (is_string ($x))
            return htmlspecialchars($x, ENT_QUOTES);
        elseif (is_array($x))
        {
            foreach($x as $k => $v)
            {
                $x[$k] = $this->osetri($v);
            }
            return $x;
        }
        else 
            return $x;
    }
}