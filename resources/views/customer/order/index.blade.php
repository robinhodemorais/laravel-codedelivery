@extends('app)

@section('content')
    <div class="container">
        <h3>Meus Pedidos</h3>

        <a href="{{route('customer.order.create')}}", class="btn btn-default">Novo Pedido</a>
        <br><br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Total</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            @foreach($orders as $order)
                <tr>
                    <th>{{$order->id}}</th>
                    <th>{{$order->total}}</th>
                    <th>{{$order->status}}</th>
                </tr>
            @endforeach
            </tbody>
        </table>

        {!! $cupoms->render() !!}
    </div>

    //gera o paginador
    {!! $orders->render()  !!}
@endsection