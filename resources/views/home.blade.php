@extends('adminlte::page')

@section('title', 'Dashboard')

@push('css')
<!-- Custom Dashboard Styles -->
<style>
    .info-box {
        transition: all 0.3s ease;
        border-radius: 10px;
        overflow: hidden;
    }
    .info-box:hover {
        transform: translateY(-5px);
        box-shadow: 0 5px 15px rgba(0,0,0,0.1);
    }
    .info-box-icon {
        border-radius: 10px 0 0 10px;
    }
    .card {
        border-radius: 10px;
        border: none;
        box-shadow: 0 2px 10px rgba(0,0,0,0.05);
    }
    .card-header {
        border-radius: 10px 10px 0 0;
        font-weight: 600;
    }
    .progress-bar {
        border-radius: 10px;
    }
    .stat-card {
        transition: all 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 5px 20px rgba(0,0,0,0.1);
    }
    .channel-icon {
        width: 50px;
        height: 50px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 12px;
        font-size: 24px;
    }
    .activity-item {
        padding: 12px 0;
        border-bottom: 1px solid #eee;
        transition: all 0.2s ease;
    }
    .activity-item:hover {
        background-color: #f8f9fa;
        padding-left: 10px;
    }
    .activity-item:last-child {
        border-bottom: none;
    }
    .badge-glow {
        box-shadow: 0 0 10px currentColor;
    }
    .chart-container {
        position: relative;
        height: 300px;
    }
</style>
@endpush

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-tachometer-alt mr-2 text-primary"></i>Dashboard</h1>
    <div>
        <span class="text-muted small mr-3">
            <i class="fas fa-calendar mr-1"></i>{{ now()->format('l, F d, Y') }}
        </span>
        <a href="{{ route('profile.index') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-user mr-1"></i>My Profile
        </a>
    </div>
</div>
@stop

