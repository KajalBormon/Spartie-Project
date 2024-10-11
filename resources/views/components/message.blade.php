@if(Session::has('success'))
<div class="bg-green-300 border-green-600 rounded-lg p-3 shadow-sm text-black font-medium mb-2">
    {{ Session::get('success') }}
</div>
@endif

@if(Session::has('error'))
    <div class="bg-red-300 border-red-600 rounded-lg p-4 shadow-sm text-black font-medium mb-2">
        {{ Session::get('success') }}
    </div>
@endif
