@extends('layouts.app')

@section('content')

<h2>Edit Question</h2>

<form
    method="POST"
    action="{{ route('questions.update',$question) }}"
>

    @csrf
    @method('PUT')

    <div>
        <label>Question</label>

        <textarea
            name="question_text"
            rows="4"
            style="width:100%;"
        >{{ old('question_text',$question->question_text) }}</textarea>
    </div>

    <br>

    <div>
        <label>Marks</label>

        <input
            type="number"
            name="marks"
            value="{{ old('marks',$question->marks) }}"
        >
    </div>

    <br>

    <div>
        <label>Video URL</label>

        <input
            type="text"
            name="video_url"
            value="{{ old('video_url',$question->video_url) }}"
            style="width:100%;"
        >
    </div>

    <br>

    <button class="btn">
        Update Question
    </button>

</form>

@endsection