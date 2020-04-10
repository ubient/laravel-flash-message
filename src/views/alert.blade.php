@if (session('flash_message') || session('status'))
    <div role="alert" class="{{ collect([
        'info' => 'bg-blue-400',
        'success' => 'bg-green-400',
        'warning' => 'bg-orange-500',
        'error' => 'bg-red-400',
    ])->get(session('flash_message.level', 'success')) }} rounded shadow-inner text-white-500 p-4">
        <p class="text-sm">{{ session('flash_message.message', session('status')) }}</p>
    </div>
    @php(session()->forget('flash_message'))
@endif
