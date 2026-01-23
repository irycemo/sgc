<x-mail::message>

<p>Ha solicitado un nuevo trámtie catastral</p>

<p><strong>Folio del trámite: </strong>{{ $tramite->año }}-{{ $tramite->folio }}-{{ $tramite->usuario }}</p>
<p><strong>Categoría del servicio: </strong>{{ $tramite->servicio->categoria->nombre }}</p>
<p><strong>Servicio: </strong>{{ $tramite->servicio->nombre }}</p>
<p><strong>Cantidad: </strong>{{ $tramite->cantidad }}</p>
<p><strong>Solicitante: </strong>{{ $tramite->solicitante }}, {{ $tramite->nombre_solicitante }}</p>
<p><strong>Fecha de vencimiento: </strong>{{ $tramite->fecha_vencimiento }}</p>
<p><strong>Línea de captura: </strong>{{ $tramite->linea_de_captura }}</p>
<p><strong>Monto: </strong>${{ number_format($tramite->linea_de_captura, 2) }}</p>
<p><strong>Fecha de creación: </strong>{{ $tramite->created_at }}</p>

<p>La orden de pago de este trámite se ha adjuntado a este correo.</p>


Favor de no contestar a este correo<br>
{{ config('app.name') }}<br>
Instituto Registral y Catastral de Michoacán de Ocampo<br>
Gobierno del Estado de Michoacán
</x-mail::message>