@extends('layouts.app')

@section('title', 'RSS 訂閱列表')

@section('content')
    <h1 class="mb-4">RSS 訂閱列表</h1>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach($feeds as $name => $url)
            <div class="col">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ $name }}</h5>
                        <a href="{{ route('rss.show', ['feedName' => $name]) }}" class="btn btn-primary">查看詳情</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection