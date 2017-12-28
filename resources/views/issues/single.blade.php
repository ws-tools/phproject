@extends('layouts.app')

@section('content')
<div class="jumbotron jumbotron-sm jumbotron-fluid">
    <div class="container">
        <div class="d-flex align-items-center">
            <h1 class="mr-auto">
                {{ $issue->name }}
                <small class="text-muted">
                    {{ $issue->type->name }} #{{ $issue->id }}
                </small>
            </h1>
            <form action="{{ route('issue_toggle_close', ['issue' => $issue]) }}" method="post">
                {{ csrf_field() }}
                <a href="{{ route('issue_edit', ['issue' => $issue]) }}" class="btn btn-secondary">Edit</a>
                @if ($issue->status->closed)
                    <button type="submit" class="btn btn-warning">Reopen</button>
                @else
                    <button type="submit" class="btn btn-primary">Complete</button>
                @endif
            </form>
        </div>
        Created {{ $issue->created_at->diffForHumans() }}&ensp;
        <span class="badge badge-secondary">{{ $issue->status->name }}</span>
        @if ($issue->priority->value == 0)
            <span class="badge badge-secondary">{{ $issue->priority->name }}</span>
        @elseif ($issue->priority->value < 1)
            <span class="badge badge-info">{{ $issue->priority->name }}</span>
        @else
            <span class="badge badge-danger">{{ $issue->priority->name }}</span>
        @endif
    </div>
</div>
<div class="container">
    <div class="row">
        <div class="col-sm-3 order-sm-2">
            <h4>Author</h4>
            @include('blocks.user-tiny', ['user' => $issue->author])

            <h4>Assigned to</h4>
            @include('blocks.user-tiny', ['user' => $issue->owner])

            <h4>Watchers</h4>
            <p>(TODO)</p>
        </div>
        <div class="col-sm">
            <ul class="nav nav-pills" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab-details"
                        data-toggle="tab" href="#tab-content-details"
                        role="tab" aria-controls="tab-content-details" aria-selected="true">
                        Details
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-changelog"
                        data-toggle="tab" href="#tab-content-changelog"
                        role="tab" aria-controls="tab-content-changelog" aria-selected="false">
                        Changelog
                    </a>
                </li>
            </ul>
            <div class="tab-content mt-4">
                <div class="tab-pane active" id="tab-content-details" aria-labelledby="tab-details">
                    <div class="markdown">
                        @markdown($issue->description)
                    </div>
                </div>
                <div class="tab-pane" id="tab-content-changelog" aria-labelledby="tab-changelog">
                    <issue-history issue-id="{{ $issue->id }}"></issue-history>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
