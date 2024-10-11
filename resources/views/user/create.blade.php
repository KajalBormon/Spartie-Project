<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                User / Edit
            </h2>
            <a href="{{ route('user.index') }}" class="bg-emerald-400 rounded-lg text-black px-4 py-2 hover:bg-emerald-300">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('user.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="Role" class="font-medium text-lg">User Name</label>
                            <div class="my-3">
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter Role Name" id="" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('name')
                                    <span class="text-red-300 font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="Role" class="font-medium text-lg">User Email</label>
                            <div class="my-3">
                                <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter User Email" id="" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('email')
                                    <span class="text-red-300 font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="Role" class="font-medium text-lg">User Password</label>
                            <div class="my-3">
                                <input type="password" name="password" value="{{ old('password') }}" placeholder="Enter User Password" id="" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('password')
                                    <span class="text-red-300 font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="Role" class="font-medium text-lg">Confirm Password</label>
                            <div class="my-3">
                                <input type="password" name="confirm_password" value="{{ old('confirm_password') }}" placeholder="Enter User Password" id="" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('confirm_password')
                                    <span class="text-red-300 font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                           <div class="grid grid-cols-4 mb-6">
                                @if($roles->isNotEmpty())
                                    @foreach ($roles as $role)
                                        <div class="mt-3">
                                            <input type="checkbox" name="roles[]" id="role-{{ $role->id }}"  value="{{ $role->name }}" class="rounded">
                                            <label for="role-{{ $role->id }}"> {{ $role->name }}</label>
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
