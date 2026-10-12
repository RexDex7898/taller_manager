@extends('layouts.app')

@section('content')
    <div class="header">
        <h1>Flujo del Taller</h1>
        <p>Mueve los equipos según su estado actual</p>
    </div>

    <div class="kanban-container">
        @php
            $columnas = [
                'recepcion' => 'Entrada / Pendientes',
                'diagnostico' => 'En Diagnóstico',
                'esperando_piezas' => 'Faltan Refacciones',
                'en_reparacion' => 'Manos a la obra',
                'listo_entrega' => 'Listos para Entregar'
            ];
        @endphp

        @foreach($columnas as $estado => $titulo)
            <div class="kanban-column">
                <h3>{{ $titulo }} <span>({{ isset($reparaciones[$estado]) ? $reparaciones[$estado]->count() : 0 }})</span></h3>
                
                @if(isset($reparaciones[$estado]))
                    @foreach($reparaciones[$estado] as $rep)
                        <div class="kanban-card">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 8px;">
                                <h4>{{ $rep->equipo->marca }} {{ $rep->equipo->modelo }}</h4>
                                <span class="status">#{{ str_pad($rep->id, 4, '0', STR_PAD_LEFT) }}</span>
                            </div>
                            
                            <p><strong>Falla:</strong> {{ Str::limit($rep->equipo->falla_reportada, 50) }}</p>
                            <p><strong>Cliente:</strong> {{ $rep->equipo->cliente->nombre }}</p>
                            
                            <div class="kanban-action">
                                <form action="{{ route('reparaciones.estado', $rep) }}" method="POST">
                                    @csrf
                                    @method('PATCH')
                                    <select name="estado" onchange="this.form.submit()" class="kanban-select">
                                        <option value="" disabled selected>Mover a...</option>
                                        @foreach($columnas as $est => $tit)
                                            @if($est != $estado)
                                                <option value="{{ $est }}">{{ $tit }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </form>
                            </div>
                        </div>
                    @endforeach
                @endif
            </div>
        @endforeach
    </div>
@endsection