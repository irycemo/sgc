<button {{ $attributes->exceptProps(['class']) }} {{ $attributes->merge(['class' => 'bg-gray-400 hover:shadow-lg text-white px-4 py-1 rounded-full text-sm hover:bg-gray-700 dark:bg-gray-600 dark:hover:bg-gray-500 flex items-center justify-center focus:outline-gray-400 dark:focus:outline-gray-500 focus:outline-offset-2']) }}>

    {{ $slot }}

</button>
