@extends('layouts.app')

@section('content')

<h2>
    Quiz Result
</h2>

<p>

    Score:

    <strong>

        {{ $attempt->score }}

        /

        {{ $attempt->total_marks }}

    </strong>

</p>

<p>

    Percentage:

    <strong>

        {{
            $attempt->total_marks
            ? round(
                ($attempt->score /
                 $attempt->total_marks)
                 * 100,
                2
              )
            : 0
        }}%

    </strong>

</p>

<a
    href="{{ route('quizzes.index') }}"
    class="btn">

    Back To Quizzes

</a>

@endsection

