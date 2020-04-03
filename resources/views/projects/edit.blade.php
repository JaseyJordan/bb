@extends('layouts.app')

@section('content')
    <form method="POST" action="{{ $project->path() }}" class="lg:w-1/2 lg:mx-auto bg-card p-6 md:py-12 md:px-16 rounded shadow">
        @method('PATCH')
        @include('projects.form', ['buttonText' => 'Edit Project'])
    </form>
@endsection

