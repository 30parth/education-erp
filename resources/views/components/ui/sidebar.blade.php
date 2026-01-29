<aside id="logo-sidebar"
    class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full bg-white border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700 flex flex-col"
    aria-label="Sidebar">

    <!-- Sidebar Header / Logo -->
    <div
        class="h-14 flex items-center justify-between px-3 border-b border-gray-200 dark:border-gray-700 bg-white dark:bg-gray-800 shrink-0">
        <a href="/" class="flex items-center ms-2 md:me-24">
            <img src="https://flowbite.com/docs/images/logo.svg" class="h-8 me-3" alt="FlowBite Logo" />
            <span
                class="self-center text-xl font-semibold sm:text-2xl whitespace-nowrap dark:text-white">{{ config('app.name') }}</span>
        </a>
    </div>

    <!-- Sidebar Menu -->
    <div class="flex-1 px-3 pb-4 pt-4 overflow-y-auto bg-white dark:bg-gray-800">
        <ul class="space-y-2 font-medium">
            @foreach ($menuItems as $item)
                @if (isset($item['children']) && !empty($item['children']))
                    <li>
                        <button type="button"
                            class="flex items-center w-full p-2 text-base text-gray-900 transition duration-75 rounded-lg group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700"
                            aria-controls="dropdown-{{ $loop->index }}"
                            data-collapse-toggle="dropdown-{{ $loop->index }}">
                            {!! $item['icon'] !!}
                            <span class="flex-1 ms-3 text-left whitespace-nowrap">{{ $item['label'] }}</span>
                            <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                                viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>
                        <ul id="dropdown-{{ $loop->index }}" class="hidden py-2 space-y-2">
                            @foreach ($item['children'] as $child)
                                <li>
                                    <a href="{{ $child['url'] }}" wire:navigate
                                        class="flex items-center w-full p-2 text-gray-900 transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">{{ $child['label'] }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ $item['url'] }}" wire:navigate
                            class="flex items-center p-2 text-gray-900 rounded-lg dark:text-white hover:bg-gray-100 dark:hover:bg-gray-700 group">
                            {!! $item['icon'] !!}
                            <span class="flex-1 ms-3 whitespace-nowrap">{{ $item['label'] }}</span>
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
</aside>
