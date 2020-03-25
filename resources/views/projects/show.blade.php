@extends('layouts.app')

@section('content')
    <header class="flex items-center mb-3">
        <div class="flex justify-between items-end w-full">
            <p class="text-gray-200 text-sm font-normal">
                <a href="/projects">My Projects</a> / {{ $project->title }}
            </p>
            <div class="inline-block">
                @foreach ($project->members as $member)
                    <img
                        class="inline-block rounded-full mr-2 w-8"
                        src="{{ gravatar($member->email) }}"
                        alt="{{ $member->name }}"
                        title="{{ $member->name }}" />
                @endforeach

                <img
                    class="inline-block rounded-full mr-2 w-8"
                    src="{{ gravatar($project->owner->email) }}"
                    alt="{{ $project->owner->name }}"
                    title="{{ $project->owner->name }}" />

                <a href="{{ $project->path() . '/edit' }}" class="button bluebtn ml-4">
                    Edit Project
                </a>
            </div>

        </div>

    </header>

    <main>
        <div class="lg:flex items-center -mx-3">
            <div class="lg:w-3/4 px-3 mb-6">
                <div class="mb-8">
                    <h2 class="text-gray-200 text-lg font-normal">Tasks</h2>
                    {{-- Tasks --}}
                    @foreach ($project->tasks as $task)
                        <form method="POST" action="{{ $task->path() }}">
                            @method('PATCH')
                            @csrf
                            <div class="card mb-3">
                                <div class="flex">
                                    <input class="w-full {{ $task->completed  === true ? 'text-gray-200' : '' }}"
                                    type="text" name="body" value="{{ $task->body }}" />
                                    <input name="completed" type="checkbox" {{ $task->completed  === true ? 'checked' : '' }} onchange="this.form.submit()" />
                                </div>

                            </div>
                        </form>
                    @endforeach
                    <div class="card mb-3">
                        <form method="POST" action="{{ $project->path() . '/tasks' }}">
                            @csrf
                            <input class="w-full" type="text" name="body" placeholder="Add a new task..." />
                        </form>
                    </div>
                </div>

                <div class="mb-8">
                    <h2 class="text-gray-200 text-lg font-normal">General Notes</h2>
                    {{-- General Notes --}}
                    <form method="POST" action="{{ $project->path() }}">
                        @method('PATCH')
                        @csrf

                        <textarea class="card w-full mb-4" name="notes" style="min-height: 200px;" placeholder="Enter any notes here...">{{ $project->notes }}</textarea>

                        <button type="submit" class="button">Save</button>

                        @if($errors->any())
                            <div class="field mt-8 px-3">
                                @foreach($errors->all() as $error)
                                    <li class="text-red-400 text-sm font-normal">{{ $error }}</li>
                                @endforeach
                            </div>
                        @endif

                    </form>

                </div>

            </div>

            <div class="lg:w-1/4 px-3">

                @include('projects.card')
                @include('projects.activity.card')
            </div>

        </div>

    </main>

@endsection
