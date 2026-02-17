<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Marca;
use DB;

class MarcaController extends Controller
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





        //Applico ordinamento

        $records = $recordsQB->paginate(25)->withQueryString();

        if ($request->ajax()) {
            return [
                'html' => base64_encode(view('Backend.Marca.tabella', [
                    'records' => $records,
                    'controller' => $nomeClasse,
                ]))
            ];
        }

        return view('Backend.Marca.index', [
            'records' => $records,
            'controller' => $nomeClasse,
            'titoloPagina' => 'Elenco ' . \App\Models\Marca::NOME_PLURALE,
            'orderBy' => null,//$orderBy,
            'ordinamenti' =>null,// $ordinamenti,
            'filtro' => $filtro ?? 'tutti',
            'conFiltro' => $this->conFiltro,
            'testoNuovo'=>'Nuova '. \App\Models\Marca::NOME_SINGOLARE,
            'testoCerca'=>null,
        ]);
    }

            /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function applicaFiltri($request)
    {

        $queryBuilder =  \App\Models\Marca::query()->orderBy('nome_marca');
        $term = $request->input('cerca');
        if ($term) {
            $arrTerm = explode(' ', $term);
            foreach ($arrTerm as $t) {
                $queryBuilder->whereRaw('concat_ws(\' \',cognome,nome) like ?', "%$t%");
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
                $record=new Marca();
        return view('Backend.Marca.edit', [
            'record' => $record,
            'titoloPagina' => 'Nuova ' . Marca::NOME_SINGOLARE,
            'controller' => get_class($this),
            'breadcrumbs' => [action([MarcaController::class, 'index']) => 'Torna a elenco ' . Marca::NOME_PLURALE],
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
                $request->validate($this->rules(null));
        $record=new Marca();
        $this->salvaDati($record, $request);
        return $this->backToIndex();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
                $record = Marca::find($id);
        abort_if(!$record, 404, 'Questa marca non esiste');
        return view('Backend.Marca.show', [
            'record' => $record,
            'controller' => MarcaController::class,
            'titoloPagina' =>  ucfirst(Marca::NOME_SINGOLARE),
            'breadcrumbs' => [action([MarcaController::class, 'index']) => 'Torna a elenco ' . Marca::NOME_PLURALE],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
                $record = Marca::find($id);
        abort_if(!$record, 404, 'Questa marca non esiste');
         if (false) {
            $eliminabile = 'Non eliminabile perchè presente in ...';
        } else {
            $eliminabile = true;
        }
        return view('Backend.Marca.edit', [
            'record' => $record,
            'controller' => MarcaController::class,
            'titoloPagina' => 'Modifica ' . Marca::NOME_SINGOLARE,
            'eliminabile'=>$eliminabile,
            'breadcrumbs' => [action([MarcaController::class, 'index']) => 'Torna a elenco ' . Marca::NOME_PLURALE]

        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
                $record = Marca::find($id);
        abort_if(!$record, 404, 'Questa ' . Marca::NOME_SINGOLARE . ' non esiste');
        $request->validate($this->rules($id));
        $this->salvaDati($record, $request);

        return $this->backToIndex();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
                $record = Marca::find($id);
        abort_if(!$record, 404, 'Questa ' . Marca::NOME_SINGOLARE . ' non esiste');
        $record->delete();

        return [
            'success' => true,
            'redirect' => action([MarcaController::class,'index']),
        ];
    }

    /**
     * @param Marca $record
     * @param Request $request
     * @return mixed
     */
    protected function salvaDati($record, $request)
    {

            $nuovo = !$record->id;

        if ($nuovo) {

        }

        //Ciclo su campi
        $campi = [
            'nome_marca'=>'app\getInputUcwords',
        ];
        foreach ($campi as $campo => $funzione) {
            $valore = $request->$campo;
            if ($funzione != '') {
                $valore = $funzione($valore);
            }
            $record->$campo = $valore;
        }

        $record->save();
        return $record;
    }

    protected function backToIndex()
    {
        return redirect()->action([get_class($this), 'index']);
    }





    protected function rules($id=null)
    {


        $rules=[
     'nome_marca'=>['required','max:255'],
];

        return $rules;
    }

}
