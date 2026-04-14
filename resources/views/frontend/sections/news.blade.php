{{-- ================= NEWS SECTION ================= --}}
@php
$latestNews = App\Models\News::where('is_active', true)
    ->whereNotNull('published_at')
    ->orderByDesc('published_at')
    ->take(3)
    ->get();

$count = App\Models\News::where('is_active', true)->count();
@endphp

@if($count > 0)
<section
    class="py-20 relative"
    style="background: var(--bg-color);"
>
    <div class="container mx-auto px-4">

        {{-- TITLE --}}
        <div class="text-center mb-16">
            <h2
                class="text-3xl md:text-4xl font-extrabold mb-3"
                style="
                    background: linear-gradient(
                        135deg,
                        var(--primary-color),
                        var(--secondary-color)
                    );
                    -webkit-background-clip: text;
                    color: transparent;
                "
            >
                {{ app()->getLocale() === 'ar' ? 'آخر الأخبار' : 'Latest News' }}
            </h2>

            <p
                class="text-sm md:text-base"
                style="color: color-mix(in srgb, var(--text-color) 70%, transparent);"
            >
                {{ app()->getLocale() === 'ar'
                    ? 'تابع أحدث المستجدات وأخبار الشركة'
                    : 'Follow the latest updates and company news.' }}
            </p>
        </div>

        {{-- NEWS GRID --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            @foreach ($latestNews as $news)
                <div
                    class="rounded-2xl overflow-hidden transition-all duration-300 hover:-translate-y-2"
                    style="
                        background: #ffffff;
                        border: 1px solid color-mix(in srgb, var(--primary-color) 15%, transparent);
                    "
                >

                    {{-- IMAGE --}}
                    <div class="h-48 overflow-hidden">
                        <img
                            src="{{ asset('storage/' . $news->image) }}"
                            class="w-full h-full object-cover transition duration-500 hover:scale-105"
                        >
                    </div>

                    {{-- CONTENT --}}
                    <div class="p-6">

                        <span
                            class="text-xs"
                            style="color: color-mix(in srgb, var(--text-color) 50%, transparent);"
                        >
                            {{ $news->published_at->format('Y-m-d') }}
                        </span>

                        <h3
                            class="font-bold text-lg mt-2 mb-3"
                            style="color: var(--text-color);"
                        >
                            {{ $news->title }}
                        </h3>

                        <p
                            class="text-sm mb-4"
                            style="color: color-mix(in srgb, var(--text-color) 75%, transparent);"
                        >
                            {{ Str::limit($news->excerpt, 120) }}
                        </p>

                        <a
                            href="{{ route('news.show', $news) }}"
                            class="font-semibold transition"
                            style="color: var(--primary-color);"
                            onmouseover="this.style.color='var(--secondary-color)'"
                            onmouseout="this.style.color='var(--primary-color)'"
                        >
                            {{ app()->getLocale() === 'ar' ? 'اقرأ المزيد' : 'Read More' }}
                            →
                        </a>

                    </div>
                </div>
            @endforeach

        </div>

        {{-- VIEW ALL --}}
        @if (get_general_value('news_enabled') && $count > count($latestNews))
            <div class="text-center mt-16">
                <a
                    href="{{ route('news.index') }}"
                    class="inline-flex items-center gap-3 px-10 py-3 rounded-full font-bold text-white transition-all duration-300 hover:scale-105"
                    style="
                        background: linear-gradient(
                            135deg,
                            var(--primary-color),
                            var(--secondary-color)
                        );
                    "
                >
                    {{ app()->getLocale() === 'ar' ? 'عرض جميع الأخبار' : 'View All News' }}
                    <i class="fas fa-arrow-left"></i>
                </a>
            </div>
        @endif

    </div>
</section>
@endif