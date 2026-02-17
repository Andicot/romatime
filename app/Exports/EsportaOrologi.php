<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;


class EsportaOrologi implements FromCollection, WithMapping,WithHeadings,WithColumnFormatting
{

    public function __construct(protected $anno)
    {

    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return \App\Models\Orologio::query()
            ->with('cittaVenditore')
            ->with('vendita.cittaAcquirente')
            ->with('vendita.nazioneAcquirente')
            ->whereYear('data_vendita', $this->anno)
            ->orderBy('progressivo_acquisto')
            ->get();
    }

    public function map($row): array
    {
        return [
            $row->tipo_acquisto,
            $row->marca,
            $row->modello,
            $row->referenza,
            $row->seriale,
            $row->numero_movimento,
            $row->garanzia,
            $row->data_acquisto ? $row->data_acquisto->format('d/m/Y') : '',
            $row->progressivo_acquisto,
            $row->tipo_venditore,
            $row->cognome_venditore,
            $row->nome_venditore,
            $row->codice_fiscale_venditore,
            $row->denominazione_venditore,
            $row->partita_iva_venditore,
            $row->telefono_venditore,
            $row->email_venditore,
            $row->indirizzo_venditore,
            $row->cittaVenditore?->comuneConTarga(),
            $row->cap_venditore,
            $row->prezzo_di_acquisto,
            $row->numero_fattura_acquisto,
            $row->tipo_documento,
            $row->numero_documento,
            $row->prezzo_di_vendita,
            $row->vendita?->data_vendita->format('d/m/Y'),
            $row->vendita?->tipo_acquirente,
            $row->vendita?->cognome_acquirente,
            $row->vendita?->nome_acquirente,
            $row->vendita?->codice_fiscale_acquirente,
            $row->vendita?->denominazione_acquirente,
            $row->vendita?->partita_iva_acquirente,
            $row->vendita?->telefono_acquirente,
            $row->vendita?->email_acquirente,
            $row->vendita?->nazioneAcquirente->langIT,
            $row->vendita?->indirizzo_acquirente,
            $row->vendita?->citta_acquirente?(is_numeric($row->vendita?->citta_acquirente)?$row->vendita?->cittaAcquirente->comuneConTarga():$row->vendita?->citta_acquirente):'',
            $row->vendita?->cap_acquirente,
            $row->vendita?->prezzo_di_vendita,
            $row->vendita?->numero_fattura_vendita,
            $row->vendita?->progressivo_vendita,
            $row->utile
        ];
    }

    public function headings(): array
    {
       return [
           'tipo acquisto',
           'marca',
           'modello',
           'referenza',
           'seriale',
           'numero movimento',
           'garanzia',
           'data acquisto',
           'progressivo_acquisto',
           'tipo venditore',
           'cognome venditore',
           'nome venditore',
           'codice fiscale venditore',
           'denominazione venditore',
           'partita iva venditore',
           'telefono venditore',
           'email venditore',
           'indirizzo venditore',
           'città venditore',
           'cap venditore',
           'prezzo di acquisto',
           'numero fattura_acquisto',
           'tipo documento',
           'numero documento',
           'prezzo di vendita',
           'data_vendita',
           'tipo acquirente',
           'cognome acquirente',
           'nome acquirente',
           'codice fiscale acquirente',
           'denominazione acquirente',
           'partita iva acquirente',
           'telefono acquirente',
           'email acquirente',
           'nazione acquirente',
           'indirizzo acquirente',
           'città acquirente',
           'cap acquirente',
           'prezzo di vendita',
           'numero fattura vendita',
           'progressivo vendita',
           'utile'

       ];
    }
    public function columnFormats(): array
    {
        return [
            'T' => NumberFormat::FORMAT_TEXT,
            'AD' => NumberFormat::FORMAT_TEXT,
            'AF' => NumberFormat::FORMAT_TEXT,
            'AG' => NumberFormat::FORMAT_TEXT,
            'AL' => NumberFormat::FORMAT_TEXT,
            'AN' => NumberFormat::FORMAT_TEXT,

        ];
    }
}
