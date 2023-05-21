<?php
class Db
//Ovlada� PDO - dat�b�zov� spojen�
{
  private static PDO $spojeni;

  //V�choz� nastaven� ovlada�e
  private static array $nastaveni = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
    PDO::ATTR_EMULATE_PREPARES => false,
    );

  //P�ipoj� se k datab�zi pomoc� �daj�
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

  //Spust� dotaz a vr�t� jeden ��dek z tabulky
  public static function dotazJeden(string $dotaz, array $parametry = array()) : array|bool
  {
    $navrat = self::$spojeni->prepare($dotaz);
    $navrat->execute($parametry);
    return $navrat->fetch();
  }
  
  //Spust� dotaz a vr�t� v�echny ��dky z tabulky
  public static function dotazVsechny(string $dotaz, array $parametry = array()) : array|bool
  {
      $navrat = self::$spojeni->prepare($dotaz);
      $navrat->execute($parametry);
      return $navrat->fetchAll();
  }
  
  //Vlo�� do tabulky nov� ��dek jako data z asociativn�ho pole
  public static function vloz(string $tabulka, array $parametry = array()) : bool
  {
      return self::dotazJeden("INSERT INTO `$tabulka` (`".
              implode('`, `', array_keys($parametry)).
              "`) VALUES (". str_repeat('?,', sizeOf($parametry)-1)."?)",
              array_values($parametry));
  }
}