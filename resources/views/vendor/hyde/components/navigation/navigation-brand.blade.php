<a href="{{ Routes::get('index') }}" class="font-bold px-4 flex items-center" aria-label="Home page">
    <img src="{{ Asset::mediaLink('logo.png') }}" alt="{{ config('hyde.name', 'notAkrista') }}"
        class="h-8 w-auto inline mr-2" />
    {{ config('hyde.name', 'notAkrista') }}
</a>
