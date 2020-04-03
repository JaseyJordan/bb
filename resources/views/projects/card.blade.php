    <div class="card flex flex-col text-default" style="height: 200px;">

        <h3 class="font-normal text-xl py-2 pl-4 mb-4 -ml-5 border-l-4 border-blue-500"><a href="{{ $project->path() }}">{{ $project->title }}</a></h3>

        <div class="text-sm flex-1">{{ Str::limit($project->description, 100) }}</div>
        @can('manage', $project)
        <footer>
            <form method="POST" action="{{ $project->path() }}" class="text-right">
                @method('DELETE')
                @csrf
                <button class="button bg-red-500 text-xs mt-2 mr-4" type="submit">Delete</button>
            </form>
        </footer>
        @endcan
    </div>
