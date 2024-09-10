@extends('layouts.app')

@section('title', $feedName)

@section('content')
    <div class="container">
        <div class="d-flex align-items-center mb-4">
            <img src="{{ asset('favicon.png') }}" alt="RSS Feed Icon" class="rss-icon me-3">
            <h1 class="mb-0">{{ $channel['title'] }}</h1>
        </div>
        <p class="mb-4">{{ $channel['description'] }}</p>

        <div class="row">
            @foreach ($items as $item)
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-img-top-wrapper">
                            <img class="card-img-top lazy" data-src="{{ $item['imageUrl'] }}" alt="{{ $item['title'] }}">
                        </div>
                        <div class="card-body d-flex flex-column">
                            <h5 class="card-title">
                                <a href="{{ $item['link'] }}" target="_blank">{{ $item['title'] }}</a>
                            </h5>
                            <p class="card-text flex-grow-1">{!! Str::limit(strip_tags($item['description']), 150) !!}</p>
                            <p class="card-text mt-auto">
                                <small class="text-muted">
                                    發布日期:
                                    {{ Carbon\Carbon::parse($item['pubDate'])->locale('zh-TW')->isoFormat('YYYY 年 MM 月DD日 HH:mm') }}
                                </small>
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .rss-icon {
            width: 32px;
            height: 32px;
        }

        .card-img-top-wrapper {
            position: relative;
            height: 250px;
            background-color: #f8f9fa;
            overflow: hidden;
        }

        .card-img-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .lazy-placeholder {
            width: 100%;
            height: 100%;
            background-color: #e9ecef;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #6c757d;
            font-size: 14px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        $(function() {
            $('.lazy').Lazy({
                effect: 'fadeIn',
                effectTime: 300,
                threshold: 0,
                placeholder: "data:image/gif;base64,R0lGODlhAQABAIAAAP///wAAACH5BAEAAAAALAAAAAABAAEAAAICRAEAOw==",
                beforeLoad: function(element) {
                    var placeholderDiv = $('<div class="lazy-placeholder">載入中...</div>');
                    element.parent().append(placeholderDiv);
                },
                afterLoad: function(element) {
                    element.parent().find('.lazy-placeholder').remove();
                },
                onError: function(element) {
                    var placeholderDiv = $('<div class="lazy-placeholder">圖片載入失敗</div>');
                    element.parent().find('.lazy-placeholder').remove();
                    element.parent().append(placeholderDiv);
                }
            });
        });
    </script>
@endpush
