<div class="relative mt-3 md:mt-0" x-data="{ isOpen:true }" @click.away="isOpen = false">
                   
    <input wire:model.debounce.500ms="search" type="text" class="bg-gray-800 rounded-full w-64  pl-8 py-1 
    focus:outline-none focus:shadow-outline" placeholder="Search"
    x-ref="search"
    @keydown.window="
        if (event.keyCode == 191){
            event.preventDefault();
            $ref.search.focus();
        }
    "
    @focus="isOpen = true"
    @keydown="isOpen = true"
    @keydown.escape.window="isOpen = false"
    @keydown.shift.tab="isOpen = false"

    />
    <div class="absolute top-0">
      <svg  class="fill-current text-gray-500 w-5 mt-1 ml-1" xmlns="http://www.w3.org/2000/svg" 
      viewBox="0 0 50 50"><path d="M21 3a17 17 0 1010 31l13 13 3-3-13-13c2-3 4-7 4-11 0-9-8-17-17-17zm0 2a15 15 0 110 30 15 15 0 010-30z"/>
        </svg> 
    </div>

    <div wire:loading class="spinner top-0 right-0 mr-4 mt-3"></div>

    @if (strlen($search) >= 2)
        <div class="z-50 absolute bg-gray-800 text-sm rounded w-64 mt-4" 
            x-show.transition.opacity="isOpen"
            >
            @if ( $searchResults->count() > 0)
                <ul> 
                    @foreach ( $searchResults as $result)
                        <li class="border-b border-gray-700">
                            <a href="{{route('movies.show',$result['id'])}}" class="block 
                                hover:bg-gray-700 px-3 py-3 flex items-center transition ease-in-out duration-150"
                                @if ($loop->last) @keydown.tab="isOpen = false" @endif

                            >
                            @if ($result['poster_path'])
                                <img src="https://image.tmdb.org/t/p/w92/{{$result['poster_path']}}" alt="poster"
                                class="w-8">
                            @else
                                <img src="https://via.placeholder.com/50x75" alt="poster" class="w-8">
                            @endif
                                <span class="ml-4">{{ $result['title'] }} </span>
                        </a>
                        </li>
                    @endforeach
                
                </ul> 
            @else
                <div class="px-3 py-3">No results for "{{ $search  }}"</div>    
            @endif
        </div>
    @endif
  </div>