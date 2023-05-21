<?php
//Kontroler pro vložení nového pojištìnce do databáze
class NovyPojistenecKontroler extends Kontroler
{
    public function zpracuj(array $parametry) : void
    {
       $spravcePojistencu = new SpravcePojistencu();
       //Pøíprava údajù pro nového pojištìnce
       $pojistenec = array(
           'pojistenci_id' => '',
           'jmeno' => '',
           'prijmeni' => '',
           'vek' => '',
           'telefon' => '',
       );
       //Když je odeslán vyplnìný formuláø
       if ($_POST)
       {
           //Získání údajù z POST
           $klice = array('jmeno', 'prijmeni', 'vek', 'telefon');
           $pojistenec = array_intersect_key($_POST, array_flip($klice));
           //Uložení nového pojištìnce do databáze
           $spravcePojistencu->ulozPojistence($pojistenec);
           $this->presmeruj('pojistenci');
       }
       
       $this->data['pojistenec'] = $pojistenec;
       $this->pohled = 'novy';
    } 
}