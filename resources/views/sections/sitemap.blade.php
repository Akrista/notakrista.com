@php
    $pages = array_merge(BladePage::files(), MarkdownPage::files());

    usort($pages, function ($a, $b) {
        return strcmp($a, $b);
    });

    $errorPages = ['401', '403', '404', '419', '429', '500', '503'];
    foreach ($errorPages as $errorPage) {
        if (($key = array_search($errorPage, $pages)) !== false) {
            unset($pages[$key]);
        }
    }

@endphp

<div class="flex flex-wrap">
    <section class="pr-20 lg:pr-32">
        <h2>Main Pages</h2>

        <ul>
            @foreach ($pages as $page)
                <li><a href="{{ $page }}">{{ Hyde::makeTitle($page) }}</a></li>
            @endforeach
        </ul>
    </section>
</div>
