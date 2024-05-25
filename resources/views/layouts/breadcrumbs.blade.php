<nav class="mx-auto px-4 py-2">
    <ul>
        <li class="inline p-2">
        <a href="{{route('dashboard')}}" class="inline-flex items-center p-0.5 text-sm font-medium hover:text-gray-400 focus:outline-none">
        {{ Auth::user()->getCompany()->name }}
        </a>
        </li>
        @if (session('school') !== null)
        > <li class="inline p-2">
            <form action="{{route('school.show', session('school_id'))}}" method="get" class="inline">
            @csrf
            <button class="inline-flex items-center p-0.5 text-sm font-medium hover:text-gray-400 focus:outline-none" type="submit">
            {{session('school')}}
            </button>    
            </form>
        </li>
        @endif
        @if (session('course') !== null)
        > <li class="inline p-2">{{session('course')}}</li>
        @endif
    </ul>
</nav>