<?php
class SmerovacKontroler extends Kontroler
//Kontroler, kter� podle URL zavol� spr�vn� kontroler a j�m vytvo�en� pohled vlo�� do str�nky
{
    protected Kontroler $kontroler;
    
    //P�evede URL s poml�kami na n�zev t��dy kontroleru
    private function pomlckyDoVelbloudiNotace(string $text) : string
    {
        $veta = str_replace('-', ' ', $text);
        $veta = ucwords($veta);
        $veta = str_replace(' ', '', $veta);
        return $veta;
    }
    
    //Naparsuje URL podle lom�tek a vr�t� pole parametr�
    private function parsujURL(string $url) : array
    {
        $naparsovanaURL = parse_url($url);
        $naparsovanaURL["path"] = ltrim($naparsovanaURL["path"], "/");
        $naparsovanaURL["path"] = trim($naparsovanaURL["path"]);
        $rozdelenaCesta = explode("/", $naparsovanaURL["path"]);
        return $rozdelenaCesta;
    }
    
    //Vytvo�en� p��slu�n�ho kontroleru pomoc� metod parsujURL a pomlckyDoVelbloudiNotace
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
        
        //Vol�n� kontroleru
        $this->kontroler->zpracuj($naparsovanaURL);
        
        //Nastaven� hlavn�ho pohledu, do kter�ho se budou vkl�dat str�nky
        $this->pohled = 'rozlozeni';
    }
}