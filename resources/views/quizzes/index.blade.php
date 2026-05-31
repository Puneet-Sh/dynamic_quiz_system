@extends('layouts.app')

@section('content')

<a href="{{ route('quizzes.create') }}" class="btn">
    Create Quiz
</a>

<br><br>

<table>

    <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Description</th>
        <th>Actions</th>
    </tr>

    @forelse($quizzes as $quiz)

        <tr>

            <td>{{ $quiz->id }}</td>

            <td>{{ $quiz->title }}</td>

            <td>{{ $quiz->description }}</td>

            <td>

                <a
                    href="{{ route('quizzes.edit',$quiz) }}"
                    class="btn">
                    Edit
                </a>

                <a
                    href="{{ route('questions.index',$quiz) }}"
                    class="btn">
                    Questions
                </a>

                <a
                    href="{{ route('quizzes.attempt',$quiz) }}"
                    class="btn">
                    Attempt
                </a>

                <form
                    action="{{ route('quizzes.destroy',$quiz) }}"
                    method="POST"
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
                No quizzes found
            </td>
        </tr>

    @endforelse

</table>

@endsection

