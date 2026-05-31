@extends('layouts.app')

@section('content')

<h2>Create Quiz</h2>

<form method="POST"
      action="{{ route('quizzes.store') }}">

    @csrf

    <div>

        <label>Title</label>

        <br>

        <input
            type="text"
            name="title"
            value="{{ old('title') }}"
            style="width:100%;">

    </div>

    <br>

    <div>

        <label>Description</label>

        <br>

        <textarea
            name="description"
            rows="5"
            style="width:100%;"></textarea>

    </div>

    <br>

    <button class="btn">
        Save Quiz
    </button>

</form>

@endsection

