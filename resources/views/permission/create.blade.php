<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Permission / Create
            </h2>
            <a href="{{ route('permission.index') }}" class="bg-emerald-400 rounded-lg text-black px-4 py-2 hover:bg-emerald-300">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('permission.store') }}" method="post">
                        @csrf
                        <div>
                            <label for="permission" class="font-medium text-lg">Permission Name</label>
                            <div class="my-3">
                                <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter Permission Name" id="" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('name')
                                    <span class="text-red-300 font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <button class="bg-emerald-400 rounded-lg text-black px-4 py-2 hover:bg-emerald-100">Submit</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
