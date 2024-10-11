<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                Articles / Edit
            </h2>
            <a href="{{ route('article.index') }}" class="bg-emerald-400 rounded-lg text-black px-4 py-2 hover:bg-emerald-300">Back</a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('article.update',$article->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div>
                            <label for="article" class="font-medium text-lg">Article Name</label>
                            <div class="my-3">
                                <input type="text" name="author" value="{{ old('author',$article->author) }}" placeholder="Author" id="" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('author')
                                    <span class="text-red-300 font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="title" class="font-medium text-lg">Article Title</label>
                            <div class="my-3">
                                <input type="text" name="title" value="{{ old('title',$article->title) }}" placeholder="Title" id="" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">
                                @error('title')
                                    <span class="text-red-300 font-medium">{{ $message }}</span>
                                @enderror
                            </div>

                            <label for="article" class="font-medium text-lg">Article Content</label>
                            <div class="my-3">
                                <textarea name="description" id="" cols="30" rows="10" class="border-gray-300 shadow-sm w-1/2 rounded-lg text-black">{{ old('content',$article->content) }}
                                </textarea>
                            </div>
                            <button class="bg-emerald-400 rounded-lg text-black px-4 py-2 hover:bg-emerald-100">Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
