<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Users') }}
            </h2>
            <a href="{{ route('user.create') }}" class="bg-emerald-400 rounded-lg text-black px-4 py-2 hover:bg-emerald-200">Create</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <x-message></x-message>
            <table class="text-white w-full">
                <thead class="bg-cyan-950">
                    <tr class="border-b text-emerald-400">
                        <th class="px-3 py-3 text-center">Name</th>
                        <th class="px-3 py-3 text-center">Role</th>
                        <th class="px-3 py-3 text-center">Email</th>
                        <th class="px-3 py-3 text-center">Created At</th>
                        <th class="px-3 py-3 text-center">Action</th>
                    </tr>
                </thead>
                <tbody class="bg-gray-700">
                    @foreach ($users as $user)
                    <tr class="border-b">
                        <td class="px-3 py-3 text-center">{{ $user->name }}</td>
                        <td class="px-3 py-3 text-center">
                            {{ $user->roles->pluck('name')->implode(', ') }}
                        </td>
                        <td class="px-3 py-3 text-center">{{ $user->email }}</td>
                        <td class="px-3 py-3 text-center">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</td>
                        <td class="px-3 py-1 text-center">
                            @can('edit user')
                            <a href="{{ route('user.edit',$user->id) }}" class="btn btn-primary bg-emerald-700 px-3 py-2 rounded-sm shadow-sm mr-2 hover:bg-emerald-600">Edit</a>
                            @endcan
                            @can('delete user')
                             <a href="javascript:void(0)" onclick="deleteUser({{ $user->id }})" class="btn btn-primary bg-red-700 px-3 py-2 rounded-sm shadow-sm mr-2 hover:bg-red-600">Delete</a>
                             @endcan
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="my-3">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <x-slot name="script">
        <script type="text/javascript">
            function deleteUser(id){
                if(confirm("Are You Sure Want to Delete?")){
                    $.ajax({
                        url: '{{ route("user.destroy") }}',
                        type: 'delete',
                        data: {id:id},
                        dataType: 'json',
                        headers: {
                            'x-csrf-token' : '{{ csrf_token() }}'
                        },
                        success: function(response){
                            window.location.href='{{ route("user.index") }}'
                        }
                    });
                }
            }
        </script>
    </x-slot>
</x-app-layout>
