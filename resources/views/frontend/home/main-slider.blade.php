<div class="rs-slider main-home">
    <div class="rs-carousel owl-carousel" data-loop="true" data-items="1" data-margin="0" data-autoplay="true"
        data-hoverpause="true" data-autoplay-timeout="5000" data-smart-speed="800" data-dots="false" data-nav="false"
        data-nav-speed="false" data-center-mode="false" data-mobile-device="1" data-mobile-device-nav="false"
        data-mobile-device-dots="false" data-ipad-device="1" data-ipad-device-nav="false" data-ipad-device-dots="false"
        data-ipad-device2="1" data-ipad-device-nav2="false" data-ipad-device-dots2="false" data-md-device="1"
        data-md-device-nav="true" data-md-device-dots="false">

        @forelse ($main_sliders->where('section' ,1) as $main_slider)
            @php
                if ($main_slider->firstMedia != null && $main_slider->firstMedia->file_name != null) {
                    $main_slider_img = asset('assets/main_sliders/' . $main_slider->firstMedia->file_name);

                    if (!file_exists(public_path('assets/main_sliders/' . $main_slider->firstMedia->file_name))) {
                        $main_slider_img = asset('image/not_found/placeholder.jpg');
                        // $main_slider_img = asset('frontend/images/slider/main-home/1.jpg');
                    }
                } else {
                    $main_slider_img = asset('image/not_found/placeholder.jpg');
                    // $main_slider_img = asset('frontend/images/slider/main-home/1.jpg');
                }
            @endphp
            <div class="slider-content slide1" style="background-image: url({{ $main_slider_img }})">
                {{-- <div class="container" style="height: 150vh;"> --}}
                <div class="container">
                    @if ($main_slider->show_info)
                        <div class="content-part">
                            <div class="sl-sub-title wow bounceInLeft" data-wow-delay="300ms"
                                data-wow-duration="2000ms">
                                {{ $main_slider->subtitle }}
                            </div>
                            <h1 class="sl-title wow fadeInRight" data-wow-delay="600ms" data-wow-duration="2000ms">
                                {{ $main_slider->title }}
                            </h1>
                            @if ($main_slider->show_btn_title)
                                <div class="sl-btn wow fadeInUp" data-wow-delay="900ms" data-wow-duration="2000ms">
                                    <a class="readon orange-btn main-home"
                                        href="{{ url($main_slider->btn_title) }}">{{ $main_slider->btn_title }}
                                    </a>
                                </div>
                            @endif

                        </div>
                    @endif
                </div>

            </div>
        @empty
        @endforelse
    </div>

    <!-- Features Section start -->
    <div id="rs-features" class="rs-features main-home">
        <div class="container">
            <div class="row">

                @foreach ($main_sliders->where('section', 2)->take(3) as $adv_slider)
                    <div class="col-lg-4 col-md-12 md-mb-30 ">
                        <div class="features-wrap ">

                            <div class="icon-part">

                                @php
                                    if ($adv_slider->firstMedia != null && $adv_slider->firstMedia->file_name != null) {
                                        $advertisor_slider_img = asset(
                                            'assets/advertisor_sliders/' . $adv_slider->firstMedia->file_name,
                                        );

                                        if (
                                            !file_exists(
                                                public_path(
                                                    'assets/advertisor_sliders/' . $adv_slider->firstMedia->file_name,
                                                ),
                                            )
                                        ) {
                                            // $advertisor_slider_img = asset('image/not_found/placeholder.jpg');
                                            $advertisor_slider_img = asset('frontend/images/features/icon/3.png');
                                        }
                                    } else {
                                        // $advertisor_slider_img = asset('image/not_found/placeholder.jpg');
                                        $advertisor_slider_img = asset('frontend/images/features/icon/3.png');
                                    }
                                @endphp

                                {{-- <i class="{{ $adv_slider->icon }}"></i> --}}
                                <img src="{{ $advertisor_slider_img }}" alt="">
                            </div>
                            <div class="content-part">
                                <h4 class="title">
                                    <span class="watermark">{{ $adv_slider->title }}</span>
                                </h4>
                                <p class="dese">
                                    {{ $adv_slider->subtitle }}
                                </p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Features Section End -->
</div>
