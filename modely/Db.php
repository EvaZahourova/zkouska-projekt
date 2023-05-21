<?php
class Db
//Ovladaè PDO - datábázové spojení
{
  private static PDO $spojeni;

  //Výchozí nastavení ovladaèe
  private static array $nastaveni = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_EMULATE_PREPARES => false,
    );

  //Pøipojí se k databázi pomocí údajù
  public static function pripoj(string $host, string $uzivatel, string $heslo, string $databaze) : void
    { if (!isset(self::$spojeni))
        { 
            self::$spojeni = @new PDO(
            "mysql:host=$host;dbname=$databaze",
            $uzivatel,
            $heslo,
            self::$nastaveni
            );
        }
    }

  //Spustí dotaz a vrátí jeden øádek z tabulky
  public static function dotazJeden(string $dotaz, array $parametry = array()) : array|bool
  {
    $navrat = self::$spojeni->prepare($dotaz);
    $navrat->execute($parametry);
    return $navrat->fetch();
  }
  
  //Spustí dotaz a vrátí všechny øádky z tabulky
  public static function dotazVsechny(string $dotaz, array $parametry = array()) : array|bool
  {
      $navrat = self::$spojeni->prepare($dotaz);
      $navrat->execute($parametry);
      return $navrat->fetchAll();
  }
  
  //Vloží do tabulky nový øádek jako data z asociativního pole
  public static function vloz(string $tabulka, array $parametry = array()) : bool
  {
      return self::dotazJeden("INSERT INTO `$tabulka` (`".
              implode('`, `', array_keys($parametry)).
              "`) VALUES (". str_repeat('?,', sizeOf($parametry)-1)."?)",
              array_values($parametry));
  }
}