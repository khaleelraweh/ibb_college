<div>

    <!-- Main content Start -->
    <div class="main-content">

        <!-- Breadcrumbs Start -->
        <div class="rs-breadcrumbs breadcrumbs-overlay">
            <div class="breadcrumbs-img">
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

                            @case(Route::is('frontend.blog_index'))
                                Blog Index
                            @break

                            @case(Route::is('frontend.contact'))
                                Contact Us
                            @break

                            @default
                                Default Title
                        @endswitch


                    </li>
                </ul>
            </div>
        </div>
        <!-- Breadcrumbs End -->

        <!-- Popular Course Section Start -->
        <div
            class="rs-popular-courses style1 course-view-style orange-color rs-inner-blog white-bg pt-70 pb-70 md-pt-50 md-pb-50">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 pr-50 md-pr-15">
                        <div class="course-search-part">
                            <div class="course-view-part">
                                <div class="view-icons">
                                    <a href="#" class="view-grid mr-10"><i class="fa fa-th-large"></i></a>
                                    <a href="#" class="view-list"><i class="fa fa-list-ul"></i></a>
                                </div>
                                {{-- <div class="view-text">Showing 1-9 of 11 results</div> --}}

                                <div class="view-text">
                                    <div class="search-wrap">
                                        <input type="search" wire:model="searchQuery"
                                            placeholder="{{ __('transf.search') }}..." name="s"
                                            class="search-input form-control" value="">
                                    </div>
                                </div>


                            </div>
                            <div class="type-form">

                                <form method="post"
                                    action="https://keenitsolutions.com/products/html/educavo/mailer.php">
                                    <!-- Form Group -->
                                    <div class="form-group mb-0">
                                        <div class="custom-select-box">
                                            <select id="timing" wire:model="sortingBy">
                                                <option value="default">Default</option>
                                                <option value="new">Newest</option>
                                                <option value="old">Oldest</option>
                                            </select>
                                        </div>


                                    </div>
                                </form>
                            </div>
                        </div>





                        <div class="course-part clearfix">

                            @foreach ($posts as $post)
                                <div class="courses-item {{ $loop->index % 2 === 1 ? 'right' : '' }}">
                                    <div class="img-part">
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
                                    <div class="content-part">
                                        <h3 class="title">
                                            <x-post-link :route="$linkRoute" :slug="$post->slug">
                                                {{ $post->title }}
                                            </x-post-link>
                                        </h3>
                                        <p class="text">
                                            {!! \Illuminate\Support\Str::words($post->content, 30, '...') !!}
                                        </p>
                                        <div class="bottom-part">
                                            <div class="info-meta">
                                                <div class="date">
                                                    <i class="fa fa-calendar-check-o"></i>
                                                    {{ formatPostDate($post->created_at) }}
                                                </div>
                                            </div>
                                            <div class="btn-part">
                                                {{-- <a href="#">Join Event</a> --}}
                                                <x-post-link :route="$linkRoute" :slug="$post->slug" class="">
                                                    {{ __('panel.continue_reading') }} ...
                                                </x-post-link>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach


                        </div>


                        {{-- PAGINATION --}}
                        {{-- <nav class="mb-11" aria-label="Page navigationa">
                            <ul class="pagination justify-content-center">
                                {!! $posts->appends(request()->all())->onEachSide(3)->links() !!}
                            </ul>
                        </nav> --}}

                        {{-- <div class="pagination-area orange-color text-center mt-30 md-mt-0">
                            <ul class="pagination-part">
                                <li class="active"><a href="#">1</a></li>
                                <li><a href="#">2</a></li>
                                <li><a href="#">Next <i class="fa fa-long-arrow-right"></i></a></li>
                            </ul>
                        </div> --}}

                        <div class="pagination-area orange-color text-center mt-30 md-mt-0">
                            {!! $posts->appends(request()->all())->onEachSide(3)->links('vendor.pagination.bootstrap-4') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Popular Course Section End -->
    </div>
    <!-- Main content End -->
</div>
