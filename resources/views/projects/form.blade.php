@csrf
<h1 class="text-center font-normal text-2xl mb-10">{{ isset($project->id) ? 'Edit Your Project' : 'Create a Project' }}</h1>
<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="title">Title <span class="text-red-400">*</span></label>
    <div class="control">
        <input class="input bg-transparent border border-gray-100 rounded p-2 text-xs w-full" value="{{ isset($project->id) ? $project->title : '' }}" type="text" name="title" required>
    </div>
</div>

<div class="field mb-6">
    <label class="label text-sm mb-2 block" for="title">Description <span class="text-red-400">*</span></label>
    <div class="control">
        <textarea class="bg-transparent border border-gray-100 rounded p-2 text-xs w-full" name="description" rows="3" style="height: 200px;" required>{{ isset($project->id) ? $project->description : '' }}</textarea>
    </div>
</div>

<div>
    <button type="submit" class="button mr-6">{{ $buttonText }}</button>
    <a href="{{ isset($project->id) ? $project->path() : '/projects' }}">Cancel</a>
</div>
@if($errors->any())
    <div class="field mt-8">
        @foreach($errors->all() as $error)
            <li class="text-red-400 text-sm font-normal">{{ $error }}</li>
        @endforeach
    </div>
@endif
