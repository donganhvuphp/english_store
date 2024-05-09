@extends('common.main')

@section('js-bot')
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('js/translate.js') }}"></script>
@endsection

@section('content')
    <div class="container">
        <div class="row">
            @forelse($lessons as $lesson)
                <div class="col-4">
                    <div class="card cursor-pointer">
                        <div class="card-body d-flex justify-content-between">
                            <a href="{{ route('translate.show', ['id' => $lesson->id ]) }}" class="text-default">
                                <h5 class="card-title">{{ $lesson->name ?? '' }}</h5>
                            </a>
                            <i class="fas fa-trash text-danger lh-25 remove-lesson" data-url="{{ route('translate.delete', ['id' => $lesson->id ?? '']) }}"></i>
                        </div>
                    </div>
                </div>
            @empty
            @endforelse
        </div>
    </div>

    @include('common.confirm', [
        'idModal' => 'remove-lesson-modal',
        'title' => 'Xác nhận',
        'content' => 'Bạn có chắc chắn muốn xóa không ?'
    ])
@endsection
