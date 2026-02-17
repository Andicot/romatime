<?php

namespace App\Http\Controllers\Backend;

use App\Enums\TipiAcquistoEnum;
use App\Exports\EsportaOrologi;
use App\Http\MieClassiCache\CacheUnaVoltaAlGiorno;
use App\Models\Orologio;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;
use function App\mese;

class DashboardController extends Controller
{
    public function show(Request $request)
    {

        if ($request->has('esporta')) {
            $anno = $request->input('esporta');
           return Excel::download(new EsportaOrologi($anno), 'Orologi_' . $anno . '.xlsx');
        }

        dispatch(function () {
            CacheUnaVoltaAlGiorno::get();
        })->afterResponse();

        $statOrologi['orologi'] = Orologio::count();
        $statOrologi['venduti'] = Orologio::has('vendita')->count();

        $anno = $request->input('anno', now()->year);

        $annoCorrente = date("Y");

        $titoloPagina = 'Dashboard';

        return view('Backend.Dashboard.show', [
            'titoloPagina' => $titoloPagina,
            'statOrologi' => $statOrologi,
            'annoCorrente' => $annoCorrente,
            'anno' => $anno,
            'graficoUscite' => $this->reportUsciteAnno($anno),
            'graficoEntrate' => $this->reportEntrateAnno($anno),
            'graficoUtile' => $this->reportUtileAnno($anno),


        ]);


    }

    private function reportUsciteAnno($anno)
    {
        $perMese = Orologio::selectRaw('MONTH(data_acquisto) as mese,YEAR(data_acquisto) as anno, sum(prezzo_di_acquisto) as prezzo_di_acquisto ')
            ->groupByRaw('YEAR(data_acquisto), MONTH(data_acquisto)')
            ->whereYear('data_acquisto', $anno)
            ->get();


        $arrDati = [];
        for ($n = 1; $n <= 12; $n++) {
            $datiMese = $perMese->where('mese', $n)->first();
            $arrDati['prezzo_di_acquisto'][] = $datiMese?->prezzo_di_acquisto ?? null;
            $arrDati['labels'][] = mese($n);
        }


        return [
            'anno' => $anno,
            'arrDati' => $arrDati,
            'elencoAnni' => $this->elencoAnni(),
        ];
    }

    private function reportEntrateAnno($anno)
    {
        $perMese = Orologio::selectRaw('MONTH(data_vendita) as mese,YEAR(data_vendita) as anno, sum(prezzo_di_vendita) as prezzo_di_vendita ')
            ->groupByRaw('YEAR(data_vendita), MONTH(data_vendita)')
            ->whereYear('data_vendita', $anno)
            ->get();


        $arrDati = [];
        for ($n = 1; $n <= 12; $n++) {
            $datiMese = $perMese->where('mese', $n)->first();
            $arrDati['prezzo_di_vendita'][] = $datiMese?->prezzo_di_vendita ?? null;
            $arrDati['labels'][] = mese($n);
        }

        return [
            'anno' => $anno,
            'arrDati' => $arrDati,
            'elencoAnni' => $this->elencoAnni(),
        ];
    }

    private function reportUtileAnno($anno)
    {
        $perMese = Orologio::selectRaw('MONTH(data_vendita) as mese,YEAR(data_vendita) as anno, sum(utile) as utile ')
            ->groupByRaw('YEAR(data_vendita), MONTH(data_vendita)')
            ->whereYear('data_vendita', $anno)
            ->get();

        $arrDati = [];
        for ($n = 1; $n <= 12; $n++) {
            $datiMese = $perMese->where('mese', $n)->first();
            $arrDati['utile'][] = $datiMese?->utile ?? null;
            $arrDati['labels'][] = mese($n);
        }
        return [
            'anno' => $anno,
            'arrDati' => $arrDati,
            'elencoAnni' => $this->elencoAnni(),
        ];
    }

    private function elencoAnni(): array
    {
        $record = Orologio::orderBy('data_acquisto')->first();
        if ($record) {
            $primoAnno = $record->data_acquisto->year;
        } else {
            $primoAnno = config('configurazione.primoAnno');
        }
        $anni = [];
        for ($anno = $primoAnno; $anno <= now()->year; $anno++) {
            $anni[] = $anno;
        }
        return $anni;
    }


}
