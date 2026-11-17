<button {{ $attributes->exceptProps(['class']) }} {{ $attributes->merge(['class' => 'bg-blue-400 hover:shadow-lg text-white px-4 py-1 rounded-full text-sm hover:bg-blue-700 dark:bg-blue-600 dark:hover:bg-blue-500 flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2']) }}>

    {{ $slot }}

</button>
