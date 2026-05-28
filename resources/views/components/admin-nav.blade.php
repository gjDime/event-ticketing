@php
    $tabs = [
        ['name' => 'Events Overview', 'route' => 'admin.dashboard'],
        ['name' => 'Check-In Scanner', 'route' => 'admin.check-in'],
        ['name' => 'Analytics', 'route' => 'admin.analytics'],
    ];
@endphp

<div class="bg-white border-b border-gray-200 shadow-sm">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <nav class="flex space-x-1 sm:space-x-4 -mb-px overflow-x-auto" aria-label="Admin sections">
            @foreach($tabs as $tab)
                @php $active = request()->routeIs($tab['route']); @endphp
                <a href="{{ route($tab['route']) }}"
                   class="whitespace-nowrap py-3 px-3 sm:px-4 border-b-2 text-sm font-medium transition
                          {{ $active
                                ? 'border-indigo-500 text-indigo-600'
                                : 'border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300' }}">
                    {{ $tab['name'] }}
                </a>
            @endforeach
        </nav>
    </div>
</div>
