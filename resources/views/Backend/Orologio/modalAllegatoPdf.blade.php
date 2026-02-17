@extends('Backend._components.modal',['minW' => 'modal-fullscreen'])
@section('content')
    <script>
        var altezzaFinestra = window.innerHeight;
        var el = document.getElementById('myiframe');
        el.height = altezzaFinestra.toFixed(0) - 200;
        el.width = window.innerWidth.toFixed(0) - 100;
    </script>
    <div class="card">
        <div class="card-body text-center">
            <iframe id="myiframe"
                    src="/assets_backend/js-progetto/pdfjs/web/viewer.html?file={{action([\App\Http\Controllers\Backend\AllegatoController::class,'downloadAllegato'],[$record->id])}}"></iframe>
        </div>
    </div>
@endsection
