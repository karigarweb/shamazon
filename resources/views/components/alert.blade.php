@if(Session::has('message'))
    <div class="bg-green-600 relative text-white py-3 px-3 rounded-lg">
        {{ Session::get('message') }}
    </div>
@endif
