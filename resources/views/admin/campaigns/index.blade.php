@extends('adminlte::page')

@section('title', 'Campaigns')

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-rocket mr-2 text-primary"></i>Campaigns</h1>
    <a href="{{ route('campaigns.create') }}" class="btn btn-primary">
        <i class="fas fa-plus mr-1"></i> New Campaign
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    @if(session('success'))
        <div class="alert alert-success alert-dismissible">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    <!-- Stats Cards -->
    <div class="row mb-4">
        <div class="col-md-4">
            <div class="info-box bg-primary">
                <span class="info-box-icon"><i class="fas fa-rocket"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Campaigns</span>
                    <span class="info-box-number">{{ $stats['total'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-check-circle"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Completed</span>
                    <span class="info-box-number">{{ $stats['completed'] }}</span>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="fas fa-spinner"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">In Progress</span>
                    <span class="info-box-number">{{ $stats['sending'] }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Campaigns Table -->
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title"><i class="fas fa-list mr-2"></i>All Campaigns</h3>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Channel</th>
                            <th>Status</th>
                            <th>Contacts</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($campaigns as $campaign)
                        <tr>
                            <td>
                                <strong>{{ $campaign->name }}</strong>
                            </td>
                            <td>
                                <span class="badge badge-{{ $campaign->channel_color }}">
                                    <i class="{{ $campaign->channel_icon }} mr-1"></i>
                                    {{ ucfirst($campaign->channel) }}
                                </span>
                            </td>
                            <td>
                                @if($campaign->status === 'completed')
                                    <span class="badge badge-success">Completed</span>
                                @elseif($campaign->status === 'sending')
                                    <span class="badge badge-warning">Sending</span>
                                @elseif($campaign->status === 'failed')
                                    <span class="badge badge-danger">Failed</span>
                                @else
                                    <span class="badge badge-secondary">Draft</span>
                                @endif
                            </td>
                            <td>{{ number_format($campaign->total_contacts) }}</td>
                            <td class="text-muted small">{{ $campaign->created_at->diffForHumans() }}</td>
                            <td>
                                <a href="{{ route('campaigns.show', $campaign) }}" class="btn btn-sm btn-info">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('campaigns.destroy', $campaign) }}" method="POST" class="d-inline">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Delete?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center py-4">
                                <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                                <p>No campaigns yet</p>
                                <a href="{{ route('campaigns.create') }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-plus mr-1"></i> Create First Campaign
                                </a>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-3">
                {{ $campaigns->links() }}
            </div>
        </div>
    </div>
</div>
@stop