@extends('app')

@section('content')
    <div class="container">
        <h2>Pedido  :  {{$order->id}} - {{$order->total}}</h2>
        <h3>Cliente :  {{$order->client->user->name}}</h3>
        <h4>Data    :  {{$order->created_at}}</h4>

        <p>
           <b> Entregar em :</b> <br>
            {{$order->client->adress}} - {{$order->client->city}} - {{$order->client->state}}
        </p>


        {!! Form::model($order,['route'=>['admin.orders.update', $order->id]]) !!}

        <div class="form-group">
            {!! Form::label('Status','Status:') !!}
            {!! Form::select('status',$list_status, null,['class'=>'form-control']) !!}
        </div>

        <div class="form-group">
            {!! Form::label('Entregador','Entregador:') !!}
            {!! Form::select('user_deliveryman_id',$deliveryman, null,['class'=>'form-control']) !!}
        </div>


        <div class="form-group">
            {!! Form::submit('Salvar',['class'=>'btn btn-primary']) !!}
        </div>

        {!! Form::close() !!}


    </div>



@endsection