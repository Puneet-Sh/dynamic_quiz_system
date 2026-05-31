@extends('layouts.app')

@section('content')

<h2>Edit Quiz</h2>

<form method="POST"
      action="{{ route('quizzes.update',$quiz) }}">

    @csrf
    @method('PUT')

    <div>

        <label>Title</label>

        <br>

        <input
            type="text"
            name="title"
            value="{{ old('title',$quiz->title) }}"
            style="width:100%;">

    </div>

    <br>

    <div>

        <label>Description</label>

        <br>

        <textarea
            name="description"
            rows="5"
            style="width:100%;"
        >{{ old('description',$quiz->description) }}</textarea>

    </div>

    <br>

    <button class="btn">
        Update Quiz
    </button>

</form>

@endsection

