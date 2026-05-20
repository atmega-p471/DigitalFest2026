@extends('layouts.app')

@section('content')
    <div class="card">
        <h1 class="title">Admin dashboard</h1>
        <p class="muted">Управление simulator, ставками, инцидентами, ручными правками и export.</p>
    </div>

    <div class="split-2">
        <div class="card">
            <h3 class="title">Запуск sync</h3>
            <form method="POST" action="{{ route('admin.sync.daily') }}" style="margin-bottom:8px;">
                @csrf
                <button class="primary" type="submit">Запустить daily sync (03:00 UTC)</button>
            </form>
            <form method="POST" action="{{ route('admin.sync.monthly') }}">
                @csrf
                <button class="secondary" type="submit">Запустить monthly sync (5-е число)</button>
            </form>
        </div>

        <div class="card">
            <h3 class="title">Ставки по platform</h3>
            <form method="POST" action="{{ route('admin.rates.update') }}">
                @csrf
                <label>Platform</label>
                <input type="text" name="platform" placeholder="Yandex Music" required>
                <label>Country</label>
                <input type="text" name="country" value="RU" required>
                <label>Subscription type</label>
                <input type="text" name="subscription_type" value="premium" required>
                <label>Ставка за стрим (RUB)</label>
                <input type="number" step="0.000001" name="rate_per_stream_rub" required>
                <button class="secondary" type="submit">Сохранить ставку</button>
            </form>
        </div>
    </div>

    <div class="card">
        <h3 class="title">Ставки (список)</h3>
        <table>
            <thead><tr><th>Platform</th><th>Country</th><th>Type</th><th>Rate RUB</th></tr></thead>
            <tbody>
            @forelse($rates as $r)
                <tr><td>{{ $r->platform }}</td><td>{{ $r->country }}</td><td>{{ $r->subscription_type }}</td><td>{{ $r->rate_per_stream_rub }}</td></tr>
            @empty
                <tr><td colspan="4">Ставки еще не настроены.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>

    <div class="split-2">
        <div class="card">
            <h3 class="title">Ручная корректировка</h3>
            <p class="muted">Исправленные строки получают флаг "is_manual_corrected" и не перезаписываются simulator.</p>
            <table>
                <thead><tr><th>ID</th><th>Трек</th><th>Дата</th><th>Actual</th><th>Expected</th><th>Действие</th></tr></thead>
                <tbody>
                @forelse($entries as $entry)
                    <tr>
                        <td>{{ $entry->id }}</td>
                        <td>{{ $entry->track?->title }}</td>
                        <td>{{ $entry->revenue_date?->format('Y-m-d') }}</td>
                        <td>{{ $entry->amount }}</td>
                        <td>{{ $entry->expected_amount_rub }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.revenue.adjust', $entry->id) }}">
                                @csrf
                                <input type="number" step="0.01" name="amount" placeholder="новый amount">
                                <input type="text" name="reason" placeholder="причина">
                                <button class="secondary" type="submit">Применить</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="6">Записей пока нет.</td></tr>
                @endforelse
                </tbody>
            </table>
        </div>

        <div>
            <div class="card">
                <h3 class="title">Инциденты</h3>
                <table>
                    <thead><tr><th>Type</th><th>Сообщение</th><th>Deviation %</th><th>Трек</th><th>Артист</th></tr></thead>
                    <tbody>
                    @forelse($incidents as $incident)
                        <tr>
                            <td>{{ $incident->type }}</td>
                            <td>{{ $incident->message }}</td>
                            <td>{{ $incident->deviation_percent }}</td>
                            <td>{{ $incident->track?->title }}</td>
                            <td>{{ $incident->artist?->name }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="5">Инцидентов нет.</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card">
                <h3 class="title">Экспорты</h3>
                <a href="{{ route('admin.export.revenue') }}">Скачать normalized revenue CSV</a><br>
                <a href="{{ route('admin.export.incidents') }}">Скачать incidents CSV</a>
            </div>
        </div>
    </div>
@endsection
