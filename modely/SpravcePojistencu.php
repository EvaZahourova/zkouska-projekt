<?php
//T��da poskytuje metody pro spr�vu poji�t�nc� v aplikaci
class SpravcePojistencu
{
    //Vr�t� jednoho poji�t�nce z datab�ze podle jeho ID
    public function vratPojisteneho(int $pojistenci_id) :array
    {
        return Db::dotazJeden('
            SELECT `pojistenci_id`, `jmeno`, `prijmeni`, `vek`, `telefon` FROM `pojistenci` WHERE `pojistenci_id = ?
            ', array($pojistenci_id));
    }
    //Vr�t� seznam v�ech poji�t�nc� v datab�zi
    public function vratPojistence() : array
    {
        return Db::dotazVsechny('SELECT `jmeno`, `prijmeni`, `vek`, `telefon` FROM `pojistenci` ORDER BY `pojistenci_id` DESC');
    }
    //Ulo�� nov�ho poji�t�nce do datab�ze
    public function ulozPojistence(array $pojistenec) : void
    {
 
            Db::vloz('pojistenci', $pojistenec);
        
    }
}