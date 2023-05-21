<?php
class ChybaKontroler extends Kontroler
//Kontroler pro chybovou stránku
{
    public function zpracuj(array $parametry) : void
    {
        header("HTTP/1.0 404 Not Found");
        $this->pohled = 'chyba';
    }
}