<?php

namespace App\Http\Controllers\Backend;

use App\Enums\TipiAcquistoEnum;
use App\Http\Controllers\Controller;
use App\Models\AllegatoServizio;
use App\Models\Marca;
use App\Rules\DataItalianaRule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Orologio;
use DB;
use Illuminate\Support\Str;
use function App\getInputUcwords;

class OrologioController extends Controller
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
                'html' => base64_encode(view('Backend.Orologio.tabella', [
                    'records' => $records,
                    'controller' => $nomeClasse,
                ]))
            ];
        }

        return view('Backend.Orologio.index', [
            'records' => $records,
            'controller' => $nomeClasse,
            'titoloPagina' => 'Elenco ' . \App\Models\Orologio::NOME_PLURALE,
            'orderBy' => $orderBy,
            'ordinamenti' => null,// $ordinamenti,
            'filtro' => $filtro ?? 'tutti',
            'conFiltro' => $this->conFiltro,
            'testoNuovo' => 'Nuovo Acquisto',
            'testoCerca' => 'Cerca...',
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applicaFiltri($request)
    {

        $queryBuilder = \App\Models\Orologio::query()
            ->with('vendita:id,orologio_id,progressivo_vendita');
        $term = $request->input('cerca');
        if ($term) {
            $arrTerm = explode(' ', $term);
            foreach ($arrTerm as $t) {
                $queryBuilder->whereRaw('testo_ricerca like ?', "%$t%");
            }
        }

        if ($request->has('stato')) {
            switch ($request->input('stato')) {
                case 'in_carico':
                    $queryBuilder->doesntHave('vendita')->where('tipo_acquisto', TipiAcquistoEnum::acquisto->value);
                    break;

                case 'conto_vendita':
                    $queryBuilder->where('tipo_acquisto', TipiAcquistoEnum::conto_vendita->value);
                    break;

                case 'venduti':
                    $queryBuilder->has('vendita');
                    break;
            }
        }

        //$this->conFiltro = true;
        return $queryBuilder;
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $record = new Orologio();
        $record->tipo_venditore = 'privato';
        $record->tipo_acquisto = TipiAcquistoEnum::acquisto->value;
        $record->progressivo_acquisto = (Orologio::max('progressivo_acquisto') ?? 0) + 1;
        $record->data_acquisto = today();
        $record->nazione_venditore = 'IT';

        return view('Backend.Orologio.edit', [
            'uid' => Str::ulid(),
            'record' => $record,
            'titoloPagina' => 'Nuovo Acquisto',
            'controller' => get_class($this),
            'breadcrumbs' => [action([OrologioController::class, 'index']) => 'Torna a elenco ' . Orologio::NOME_PLURALE],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate($this->rules($request->input('nazione_acquirente')));

        Marca::firstOrCreate(['nome_marca' => getInputUcwords($request->input('marca'))]);

        $record = new Orologio();
        $this->salvaDati($record, $request);

        return $this->backToIndex();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $record = Orologio::find($id);
        abort_if(!$record, 404, 'Questo orologio non esiste');
        return view('Backend.Orologio.show', [
            'record' => $record,
            'controller' => OrologioController::class,
            'titoloPagina' => ucfirst(Orologio::NOME_SINGOLARE),
            'breadcrumbs' => [action([OrologioController::class, 'index']) => 'Torna a elenco ' . Orologio::NOME_PLURALE],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $record = Orologio::find($id);
        abort_if(!$record, 404, 'Questo orologio non esiste');
        if ($record->vendita) {
            $eliminabile = 'Non eliminabile perchè venduto';
        } else {
            $eliminabile = true;
        }
        return view('Backend.Orologio.edit', [
            'record' => $record,
            'controller' => OrologioController::class,
            'titoloPagina' => 'Modifica ' . Orologio::NOME_SINGOLARE,
            'eliminabile' => $eliminabile,
            'breadcrumbs' => [action([OrologioController::class, 'index']) => 'Torna a elenco ' . Orologio::NOME_PLURALE]

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $record = Orologio::find($id);
        abort_if(!$record, 404, 'Questo ' . Orologio::NOME_SINGOLARE . ' non esiste');
        $request->validate($this->rules($request->input('nazione_acquirente')));
        $this->salvaDati($record, $request);
        return $this->backToIndex();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $record = Orologio::find($id);
        abort_if(!$record, 404, 'Questo ' . Orologio::NOME_SINGOLARE . ' non esiste');
        AllegatoServizio::where('orologio_id', $id)->delete();
        $record->delete();
        return [
            'success' => true,
            'redirect' => action([OrologioController::class, 'index']),
        ];
    }

    /**
     * @param Orologio $record
     * @param Request $request
     * @return mixed
     */
    protected function salvaDati($record, $request)
    {
        //Ciclo su campi
        $campi = [
            'marca' => 'app\getInputUcwords',
            'tipo_acquisto' => '',
            'modello' => '',
            'referenza' => 'strtoupper',
            'seriale' => 'strtoupper',
            'numero_movimento' => 'strtoupper',
            'garanzia' => '',
            'progressivo_acquisto' => 'app\getInputNumero',
            'data_acquisto' => 'app\getInputData',
            'tipo_venditore' => '',
            'cognome_venditore' => 'app\getInputUcwords',
            'nome_venditore' => 'app\getInputUcwords',
            'codice_fiscale_venditore' => 'strtoupper',
            'denominazione_venditore' => 'app\getInputUcwords',
            'partita_iva_venditore' => 'strtoupper',
            'telefono_venditore' => 'app\getInputTelefono',
            'email_venditore' => 'strtolower',
            'indirizzo_venditore' => 'app\getInputUcfirst',
            'citta_venditore' => '',
            'cap_venditore' => '',
            'nazione_venditore' => '',
            'prezzo_di_acquisto' => 'app\getInputNumero',
            'numero_fattura_acquisto' => '',
            'tipo_documento' => '',
            'numero_documento' => 'strtoupper',
        ];
        foreach ($campi as $campo => $funzione) {
            $valore = $request->$campo;
            if ($funzione != '') {
                $valore = $funzione($valore);
            }
            $record->$campo = $valore;
        }
        if ($record->tipo_venditore == 'privato') {
            $record->denominazione_venditore = $record->cognome_venditore . ' ' . $record->nome_venditore;
        }        if ($record->nazione_venditore !== 'IT') {
        $record->citta_venditore = $request->input('citta_estera');
    }

        $record->sincronizzaDati();
        $record->save();

        if ($request->input('uid')) {
            AllegatoServizio::where('uid', $request->input('uid'))->whereNotNull('uid')->update(['orologio_id' => $record->id, 'uid' => null]);
        }
        return $record;
    }


    protected function backToIndex()
    {
        return redirect()->action([get_class($this), 'index']);
    }


    protected function rules($nazione)
    {
        $rules = [
            'marca' => ['required', 'max:255'],
            'modello' => ['required', 'max:255'],
            'referenza' => ['required', 'max:255'],
            'seriale' => ['required', 'max:255'],
            'garanzia' => ['nullable', 'max:255'],
            'data_acquisto' => ['required', new DataItalianaRule()],
            'tipo_venditore' => ['required', 'max:255'],
            'progressivo_acquisto' => ['required'],
            'cognome_venditore' => ['nullable', 'max:255'],
            'nome_venditore' => ['nullable', 'max:255'],
            'codice_fiscale_venditore' => ['nullable', 'max:255', new \App\Rules\CodiceFiscaleRule($nazione)],
            'denominazione_venditore' => ['nullable', 'max:255'],
            'partita_iva_venditore' => ['nullable', 'max:255', new \App\Rules\PartitaIvaRule($nazione)],
            'telefono_venditore' => ['nullable', 'max:255', new \App\Rules\TelefonoRule()],
            'email_venditore' => ['nullable', 'max:255', 'email'],
            'indirizzo_venditore' => ['nullable', 'max:255'],
            'citta_venditore' => ['nullable', 'max:255'],
            'cap_venditore' => ['nullable', 'max:255'],
            'prezzo_di_acquisto' => ['nullable'],
            'numero_fattura_acquisto' => ['nullable', 'max:255'],
        ];
        return $rules;
    }


}
