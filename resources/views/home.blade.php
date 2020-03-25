@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="text-2xl text-center">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <p class="text-center mt-6">You are logged in! </p>

                    <div class="mt-6"><a href="/projects" class="button"> Projects </a></div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
