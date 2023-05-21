<?php
mb_internal_encoding("UTF-8");
//Automatick� na��t�n� t��d
function autoloadFunkce(string $trida) : void
{
    if (preg_match(' /Kontroler$/', $trida))
    {
        require("kontrolery/" . $trida . ".php");
    }
    else
    {
        require("modely/" . $trida . ".php");
    }
}
spl_autoload_register("autoloadFunkce");

//P�ipojen� k datab�zi
Db::pripoj("127.0.0.1", "root", "", "pojistovna_db");

//Vytvo�en� sm�rova�e a zpracov�n� parametr� od u�ivatele z URL
$smerovac = new SmerovacKontroler();
$smerovac->zpracuj(array($_SERVER['REQUEST_URI']));

$smerovac->vypisPohled();