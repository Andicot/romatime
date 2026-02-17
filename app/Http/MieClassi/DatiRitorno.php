<?php

namespace App\Http\MieClassi;

class DatiRitorno
{
    protected $datiRitornoArray = [
        'success' => true
    ];

    /**
     * @param bool $bool
     * @return DatiRitorno
     */
    public function success($bool)
    {
        $this->datiRitornoArray = array_merge($this->datiRitornoArray, ['success' => $bool]);
        return $this;
    }

    /**
     * @param bool $idModal
     * @return DatiRitorno
     */
    public function chiudiModal($idModalConCancelletto = '#kt_modal')
    {
        if ($idModalConCancelletto === true) {
            $idModalConCancelletto = '#kt_modal';
        }
        if (!\Str::of($idModalConCancelletto)->startsWith('#')) {
            $idModalConCancelletto = '#' . $idModalConCancelletto;
        }
        $this->datiRitornoArray = array_merge($this->datiRitornoArray, ['chiudiModal' => $idModalConCancelletto]);
        return $this;
    }

    /**
     * @param string $funzione
     * @return DatiRitorno
     */
    public function eseguiFunzione($funzione)
    {
        $this->datiRitornoArray = array_merge($this->datiRitornoArray, ['eseguiFunzione' => $funzione]);
        return $this;

    }

    /**
     * @param bool $bool
     * @return DatiRitorno
     */
    public function redirect($url)
    {
        $this->datiRitornoArray = array_merge($this->datiRitornoArray, ['redirect' => $url]);
        return $this;
    }

    /**
     * @param int $id
     * @return DatiRitorno
     */
    public function id($id)
    {
        $this->datiRitornoArray = array_merge($this->datiRitornoArray, ['id' => $id]);
        return $this;

    }

    /**
     * @param bool $bool
     * @return DatiRitorno
     */
    public function oggettoReload($idOggettoSenzaCancelletto, $html)
    {
        $this->datiRitornoArray = array_merge($this->datiRitornoArray, ['oggettoReload' => $idOggettoSenzaCancelletto, 'html' => base64_encode($html)]);
        return $this;

    }

    /**
     * @param bool $bool
     * @return DatiRitorno
     */
    public function oggettoReplace($idOggettoSenzaCancelletto, $html)
    {
        $this->datiRitornoArray = array_merge($this->datiRitornoArray, ['oggettoReplace' => $idOggettoSenzaCancelletto, 'html' => base64_encode($html)]);
        return $this;

    }

    /**
     * @param bool $bool
     * @return DatiRitorno
     */
    public function rimuoviOggetto($idOggettoConCacelletto)
    {
        if (!\Str::of($idOggettoConCacelletto)->startsWith('#')) {
            $idOggettoConCacelletto = '#' . $idOggettoConCacelletto;
        }
        $this->datiRitornoArray = array_merge($this->datiRitornoArray, ['oggettoRimuovi' => $idOggettoConCacelletto]);
        return $this;

    }

    /**
     * @param bool $bool
     * @return DatiRitorno
     */
    public function mostraOggetto($idOggettoConCacelletto)
    {
        if (!\Str::of($idOggettoConCacelletto)->startsWith('#')) {
            $idOggettoConCacelletto = '#' . $idOggettoConCacelletto;
        }
        $this->datiRitornoArray = array_merge($this->datiRitornoArray, ['mostraOggetto' => $idOggettoConCacelletto]);
        return $this;

    }


    public function keyValue($key, $value)
    {
        $this->datiRitornoArray = array_merge($this->datiRitornoArray, [$key => $value]);
        return $this;

    }

    public function message($messaggio)
    {
        $this->datiRitornoArray = array_merge($this->datiRitornoArray, ['message' => $messaggio]);
        return $this;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->datiRitornoArray;
    }


}
