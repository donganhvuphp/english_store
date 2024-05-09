@extends('common.main')

@section('js-bot')
    <script src="{{ asset('js/ckeditor.js') }}"></script>
    <script src="{{ asset('js/translate.js') }}"></script>
@endsection

@section('content')
    <div class="translate-screen">
       <div class="row">
           <div class="col-5">
               <div class="row mt-5">
                   <div class="col-12">
                       <input type="text" class="form-control" placeholder="Please input title lesson" name="lesson">
                   </div>
               </div>
               <div class="row mt-5 mb-5">
                   <div class="col-12">
                       <textarea id="editor" name="descriptions" placeholder="Please input description lesson"></textarea>
                   </div>
               </div>
               <div class="row">
                   <div class="col-12">
                       <span class="text-danger">* Có thể dịch nhiều từ cách nhau bằng dấu | hoặc 2 khoảng trắng</span>
                       <div class="d-flex flex-column">
                           <input type="text" class="form-control" placeholder="Please input text translate" name="translate_text">
                           <button class="btn btn-success w-20 mt-3" id="translate" data-url="{{ route('translate') }}">
                               Translate
                           </button>
                       </div>
                   </div>
               </div>
           </div>
           <div class="col-6">
               <div class="row mt-5 translate-result d-none">
                   <div class="col-12">
                       <table class="table table-bordered">
                           <thead class="text-center">
                           <tr>
                               <th class="w-30">Text translate</th>
                               <th class="w-30">Result</th>
                               <th class="w-20">Spelling</th>
                               <th class="w-10">Voice</th>
                               <th class="w-10">Action</th>
                           </tr>
                           </thead>
                           <tbody class="data-translate">
                           </tbody>
                       </table>
                   </div>
                   <div class="col-12">
                       <button data-url="{{ route('translate.store') }}" class="save-translate btn btn-success">Save translate</button>
                   </div>
               </div>
           </div>
       </div>
    </div>
@endsection
