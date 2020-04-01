    <div class="card flex flex-col mt-3">

        <h3 class="font-normal text-xl py-2 pl-4 mb-4 -ml-5 border-l-4 border-blue-500">Invite a user</h3>

        <form method="POST" action="{{ $project->path() . '/invitations' }}" class="text-center">
            @method('POST')
            @csrf
            <input type="email" placeholder="User Email" name="email" class="text-center w-full p-1 rounded border border-gray-200">
            <button class="button my-4" type="submit">Invite</button>
        </form>
        @include('projects.errors', ['bag' => 'invitations'])
    </div>
