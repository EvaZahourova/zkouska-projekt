<?php
//Kontroler pro vypsání všech pojištìncù z databáze do pohledu "pojistenci"
class PojistenciKontroler extends Kontroler
{
    public function zpracuj(array $parametry) : void
    {
        $spravcePojistencu = new SpravcePojistencu();
        if(!empty($paramety[0]))
        {
            $pojistenec = $spravcePojistencu->vratPojisteneho($parametry[0]);
            if (!$pojistenec)
            {
            $this->presmeruj('chyba');
            }
            //Naplnìní promìnných pro pohled
            $this->data['pojistenci_id'] = $pojistenec['pojistenci_id'];
            $this->data['jmeno'] = $pojistenec['jmeno'];
            $this->data['prijmeni'] = $pojistenec['prijmeni'];
            $this->data['vek'] = $pojistenec['vek'];
            $this->data['telefon'] = $pojistenec['telefon'];
        
            $this->pohled = 'pojistenci';
        }
        else
        {
            //Vypíše všechny pojištìnce a jejich data do šablony "pojistenci"
            $pojistenci = $spravcePojistencu->vratPojistence();
            $this->data['pojistenci'] = $pojistenci;
            $this->pohled = 'pojistenci';
        }
    }
}