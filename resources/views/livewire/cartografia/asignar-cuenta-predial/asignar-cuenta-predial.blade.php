<div class="">

    <x-header>Asignación de cuentas prediales</x-header>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <div class="p-4 bg-white rounded-lg mb-3 shadow-md space-y-3">

            <div class="flex flex-row flex-wrap justify-center items-center space-y-2 mb-6">

                <div class="mx-auto">

                    <input placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model="localidad">

                    <input placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model.live="oficina" @if(auth()->user()->oficina->oficina != 101 && !auth()->user()->hasRole('Administrador')) readonly @endif>

                    <input placeholder="Tipo" type="number" max="2" min="1" class="bg-white rounded text-xs w-20 @error('tipo') border-1 border-red-500 @enderror" wire:model="tipo">

                </div>

                <x-input-group for="valuador" label="Valuador" :error="$errors->first('valuador')" class="w-full">

                    <x-input-select id="valuador" wire:model="valuador" class="w-full">

                        <option value="">Seleccione una opción</option>
                        @foreach ($valuadores as $item)

                            <option value="{{ $item->id }}">{{ $item->name }}</option>

                        @endforeach

                    </x-input-select>

                </x-input-group>

            </div>

            <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                <x-input-group for="tipo_titulo" label="Tipo de título" :error="$errors->first('tipo_titulo')" class="w-full">

                    <x-input-select id="tipo_titulo" wire:model.live="tipo_titulo" class="w-full">

                        <option value="">Seleccione una opción</option>
                        <option value="TÍTULO DE PROPIEDAD PARCELARIO">TÍTULO DE PROPIEDAD PARCELARIO</option>
                        <option value="TÍTULO DE PROPIEDAD SOLAR URBANO">TÍTULO DE PROPIEDAD SOLAR URBANO</option>

                    </x-input-select>

                </x-input-group>

                <x-input-group for="titulo" label="Título de propiedad" :error="$errors->first('titulo')" class="w-full">

                    <x-input-text id="titulo" wire:model="titulo" />

                </x-input-group>

                <x-input-group for="cantidad" label="Cantidad solicitada" :error="$errors->first('cantidad')" class="w-full">

                    <x-input-text type="number" id="cantidad" wire:model="cantidad"/>

                </x-input-group>



            </div>

            <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                <x-input-group for="origen" label="Predio de origen" :error="$errors->first('origen')" class="w-full">

                    <x-input-text id="origen" wire:model="origen" />

                </x-input-group>

                <x-input-group for="oficio" label="Número de oficio" :error="$errors->first('oficio')" class="w-full">

                    <x-input-text id="oficio" wire:model="oficio" />

                </x-input-group>

            </div>

            <x-input-group for="observaciones" label="Observaciones" :error="$errors->first('observaciones')" class="w-full">

                <x-input-select id="observaciones" wire:model="observaciones" class="w-full">

                    <option value="">Seleccione una opción</option>
                    <option value="AVALUO PARA EFECTOS DE ACTULIZACION DE VALOR CATASTRAL POR SUBDIVICION AUTORIZADA POR LA SUOP OFICIO SUOP-DOU-RU-XXXXX  DE FECHA XX/XX/XXXX">
                        AVALUO PARA EFECTOS DE ACTULIZACION DE VALOR CATASTRAL POR SUBDIVICION AUTORIZADA POR LA SUOP OFICIO SUOP-DOU-RU-XXXXX  DE FECHA XX/XX/XXXX
                    </option>
                    <option value="SURGE POR SUB-DIVISION AUTORIZADO POR EL MUNICIPIO EN OFICIO XXXX/XXXX, DE FECHA XX DE XXXXXXX DEL XXXX">
                        SURGE POR SUB-DIVISION AUTORIZADO POR EL MUNICIPIO EN OFICIO XXXX/XXXX, DE FECHA XX DE XXXXXXX DEL XXXX
                    </option>
                    <option value="SE ASIGNA CUENTA PREDIAL POR DESGLOSE AUTORIZADO POR EL MPIO MEDIANTE OFICIO SUOP/DOU/FRACC/2039/2019 DE FECHA XX DE XXXXXX DE XXXX">
                        SE ASIGNA CUENTA PREDIAL POR DESGLOSE AUTORIZADO POR EL MPIO MEDIANTE OFICIO SUOP/DOU/FRACC/2039/2019 DE FECHA XX DE XXXXXX DE XXXX
                    </option>
                    <option value="SE ASIGNA CUENTA PREDIAL POR CAMBIO DE LOCALIDAD PASA DE XXXXXXX CON CUENTA X-XXX-X-XXXX     A       XXXXXXXXX">
                        SE ASIGNA CUENTA PREDIAL POR CAMBIO DE LOCALIDAD PASA DE XXXXXXX CON CUENTA X-XXX-X-XXXX     A       XXXXXXXXX
                    </option>
                    <option value="SE ASIGNA CUENTA PREDIAL POR ALTA EN EL RAN DEL TITULO NO. xxxxxxx QUE AMPARA EL SOLAR LOTE xxx MZNA xxxx ZONA x ubicado en POBLADO CON SUPERFICIE xxxxxxxxxxxx A NOMBRE DE xxxxxxxxxxxxxxxx">
                        SE ASIGNA CUENTA PREDIAL POR ALTA EN EL RAN DEL TITULO NO. xxxxxxx QUE AMPARA EL SOLAR LOTE xxx MZNA xxxx ZONA x ubicado en POBLADO CON SUPERFICIE xxxxxxxxxxxx A NOMBRE DE xxxxxxxxxxxxxxxx
                    </option>

                </x-input-select>

                <textarea rows="5" wire:model="observaciones" class="bg-white rounded text-xs w-full mt-2 @error('observaciones') border-red-500 @enderror" placeholder="Se lo más específico posible acerca del motivo por el que se asignan las nuevas cuentas prediales"></textarea>

            </x-input-group>

            <div class="flex justify-end">

                <x-button-gray wire:click="crearCuentas">
                    <img wire:loading wire:target="crearCuentas" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Crear cuentas
                </x-button-gray>

            </div>

        </div>

        <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

            <h4 class="text-lg mb-5 text-center">Búsqueda de cuentas prediales asignadas</h4>

            <div class="flex flex-wrap space-x-1 justify-center items-center gap-1">

                <input placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad_busqueda') border-1 border-red-500 @enderror" wire:model.blur="localidad_busqueda">

                <input placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina_busqueda') border-1 border-red-500 @enderror" wire:model="oficina_busqueda" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                <input placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('tipo_busqueda') border-1 border-red-500 @enderror" wire:model="tipo_busqueda">

                <input placeholder="Registro inicial" type="number" class="bg-white rounded text-xs @error('registro_inicio') border-1 border-red-500 @enderror" wire:model="registro_inicio">
                <p class="text-sm mb-0">a</p>
                <input placeholder="Registro final" type="number" class="bg-white rounded text-xs @error('registro_final') border-1 border-red-500 @enderror" wire:model="registro_final">

            </div>

            <div class="flex justify-center">

                <x-button-gray wire:click="buscarCuentas">
                    <img wire:loading wire:target="buscarCuentas" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Buscar por cuenta
                </x-button-gray>

            </div>

            <div class="flex flex-wrap space-x-1 justify-center items-center gap-1">

                <input placeholder="Título de propiedad" type="text" class="bg-white rounded text-xs @error('titulo_busqueda') border-1 border-red-500 @enderror" wire:model="titulo_busqueda">

                <input placeholder="Número de oficio" type="text" class="bg-white rounded text-xs @error('oficio_busqueda') border-1 border-red-500 @enderror" wire:model="oficio_busqueda">

            </div>

            <div class="flex flex-wrap space-x-1 justify-center items-center gap-1">

                <input placeholder="Observaciones" type="text" class="bg-white rounded text-xs w-1/2 @error('observaciones_busqueda') border-1 border-red-500 @enderror" wire:model="observaciones_busqueda">

            </div>

            <x-input-group for="valuador" label="" :error="$errors->first('valuador')" class="w-1/2 mx-auto text-xs">

                <x-input-select id="valuador" wire:model="valuador" class="w-full text-xs">

                    <option value="">Seleccione un valuador</option>
                    @foreach ($valuadores as $item)

                        <option value="{{ $item->id }}">{{ $item->name }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

            <div class="flex justify-center">

                <x-button-gray wire:click="buscarCampos">
                    <img wire:loading wire:target="buscarCampos" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Buscar por campos
                </x-button-gray>

            </div>

        </div>

    </div>

    @if($cuentasAsignadas)

        <div class="overflow-x-auto rounded-lg shadow-xl p-4 flex gap-4 items-center justify-between bg-white">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cuentas asignadas</strong>

                <p>{{ count($cuentasAsignadas) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cuentas preexistentes</strong>

                <p>{{ $cuentas_preexistentes }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cuenta inicial</strong>

                <p>{{ $cuentasAsignadas[0]['localidad'] }}-{{ $cuentasAsignadas[0]['oficina'] }}-{{ $cuentasAsignadas[0]['tipo_predio'] }}-{{ $cuentasAsignadas[0]['numero_registro'] }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cuenta final</strong>

                <p>{{ end($cuentasAsignadas)['localidad'] }}-{{ end($cuentasAsignadas)['oficina'] }}-{{ end($cuentasAsignadas)['tipo_predio'] }}-{{ end($cuentasAsignadas)['numero_registro'] }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número de oficio</strong>

                <p>{{ $cuentasAsignadas[0]['oficio'] ?? 'N/A' }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Tipo de título de propiedad</strong>

                <p>{{ $cuentasAsignadas[0]['tipo_titulo'] ?? 'N/A' }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Número de título de propiedad</strong>

                <p>{{ $cuentasAsignadas[0]['titulo_propiedad'] ?? 'N/A' }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valuador asignado</strong>

                <p>{{ $cuentasAsignadas[0]['valuadorAsignado'] }}</p>

            </div>

        </div>

    @endif

</div>
