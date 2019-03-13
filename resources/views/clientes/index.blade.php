<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <title>Credito</title>
</head>
<body>

    <nav class="navbar" style="background-color: yellow;">
        <a class="navbar-brand" href="#">
            <img src="/docs/4.3/assets/brand/bootstrap-solid.svg" width="30" height="30" class="d-inline-block align-top" alt="">
            Bancolombia
        </a>
    </nav>

        <div class="container">

            <div class="jumbotron">
                <h1 class="display-4">Datos de Cliente</h1>
                <p class="lead">Nombre: {{ $clientes[0]->nombre }}</p>
                <p class="lead">Teléfono: {{ $clientes[0]->telefono }}</p>
                <p class="lead">Direccíon: {{ $clientes[0]->direccion }}</p>
                <p class="lead">Estos son los movimientos de su cuenta.</p>
                <a class="btn btn-primary" href="{{url('abonos', ['documento' => $clientes[0]->documento])}}">Abonar</a>
            </div>

            
            <table align="center" style="width: 100%;">
                <tr>
                    <td align="center">
                            <div class="card" style="background-color: cyan;width: 18rem;">
                                <div class="card-body">
                                <h5 class="card-title">valor del credito</h5>
                                <h6 class="card-subtitle mb-2 text-muted">${{ number_format($clientes[0]->valor_credito, 2) }}</h6>
                                <p class="card-text">Fecha desembolso: {{ $clientes[0]->fecha_desembolso }}</p>
                            </div>
                    </td>
                
                    <td align="center">
                            <div class="card" style="background-color: cyan;width: 18rem;">
                                <div class="card-body">
                                <h5 class="card-title">Valor Intereses</h5>
                                <h6 class="card-subtitle mb-2 text-muted">${{ number_format($clientes[0]->intereses, 2 ) }}</h6>
                                
                            </div>
                    </td>

                    <td align="center">
                            <div class="card" style="background-color: cyan;width: 18rem;">
                                <div class="card-body">
                                <h5 class="card-title">FECHA CREDITO</h5>
                                <h6 class="card-subtitle mb-2 text-muted">{{ $clientes[0]->fecha_desembolso }}</h6>
                               
                            </div>
                    </td>

                    
                </tr>

                <table align="center" style="width: 100%;">
                <tr>
                    <td align="center">
                            <div class="card" style="background-color: cyan;width: 18rem;">
                                <div class="card-body">
                                <h5 class="card-title">Saldo Actual</h5>
                                <h6 class="card-subtitle mb-2 text-muted">${{ number_format($clientes[0]->saldo, 2) }}</h6>
                                <p class="card-text">Fecha desembolso: {{ $clientes[0]->fecha_desembolso }}</p>
                            </div>
                    </td>
                
                    <td align="center">
                            <div class="card" style="background-color: cyan;width: 18rem;">
                                <div class="card-body">
                                <h5 class="card-title">Total Abonado a Capital</h5>
                                ${{ number_format($clientes[0]->valor_abono, 2) }}
                                <p class="card-text">Fecha abono: {{ $clientes[0]->fecha_abono }}</p>
                            </div>
                    </td>

                    <td align="center">
                            <div class="card" style="background-color: cyan;width: 18rem;">
                                <div class="card-body">
                                <h5 class="card-title">Total Intereses Recaudados</h5>
                                <h6 class="card-subtitle mb-2 text-muted">${{ number_format($clientes[0]->totalabonado, 2) }}</h6>
                                <p class="card-text">Fecha ultimo abono: {{ $clientes[0]->fecha_abono }}</p>
                            </div>
                    </td>
                    
                </tr>
                <tr>
                <td align="center">
                            <div class="card" style="background-color: cyan;width: 18rem;">
                                <div class="card-body">
                                <h5 class="card-title">Valor Total Abonos</h5>
                                <h6 class="card-subtitle mb-2 text-muted">${{ number_format($clientes[0]->totalabonado, 2) }}</h6>
                                <p class="card-text">Fecha ultimo abono: {{ $clientes[0]->fecha_abono }}</p>
                            </div>
                    </td>
                </tr>

            </table>
                        
        </div>
                      
</body>
</html>