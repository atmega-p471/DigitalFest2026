@extends('layouts.app')

@section('title', 'Админ — Label DataHub')

@section('content')
    @php
        $ratesCount = $rates->count();
        $incidentsCount = $incidents->count();
        $entriesCount = $entries->count();
        $manualCount = $entries->where('is_manual_corrected', true)->count();
        $lastEntryAt = optional($entries->first()?->revenue_date)->format('d.m.Y') ?? '—';
    @endphp

    <header class="page-header">
        <h1 class="title">Панель администратора</h1>
        <p class="muted">Витрина управления в стиле Яндекс DataLens: KPI, синхронизация и контроль качества данных.</p>
    </header>

    <section class="page-section admin-dl">
        <div class="card">
            <div class="admin-dl-hero">
                <div class="admin-dl-hero-main">
                    <p class="admin-dl-caption">Dashboard overview</p>
                    <h3 class="admin-dl-title">Мониторинг витрины Яндекс DataLens</h3>
                    <p class="admin-dl-subtitle">Актуальность данных, инциденты и управляемые параметры в одном окне.</p>
                </div>
                <div class="admin-dl-hero-side">
                    <p class="admin-dl-caption">Быстрые действия</p>
                    <div class="admin-dl-links">
                        <a class="admin-dl-link" href="{{ route('admin.export.revenue') }}">Экспорт нормализованных доходов</a>
                        <a class="admin-dl-link" href="{{ route('admin.export.incidents') }}">Экспорт журнала инцидентов</a>
                    </div>
                </div>
            </div>

            <div class="admin-dl-kpi">
                <div class="admin-dl-kpi-card">
                    <span class="k-label">Платформы</span>
                    <span class="k-value">{{ $ratesCount }}</span>
                    <span class="k-note">активных тарифов</span>
                </div>
                <div class="admin-dl-kpi-card">
                    <span class="k-label">Инциденты</span>
                    <span class="k-value">{{ $incidentsCount }}</span>
                    <span class="k-note">в окне контроля</span>
                </div>
                <div class="admin-dl-kpi-card">
                    <span class="k-label">Строки доходов</span>
                    <span class="k-value">{{ $entriesCount }}</span>
                    <span class="k-note">в последней выборке</span>
                </div>
                <div class="admin-dl-kpi-card">
                    <span class="k-label">Ручные правки</span>
                    <span class="k-value">{{ $manualCount }}</span>
                    <span class="k-note">обновлено · {{ $lastEntryAt }}</span>
                </div>
            </div>
            <p class="data-source-note">Источник данных: Яндекс DataLens</p>
        </div>
    </section>

    <section class="page-section split-2-equal">
        <div class="card form-card">
            <div class="admin-dl-section-head">
                <h3 class="title">Запуск синхронизации</h3>
                <span class="badge badge-muted">ETL</span>
            </div>
            <p class="muted card-desc">Обновление данных из симулятора по расписанию.</p>
            <div class="form-stretch">
                <div class="form-fields form-fields--center">
                    <form method="POST" action="{{ route('admin.sync.daily') }}">
                        @csrf
                        <button class="primary" type="submit" style="width: 100%;">Ежедневная (03:00 UTC)</button>
                    </form>
                    <form method="POST" action="{{ route('admin.sync.monthly') }}">
                        @csrf
                        <button class="secondary" type="submit" style="width: 100%;">Ежемесячная (5-е число)</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="card form-card">
            <div class="admin-dl-section-head">
                <h3 class="title">Ставки по площадкам</h3>
                <span class="badge badge-muted">Config</span>
            </div>
            <p class="muted card-desc">Настройка ставки за один стрим для платформы.</p>
            <div class="form-stretch">
                <form method="POST" action="{{ route('admin.rates.update') }}">
                    <div class="form-fields">
                        <label>Площадка</label>
                        <input type="text" name="platform" placeholder="Яндекс Музыка" required>
                        <div class="field-row-2">
                            <div>
                                <label>Страна</label>
                                <input type="text" name="country" value="RU" required>
                            </div>
                            <div>
                                <label>Тип подписки</label>
                                <input type="text" name="subscription_type" value="premium" required>
                            </div>
                        </div>
                        <label>Ставка за стрим (₽)</label>
                        <input type="number" step="0.000001" name="rate_per_stream_rub" required>
                    </div>
                    <div class="form-actions">
                        <button class="secondary" type="submit">Сохранить ставку</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <section class="page-section layout-stack">
        <div class="card card-table">
            <h3 class="title">Текущие ставки</h3>
            <p class="data-source-note">Источник данных: Яндекс DataLens</p>
            <div class="table-wrap">
                <table>
                    <thead><tr><th>Площадка</th><th>Страна</th><th>Подписка</th><th>Ставка, ₽</th></tr></thead>
                    <tbody>
                    @forelse($rates as $r)
                        <tr>
                            <td><strong>{{ $r->platform }}</strong></td>
                            <td>{{ $r->country }}</td>
                            <td><span class="badge badge-muted">{{ $r->subscription_type }}</span></td>
                            <td style="color: var(--accent); font-weight: 600;">{{ $r->rate_per_stream_rub }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="muted" style="text-align: center; padding: 28px;">Ставки не настроены</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card card-table">
            <h3 class="title">Ручная корректировка</h3>
            <p class="muted card-desc">Строки с ручной правкой не перезаписываются симулятором.</p>
            <p class="data-source-note">Источник данных: Яндекс DataLens</p>
            <div class="table-wrap">
                <table>
                    <thead>
                    <tr>
                        <th>№</th>
                        <th>Трек</th>
                        <th>Дата</th>
                        <th>Факт</th>
                        <th>Ожидание</th>
                        <th>Действие</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($entries as $entry)
                        <tr>
                            <td><span class="badge badge-muted">#{{ $entry->id }}</span></td>
                            <td>{{ $entry->track?->title }}</td>
                            <td class="muted">{{ $entry->revenue_date?->format('d.m.Y') }}</td>
                            <td>{{ $entry->amount }}</td>
                            <td class="muted">{{ $entry->expected_amount_rub }}</td>
                            <td>
                                <form method="POST" action="{{ route('admin.revenue.adjust', $entry->id) }}" class="table-actions">
                                    @csrf
                                    <input type="number" step="0.01" name="amount" placeholder="Сумма">
                                    <input type="text" name="reason" placeholder="Причина">
                                    <button class="secondary" type="submit">Применить</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="muted" style="text-align: center; padding: 28px;">Записей нет</td></tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="split-incidents-export">
            <div class="card card-table card-table--incidents">
                <h3 class="title">Инциденты</h3>
                <p class="data-source-note">Источник данных: Яндекс DataLens</p>
                <div class="table-wrap">
                    <table class="table-incidents">
                        <colgroup>
                            <col class="col-type">
                            <col class="col-msg">
                            <col class="col-pct">
                            <col class="col-track">
                            <col class="col-artist">
                        </colgroup>
                        <thead><tr><th>Тип</th><th>Сообщение</th><th>%</th><th>Трек</th><th>Артист</th></tr></thead>
                        <tbody>
                        @forelse($incidents as $incident)
                            <tr>
                                <td class="cell-type"><span class="badge">{{ $incident->type }}</span></td>
                                <td class="cell-msg muted">{{ $incident->message }}</td>
                                <td class="cell-pct">{{ $incident->deviation_percent }}%</td>
                                <td class="cell-track muted">{{ $incident->track?->title ?? '—' }}</td>
                                <td class="cell-artist">{{ $incident->artist?->name ?? '—' }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="5" class="muted" style="text-align: center; padding: 20px;">Инцидентов нет</td></tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="card card-exports">
                <div class="card-exports__head">
                    <h3 class="title">Выгрузки</h3>
                    <span class="export-format">CSV</span>
                </div>
                <p class="muted card-desc">Скачать отчёты одним файлом</p>
                <div class="export-tiles">
                    <a class="export-tile" href="{{ route('admin.export.revenue') }}">
                        <span class="export-tile__icon" aria-hidden="true">₽</span>
                        <span class="export-tile__body">
                            <span class="export-tile__name">Доходы</span>
                            <span class="export-tile__hint">Нормализованные</span>
                        </span>
                    </a>
                    <a class="export-tile" href="{{ route('admin.export.incidents') }}">
                        <span class="export-tile__icon" aria-hidden="true">!</span>
                        <span class="export-tile__body">
                            <span class="export-tile__name">Инциденты</span>
                            <span class="export-tile__hint">Все записи</span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </section>
@endsection
