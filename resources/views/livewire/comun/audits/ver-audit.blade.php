<div>

    <x-button-green wire:click="$toggle('modal')">Ver</x-button-green>

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">

            {{ Str::substr($audit['auditable_type'], 11) }}

        </x-slot>

        <x-slot name="content">

            <strong>Evento:</strong>
            @if( $audit['event'] == 'updated')
                <p>Actualización</p>
            @elseif($audit['event'] == 'created')
               <p>Creado</p>
            @elseif($audit['event'] == 'sync')
                <p>Sync</p>
            @elseif($audit['event'] == 'sync')
                <p>Sync</p>
            @elseif($audit['event'] == 'attach')
                <p>Attach</p>
            @else
                Borrado
            @endif

            <strong>Usuario:</strong>
            <p>{{ $audit['user']['name'] ?? 'N/A' }}</p>

            <strong>Modelo:</strong>
            <p>{{ Str::substr($audit['auditable_type'], 11) }}, id: {{ $audit['auditable_id'] }}</p>

            <strong>URL:</strong>
            <p>{{ $audit['url'] }}</p>

            <strong>IP:</strong>
            <p>{{ $audit['ip_address'] }}</p>

            <strong>Agente:</strong>
            <p>{{ $audit['user_agent'] }}</p>

            <strong>Registrado:</strong>
            <p>{{ $audit['created_at'] }}</p>

            @if($audit['event'] == 'attach' || $audit['event'] == 'sync')

                <p class="mt-4 capitalize"><strong>Relacion:</strong> {{ key($this->newValues) }}</p>

                <div class="grid grid-cols-2 gap-3 my-4">

                    <div class="break-words">

                        <strong>Valores anteriores</strong>

                        @if($audit['event'] == 'sync')

                            @foreach ($this->oldValues[key($this->oldValues)][0] as $key => $value )

                                @if($key == 'pivot') @continue @endif

                                <p>{{ $key }} = {{ $value }}</p>

                            @endforeach

                        @endif

                    </div>

                    <div class="break-words">

                        <strong>Valores nuevos</strong>

                        @foreach ($this->newValues[key($this->newValues)][0] as $key => $value )

                            @if($key == 'pivot') @continue @endif

                            <p>{{ $key }} = {{ $value }}</p>

                        @endforeach

                    </div>

                </div>

            @else

                <div class="grid grid-cols-2 gap-3 my-4">

                    <div class="break-words">

                        <strong>Valores anteriores</strong>

                        @foreach ($audit['old_values'] as $key => $value)

                            <p>{{ $key }} = {{ $value ?? 'null' }}</p>

                        @endforeach

                    </div>

                    <div class="break-words">

                        <strong>Valores nuevos</strong>

                        @foreach ($audit['new_values'] as $key => $value)

                            <p>{{ $key }} = {{ $value ?? 'null' }}</p>

                        @endforeach

                    </div>

                </div>

            @endif

        </x-slot>

        <x-slot name="footer">

            <div class="flex justify-between w-full">

                <x-link-blue href="{{ route('auditoria') . '?modelo=' . $modelo . '&modelo_id=' . $modelo_id }}" target="_blank">
                    Ver auditoria completa de esta entidad
                </x-link-blue>

                <x-button-red
                    wire:click="$set('modal', false)"
                    wire:loading.attr="disabled"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
