<a {{ $attributes->exceptProps(['class']) }} {{ $attributes->merge(['class' => 'bg-green-400 hover:shadow-lg text-white px-4 py-1 rounded-full text-sm hover:bg-green-700 dark:bg-green-600 dark:hover:bg-green-500 flex items-center justify-center focus:outline-green-400 focus:outline-offset-2']) }}>

    {{ $slot }}

</a>
