<?php
abstract class Kontroler
{
    //Pole, jeho� indexy jsou pak v pohledu jako b�n� prom�nn�
    protected array $data = array();
    //N�zev pohledu
    protected string $pohled = "";
    
    //hlavn� metoda kontroleru
    abstract function zpracuj(array $parametry) : void;
    
    //Vyp�e pohled
    public function vypisPohled() : void
    {
        if ($this->pohled)
        {
            extract($this->osetri($this->data));
            require("pohledy/" . $this->pohled . ".phtml");
        }
    }
    //P�esm�ruje na danou URL
    public function presmeruj(string $url) : never
    {
        header("Location: /$url");
        header("Connection: close");
        exit;
    }
    
    //Metoda pro automatizaci o�et�en� v�ech string prom�nn�ch proti XSS �toku
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