<div alt="Cartografía">

    <div class="ml-3 relative z-50" x-data="{ open_drop_down:false }">

        <div>

            <button x-on:click="open_drop_down=true" type="button" class="flex text-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white" id="user-menu" aria-expanded="false" aria-haspopup="true">

                <span class="sr-only">Cartografía</span>

                <img class="h-10 w-10 " src="{{ asset('storage/img/CARTO.png') }}" id="nav-profile">

            </button>

        </div>

        <div x-cloak x-show="open_drop_down" x-on:click.away="open_drop_down=false" class="origin-top-right absolute right-0 mt-2 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

            @foreach ($cartografia as $cartografia)

                <a  href="{{ $cartografia->getLink() }}" target="_blank" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100" role="menuitem">{{ $cartografia['url'] }}</a>

            @endforeach

        </div>

    </div>

</div>
