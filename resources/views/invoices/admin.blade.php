@extends('layouts.app')

@section('jumbotron')
    @include('partials.jumbotron', ['title' => __('Manejar mis facturas'), 'icon' => 'archive'])
@endsection


@section('content')
    <div class="pl-5 pr-5">
        <div class="row justify-content-center">
            <table class="table table-hover table-dark">
                <thead>
                    <tr>
                        <th scope="col">{{ __('Fecha de la suscripcion') }}</th>
                        <th scope="col">{{ __('Coste de la suscripcion') }}</th>
                        <th scope="col">{{ __('Cupón') }}</th>
                        <th scope="col">{{ __('Descargar factura') }}</th>
                    </tr>
                </thead>
                <tbody>
                @forelse($invoices as $invoice)
                    <tr>
                        <td>{{ $invoice->date()->format('d/m/Y') }}</td>
                        <td>{{ $invoice->total() }}</td>
                        <td>
                            @if($invoice->hasDiscount)
                               {{ __('Cupón') }}: ({{ $invoice->cupon() }}) / {{ $invoice->discount() }}
                            @else
                                {{ __('No se ha utilizado ningún cupón') }}
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-course" href="{{ route('invoices.download', ['id'=>$invoice->id]) }}">{{ __('Descargar') }}</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4">{{ __('No hay ninguna factura disponible') }}</td>
                    </tr>
                @endforelse
                </tbody>

            </table>
        </div>
    </div>
@endsection