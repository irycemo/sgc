<button {{ $attributes->exceptProps(['class']) }} {{ $attributes->merge(['class' => 'bg-yellow-400 hover:shadow-lg text-white px-4 py-1 rounded-full text-sm hover:bg-yellow-700 dark:bg-yellow-600 dark:hover:bg-yellow-500 flex items-center justify-center focus:outline-yellow-400 focus:outline-offset-2']) }}>

    {{ $slot }}

</button>
