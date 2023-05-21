<?php
//Tшнda poskytuje metody pro sprбvu pojiљtмncщ v aplikaci
class SpravcePojistencu
{
    //Vrбtн jednoho pojiљtмnce z databбze podle jeho ID
    public function vratPojisteneho(int $pojistenci_id) :array
    {
        return Db::dotazJeden('
            SELECT `pojistenci_id`, `jmeno`, `prijmeni`, `vek`, `telefon` FROM `pojistenci` WHERE `pojistenci_id = ?
            ', array($pojistenci_id));
    }
    //Vrбtн seznam vљech pojiљtмncщ v databбzi
    public function vratPojistence() : array
    {
        return Db::dotazVsechny('SELECT `jmeno`, `prijmeni`, `vek`, `telefon` FROM `pojistenci` ORDER BY `pojistenci_id` DESC');
    }
    //Uloћн novйho pojiљtмnce do databбze
    public function ulozPojistence(array $pojistenec) : void
    {
 
            Db::vloz('pojistenci', $pojistenec);
        
    }
}