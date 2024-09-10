@extends('layouts.app')

@section('title', $feedName)

@section('content')
    <div class="container">
        <h1 class="mb-4">{{ $channel['title'] }}</h1>
        <p class="mb-4">{{ $channel['description'] }}</p>

        <div class="row">
            @foreach ($items as $item)
                <div class="col-12 col-md-4 mb-4">
                    <div class="card h-100">
                        <div class="card-img-top-wrapper">
                            <div class="placeholder-loader"></div>
                            <img src="{{ $item['imageUrl'] }}" class="card-img-top" alt="{{ $item['title'] }}">
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
    <link rel="stylesheet" href="{{ asset('css/rss-reader.css') }}">
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var lazyImages = document.querySelectorAll('img.card-img-top');
            lazyImages.forEach(function(img) {
                img.addEventListener('load', function() {
                    this.classList.add('loaded');
                    this.previousElementSibling.style.display = 'none';
                });
            });
        });
    </script>
@endpush
