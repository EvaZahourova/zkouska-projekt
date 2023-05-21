<?php
mb_internal_encoding("UTF-8");
//Automatické naèítání tøíd
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

//Pøipojení k databázi
Db::pripoj("127.0.0.1", "root", "", "pojistovna_db");

//Vytvoøení smìrovaèe a zpracování parametrù od uživatele z URL
$smerovac = new SmerovacKontroler();
$smerovac->zpracuj(array($_SERVER['REQUEST_URI']));

$smerovac->vypisPohled();