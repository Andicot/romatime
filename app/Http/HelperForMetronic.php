<?php


namespace App\Http;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;


class HelperForMetronic
{

    protected const CONTAINER = false;

    public const SIDEBAR = false;

    public const TOP_MENU=false;


    //Visualizza il nome completo nella top bar, altrimenti solo le iniziali
    public const NOME_COMPLETO_IN_TOPBAR=false;

    public const PULSANTE_FRONTEND=false;

    public static function container()
    {
        return self::CONTAINER ? 'container-xxl' : 'container-fluid';
    }


    public static function breadCrumbs($arr)
    {

    }

    public static function labelSegnalazione($risolto)
    {
        switch ($risolto) {
            case 50:
                return '<span class="badge badge-light-success">Completato</span>';
            case 25:
                return '<span class="badge badge-light-warning">Parzialmente</span>';
            case 0:
                return '<span class="badge badge-light-info">Da fare</span>';
        }

    }

    public static function iconaRegistro($evento)
    {
        switch ($evento) {
            case 'created':
                return '<i class="fa fa-plus-square"></i>';
            case 'updated':
                return '<i class="fa fa-pencil-square"></i>';
            case 'deleted':
                return '<i class="fa fa-trash-square"></i>';
        }

    }


}
