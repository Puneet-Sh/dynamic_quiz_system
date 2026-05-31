@extends('layouts.app')

@section('content')

<h2>
    {{ $quiz->title }}
</h2>

<p>
    {{ $quiz->description }}
</p>

<form
    method="POST"
    action="{{ route('quizzes.submit',$quiz) }}">

    @csrf

    @foreach($questions as $question)

        <hr>

        <h3>
            {!! $question->question_text !!}
        </h3>

        <p>
            Marks:
            {{ $question->marks }}
        </p>

        @if($question->image_path)

            <img
                src="{{ asset('storage/'.$question->image_path) }}"
                width="200">

        @endif

        @if($question->video_url)

            <p>
                Video:
                <a href="{{ $question->video_url }}"
                   target="_blank">
                    Open Video
                </a>
            </p>

        @endif

        {{-- Binary --}}
        @if($question->type === 'binary')

            <select
                name="answers[{{ $question->id }}]">

                <option value="1">
                    True
                </option>

                <option value="0">
                    False
                </option>

            </select>

        @endif

        {{-- Number --}}
        @if($question->type === 'number')

            <input
                type="number"
                name="answers[{{ $question->id }}]">

        @endif

        {{-- Text --}}
        @if($question->type === 'text')

            <input
                type="text"
                name="answers[{{ $question->id }}]">

        @endif

        {{-- Single Choice --}}
        @if($question->type === 'single_choice')

            @foreach($question->options as $option)

                <div>

                    <label>

                        <input
                            type="radio"
                            name="answers[{{ $question->id }}]"
                            value="{{ $option->id }}">

                        {{ $option->option_text }}

                    </label>

                </div>

            @endforeach

        @endif

        {{-- Multiple Choice --}}
        @if($question->type === 'multiple_choice')

            @foreach($question->options as $option)

                <div>

                    <label>

                        <input
                            type="checkbox"
                            name="answers[{{ $question->id }}][]"
                            value="{{ $option->id }}">

                        {{ $option->option_text }}

                    </label>

                </div>

            @endforeach

        @endif

    @endforeach

    <br>

    <button class="btn">
        Submit Quiz
    </button>

</form>

@endsection

