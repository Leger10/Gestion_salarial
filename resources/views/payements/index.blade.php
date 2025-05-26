@extends('layouts.template')

@php
    use Carbon\Carbon;
    $today = Carbon::now();
    $isPaymentDate = $today->isSameDay($payementDate);
    $isBeforePaymentDate = $today->isBefore($payementDate);
@endphp

@section('content')

    {{-- Success Message --}}
    @if (session('success_message'))
        <div class="alert alert-success mt-3" role="alert">
            {{ session('success_message') }}
        </div>
    @endif

    {{-- Payment Date Alerts --}}
    @if ($isBeforePaymentDate)
        <div class="alert alert-danger mt-3" role="alert">
            Vous ne pourrez pas effectuer de paiement jusqu'à la date de paiement prévue ({{ $payementDate->format('d-m-Y') }}).
        </div>
    @elseif ($isPaymentDate)
        <div class="alert alert-success mt-3" role="alert">
            Vous pouvez effectuer les paiements des employés aujourd'hui ({{ $payementDate->format('d-m-Y') }}).
        </div>
    @endif

    {{-- Error Message --}}
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    {{-- Export Button --}}
    @if($showPaymentButton)
        <a class="btn btn-primary" href="{{ route('paiements.export') }}">
            <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
            </svg>
            Exporter vers Excel
        </a>
    @endif

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <div class="row g-3 mb-4 align-items-center justify-content-between">
        <div class="col-auto">
            <h1 class="app-page-title mb-0">Paiements</h1>
        </div>
        <form action="{{ route('payments.index') }}" method="GET" class="d-flex">
            <div class="col-auto">
                <input type="text" name="query" class="form-control" placeholder="Rechercher un employeur" value="{{ request('query') }}">
            </div>
            <div class="col-auto">
                <select name="filter" class="form-select w-auto">
                    <option value="option-1" {{ request('filter') == 'option-1' ? 'selected' : '' }}>Total</option>
                    <option value="option-2" {{ request('filter') == 'option-2' ? 'selected' : '' }}>Cette Semaine</option>
                    <option value="option-3" {{ request('filter') == 'option-3' ? 'selected' : '' }}>Ce Mois</option>
                    <option value="option-4" {{ request('filter') == 'option-4' ? 'selected' : '' }}>Les 3 Derniers Mois</option>
                    <option value="option-5" {{ request('filter') == 'option-5' ? 'selected' : '' }}>Les 6 Derniers Mois</option>
                </select>
            </div>
            <div class="col-auto">
                <button type="submit" class="btn app-btn-secondary">Recherche</button>
            </div>
        </form>
        <div class="col-auto ms-auto">
            @if($showPaymentButton)
                <a class="btn app-btn-secondary" href="{{ route('paiements.init') }}">
                    <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-download me-1" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd" d="M.5 9.9a.5.5 0 0 1 .5.5v2.5a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-2.5a.5.5 0 0 1 1 0v2.5a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2v-2.5a.5.5 0 0 1 .5-.5z"/>
                        <path fill-rule="evenodd" d="M7.646 11.854a.5.5 0 0 0 .708 0l3-3a.5.5 0 0 0-.708-.708L8.5 10.293V1.5a.5.5 0 0 0-1 0v8.793L5.354 8.146a.5.5 0 1 0-.708.708l3 3z"/>
                    </svg>
                    Lancer les paiements
                </a>
            @endif
        </div>
    </div>

    <nav id="orders-table-tab" class="orders-table-tab app-nav-tabs nav shadow-sm flex-column flex-sm-row mb-4">
        <a class="flex-sm-fill text-sm-center nav-link active" id="orders-all-tab" data-bs-toggle="tab" href="#orders-all" role="tab" aria-controls="orders-all" aria-selected="true">Tous les Paiements</a>
    </nav>

    <div class="tab-content" id="orders-table-tab-content">
        <div class="tab-pane fade show active" id="orders-all" role="tabpanel" aria-labelledby="orders-all-tab">
            <div class="app-card app-card-orders-table shadow-sm mb-5">
                <div class="app-card-body">
                    <div class="table-responsive">
                        <table class="table app-table-hover mb-0 text-left">
                            <thead>
                                <tr>
                                    <th class="cell">#</th>
                                    <th class="cell">Référence</th>
                                    <th class="cell">Employeur</th>
                                    <th class="cell">Date de la Transaction</th>
                                    <th class="cell">Mois</th>
                                    <th class="cell">Année</th>
                                    <th class="cell">Statut</th>
                                    <th class="cell">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($payments as $payment)
                                    <tr>
                                        <td class="cell">{{ $payment->id }}</td>
                                        <td class="cell" style="color: green">{{ $payment->reference }}</td>
                                        <td class="cell" style="color: green">
                                            @if($payment->employer)
                                                {{ $payment->employer->nom }} {{ $payment->employer->prenom }}
                                            @else
                                                Employeur non trouvé
                                            @endif
                                        </td>
                                        <td class="cell" style="color: green">{{ $payment->launch_date }}</td>
                                        <td class="cell" style="color: green">{{ $payment->month }}</td>
                                        <td class="cell" style="color: green">{{ $payment->year }}</td>
                                        <td class="cell">
                                            <button class="btn btn-success btn-sm" style="color: white; font-size: 0.75rem;">
                                                {{ $payment->status }}
                                            </button>
                                        </td>
                                        <td class="cell">
                                            <a href="{{ route('payment.download', $payment->id) }}" class="btn btn-link" style="color: #007bff;">
                                                <i class="fas fa-download" style="font-size: 1.2rem; margin-right: 5px;"></i>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div><!--//table-responsive-->
                </div><!--//app-card-body-->
            </div><!--//app-card-->
        </div><!--//tab-pane-->
    </div><!--//tab-content-->

    <nav class="app-pagination">
        {{ $payments->links() }}
    </nav>

@endsection
