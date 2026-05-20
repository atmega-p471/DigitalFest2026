@extends('layouts.app')

@section('content')
    <div class="card">
        <h1 class="title">Отчеты</h1>
        <p class="muted">Создание отчета за период и по выбранным трекам.</p>
    </div>

    <div class="split-2">
        <div class="card">
            <form method="POST" action="{{ route('reports.store') }}">
            @csrf
            <label>Артист</label>
            <select name="artist_id" required>
                @foreach($artists as $artist)
                    <option value="{{ $artist->id }}">{{ $artist->name }}</option>
                @endforeach
            </select>

            <label>Период с</label>
            <input type="date" name="period_from" required>

            <label>Период по</label>
            <input type="date" name="period_to" required>

            <label>Фильтр по трекам (необязательно)</label>
            <select name="track_ids[]" multiple size="5">
                @foreach($tracks as $track)
                    <option value="{{ $track->id }}">{{ $track->title }}</option>
                @endforeach
            </select>

            <button class="primary" type="submit" style="margin-top:10px;">Создать отчет</button>
            </form>
        </div>

        @if(auth()->user()->isAdmin())
            <div class="card">
                <h3 class="title">Admin: массовое обновление долей</h3>
                <form method="POST" action="{{ route('admin.shares.update') }}">
                    @csrf
                    <label>Выберите треки</label>
                    <select name="track_ids[]" multiple size="5" required>
                        @foreach($tracks as $track)
                            <option value="{{ $track->id }}">{{ $track->title }}</option>
                        @endforeach
                    </select>
                    <label>Новый share percent</label>
                    <input type="number" step="0.01" min="0" max="100" name="share_percent" required>
                    <button class="secondary" type="submit">Обновить доли</button>
                </form>
            </div>
        @endif
    </div>

    <div class="card">
        <h3 class="title">Последние отчеты</h3>
        <table>
            <thead>
            <tr>
                <th>ID</th>
                <th>Артист</th>
                <th>Период</th>
                <th>Сумма</th>
                <th>Кем создан</th>
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
                <tr><td colspan="5">Отчеты пока не созданы.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="split-2">
        <div class="card">
            <h3 class="title">История выплат</h3>
            <table>
                <thead><tr><th>Артист</th><th>Трек</th><th>Период</th><th>Сумма</th><th>Status</th></tr></thead>
                <tbody>
                @forelse($payouts as $payout)
                    <tr>
                        <td>{{ $payout->artist?->name }}</td>
                        <td>{{ $payout->track?->title }}</td>
                        <td>{{ $payout->period_start?->format('Y-m-d') }} - {{ $payout->period_end?->format('Y-m-d') }}</td>
                        <td>{{ number_format($payout->amount, 2, '.', ' ') }} {{ $payout->currency }}</td>
                        <td>{{ $payout->status }}</td>
                    </tr>
                @empty
                    <tr><td colspan="5">Выплаты пока отсутствуют.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div class="card">
            <h3 class="title">Инциденты</h3>
            <table>
                <thead><tr><th>Type</th><th>Сообщение</th><th>Deviation %</th><th>Трек</th></tr></thead>
                <tbody>
                @forelse($incidents as $incident)
                    <tr>
                        <td>{{ $incident->type }}</td>
                        <td>{{ $incident->message }}</td>
                        <td>{{ $incident->deviation_percent }}</td>
                        <td>{{ $incident->track?->title }}</td>
                    </tr>
                @empty
                    <tr><td colspan="4">Инцидентов нет.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
