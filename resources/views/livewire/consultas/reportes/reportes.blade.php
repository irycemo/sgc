<div>

    <x-header>Reportes</x-header>

    <div class="p-4 mb-5 bg-white shadow-lg rounded-lg flex justify-center">

        <x-input-group for="area" label="Área" :error="$errors->first('area')" class="">

            <x-input-select id="area" wire:model.live="area">

                <option selected value="">Selecciona una área</option>
                <option value="Tramites">Trámites</option>
                <option value="Usuarios">Usuarios</option>
                <option value="Certificaciones">Certificaciones</option>
                <option value="Avisos">Avisos</option>
                <option value="EscrituracionSocial">Escrituración social</option>
                <option value="Recaudacion">Recaudación</option>
                <option value="Sat">SAT</option>

            </x-input-select>

        </x-input-group>

    </div>

    @if ($flags['Tramites'])

        @livewire('consultas.reportes.reporte-tramites')

    @endif

    @if ($flags['Usuarios'])

        @livewire('consultas.reportes.reporte-usuarios')

    @endif

    @if ($flags['Certificaciones'])

        @livewire('consultas.reportes.reporte-certificaciones')

    @endif

    @if ($flags['EscrituracionSocial'])

        @livewire('consultas.reportes.reporte-escrituracion-social')

    @endif

    @if ($flags['Avisos'])

        @livewire('consultas.reportes.reporte-avisos')

    @endif

    @if ($flags['Recaudacion'])

        @livewire('consultas.reportes.reporte-recaudacion')

    @endif

    @if ($flags['Sat'])

        @livewire('consultas.reportes.reporte-sat')

    @endif

</div>
