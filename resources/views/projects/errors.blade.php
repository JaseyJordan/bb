
@if($errors->{ $bag ?? 'default' }->all())
    <ul class="field mt-2 px-3 list-reset">
        @foreach($errors->{ $bag ?? 'default' }->all() as $error)
            <li class="text-red-400 text-sm font-normal">{{ $error }}</li>
        @endforeach
    </div>
@endif
