@extends('layouts.admin')
@php
    use App\Models\SiteSetting;
@endphp


@section('style')
    <link rel="stylesheet" href="{{ asset('backend/vendors/tag_meta/tag_meta.css') }}">
    <style>
        .tags-container {
            display: block;
            height: 150px;
            font-size: 18px;
        }

        .tag {
            float: right;
            margin: 5px 5px;
        }
    </style>
@endsection

@section('content')
    {{-- main holder page  --}}
    <div class="card shadow mb-4">


        {{-- breadcrumb part  --}}
        <div class="card-header py-3 d-flex justify-content-between">
            <div class="card-naving">
                <h3 class="font-weight-bold text-primary">
                    <i class="fa fa-folder"></i>
                    {{ __('panel.manage_site_settings') }}
                </h3>
                <ul class="breadcrumb pt-3">
                    <li>
                        <a href="{{ route('admin.index') }}">{{ __('panel.main') }}</a>
                        @if (config('locales.languages')[app()->getLocale()]['rtl_support'] == 'rtl')
                            /
                        @else
                            \
                        @endif
                    </li>
                    <li class="ms-1">
                        {{ __('panel.show_site_meta_tag') }}
                    </li>
                </ul>
            </div>

            <div class="ml-auto d-none">
                @ability('admin', 'create_main_sliders')
                    <a href="{{ route('admin.main_sliders.create') }}" class="btn btn-primary">
                        <span class="icon text-white-50">
                            <i class="fa fa-plus-square"></i>
                        </span>
                        <span class="text">{{ __('panel.add_new_site_meta_tag') }}</span>
                    </a>
                @endability
            </div>

        </div>

        {{-- body part  --}}
        <div class="card-body">

            <form action="{{ route('admin.settings.site_meta.update', 4) }}" method="post">
                @csrf

                <ul class="nav nav-tabs" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link active" id="content-tab" data-toggle="tab" href="#content" role="tab"
                            aria-controls="content" aria-selected="true">{{ __('panel.content_tab') }}</a>
                    </li>
                </ul>

                <div class="tab-content" id="myTabContent">

                    <div class="tab-pane fade active show" id="content" role="tabpanel" aria-labelledby="content-tab">

                        <div class="row">
                            @php
                                $site = SiteSetting::where('key', 'site_name_meta')->get()->first();
                            @endphp
                            <div class="col-sm-12 col-md-2 pt-3">

                                <label for="{{ $site->key }}">
                                    {{ __('panel.site_name_meta') }}
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <input type="text" id="{{ $site->key }}" name="{{ $site->key }}"
                                    value="{{ old($site->key, $site->value) }}" class="form-control"
                                    placeholder="{{ $site->key }}">
                                @error('{{ $site->key }}')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            @php
                                $site = SiteSetting::where('key', 'site_description_meta')->get()->first();
                            @endphp
                            <div class="col-sm-12 col-md-2 pt-3">
                                <label for="{{ $site->key }}">
                                    {{ __('panel.site_description_meta') }}
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <input type="text" id="{{ $site->key }}" name="{{ $site->key }}"
                                    value="{{ old($site->key, $site->value) }}" class="form-control"
                                    placeholder="{{ $site->key }}">
                                @error('{{ $site->key }}')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            @php
                                $site = SiteSetting::where('key', 'site_link_meta')->get()->first();
                            @endphp
                            <div class="col-sm-12 col-md-2 pt-3">

                                <label for="{{ $site->key }}">
                                    {{ __('panel.site_link_meta') }}
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <input type="text" id="{{ $site->key }}" name="{{ $site->key }}"
                                    value="{{ old($site->key, $site->value) }}" class="form-control"
                                    placeholder="{{ $site->key }}">
                                @error('{{ $site->key }}')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>


                        <div class="row">
                            @php
                                $site = SiteSetting::where('key', 'site_keywords_meta')->get()->first();
                            @endphp
                            <div class="col-sm-12 col-md-2 pt-3">

                                <label for="exist-values">
                                    {{ __('panel.site_keywords_meta') }}
                                </label>
                            </div>
                            <div class="col-sm-12 col-md-10 pt-3">
                                <input type="text" id="exist-values" class="tagged form-control" data-removeBtn="true"
                                    name="{{ $site->key }}" value="{{ old($site->key, $site->value) }}"
                                    placeholder="{{ __('panel.site_keywords_meta_message_input') }}" />

                                @error('exist-values')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                    </div>


                </div>

                @ability('admin', 'update_site_metas')
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group pt-3 mx-3">
                                <button type="submit" name="submit" class="btn btn-primary">{{ __('panel.update_data') }}
                                </button>
                            </div>
                        </div>
                    </div>
                @endability

            </form>

        </div>

    </div>
@endsection


@section('script')
    <script src="{{ asset('backend/vendors/tag_meta/tag_meta.js') }}"></script>
@endsection
