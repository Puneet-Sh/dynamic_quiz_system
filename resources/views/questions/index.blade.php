@extends('layouts.app')

@section('content')

<h2>
    {{ $quiz->title }}
</h2>

<a
    href="{{ route('questions.create',$quiz) }}"
    class="btn">
    Add Question
</a>

<br><br>

<table>

<tr>

    <th>ID</th>
    <th>Type</th>
    <th>Question</th>
    <th>Images</th>
    <th>Marks</th>
    <th>Edit</th>

</tr>

@forelse($questions as $question)

<tr>

    <td>
        {{ $question->id }}
    </td>

    <td>
        {{ $question->type }}
    </td>

    <td>

        {!! $question->question_text !!}

        @if($question->image_path)

            <br>

            <img
                src="{{ asset('storage/'.$question->image_path) }}"
                width="150">

        @endif
        

        @if($question->video_url)

            <br>

            <a
                href="{{ $question->video_url }}"
                target="_blank"
                rel="noopener noreferrer"
            >
                Watch Video
            </a>

        @endif

        @if(
            in_array(
                $question->type,
                [
                    'single_choice',
                    'multiple_choice'
                ]
            )
        )

            <ul>

            @foreach( $question->options as $option )

                <li>

                    {{ $option->option_text }}

                    @if(
                        $option->is_correct
                    )
                        ✅
                    @endif

                </li>

            @endforeach

            </ul>

        @else

            <p>

                Correct:

                {{
                    $question->meta['correct_answer']
                    ?? ''
                }}

            </p>

        @endif

    </td>

    <td>

        @if(
            in_array(
                $question->type,
                ['single_choice', 'multiple_choice']
            )
        )

            @foreach($question->options as $option)

                @if($option->image_path)

                    <img
                        src="{{ asset('storage/'.$option->image_path) }}"
                        width="80">

                    <br>

                @endif

            @endforeach

        @endif

    </td>

    <td>
        {{ $question->marks }}
    </td>

    <td>
       <a
    href="{{ route('questions.edit',$question) }}"
    class="btn">
    Edit
</a>

<form
    method="POST"
    action="{{ route('questions.destroy',$question) }}"
    style="display:inline">

    @csrf
    @method('DELETE')

    <button class="btn">
        Delete
    </button>

</form>
    </td>

</tr>

@empty

<tr>

    <td colspan="4">
        No questions found
    </td>

</tr>

@endforelse

</table>

@endsection