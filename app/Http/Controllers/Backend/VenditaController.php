<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\AllegatoServizio;
use App\Models\Orologio;
use App\Rules\DataItalianaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Vendita;
use DB;

class VenditaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $conFiltro = false;


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $nomeClasse = get_class($this);
        $recordsQB = $this->applicaFiltri($request);

        $ordinamenti = [
            'recente' => ['testo' => 'Più recente', 'filtro' => function ($q) {
                return $q->orderBy('id', 'desc');
            }],

            'nominativo' => ['testo' => 'Nominativo', 'filtro' => function ($q) {
                return $q->orderBy('cognome')->orderBy('nome');
            }]

        ];

        $orderByUser = Auth::user()->getExtra($nomeClasse);
        $orderByString = $request->input('orderBy');

        if ($orderByString) {
            $orderBy = $orderByString;
        } else if ($orderByUser) {
            $orderBy = $orderByUser;
        } else {
            $orderBy = 'recente';
        }

        if ($orderByUser != $orderByString) {
            Auth::user()->setExtra([$nomeClasse => $orderBy]);
        }

        //Applico ordinamento
        $recordsQB = call_user_func($ordinamenti[$orderBy]['filtro'], $recordsQB);

        $records = $recordsQB->paginate(25)->withQueryString();

        if ($request->ajax()) {
            return [
                'html' => base64_encode(view('Backend.Vendita.tabella', [
                    'records' => $records,
                    'controller' => $nomeClasse,
                ]))
            ];
        }

        return view('Backend.Vendita.index', [
            'records' => $records,
            'controller' => $nomeClasse,
            'titoloPagina' => 'Elenco ' . \App\Models\Vendita::NOME_PLURALE,
            'orderBy' => $orderBy,
            'ordinamenti' => $ordinamenti,
            'filtro' => $filtro ?? 'tutti',
            'conFiltro' => $this->conFiltro,
            'testoNuovo' => 'Nuova ' . \App\Models\Vendita::NOME_SINGOLARE,
            'testoCerca' => null,
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applicaFiltri($request)
    {
        $queryBuilder = \App\Models\Vendita::query();
        $term = $request->input('cerca');
        if ($term) {
            $arrTerm = explode(' ', $term);
            foreach ($arrTerm as $t) {
                $queryBuilder->whereRaw('concat_ws(\' \',cognome,nome) like ?', "%$t%");
            }
        }

        return $queryBuilder;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create($orologioId)
    {
        $orologio = Orologio::find($orologioId);
        abort_if(!$orologio, 404, 'Questo ' . Orologio::NOME_SINGOLARE . ' non esiste');
        $record = new Vendita();
        $record->orologio_id = $orologio->id;
        $record->tipo_acquirente = 'privato';
        $record->data_vendita = today();
        $record->progressivo_vendita = (Vendita::max('progressivo_vendita') ?? 0) + 1;


        return view('Backend.Vendita.edit', [
            'orologio' => $orologio,
            'record' => $record,
            'titoloPagina' => 'Nuova ' . Vendita::NOME_SINGOLARE,
            'controller' => get_class($this),
            'breadcrumbs' => [action([OrologioController::class, 'show'], $orologio->id) => 'Torna a orologio'],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $orologioId)
    {
        $orologio = Orologio::find($orologioId);
        abort_if(!$orologio, 404, 'Questo ' . Orologio::NOME_SINGOLARE . ' non esiste');
        $request->validate($this->rules($request->input('nazione_acquirente')));
        $record = Vendita::firstOrNew(['orologio_id' => $orologioId]);
        $record->orologio_id = $orologioId;
        $this->salvaDati($record, $request);

        return redirect()->action([OrologioController::class, 'show'], $orologioId);
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $orologioId, string $id)
    {
        $record = Vendita::find($id);
        abort_if(!$record, 404, 'Questa vendita non esiste');
        if (false) {
            $eliminabile = 'Non eliminabile perchè presente in ...';
        } else {
            $eliminabile = true;
        }
        return view('Backend.Vendita.edit', [
            'orologio' => Orologio::find($record->orologio_id),
            'record' => $record,
            'controller' => VenditaController::class,
            'titoloPagina' => 'Modifica ' . Vendita::NOME_SINGOLARE,
            'eliminabile' => $eliminabile,
            'breadcrumbs' => [action([OrologioController::class, 'index']) => 'Torna a elenco ' . Orologio::NOME_PLURALE],

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $orologioId, string $id)
    {
        $record = Vendita::find($id);
        abort_if(!$record, 404, 'Questa ' . Vendita::NOME_SINGOLARE . ' non esiste');
        $request->validate($this->rules($request->input('nazione_acquirente')));
        $this->salvaDati($record, $request);

        return redirect()->action([OrologioController::class, 'show'], $record->orologio_id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $orologioId, string $id)
    {
        $record = Vendita::find($id);
        abort_if(!$record, 404, 'Questa ' . Vendita::NOME_SINGOLARE . ' non esiste');
        AllegatoServizio::where('tipo_allegato', 'acquirente')->where('orologio_id', $record->orologio_id)->delete();
        $record->delete();

        return [
            'success' => true,
            'redirect' => action([OrologioController::class, 'index']),
        ];
    }

    /**
     * @param Vendita $record
     * @param Request $request
     * @return mixed
     */
    protected function salvaDati($record, $request)
    {

        //Ciclo su campi
        $campi = [
            'data_vendita' => 'app\getInputData',
            'tipo_acquirente' => '',
            'cognome_acquirente' => 'app\getInputUcwords',
            'nome_acquirente' => 'app\getInputUcwords',
            'codice_fiscale_acquirente' => 'strtoupper',
            'denominazione_acquirente' => 'app\getInputUcwords',
            'partita_iva_acquirente' => 'strtoupper',
            'telefono_acquirente' => 'app\getInputTelefono',
            'email_acquirente' => 'strtolower',
            'indirizzo_acquirente' => 'app\getInputUcfirst',
            'citta_acquirente' => '',
            'nazione_acquirente' => '',
            'cap_acquirente' => '',
            'prezzo_di_vendita' => 'app\getInputNumero',
            'numero_fattura_vendita' => '',
            'progressivo_vendita' => 'app\getInputNumero',

        ];
        foreach ($campi as $campo => $funzione) {
            $valore = $request->$campo;
            if ($funzione != '') {
                $valore = $funzione($valore);
            }
            $record->$campo = $valore;
        }
        if ($record->tipo_acquirente == 'privato') {
            $record->denominazione_acquirente = $record->cognome_acquirente . ' ' . $record->nome_acquirente;
        }

        if ($record->nazione_acquirente !== 'IT') {
            $record->citta_acquirente = $request->input('citta_estera');
        }

        $record->save();


        $orologio = Orologio::find($record->orologio_id);
        $orologio->sincronizzaDati();
        $orologio->save();

        return $record;
    }

    protected function backToIndex()
    {
        return redirect()->action([get_class($this), 'index']);
    }


    protected function rules($nazione)
    {
        $rules = [
            'data_vendita' => ['required', new DataItalianaRule()],
            'tipo_acquirente' => ['required', 'max:255'],
            'progressivo_vendita' => ['required'],
            'cognome_acquirente' => ['nullable', 'max:255'],
            'nome_acquirente' => ['nullable', 'max:255'],
            'codice_fiscale_acquirente' => ['nullable', 'max:255', new \App\Rules\CodiceFiscaleRule($nazione)],
            'denominazione_acquirente' => ['nullable', 'max:255'],
            'partita_iva_acquirente' => ['nullable', 'max:255', new \App\Rules\PartitaIvaRule($nazione)],
            'telefono_acquirente' => ['nullable', 'max:255', new \App\Rules\TelefonoRule()],
            'email_acquirente' => ['nullable', 'max:255', 'email'],
            'indirizzo_acquirente' => ['nullable', 'max:255'],
            'citta_acquirente' => ['nullable', 'max:255'],
            'cap_acquirente' => ['nullable', 'max:255'],
            'prezzo_di_vendita' => ['nullable'],
            'numero_fattura_vendita' => ['nullable', 'max:255'],
        ];
        return $rules;
    }

}


