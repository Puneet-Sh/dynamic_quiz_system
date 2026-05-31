# Architecture

## Database Design

Tables:

* quizzes
* questions
* options
* attempts
* answers

### quizzes

Stores quiz metadata.

### questions

Stores all question types using a single table.

Question-specific configuration is stored in the `meta` JSON column.

### options

Stores selectable options for choice-based questions.

Supports:

* text
* image
* text + image

### attempts

Stores quiz attempt summaries.

### answers

Stores user submitted answers.

## Extensibility

The system uses the Strategy Pattern.

Each question type has its own evaluator:

* BinaryEvaluator
* SingleChoiceEvaluator
* MultipleChoiceEvaluator
* NumberEvaluator
* TextEvaluator

The EvaluatorFactory resolves the evaluator based on question type.

Adding a new question type requires:

1. Creating a new evaluator.
2. Registering it in EvaluatorFactory.
3. Creating a UI renderer.

No database redesign is required.

## Evaluation Flow

QuizSubmission

→ QuizEvaluationService

→ EvaluatorFactory

→ Specific Evaluator

→ Score Calculation

## Media Support

Questions:

* image upload
* video URL

Options:

* text
* image
* text + image
