@extends('app')

@section('content')
    <div class="container">
        <h3>Cupom</h3>

        <br>

        <a href="{{ route('admin.cupoms.create') }}" class="btn btn-default"> Novo Cupom</a>

        <br><br>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Codigo</th>
                    <th>Valor</th>
                    <th>Acao</th>
                </tr>
            </thead>

            <tbody>
            @foreach($cupoms as $cupom)
                <tr>
                    <td>{{ $cupom->id  }}</td>
                    <td>{{ $cupom->code  }}</td>
                    <td>{{ $cupom->value  }}</td>

                </tr>
            @endforeach
            </tbody>
        </table>

        {!! $cupoms->render()  !!}
    </div>



@endsection