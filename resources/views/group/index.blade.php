<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('messages.groups_list') }}
        </h2>
    </x-slot>

    <section class="nice-page">
    <article  class="nice-box">
        <ul>
        @foreach ($groups as $group)
            <li class="mx-auto max-w-screen-xl px-2 lg:px-12 bg-white shadow-md sm:rounded-lg overflow-hidden mb-2
            flex flex-row md:flex-col justify-between space-y-3 md:space-y-0 md:space-x-4 p-2">
            <x-group-details :group=$group :occurences=$occurences />
            </li>
        @endforeach
        </ul>
        </article>
    </section>


    @if(Auth::user()->getMode() == "Edit")
    <section class="nice-page">
        <form action="{{route('group.save', 0)}}" method="post" 
        class="mx-auto px-6 py-2 bg-white shadow-md mb-6 flex flex-col gap-4">
            @csrf
            <x-text-input type="text" name="name" id="name" placeholder="{{ __('messages.name') }}"/>
            @error('name')
            <div class="bg-red-700 text-red-100 border-red-400 rounded-md px-4 py-2">{{ $message }}</div>
            @enderror
            <x-text-input type="text" name="short_name" id="short_name" placeholder="{{ __('messages.short_name') }}"/>
            @error('short_name')
            <div class="bg-red-700 text-red-100 border-red-400 rounded-md px-4 py-2">{{ $message }}</div>
            @enderror
            <x-text-input type="text" name="size" id="size" placeholder="{{ __('messages.size') }}"/>
            @error('size')
            <div class="bg-red-700 text-red-100 border-red-400 rounded-md px-4 py-2">{{ $message }}</div>
            @enderror            
            <x-primary-button>{{ __('messages.group_create') }}</x-primary-button>
        </form>
    </section>
    @endif

        <section  class="nice-page">
            <article  class="nice-box">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight py-4">Groupes Archivés</h2>
        <ul>
        @foreach ($inactive as $group)
            <li class="mx-auto max-w-screen-xl px-2 lg:px-12 bg-white shadow-md sm:rounded-lg overflow-hidden mb-2
            flex flex-row md:flex-col justify-between space-y-3 md:space-y-0 md:space-x-4 p-2">
            <x-group-details :group=$group :occurences=$occurences />
            </li>
        @endforeach
        </ul>
        </article>
    </section>

</x-app-layout>