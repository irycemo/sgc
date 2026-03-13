<div>

    <x-header>Reportes</x-header>

    <div class="p-4 mb-5 bg-white shadow-lg rounded-lg flex justify-center">

        <x-input-group for="area" label="Área" :error="$errors->first('area')" class="">

            <x-input-select id="area" wire:model.live="area">

                <option selected value="">Selecciona una área</option>
                <option value="tramites">Trámites</option>
                <option value="usuarios">Usuarios</option>
                <option value="certificaciones">Certificaciones</option>
                <option value="escrituracion_social">Escrituración social</option>

            </x-input-select>

        </x-input-group>

    </div>

    @if ($verTramites)

        @livewire('consultas.reportes.reporte-tramites')

    @endif

    @if ($verUsuarios)

        @livewire('consultas.reportes.reporte-usuarios')

    @endif

    @if ($verCertificaciones)

        @livewire('consultas.reportes.reporte-certificaciones')

    @endif

    @if ($verEscrituracionSocial)

        @livewire('consultas.reportes.reporte-escrituracion-social')

    @endif

</div>
