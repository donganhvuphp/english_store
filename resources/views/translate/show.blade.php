@extends('common.main')

@section('content')
    <div class="row">
        <div class="col-12">
            <h3>{{ $lesson->name }}</h3>
        </div>
    </div>
    <div class="row">
        <div>
            {!! $lesson->descriptions !!}
        </div>
    </div>
    <div class="row mt-5 translate-result">
        <div class="col-10">
            <table class="table table-bordered">
                <thead class="text-center">
                <tr>
                    <th class="w-35">Text translate</th>
                    <th class="w-35">Result</th>
                    <th class="w-10">Spelling</th>
                    <th class="w-10">Voice</th>
                    <th class="w-10">Action</th>
                </tr>
                </thead>
                <tbody class="data-translate">
                    @forelse($lesson->vocabulary as $vocabulary)
                        <tr>
                            <td class="text-end">{{ $vocabulary->text }}</td>
                            <td>{{ $vocabulary->translate }}</td>
                            <td></td>
                            <td class="text-center"><i class="fas fa-volume-up"></i></td>
                            <td class="text-center"><i class="fas fa-trash text-danger"></i></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">
                                Không có bản dịch nào hiển thị
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="col-12">
            <button class="save-translate btn btn-success">Edit translate</button>
        </div>
    </div>
@endsection
