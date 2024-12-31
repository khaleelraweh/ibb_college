<div>
    <!-- Main content Start -->
    <div class="main-content">

        <!-- Breadcrumbs Start -->
        <div class="rs-breadcrumbs breadcrumbs-overlay">
            <div class="breadcrumbs-img">
                {{-- <img src="{{ $siteSettings['site_img']->value ? asset('assets/site_settings/' . $siteSettings['site_img']->value) : asset('frontend/images/breadcrumbs/2.jpg') }}"
                    alt="{{ $siteSettings['site_name']->value }}"> --}}
                @php
                    $imagePath = public_path('assets/site_settings/' . $siteSettings['site_img']->value);
                @endphp

                <img src="{{ $siteSettings['site_img']->value && file_exists($imagePath)
                    ? asset('assets/site_settings/' . $siteSettings['site_img']->value)
                    : asset('image/not_found/placeholder2.jpg') }}"
                    alt="{{ $siteSettings['site_name']->value }}">

            </div>
            <div class="breadcrumbs-text">
                <h1 class="page-title">
                    @switch(true)
                        @case($currentRoute === 'frontend.blog_list')
                            {{ __('panel.blog_list') }}
                        @break

                        @case($currentRoute === 'frontend.news_list')
                            {{ __('panel.news_list') }}
                        @break

                        @case($currentRoute === 'frontend.events_list')
                            {{ __('panel.events_list') }}
                        @break

                        @case(Route::is('frontend.blog_index'))
                            Blog Index
                        @break

                        @case(Route::is('frontend.contact'))
                            Contact Us
                        @break

                        @default
                            Default Title
                    @endswitch
                </h1>
                <ul>
                    <li>
                        <a class="active" href="{{ route('frontend.index') }}">{{ __('panel.main') }}</a>
                    </li>
                    <li>
                        @switch(true)
                            @case($currentRoute === 'frontend.blog_list')
                                {{ __('panel.blog_list') }}
                            @break

                            @case($currentRoute === 'frontend.news_list')
                                {{ __('panel.news_list') }}
                            @break

                            @case($currentRoute === 'frontend.events_list')
                                {{ __('panel.events_list') }}
                            @break

                            @default
                                Default Title
                        @endswitch
                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumbs End -->

        <!-- Blog Section Start -->
        <div class="rs-inner-blog orange-color pt-100 pb-100 md-pt-70 md-pb-70">
            <div class="container">
                <div class="row">
                    <!-- Sidebar Start -->
                    <div class="col-lg-4 col-md-12 order-last">
                        <div class="widget-area">
                            <!-- Search Widget -->
                            <div class="search-widget mb-50">
                                <div class="search-wrap">
                                    <input type="search" wire:model="searchQuery"
                                        placeholder="{{ __('transf.search') }}..." name="s" class="search-input">
                                </div>
                            </div>

                            <!-- Recent Posts Widget -->
                            <div class="recent-posts-widget mb-50">
                                @php
                                    $titleMap = [
                                        'frontend.blog_list' => __('panel.recent_posts'),
                                        'frontend.news_list' => __('panel.recent_news'),
                                        'frontend.events_list' => __('panel.recent_events'),
                                    ];
                                    $routeMap = [
                                        'frontend.blog_list' => 'frontend.blog_single',
                                        'frontend.news_list' => 'frontend.news_single',
                                        'frontend.events_list' => 'frontend.event_single',
                                    ];
                                    $assetMap = [
                                        'frontend.blog_list' => 'assets/posts/',
                                        'frontend.news_list' => 'assets/news/',
                                        'frontend.events_list' => 'assets/events/',
                                    ];

                                    $widgetTitle = $titleMap[$currentRoute] ?? __('panel.recent_posts');
                                    $routeName = $routeMap[$currentRoute] ?? 'frontend.blog_single';
                                    $assetPath = $assetMap[$currentRoute] ?? 'assets/posts/';
                                @endphp

                                <h3 class="widget-title recent_post_title">{{ $widgetTitle }}</h3>

                                @foreach ($recent_posts as $recent_post)
                                    @php
                                        $recentImage =
                                            $recent_post->photos->first()->file_name ??
                                            'image/not_found/placeholder.jpg';
                                        $recentImgUrl = asset($assetPath . $recentImage);

                                        // Check if the image exists, otherwise fallback to default
                                        if (!file_exists(public_path(parse_url($recentImgUrl, PHP_URL_PATH)))) {
                                            $recentImgUrl = asset('image/not_found/placeholder.jpg');
                                        }
                                    @endphp

                                    <div class="show-featured">
                                        <div class="post-img">
                                            <a href="{{ route($routeName, $recent_post->slug) }}">
                                                <img src="{{ $recentImgUrl }}" alt="">
                                            </a>
                                        </div>
                                        <div class="post-desc">
                                            <a href="{{ route($routeName, $recent_post->slug) }}">
                                                {{ \Illuminate\Support\Str::words($recent_post->title, 10, '...') }}
                                            </a>
                                            <span class="date">
                                                <i class="fa fa-calendar"></i>
                                                {{ formatPostDateDash($recent_post->created_at) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Tags Widget -->
                            <div class="recent-posts mb-50">
                                <h3 class="widget-title tags_title">{{ __('panel.tags') }}</h3>
                                <ul>
                                    @foreach ($tags as $tag)
                                        @php
                                            $tagRouteMap = [
                                                'frontend.blog_list' => 'frontend.blog_tag_list',
                                                'frontend.news_list' => 'frontend.news_tag_list',
                                                'frontend.events_list' => 'frontend.events_tag_list',
                                            ];
                                            $tagRoute = $tagRouteMap[$currentRoute] ?? 'frontend.blog_tag_list';
                                        @endphp
                                        <li>
                                            <a href="{{ route($tagRoute, $tag->slug) }}">{{ $tag->name }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Sidebar End -->

                    <!-- Main Content Start -->
                    <div class="col-lg-8 pr-50 md-pr-15">
                        <div class="row">
                            @foreach ($posts as $post)
                                <div class="col-lg-6 mb-70">
                                    <div class="blog-item">
                                        <div class="blog-img">
                                            @php
                                                $linkRoute = match ($currentRoute) {
                                                    'frontend.blog_list' => 'frontend.blog_single',
                                                    'frontend.news_list' => 'frontend.news_single',
                                                    'frontend.events_list' => 'frontend.event_single',
                                                    default => 'frontend.blog_single',
                                                };
                                            @endphp

                                            <x-post-link :route="$linkRoute" :slug="$post->slug">
                                                @php
                                                    $post_img = getPostImage(
                                                        $post,
                                                        $currentRoute,
                                                        asset('image/not_found/placeholder.jpg'),
                                                    );
                                                @endphp
                                                <img src="{{ $post_img }}" alt="">
                                            </x-post-link>
                                        </div>

                                        <div class="blog-content">

                                            <h3 class="blog-title">
                                                <x-post-link :route="$linkRoute" :slug="$post->slug">
                                                    {{ $post->title }}
                                                </x-post-link>
                                            </h3>
                                            <div class="blog-meta">
                                                <ul class="btm-cate">
                                                    <li>
                                                        <div class="blog-date">
                                                            <i class="fa fa-calendar-check-o"></i>
                                                            {{ formatPostDate($post->created_at) }}
                                                        </div>
                                                    </li>
                                                </ul>
                                            </div>

                                            <div class="blog-desc">
                                                {!! \Illuminate\Support\Str::words($post->content, 30, '...') !!}
                                            </div>
                                            <div class="blog-button">
                                                <!-- Button -->
                                                <x-post-link :route="$linkRoute" :slug="$post->slug" class="blog-btn">
                                                    {{ __('panel.continue_reading') }}
                                                </x-post-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                    <!-- Main Content End -->
                </div>
            </div>
        </div>
        <!-- Blog Section End -->

        <!-- Popular Course Section Start -->
        <div
            class="rs-popular-courses style1 course-view-style orange-color rs-inner-blog white-bg pt-100 pb-100 md-pt-70 md-pb-70">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 pr-50 md-pr-15">
                        <div class="course-search-part">
                            <div class="course-view-part">
                                <div class="view-icons">
                                    <a href="#" class="view-grid mr-10"><i class="fa fa-th-large"></i></a>
                                    <a href="#" class="view-list"><i class="fa fa-list-ul"></i></a>
                                </div>
                                <div class="view-text">Showing 1-9 of 11 results</div>
                            </div>
                            <div class="type-form">
                                <form method="post"
                                    action="https://keenitsolutions.com/products/html/educavo/mailer.php">
                                    <!-- Form Group -->
                                    <div class="form-group mb-0">
                                        <div class="custom-select-box">
                                            <select id="timing">
                                                <option>Default</option>
                                                <option>Newest</option>
                                                <option>Old</option>
                                            </select>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>




                        <div class="course-part clearfix">


                            <div class="row">
                                <div class="col-lg-4 mb-60 col-md-6 ">
                                    <div class="event-item">
                                        <div class="event-short">
                                            <div class="featured-img">
                                                <img src="{{ asset('frontend/images/event/1.jpg') }}" alt="Image">
                                            </div>
                                            <div class="categorie">
                                                <a href="#">Recipes</a>
                                            </div>
                                            <div class="content-part">
                                                <div class="address"><i class="fa fa-map-o"></i> New Margania</div>
                                                <h4 class="title"><a href="#">Spicy Quince And Cranberry
                                                        Chutney</a></h4>
                                                <p class="text">
                                                    Bootcamp Events Description Lorem ipsum dolor sit amet, consectetuer
                                                    adipiscing elit, sed diam nonummy nibh euismod...
                                                </p>
                                                <div class="event-btm">
                                                    <div class="date-part">
                                                        <div class="date">
                                                            <i class="fa fa-calendar-check-o"></i>
                                                            July 24, 2020
                                                        </div>
                                                    </div>
                                                    <div class="btn-part">
                                                        <a href="#">Join Event</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-60 col-md-6 right">
                                    <div class="event-item">
                                        <div class="event-short">
                                            <div class="featured-img">
                                                <img src="{{ asset('frontend/images/event/2.jpg') }}" alt="Image">
                                            </div>
                                            <div class="categorie">
                                                <a href="#">Recipes</a>
                                            </div>
                                            <div class="content-part">
                                                <div class="address"><i class="fa fa-map-o"></i> New Margania</div>
                                                <h4 class="title"><a href="#">Persim, Pomegran, And Massag Kale
                                                        Salad</a></h4>
                                                <p class="text">
                                                    Bootcamp Events Description Lorem ipsum dolor sit amet, consectetuer
                                                    adipiscing elit, sed diam nonummy nibh euismod...
                                                </p>
                                                <div class="event-btm">
                                                    <div class="date-part">
                                                        <div class="date">
                                                            <i class="fa fa-calendar-check-o"></i>
                                                            July 24, 2020
                                                        </div>
                                                    </div>
                                                    <div class="btn-part">
                                                        <a href="#">Join Event</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-60 col-md-6">
                                    <div class="event-item">
                                        <div class="event-short">
                                            <div class="featured-img">
                                                <img src="{{ asset('frontend/images/event/3.jpg') }}" alt="Image">
                                            </div>
                                            <div class="categorie">
                                                <a href="#">Recipes</a>
                                            </div>
                                            <div class="content-part">
                                                <div class="address"><i class="fa fa-map-o"></i> New Margania</div>
                                                <h4 class="title"><a href="#">Essential Fall Fruits That Aren’t
                                                        Apples</a></h4>
                                                <p class="text">
                                                    Bootcamp Events Description Lorem ipsum dolor sit amet, consectetuer
                                                    adipiscing elit, sed diam nonummy nibh euismod...
                                                </p>
                                                <div class="event-btm">
                                                    <div class="date-part">
                                                        <div class="date">
                                                            <i class="fa fa-calendar-check-o"></i>
                                                            July 24, 2020
                                                        </div>
                                                    </div>
                                                    <div class="btn-part">
                                                        <a href="#">Join Event</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 mb-60 col-md-6 right">
                                    <div class="event-item">
                                        <div class="event-short">
                                            <div class="featured-img">
                                                <img src="{{ asset('frontend/images/event/4.jpg') }}" alt="Image">
                                            </div>
                                            <div class="categorie">
                                                <a href="#">Recipes</a>
                                            </div>
                                            <div class="content-part">
                                                <div class="address"><i class="fa fa-map-o"></i> New Margania</div>
                                                <h4 class="title"><a href="#">Seekers From Overcoming
                                                        Failure</a></h4>
                                                <p class="text">
                                                    Bootcamp Events Description Lorem ipsum dolor sit amet, consectetuer
                                                    adipiscing elit, sed diam nonummy nibh euismod...
                                                </p>
                                                <div class="event-btm">
                                                    <div class="date-part">
                                                        <div class="date">
                                                            <i class="fa fa-calendar-check-o"></i>
                                                            July 24, 2020
                                                        </div>
                                                    </div>
                                                    <div class="btn-part">
                                                        <a href="#">Join Event</a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>



                            <div class="courses-item">
                                <div class="event-short">
                                    <div class="featured-img">
                                        <img src="{{ asset('frontend/images/event/2.jpg') }}" alt="Image">
                                    </div>
                                    <div class="categorie">
                                        <a href="#">Recipes</a>
                                    </div>
                                    <div class="content-part">
                                        <div class="address"><i class="fa fa-map-o"></i> New Margania</div>
                                        <h4 class="title"><a href="#">Persim, Pomegran, And Massag Kale
                                                Salad</a>
                                        </h4>
                                        <p class="text">
                                            Bootcamp Events Description Lorem ipsum dolor sit amet, consectetuer
                                            adipiscing elit, sed diam nonummy nibh euismod...
                                        </p>
                                        <div class="event-btm">
                                            <div class="date-part">
                                                <div class="date">
                                                    <i class="fa fa-calendar-check-o"></i>
                                                    July 24, 2020
                                                </div>
                                            </div>
                                            <div class="btn-part">
                                                <a href="#">Join Event</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="courses-item right">
                                <div class="event-short">
                                    <div class="featured-img">
                                        <img src="{{ asset('frontend/images/event/2.jpg') }}" alt="Image">
                                    </div>
                                    <div class="categorie">
                                        <a href="#">Recipes</a>
                                    </div>
                                    <div class="content-part">
                                        <div class="address"><i class="fa fa-map-o"></i> New Margania</div>
                                        <h4 class="title"><a href="#">Persim, Pomegran, And Massag Kale
                                                Salad</a>
                                        </h4>
                                        <p class="text">
                                            Bootcamp Events Description Lorem ipsum dolor sit amet, consectetuer
                                            adipiscing elit, sed diam nonummy nibh euismod...
                                        </p>
                                        <div class="event-btm">
                                            <div class="date-part">
                                                <div class="date">
                                                    <i class="fa fa-calendar-check-o"></i>
                                                    July 24, 2020
                                                </div>
                                            </div>
                                            <div class="btn-part">
                                                <a href="#">Join Event</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="courses-item">
                                <div class="img-part">
                                    <img src="{{ asset('frontend/images/courses/1.jpg') }}" alt="">
                                </div>
                                <div class="content-part">
                                    <ul class="meta-part">
                                        <li><span class="price">$55.00</span></li>
                                        <li><a class="categorie" href="#">Web Development</a></li>
                                    </ul>
                                    <h3 class="title"><a href="course-single.html">Become a PHP Master and Make Money
                                            Fast</a></h3>
                                    <div class="bottom-part">
                                        <div class="info-meta">
                                            <ul>
                                                <li class="user"><i class="fa fa-user"></i> 245</li>
                                                <li class="ratings">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    (05)
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-part">
                                            <a href="#"><i class="flaticon-right-arrow"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="courses-item right">
                                <div class="img-part">
                                    <img src="{{ asset('frontend/images/courses/2.jpg') }}" alt="">
                                </div>
                                <div class="content-part">
                                    <ul class="meta-part">
                                        <li><span class="price">$55.00</span></li>
                                        <li><a class="categorie" href="#">Web Development</a></li>
                                    </ul>
                                    <h3 class="title"><a href="course-single.html">Learning jQuery Mobile for
                                            Beginners</a></h3>
                                    <div class="bottom-part">
                                        <div class="info-meta">
                                            <ul>
                                                <li class="user"><i class="fa fa-user"></i> 245</li>
                                                <li class="ratings">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    (05)
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-part">
                                            <a href="#"><i class="flaticon-right-arrow"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="courses-item">
                                <div class="img-part">
                                    <img src="{{ asset('frontend/images/courses/3.jpg') }}" alt="">
                                </div>
                                <div class="content-part">
                                    <ul class="meta-part">
                                        <li><span class="price">$55.00</span></li>
                                        <li><a class="categorie" href="#">Photography</a></li>
                                    </ul>
                                    <h3 class="title"><a href="course-single.html">The Art of Black and White
                                            Photography</a></h3>
                                    <div class="bottom-part">
                                        <div class="info-meta">
                                            <ul>
                                                <li class="user"><i class="fa fa-user"></i> 245</li>
                                                <li class="ratings">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    (05)
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-part">
                                            <a href="#"><i class="flaticon-right-arrow"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="courses-item right">
                                <div class="img-part">
                                    <img src="{{ asset('frontend/images/courses/4.jpg') }}" alt="">
                                </div>
                                <div class="content-part">
                                    <ul class="meta-part">
                                        <li><span class="price">$55.00</span></li>
                                        <li><a class="categorie" href="#">Web Development</a></li>
                                    </ul>
                                    <h3 class="title"><a href="course-single.html">Learn Python – Interactive Python
                                            Tutorial</a></h3>
                                    <div class="bottom-part">
                                        <div class="info-meta">
                                            <ul>
                                                <li class="user"><i class="fa fa-user"></i> 245</li>
                                                <li class="ratings">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    (05)
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-part">
                                            <a href="#"><i class="flaticon-right-arrow"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="courses-item">
                                <div class="img-part">
                                    <img src="{{ asset('frontend/images/courses/5.jpg') }}" alt="">
                                </div>
                                <div class="content-part">
                                    <ul class="meta-part">
                                        <li><span class="price">$55.00</span></li>
                                        <li><a class="categorie" href="#">Photography</a></li>
                                    </ul>
                                    <h3 class="title"><a href="course-single.html">Your Complete Guide to Dark
                                            Photography</a></h3>
                                    <div class="bottom-part">
                                        <div class="info-meta">
                                            <ul>
                                                <li class="user"><i class="fa fa-user"></i> 245</li>
                                                <li class="ratings">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    (05)
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-part">
                                            <a href="#"><i class="flaticon-right-arrow"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="courses-item right">
                                <div class="img-part">
                                    <img src="{{ asset('frontend/images/courses/6.jpg') }}" alt="">
                                </div>
                                <div class="content-part">
                                    <ul class="meta-part">
                                        <li><span class="price">$55.00</span></li>
                                        <li><a class="categorie" href="#">Web Development</a></li>
                                    </ul>
                                    <h3 class="title"><a href="course-single.html">From Zero to Hero with Advance
                                            Nodejs</a></h3>
                                    <div class="bottom-part">
                                        <div class="info-meta">
                                            <ul>
                                                <li class="user"><i class="fa fa-user"></i> 245</li>
                                                <li class="ratings">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    (05)
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-part">
                                            <a href="#"><i class="flaticon-right-arrow"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="courses-item">
                                <div class="img-part">
                                    <img src="{{ asset('frontend/images/courses/3.jpg') }}" alt="">
                                </div>
                                <div class="content-part">
                                    <ul class="meta-part">
                                        <li><span class="price">$55.00</span></li>
                                        <li><a class="categorie" href="#">Web Development</a></li>
                                    </ul>
                                    <h3 class="title"><a href="course-single.html">Become a PHP Master and Make Money
                                            Fast</a></h3>
                                    <div class="bottom-part">
                                        <div class="info-meta">
                                            <ul>
                                                <li class="user"><i class="fa fa-user"></i> 245</li>
                                                <li class="ratings">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    (05)
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-part">
                                            <a href="#"><i class="flaticon-right-arrow"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="courses-item right">
                                <div class="img-part">
                                    <img src="{{ asset('frontend/images/courses/4.jpg') }}" alt="">
                                </div>
                                <div class="content-part">
                                    <ul class="meta-part">
                                        <li><span class="price">$55.00</span></li>
                                        <li><a class="categorie" href="#">Web Development</a></li>
                                    </ul>
                                    <h3 class="title"><a href="course-single.html">Introduction to Quantitativ and
                                            Qualitative</a></h3>
                                    <div class="bottom-part">
                                        <div class="info-meta">
                                            <ul>
                                                <li class="user"><i class="fa fa-user"></i> 245</li>
                                                <li class="ratings">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    (05)
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="btn-part">
                                            <a href="#"><i class="flaticon-right-arrow"></i></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>




                        <div class="pagination-area orange-color text-center mt-30 md-mt-0">
                            <ul class="pagination-part">
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">Next <i class="fa fa-long-arrow-right"></i></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Popular Course Section End -->
    </div>
    <!-- Main content End -->
</div>
