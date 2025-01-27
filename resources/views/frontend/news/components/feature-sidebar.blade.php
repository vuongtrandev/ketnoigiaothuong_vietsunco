<div class="wsus__blog_sidebar" id="sticky_sidebar">
    <div class="wsus__blog_search">
        <h4>Tìm kiếm</h4>
        <form action="{{ route('news.search') }}" method="GET">
            <input type="text" placeholder="Tìm kiếm..." name="search_query">
            <button type="submit" class="common_btn"><i class="fas fa-search"></i></button>
        </form>
    </div>
    <div class="wsus__blog_post">
        <h4>Các bài khác</h4>
        @foreach ($moreNews as $item)
            <div class="wsus__blog_post_single">
                <a href="{{ route('news.detail', $item->slug) }}" class="wsus__blog_post_img">
                    <img style="height: 71px;" src="{{ asset($item->image) }}" alt="blog"
                        class="imgofluid w-100">
                </a>
                <div class="wsus__blog_post_text">
                    <a href="{{ route('news.detail', $item->slug) }}">{{ $item->title }}</a>
                    <p> <span>{{ date('d/m/Y', strtotime($item->created_at)) }}</span></p>
                </div>
            </div>
        @endforeach
    </div>
</div>
