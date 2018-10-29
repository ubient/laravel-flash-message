@if (session('flash_message') || session('status'))
    <div role="alert" class="{{ collect([
        'info' => 'bg-blue-light',
        'success' => 'bg-green-light',
        'warning' => 'bg-orange',
        'error' => 'bg-red-light',
    ])->get(session('flash_message.level', 'success')) }} rounded shadow-inner text-white p-4">
        <p class="text-sm">{{ session('flash_message.message', session('status')) }}</p>
    </div>
@endif
