<?php
//Kontroler pro vlo�en� nov�ho poji�t�nce do datab�ze
class NovyPojistenecKontroler extends Kontroler
{
    public function zpracuj(array $parametry) : void
    {
       $spravcePojistencu = new SpravcePojistencu();
       //P��prava �daj� pro nov�ho poji�t�nce
       $pojistenec = array(
           'pojistenci_id' => '',
           'jmeno' => '',
           'prijmeni' => '',
           'vek' => '',
           'telefon' => '',
       );
       //Kdy� je odesl�n vypln�n� formul��
       if ($_POST)
       {
           //Z�sk�n� �daj� z POST
           $klice = array('jmeno', 'prijmeni', 'vek', 'telefon');
           $pojistenec = array_intersect_key($_POST, array_flip($klice));
           //Ulo�en� nov�ho poji�t�nce do datab�ze
           $spravcePojistencu->ulozPojistence($pojistenec);
           $this->presmeruj('pojistenci');
       }
       
       $this->data['pojistenec'] = $pojistenec;
       $this->pohled = 'novy';
    } 
}