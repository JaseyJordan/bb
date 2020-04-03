@extends('layouts.app')

@section('content')
    {{-- if New field  --}}
    <form method="POST" action="/projects" class="lg:w-1/2 lg:mx-auto bg-card p-6 md:py-12 md:px-16 rounded shadow">
        @include('projects.form', [
    'project' => new App\Project,
    'buttonText' => 'New Project'
    ])
    </form>
@endsection
