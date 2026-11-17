<button {{ $attributes->exceptProps(['class']) }} {{ $attributes->merge(['class' => 'tracking-widest py-1 px-4 text-gray-600 dark:text-gray-300 rounded-xl border-b-2 border-gray-500 dark:border-gray-400 font-thin mb-2 bg-white dark:bg-gray-800 cursor-pointer hover:shadow-lg hover:bg-gray-50 dark:hover:bg-gray-700']) }} type="button">

    {{ $slot }}

</button>
