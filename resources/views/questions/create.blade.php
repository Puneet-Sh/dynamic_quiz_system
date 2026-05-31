@extends('layouts.app')

@section('content')

<h2>
    Add Question
</h2>

<p>
    Quiz:
    <strong>{{ $quiz->title }}</strong>
</p>

<form
    action="{{ route('questions.store',$quiz) }}"
    method="POST"
    enctype="multipart/form-data">

    @csrf

    <div>
        <label>Question Type</label>

        <select
            name="type"
            id="questionType">

            <option value="binary">
                Binary
            </option>

            <option value="single_choice">
                Single Choice
            </option>

            <option value="multiple_choice">
                Multiple Choice
            </option>

            <option value="number">
                Number
            </option>

            <option value="text">
                Text
            </option>

        </select>
    </div>

    <br>

    <div>

        <label>Question</label>

        <textarea
            name="question_text"
            rows="4"
            style="width:100%;"></textarea>

    </div>

    <br>

    <div>

        <label>Marks</label>

        <input
            type="number"
            name="marks"
            value="1">

    </div>

    <br>

    <div>

        <label>Image</label>

        <input
            type="file"
            name="image">

    </div>

    <br>

    <div>

        <label>Video URL</label>

        <input
            type="text"
            name="video_url"
            style="width:100%;">

    </div>

    <hr>

    <div id="dynamicFields">

    </div>

    <button class="btn">
        Save Question
    </button>

</form>

<script>

const questionType =
    document.getElementById('questionType');

const dynamicFields =
    document.getElementById('dynamicFields');

function renderFields()
{
    const type =
        questionType.value;

    if(type === 'binary')
    {
        dynamicFields.innerHTML = `
            <label>
                Correct Answer
            </label>

            <select name="correct_answer">

                <option value="1">
                    True
                </option>

                <option value="0">
                    False
                </option>

            </select>
        `;
    }

    if(type === 'number')
    {
        dynamicFields.innerHTML = `
            <label>
                Correct Number
            </label>

            <input
                type="number"
                name="correct_answer">
        `;
    }

    if(type === 'text')
    {
        dynamicFields.innerHTML = `
            <label>
                Correct Text
            </label>

            <input
                type="text"
                name="correct_answer">
        `;
    }

    if(type === 'single_choice')
    {
        dynamicFields.innerHTML = renderChoiceFields(false);
    }

    if(type === 'multiple_choice')
    {
        dynamicFields.innerHTML = renderChoiceFields(true);
    }
}

function renderChoiceFields(multiple)
{
    let html = '';

    for(let i=0;i<4;i++)
        {
            html += `
            <div>

                <input
                    type="text"
                    name="options[]"
                    placeholder="Option ${i+1}">

                <input
                    type="file"
                    name="option_images[]">

                ${
                    multiple
                    ?
                    `<input
                        type="checkbox"
                        name="correct_options[]"
                        value="${i}"> Correct`
                    :
                    `<input
                        type="radio"
                        name="correct_option"
                        value="${i}"> Correct`
                }

            </div>

            <br>
            `;
        }

    return html;
}

questionType.addEventListener(
    'change',
    renderFields
);

renderFields();

</script>

@endsection

