@extends('layouts.app')

@section('content')
<style>
    body {
        font-family: 'Nunito', sans-serif;
        background-color: #f8fafc;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
        margin: 0;
        width: 100%;
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
        max-width: 600px; /* Adjust max-width as needed */
        margin: 20px;
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
        max-height: 70vh; /* Adjust as needed */
        overflow-y: auto; /* Enable vertical scrolling */
    }

    .form-control {
        border-radius: 5px;
        border: 1px solid #ced4da;
        padding: 0.75rem;
        font-size: 0.875rem;
        width: 100%; /* Fill the width of its container */
        height: auto; /* Let the height adjust to content */
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

    .scrollable {
        overflow-y: auto; /* Enable vertical scrolling */
        max-height: 200px; /* Adjust as needed for the textarea */
    }

    /* Error styling */
    .error {
        color: red;
    }

    /* Media Queries */
    @media (max-width: 768px) {
        .card {
            margin: 10px;
        }
    }

    /* Additional styling for the share section */
    .share-section {
        display: flex;
        align-items: center;
        gap: 1rem; /* Space between label and select */
    }

    .share-label {
        margin: 0; /* Remove margin for inline display */
    }

    .form-control option:checked {
        background-color: #007bff;
        color: white;
    }
</style>

<div class="container">
    <div class="card">
        <div class="card-header">{{ __('Note') }}</div>

        <div class="card-body">
            @if($errors->any())
                @foreach ($errors->all() as $e)
                    <div class="error">{{ $e }}</div>
                @endforeach
            @endif
            <form action="{{ $isEdit ? route('notes.update', $note->id) : route('notes.store') }}" method="POST">
                @csrf
                @if ($isEdit)
                    @method('PUT')
                @endif

                <div class="mb-3">
                    <label for="Title" class="form-label">{{ __('Title') }}</label>
                    <input id="Title" name="Title" class="form-control" value="{{ $isEdit ? $note->Title : old('Title') }}" required>
                </div>

                <div class="mb-3">
                    <label for="Description" class="form-label">{{ __('Description') }}</label>
                    <textarea id="Description" name="Description" class="form-control description-text scrollable" required>{{ $isEdit ? $note->Description : old('Description') }}</textarea>
                </div>

                <div class="mb-3 share-section">
                    <label for="share" class="form-label share-label">{{ __('Share with Others') }}</label>
                    <select name="share[]" id="share" class="form-control" multiple>
                        @foreach (App\Models\User::all()->except(Auth::id()) as $user)
                            <option value="{{ $user->id }}" {{ $isEdit && $note->shared->contains($user) ? 'selected' : '' }}>{{ $user->name }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update' : 'Create' }}</button>
            </form>
        </div>
    </div>
</div>
@endsection
