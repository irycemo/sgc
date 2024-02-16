<div x-data="{ focused: false }" class="w-full">

    <span class="rounded-md shadow-sm w-full ">

        <input @focus="focused = true" @blur="focused = false" class="sr-only" type="file" wire:model.live="modelo_editar.cer" id="modelo_editar.cer">

        <label for="modelo_editar.cer" :class="{ 'outline-none border-blue-300 shadow-outline-blue': focused }" class="flex justify-between w-full cursor-pointer py-2 px-3 border border-gray-300 rounded-md text-sm leading-4 font-medium text-gray-700 hover:text-gray-500 active:bg-gray-50 active:text-gray-800 transition duration-150 ease-in-out">
            Selecccione el archivo

            @if($modelo_editar->cer)

                <span class=" text-blue-700">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 rounded-full border border-blue-700">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                    </svg>

                </span>

            @endif

        </label>

    </span>

</div>