@section('content')
<div class="container-fluid">

    {{-- Welcome Message --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-info alert-dismissible fade show shadow-sm" role="alert">
                <i class="fas fa-info-circle mr-2"></i>
                <strong>Welcome back, {{ Auth::user()->name }}!</strong>
                You have <strong>{{ $pendingCampaigns ?? 0 }} pending campaigns</strong> and 
                <strong>{{ $unreadNotifications ?? 0 }} unread notifications</strong>.
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>

    {{-- Statistics Cards --}}
    <div class="row">
        <!-- Total Messages -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="info-box stat-card bg-gradient-primary">
                <span class="info-box-icon"><i class="fas fa-envelope"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Total Messages</span>
                    <span class="info-box-number">{{ number_format($totalMessages ?? 0) }}</span>
                    <div class="progress">
                        <div class="progress-bar bg-white" style="width: 70%"></div>
                    </div>
                    <span class="progress-description small">
                        <i class="fas fa-arrow-up mr-1"></i>15% this week
                    </span>
                </div>
            </div>
        </div>

        <!-- Email Sent -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="info-box stat-card bg-gradient-success">
                <span class="info-box-icon"><i class="fas fa-paper-plane"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Emails Sent</span>
                    <span class="info-box-number">{{ number_format($emailsSent ?? 0) }}</span>
                    <div class="progress">
                        <div class="progress-bar bg-white" style="width: 85%"></div>
                    </div>
                    <span class="progress-description small">
                        <i class="fas fa-arrow-up mr-1"></i>22% this week
                    </span>
                </div>
            </div>
        </div>

        <!-- SMS Sent -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="info-box stat-card bg-gradient-warning">
                <span class="info-box-icon"><i class="fas fa-sms"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">SMS Sent</span>
                    <span class="info-box-number">{{ number_format($smsSent ?? 0) }}</span>
                    <div class="progress">
                        <div class="progress-bar bg-white" style="width: 60%"></div>
                    </div>
                    <span class="progress-description small">
                        <i class="fas fa-arrow-down mr-1"></i>5% this week
                    </span>
                </div>
            </div>
        </div>

        <!-- WhatsApp Sent -->
        <div class="col-lg-3 col-md-6 mb-4">
            <div class="info-box stat-card bg-gradient-success">
                <span class="info-box-icon"><i class="fab fa-whatsapp"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">WhatsApp Sent</span>
                    <span class="info-box-number">{{ number_format($whatsappSent ?? 0) }}</span>
                    <div class="progress">
                        <div class="progress-bar bg-white" style="width: 45%"></div>
                    </div>
                    <span class="progress-description small">
                        <i class="fas fa-arrow-up mr-1"></i>30% this week
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Main Content Row --}}
    <div class="row">
        <!-- Campaign Overview Chart -->
        <div class="col-lg-8 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-chart-line mr-2 text-primary"></i>Campaign Performance</h5>
                    <select class="form-control form-control-sm" style="width: 150px;">
                        <option>Last 7 Days</option>
                        <option>Last 30 Days</option>
                        <option>Last 90 Days</option>
                    </select>
                </div>
                <div class="card-body">
                    <div class="chart-container">
                        <canvas id="campaignChart"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Channel Distribution -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-chart-pie mr-2 text-info"></i>Channel Distribution</h5>
                </div>
                <div class="card-body">
                    <div class="chart-container" style="height: 250px;">
                        <canvas id="channelChart"></canvas>
                    </div>
                    <div class="mt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-envelope text-primary mr-2"></i>Email</span>
                            <strong>{{ $emailPercentage ?? 45 }}%</strong>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span><i class="fas fa-sms text-warning mr-2"></i>SMS</span>
                            <strong>{{ $smsPercentage ?? 30 }}%</strong>
                        </div>
                        <div class="d-flex justify-content-between">
                            <span><i class="fab fa-whatsapp text-success mr-2"></i>WhatsApp</span>
                            <strong>{{ $whatsappPercentage ?? 25 }}%</strong>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Second Row --}}
    <div class="row">
        <!-- Recent Campaigns -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-rocket mr-2 text-success"></i>Recent Campaigns</h5>
                    <a href="#" class="btn btn-sm btn-outline-primary">View All</a>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Campaign Name</th>
                                    <th>Channel</th>
                                    <th>Status</th>
                                    <th>Sent</th>
                                    <th>Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($recentCampaigns ?? [] as $campaign)
                                <tr>
                                    <td>
                                        <strong>{{ Str::limit($campaign->name, 30) }}</strong>
                                    </td>
                                    <td>
                                        @if($campaign->channel === 'email')
                                            <span class="badge badge-primary"><i class="fas fa-envelope mr-1"></i>Email</span>
                                        @elseif($campaign->channel === 'sms')
                                            <span class="badge badge-warning"><i class="fas fa-sms mr-1"></i>SMS</span>
                                        @elseif($campaign->channel === 'whatsapp')
                                            <span class="badge badge-success"><i class="fab fa-whatsapp mr-1"></i>WhatsApp</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if($campaign->status === 'completed')
                                            <span class="badge badge-success">Completed</span>
                                        @elseif($campaign->status === 'pending')
                                            <span class="badge badge-warning">Pending</span>
                                        @elseif($campaign->status === 'failed')
                                            <span class="badge badge-danger">Failed</span>
                                        @else
                                            <span class="badge badge-info">Running</span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($campaign->sent_count ?? 0) }}</td>
                                    <td class="text-muted small">{{ $campaign->created_at->diffForHumans() }}</td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="5" class="text-center text-muted py-4">
                                        <i class="fas fa-inbox fa-3x mb-3"></i>
                                        <p>No campaigns yet</p>
                                        <a href="#" class="btn btn-sm btn-primary">
                                            <i class="fas fa-plus mr-1"></i>Create Campaign
                                        </a>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Activity -->
        <div class="col-lg-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-history mr-2 text-info"></i>Recent Activity</h5>
                </div>
                <div class="card-body p-0">
                    <div class="p-3">
                        @forelse($recentActivities ?? [] as $activity)
                        <div class="activity-item d-flex align-items-start">
                            <div class="mr-3">
                                @if($activity->type === 'campaign')
                                    <span class="channel-icon bg-primary text-white">
                                        <i class="fas fa-rocket"></i>
                                    </span>
                                @elseif($activity->type === 'message')
                                    <span class="channel-icon bg-success text-white">
                                        <i class="fas fa-envelope"></i>
                                    </span>
                                @elseif($activity->type === 'user')
                                    <span class="channel-icon bg-info text-white">
                                        <i class="fas fa-user"></i>
                                    </span>
                                @else
                                    <span class="channel-icon bg-secondary text-white">
                                        <i class="fas fa-bell"></i>
                                    </span>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <p class="mb-1">{{ $activity->description }}</p>
                                <small class="text-muted">
                                    <i class="fas fa-clock mr-1"></i>{{ $activity->created_at->diffForHumans() }}
                                </small>
                            </div>
                        </div>
                        @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-history fa-3x mb-3"></i>
                            <p>No recent activity</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Quick Actions & System Health --}}
    <div class="row">
        <!-- Quick Actions -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-bolt mr-2 text-warning"></i>Quick Actions</h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="#" class="btn btn-primary">
                            <i class="fas fa-plus mr-2"></i>New Campaign
                        </a>
                        <a href="#" class="btn btn-success">
                            <i class="fas fa-paper-plane mr-2"></i>Send Message
                        </a>
                        <a href="#" class="btn btn-info">
                            <i class="fas fa-users mr-2"></i>Manage Contacts
                        </a>
                        <a href="#" class="btn btn-secondary">
                            <i class="fas fa-user-cog mr-2"></i>Profile Settings
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- System Health -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white">
                    <h5 class="mb-0"><i class="fas fa-heartbeat mr-2 text-danger"></i>System Health</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-server mr-2"></i>Server Status</span>
                            <span class="badge badge-success">Online</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-database mr-2"></i>Database</span>
                            <span class="badge badge-success">Connected</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-envelope mr-2"></i>SMTP Service</span>
                            <span class="badge badge-success">Active</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 95%"></div>
                        </div>
                    </div>
                    <div class="mb-3">
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fas fa-sms mr-2"></i>SMS Gateway</span>
                            <span class="badge badge-warning">Limited</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-warning" style="width: 70%"></div>
                        </div>
                    </div>
                    <div>
                        <div class="d-flex justify-content-between mb-1">
                            <span><i class="fab fa-whatsapp mr-2"></i>WhatsApp API</span>
                            <span class="badge badge-success">Connected</span>
                        </div>
                        <div class="progress" style="height: 6px;">
                            <div class="progress-bar bg-success" style="width: 100%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Notifications -->
        <div class="col-lg-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0"><i class="fas fa-bell mr-2 text-primary"></i>Notifications</h5>
                    <span class="badge badge-danger badge-glow">{{ $unreadNotifications ?? 0 }}</span>
                </div>
                <div class="card-body p-0">
                    <div class="list-group list-group-flush">
                        @forelse($notifications ?? [] as $notification)
                        <a href="#" class="list-group-item list-group-item-action {{ $notification->unread ? 'bg-light' : '' }}">
                            <div class="d-flex w-100 justify-content-between">
                                <h6 class="mb-1">{{ $notification->title }}</h6>
                                @if($notification->unread)
                                    <span class="badge badge-danger badge-sm">New</span>
                                @endif
                            </div>
                            <p class="mb-1 small text-muted">{{ Str::limit($notification->message, 50) }}</p>
                            <small class="text-muted">{{ $notification->created_at->diffForHumans() }}</small>
                        </a>
                        @empty
                        <div class="text-center text-muted py-4">
                            <i class="fas fa-bell-slash fa-3x mb-3"></i>
                            <p>No new notifications</p>
                        </div>
                        @endforelse
                    </div>
                    @if(count($notifications ?? []) > 0)
                    <div class="card-footer bg-white text-center">
                        <a href="#" class="text-primary small">View All Notifications</a>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

