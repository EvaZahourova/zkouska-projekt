<?php
class SmerovacKontroler extends Kontroler
//Kontroler, který podle URL zavolá správný kontroler a jím vytvoøený pohled vloží do stránky
{
    protected Kontroler $kontroler;
    
    //Pøevede URL s pomlèkami na název tøídy kontroleru
    private function pomlckyDoVelbloudiNotace(string $text) : string
    {
        $veta = str_replace('-', ' ', $text);
        $veta = ucwords($veta);
        $veta = str_replace(' ', '', $veta);
        return $veta;
    }
    
    //Naparsuje URL podle lomítek a vrátí pole parametrù
    private function parsujURL(string $url) : array
    {
        $naparsovanaURL = parse_url($url);
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
        $rozdelenaCesta = explode("/", $naparsovanaURL["path"]);
        return $rozdelenaCesta;
    }
    
    //Vytvoøení pøíslušného kontroleru pomocí metod parsujURL a pomlckyDoVelbloudiNotace
    public function zpracuj(array $parametry) : void
    {
        $naparsovanaURL = $this->parsujURL($parametry[0]);
        if (empty ($naparsovanaURL[0]))
            $this->presmeruj('pojistenci');
        $tridaKontroleru = $this->pomlckyDoVelbloudiNotace(array_shift($naparsovanaURL)) . 'Kontroler';
        if (file_exists ('kontrolery/' . $tridaKontroleru . '.php'))
                $this->kontroler = new $tridaKontroleru;
        else
            $this->presmeruj('chyba');
        
        //Volání kontroleru
        $this->kontroler->zpracuj($naparsovanaURL);
        
        //Nastavení hlavního pohledu, do kterého se budou vkládat stránky
        $this->pohled = 'rozlozeni';
    }
}