@extends('layouts.app')

@section('content')

<header class="flex items-center mb-3">
    <div class="flex justify-between items-end w-full">

        <h2 class="text-default text-sm font-normal">My Projects</h2>

        <a @click.prevent="$modal.show('new-project')" class="button bluebtn" href="/projects/create">Add Project</a>

    </div>
</header>

<div class="lg:flex lg:flex-wrap -mx-3">
    @forelse ($projects as $project)
        <div class="lg:w-1/3 p-3">
            @include('projects.card')
        </div>
    @empty
        <div>No Projects yet.</div>
    @endforelse

</div>
<new-project-modal></new-project-modal>
@endsection


