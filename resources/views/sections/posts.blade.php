<section id="posts" class="w-screen py-16  lg:mt-8 relative">
    <header class="lg:mb-12 xl:mb-16 max-w-7xl mx-auto px-8">
        <h2
            class="text-3xl text-left opacity-75 dark:opacity-90 leading-10 tracking-tight font-extrabold sm:leading-none sm:mb-8 md:text-4xl md:text-center lg:text-5xl">
            Latest Posts
        </h2>
        <p class="sm:text-center text-lg mx-auto mt-4 mb-8">
            Here are the latest posts from my Blog.
        </p>
    </header>
    <div class="max-w-xl md:max-w-2xl mx-auto px-8">
        @foreach (MarkdownPost::getLatestPosts()->where(fn($post) => $post->matter('hiddenFromHomepage') !== true)->take(3) as $post)
            @include('hyde::components.article-excerpt')
        @endforeach
    </div>

    <footer class="lg:mb-12 xl:mb-16 max-w-7xl mx-auto px-8">
        <p class="sm:text-center text-lg mx-auto mt-8 mb-8 prose dark:prose-invert">
            See more on the <a href="posts">posts page</a>!
        </p>
    </footer>
    <svg class="absolute bottom-0 w-full text-gray-100  dark:text-slate-900 fill-current" viewBox="0 0 1400 74"
        xmlns="http://www.w3.org/2000/svg">
        <path
            d="M0 24C87.243 11.422 173.12 5.133 257.633 5.133 468.305 5.133 578.027 74 700 74c136.015 0 290.882-96.208 481.234-68.867C1268.807 17.71 1341.73 24 1400 24v50H0V24z" />
    </svg>
</section>
