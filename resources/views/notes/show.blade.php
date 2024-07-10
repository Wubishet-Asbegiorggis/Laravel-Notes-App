@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Nunito', sans-serif;
        background-color: #f8fafc;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: auto;
        margin: 0;
    }

    .container {
        width: 100%;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .card {
        border-radius: 10px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: auto; /* Adjust max-width as needed */
        margin: 10px;
    }

    .card-header {
        background-color: #007bff;
        color: white;
        font-size: 1.25rem;
        font-weight: bold;
        text-align: center;
        padding: 1rem;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
    }

    .card-body {
        padding: 2rem;
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 0.75rem;
        font-size: 0.875rem;
        width: 100%; /* Fill the width of its container */
        height: auto; /* Let the height adjust to content */
        resize: none; /* Prevent resizing */
        overflow: hidden; /* Hide overflow */
    }

    .description-text {
        white-space: pre-line; /* Preserve line breaks and spaces */
    }

    .mb-3 {
        margin-bottom: 1.5rem !important;
    }

    .btn-primary {
        background-color: #007bff;
        border: none;
        border-radius: 5px;
        padding: 0.5rem 1.5rem;
        font-size: 1rem;
        cursor: pointer;
    }

    .btn-link {
        font-size: 0.875rem;
        cursor: pointer;
    }

    /* Media Queries */
    @media (max-width: 768px) {
        .card {
            margin: 10px;
        }
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Note') }}</div>

        <div class="card-body">

            <div class="mb-3">
                <label for="title" class="form-label">{{ "By: ".$note->user->name }}</label>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <p id="description" class="form-control description-text">{{$note->Description }}</p>
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('Shared with: ') }}</label>
                <ul>
                    @if ($note->shared)
                        @foreach ($note->shared as $u)
                            <li>{{ $u->name }}</li>
                        @endforeach
                    @else
                        <li>No users shared with yet.</li>
                    @endif
                </ul>
            </div>

            <a href="{{ route('notes.edit',$note->id) }}">Edit</a>
            <form method="POST" action="{{ route('notes.destroy', $note->id )}}">
                @csrf
                @method('DELETE')
                <button type="submit">Delete</button>
            </form>
        </div>
    </div>
</div>
@endsection
