@props([
    'title' => null
])
<td {{ $attributes->merge(['class' => 'w-full whitespace-no-wrap text-sm leading-5 lg:w-auto p-3 text-gray-800 dark:text-gray-200 text-center lg:text-left lg:border-0 border dark:border-gray-700 border-b block lg:table-cell relative lg:static']) }}>

    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 dark:bg-gray-200 px-2 text-[10px] text-gray-200 dark:text-gray-800 font-bold uppercase rounded-br-xl">{{ $title }}</span>

    <p class="mt-2 lg:m-0">

        {{ $slot }}

    </p>

</td>