</div>
@stop

@push('js')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@3.9.1/dist/chart.min.js"></script>

<script>
$(function() {
    // Campaign Performance Chart
    const campaignCtx = document.getElementById('campaignChart').getContext('2d');
    new Chart(campaignCtx, {
        type: 'line',
        data: {
            labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'],
            datasets: [{
                label: 'Emails',
                data: [120, 190, 150, 220, 180, 250, 200],
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'SMS',
                data: [80, 120, 100, 150, 130, 170, 140],
                borderColor: '#ffc107',
                backgroundColor: 'rgba(255, 193, 7, 0.1)',
                tension: 0.4,
                fill: true
            }, {
                label: 'WhatsApp',
                data: [50, 80, 70, 100, 90, 120, 110],
                borderColor: '#28a745',
                backgroundColor: 'rgba(40, 167, 69, 0.1)',
                tension: 0.4,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'top'
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Channel Distribution Chart
    const channelCtx = document.getElementById('channelChart').getContext('2d');
    new Chart(channelCtx, {
        type: 'doughnut',
        data: {
            labels: ['Email', 'SMS', 'WhatsApp'],
            datasets: [{
                data: [{{ $emailPercentage ?? 45 }}, {{ $smsPercentage ?? 30 }}, {{ $whatsappPercentage ?? 25 }}],
                backgroundColor: [
                    '#007bff',
                    '#ffc107',
                    '#28a745'
                ],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: true,
                    position: 'bottom'
                }
            },
            cutout: '70%'
        }
    });

    // Tooltip for info boxes
    $('.info-box').tooltip({
        title: 'Click for details',
        placement: 'top',
        trigger: 'hover'
    });
});
</script>
@endpush