@extends('layouts.app')

@section('content')
    <h1 class="title">Reports</h1>
    <p class="muted">Generate report by period and optional track selection.</p>

    <div class="card">
        <form method="POST" action="{{ route('reports.store') }}">
            @csrf
            <label>Artist</label>
            <select name="artist_id" required>
                @foreach($artists as $artist)
                    <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                @endforeach
            </select>

            <label>Period from</label>
            <input type="date" name="period_from" required>

            <label>Period to</label>
            <input type="date" name="period_to" required>

            <label>Track filter (optional)</label>
            <select name="track_ids[]" multiple size="5">
                @foreach($tracks as $track)
                    <option value="{{ $track->id }}">{{ $track->title }}</option>
                @endforeach
            </select>

            <button class="primary" type="submit" style="margin-top:10px;">Create report</button>
        </form>
    </div>

    @if(auth()->user()->isAdmin())
        <div class="card">
            <h3 class="title">Admin: bulk update track shares</h3>
            <form method="POST" action="{{ route('admin.shares.update') }}">
                @csrf
                <label>Select tracks</label>
                <select name="track_ids[]" multiple size="5" required>
                    @foreach($tracks as $track)
                        <option value="{{ $track->id }}">{{ $track->title }}</option>
                    @endforeach
                </select>
                <label>New share percent for all linked artists</label>
                <input type="number" step="0.01" min="0" max="100" name="share_percent" required>
                <button class="primary" type="submit">Update shares</button>
            </form>
        </div>
    @endif

    <div class="card">
        <h3 class="title">Recent reports</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Artist</th>
                <th>Period</th>
                <th>Total</th>
                <th>Created by</th>
            </tr>
            </thead>
            <tbody>
            @forelse($reports as $report)
                <tr>
                    <td>{{ $report->id }}</td>
                    <td>{{ $report->artist?->name }}</td>
                    <td>{{ $report->period_from?->format('Y-m-d') }} - {{ $report->period_to?->format('Y-m-d') }}</td>
                    <td>{{ number_format($report->total_amount, 2, '.', ' ') }} {{ $report->currency }}</td>
                    <td>{{ $report->creator?->name }}</td>
                </tr>
            @empty
                <tr><td colspan="5">No reports generated yet.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
@endsection
