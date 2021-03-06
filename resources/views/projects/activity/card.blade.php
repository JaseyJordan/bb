<div class="card mt-3 text-default">
    <ul class="text-xs list-reset">
        @foreach ($project->activity as $activity)
            <li {{ $loop->last ? '' : 'class="mb-1"' }}>
                @include("projects.activity.{$activity->description}")
                <span class="text-muted"> {{ $activity->created_at->diffForHumans(null, true) }} </span>
            </li>
        @endforeach
    </ul>
</div>
