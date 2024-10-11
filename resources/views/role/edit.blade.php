<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Roles / Edit
            </h2>
            <a href="{{ route('role.index') }}" class="bg-emerald-400 rounded-lg text-black px-4 py-2 hover:bg-emerald-300">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('role.update',$role->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="Role" class="font-medium text-lg">Role Name</label>
                            <div class="my-3">
                                <input type="text" name="name" value="{{ old('name',$role->name) }}" placeholder="Enter Role Name" id="" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('name')
                                    <span class="text-red-300 font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="grid grid-cols-4 mb-6">
                                @if($permissions->isNotEmpty())
                                    @foreach ($permissions as $permission)
                                        <div class="mt-3">
                                            <input {{ $hasPermission->contains($permission->name) ? "checked":" " }} type="checkbox" name="permission[]" id="permission-{{ $permission->id }}"  value="{{ $permission->name }}" class="rounded">
                                            <label for="permission-{{ $permission->id }}"> {{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                @endif
                            </div>

                            <button class="bg-emerald-400 rounded-lg text-black px-4 py-2 hover:bg-emerald-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
