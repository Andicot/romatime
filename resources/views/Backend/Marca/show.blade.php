@extends('Backend._layout._main')
@section('toolbar')
@endsection

@section('content')
    <div class="card">
        <div class="card-body">

<div class="row">
      <div class="col-md-6">
@include('Backend._inputs_v.inputShow',['campo'=>'nome_marca',])
       </div>
</div>

        </div>
    </div>
@endsection
