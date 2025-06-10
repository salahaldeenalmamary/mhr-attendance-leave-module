

{{--
    This component acts as a responsive sidebar/drawer.
    - On mobile (< md), it's a 'fixed' drawer that slides in from the left.
    - On desktop (>= md), it becomes a 'static' sidebar, always visible.
    It expects 'drawerOpen' to be defined in a parent Alpine.js component.
--}}
<aside
    class="w-64 flex-shrink-0 bg-white border-r border-gray-200 flex-col
           md:flex                                 {{-- On desktop, always display as a flex container --}}
           h-screen                              {{-- Ensure it takes full viewport height --}}
           transition-all duration-300 ease-in-out {{-- For any potential future animations --}}
           "
    :class="{ 'flex': drawerOpen, 'hidden': !drawerOpen }" {{-- On mobile, toggle between 'flex' and 'hidden' --}}
>
    <!-- Drawer Header -->
   <!-- Drawer Header -->
    <div class="flex items-center justify-center h-16 border-b border-gray-200 flex-shrink-0">
        <a href="{{ route('dashboard') }}" class="text-xl font-bold text-gray-800 tracking-wider">
            HRM System
        </a>
    </div>

    <!-- Navigation Links -->
    <nav class="flex-1 overflow-y-auto px-2 py-4 space-y-2">
        <x-responsive-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
            <svg class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path d="M10.707 2.293a1 1 0 00-1.414 0l-7 7a1 1 0 001.414 1.414L4 10.414V17a1 1 0 001 1h2a1 1 0 001-1v-2a1 1 0 011-1h2a1 1 0 011 1v2a1 1 0 001 1h2a1 1 0 001-1v-6.586l.293.293a1 1 0 001.414-1.414l-7-7z" /></svg>
            Dashboard
        </x-responsive-nav-link>
        <x-responsive-nav-link :href="route('departments.index')" :active="request()->routeIs('departments.*')">
            <svg class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10 2a.75.75 0 01.75.75v.25h3.5a.75.75 0 010 1.5h-3.5v1.5a.75.75 0 01-1.5 0v-1.5h-3.5a.75.75 0 010-1.5h3.5V2.75A.75.75 0 0110 2zM5.106 7.606a.75.75 0 01.018 1.042l-2.25 3.5a.75.75 0 01-1.06 0l-2.25-3.5a.75.75 0 111.042-1.06l1.718 2.67 1.718-2.67a.75.75 0 011.042-.018zM14.894 7.606a.75.75 0 011.042.018l2.25 3.5a.75.75 0 010 1.06l-2.25 3.5a.75.75 0 11-1.06-1.042l1.718-2.67-1.718-2.67a.75.75 0 01.018-1.042z" clip-rule="evenodd" /></svg>
            Departments
        </x-responsive-nav-link>
        <x-responsive-nav-link href="#">
            <svg class="h-5 w-5 mr-3" viewBox="0 0 20 20" fill="currentColor"><path d="M7 8a3 3 0 100-6 3 3 0 000 6zM14.5 9a4.5 4.5 0 100-9 4.5 4.5 0 000 9zM1.5 12a4.5 4.5 0 100-9 4.5 4.5 0 000 9zM10 12a3 3 0 100-6 3 3 0 000 6z" /></svg>
            Employees
        </x-responsive-nav-link>
        {{-- Add more links as needed --}}
    </nav>
</aside>