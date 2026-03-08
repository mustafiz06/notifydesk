@extends('adminlte::page')

@section('title', 'My Profile')

@push('css')
<!-- iCheck for beautiful checkboxes -->
<link rel="stylesheet" href="{{ asset('vendor/icheck-bootstrap/icheck-bootstrap.min.css') }}">
<!-- Custom profile styles -->
<style>
    .profile-user-img {
        transition: all 0.3s ease;
        border: 3px solid #fff;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .profile-user-img:hover {
        transform: scale(1.02);
        box-shadow: 0 4px 8px rgba(0,0,0,0.15);
    }
    .tab-pane {
        animation: fadeIn 0.3s ease;
    }
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
    .password-strength {
        height: 4px;
        border-radius: 2px;
        transition: width 0.3s ease, background-color 0.3s ease;
    }
    .strength-weak { background-color: #dc3545; }
    .strength-fair { background-color: #fd7e14; }
    .strength-good { background-color: #28a745; }
    .strength-strong { background-color: #20c997; }
</style>
@endpush

@section('content_header')
<div class="d-flex justify-content-between align-items-center">
    <h1><i class="fas fa-user-circle mr-2 text-primary"></i>My Profile</h1>
    <a href="{{ route('home') }}" class="btn btn-default btn-sm">
        <i class="fas fa-arrow-left mr-1"></i> Back to Dashboard
    </a>
</div>
@stop

@section('content')
<div class="container-fluid">
    
    {{-- Success Message --}}
    @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-check-circle mr-2"></i>{{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    {{-- Error Messages --}}
    @if($errors->any())
        <div class="alert alert-danger alert-dismissible fade show shadow-sm" role="alert">
            <i class="fas fa-exclamation-circle mr-2"></i>
            <ul class="mb-0 pl-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif

    <div class="row">
        <!-- Profile Sidebar -->
        <div class="col-lg-4 col-md-5">
            <div class="card card-primary card-outline shadow-sm">
                <div class="card-body box-profile">
                    <div class="text-center position-relative">
                        <!-- Avatar with Edit Overlay -->
                        <div class="avatar-wrapper position-relative d-inline-block">
                            <img class="profile-user-img img-fluid img-circle elevation-2"
                                 src="{{ $user->avatar_path ? asset('storage/'.$user->avatar_path) : asset('vendor/adminlte/dist/img/user2-160x160.jpg') }}"
                                 alt="User profile picture"
                                 style="width: 130px; height: 130px; object-fit: cover;">
                            <label for="avatarInput" class="position-absolute bottom-0 right-0 bg-primary text-white rounded-circle p-2" 
                                   style="cursor: pointer; bottom: 5px; right: 15px;" title="Change photo">
                                <i class="fas fa-camera" style="font-size: 12px;"></i>
                            </label>
                        </div>
                    </div>

                    <!-- Hidden File Input for Avatar -->
                    <form action="{{ route('profile.avatar.update') }}" method="POST" enctype="multipart/form-data" class="d-none">
                        @csrf
                        <input type="file" name="avatar" id="avatarInput" accept="image/jpeg,image/png,image/jpg,image/webp" hidden>
                    </form>

                    <h3 class="profile-username text-center mt-3 font-weight-bold">{{ $user->name }}</h3>
                    <p class="text-muted text-center small">{{ $user->email }}</p>
                    
                    @if($user->company)
                        <p class="text-center text-sm mb-1">
                            <i class="fas fa-building mr-1 text-gray-400"></i> 
                            <span class="text-secondary">{{ $user->company }}</span>
                        </p>
                    @endif
                    
                    @if($user->phone)
                        <p class="text-center text-sm mb-3">
                            <i class="fas fa-phone mr-1 text-gray-400"></i> 
                            <span class="text-secondary">{{ $user->phone }}</span>
                        </p>
                    @endif

                    <!-- Account Status Badge -->
                    <div class="mt-4 pt-3 border-top text-center">
                        @if($user->email_verified_at)
                            <span class="badge badge-success px-3 py-2">
                                <i class="fas fa-check-circle mr-1"></i> Email Verified
                            </span>
                        @else
                            <span class="badge badge-warning px-3 py-2">
                                <i class="fas fa-exclamation-circle mr-1"></i> Email Unverified
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Account Info Card -->
            <div class="card card-secondary shadow-sm">
                <div class="card-header">
                    <h3 class="card-title"><i class="fas fa-info-circle mr-2"></i>Account Information</h3>
                </div>
                <div class="card-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-envelope text-muted mr-2" style="width: 20px;"></i>Email</span>
                            <strong class="text-right">{{ Str::limit($user->email, 25) }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-phone text-muted mr-2" style="width: 20px;"></i>Phone</span>
                            <strong class="text-right">{{ $user->phone ?? 'Not set' }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-calendar-alt text-muted mr-2" style="width: 20px;"></i>Joined</span>
                            <strong class="text-right">{{ $user->created_at->format('M d, Y') }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-sign-in-alt text-muted mr-2" style="width: 20px;"></i>Last Login</span>
                            <strong class="text-right">{{ $user->last_login_at?->format('M d, h:i A') ?? 'First login' }}</strong>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center px-0">
                            <span><i class="fas fa-shield-alt text-muted mr-2" style="width: 20px;"></i>Role</span>
                            <span class="badge badge-info">{{ ucfirst($user->role ?? 'user') }}</span>
                        </li>
                    </ul>
                </div>
                <div class="card-footer bg-transparent">
                    <small class="text-muted">
                        <i class="fas fa-lock mr-1"></i> Your data is encrypted and secure
                    </small>
                </div>
            </div>
        </div>

        <!-- Profile Tabs -->
        <div class="col-lg-8 col-md-7">
            <div class="card shadow-sm">
                <div class="card-header p-0 border-bottom-0">
                    <ul class="nav nav-pills ml-auto p-2" id="profileTab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link active" id="overview-tab" data-toggle="pill" href="#overview" role="tab" aria-controls="overview" aria-selected="true">
                                <i class="fas fa-user mr-1"></i> Overview
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="edit-tab" data-toggle="pill" href="#edit" role="tab" aria-controls="edit" aria-selected="false">
                                <i class="fas fa-edit mr-1"></i> Edit Profile
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="password-tab" data-toggle="pill" href="#password" role="tab" aria-controls="password" aria-selected="false">
                                <i class="fas fa-key mr-1"></i> Security
                            </a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link" id="notifications-tab" data-toggle="pill" href="#notifications" role="tab" aria-controls="notifications" aria-selected="false">
                                <i class="fas fa-bell mr-1"></i> Notifications
                            </a>
                        </li>
                    </ul>
                </div>
                <div class="card-body">
                    <div class="tab-content" id="profileTabContent">
                        
                        <!-- Overview Tab -->
                        <div class="tab-pane fade show active" id="overview" role="tabpanel" aria-labelledby="overview-tab">
                            <div class="table-responsive">
                                <table class="table table-borderless table-hover">
                                    <tbody>
                                        <tr>
                                            <th class="text-muted font-weight-normal" style="width: 160px;">Full Name</th>
                                            <td class="font-weight-medium">{{ $user->name }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted font-weight-normal">Email Address</th>
                                            <td>
                                                {{ $user->email }}
                                                @if($user->email_verified_at)
                                                    <span class="badge badge-success ml-2"><i class="fas fa-check"></i> Verified</span>
                                                @endif
                                            </td>
                                        </tr>
                                        @if($user->phone)
                                        <tr>
                                            <th class="text-muted font-weight-normal">Phone Number</th>
                                            <td>{{ $user->phone }}</td>
                                        </tr>
                                        @endif
                                        @if($user->company)
                                        <tr>
                                            <th class="text-muted font-weight-normal">Company</th>
                                            <td>{{ $user->company }}</td>
                                        </tr>
                                        @endif
                                        @if($user->bio)
                                        <tr>
                                            <th class="text-muted font-weight-normal align-top">Bio</th>
                                            <td class="text-muted">{{ $user->bio }}</td>
                                        </tr>
                                        @endif
                                        <tr>
                                            <th class="text-muted font-weight-normal">Member Since</th>
                                            <td>{{ $user->created_at->format('F d, Y \a\t h:i A') }}</td>
                                        </tr>
                                        <tr>
                                            <th class="text-muted font-weight-normal">Last Activity</th>
                                            <td>{{ $user->last_login_at?->diffForHumans() ?? 'Never' }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                            
                            <div class="mt-4 pt-3 border-top">
                                <h6 class="text-muted mb-3"><i class="fas fa-cog mr-2"></i>Quick Actions</h6>
                                <div class="btn-group btn-group-sm" role="group">
                                    <a href="#edit" data-toggle="tab" class="btn btn-outline-primary">
                                        <i class="fas fa-edit mr-1"></i> Edit Info
                                    </a>
                                    <a href="#password" data-toggle="tab" class="btn btn-outline-warning">
                                        <i class="fas fa-key mr-1"></i> Update Password
                                    </a>
                                    <a href="#notifications" data-toggle="tab" class="btn btn-outline-success">
                                        <i class="fas fa-bell mr-1"></i> Preferences
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- Edit Profile Tab -->
                        <div class="tab-pane fade" id="edit" role="tabpanel" aria-labelledby="edit-tab">
                            <form action="{{ route('profile.update') }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                
                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label font-weight-medium">Full Name <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                               value="{{ old('name', $user->name) }}" required 
                                               placeholder="Enter your full name">
                                        @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        <small class="text-muted">Visible to other users and in notifications</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label font-weight-medium">Email Address <span class="text-danger">*</span></label>
                                    <div class="col-sm-9">
                                        <input type="email" name="email" class="form-control @error('email') is-invalid @enderror" 
                                               value="{{ old('email', $user->email) }}" required 
                                               placeholder="your@email.com">
                                        @error('email') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        <small class="text-muted">Used for login and email notifications</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label font-weight-medium">Phone Number</label>
                                    <div class="col-sm-9">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <span class="input-group-text">+88</span>
                                            </div>
                                            <input type="tel" name="phone" class="form-control @error('phone') is-invalid @enderror" 
                                                   value="{{ old('phone', $user->phone ? preg_replace('/^\+88/', '', $user->phone) : '') }}" 
                                                   placeholder="17XXXXXXXX" maxlength="11" pattern="[0-9]{11}">
                                        </div>
                                        @error('phone') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        <small class="text-muted">Required for SMS & WhatsApp notifications</small>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label font-weight-medium">Company/Organization</label>
                                    <div class="col-sm-9">
                                        <input type="text" name="company" class="form-control @error('company') is-invalid @enderror" 
                                               value="{{ old('company', $user->company) }}" 
                                               placeholder="Your company name">
                                        @error('company') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-3 col-form-label font-weight-medium">Bio</label>
                                    <div class="col-sm-9">
                                        <textarea name="bio" class="form-control @error('bio') is-invalid @enderror" 
                                                  rows="3" maxlength="500" 
                                                  placeholder="Tell us about yourself or your business...">{{ old('bio', $user->bio) }}</textarea>
                                        @error('bio') <span class="invalid-feedback">{{ $message }}</span> @enderror
                                        <small class="text-muted d-block text-right">{{ strlen(old('bio', $user->bio) ?? '') }}/500 characters</small>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="offset-sm-3 col-sm-9">
                                        <button type="submit" class="btn btn-primary px-4">
                                            <i class="fas fa-save mr-1"></i> Save Changes
                                        </button>
                                        <button type="reset" class="btn btn-outline-secondary ml-2">
                                            <i class="fas fa-undo mr-1"></i> Reset
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Change Password Tab -->
                        <div class="tab-pane fade" id="password" role="tabpanel" aria-labelledby="password-tab">
                            <form action="{{ route('profile.password.update') }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle mr-2"></i>
                                    <strong>Password Requirements:</strong> Minimum 8 characters, including uppercase, lowercase, number, and symbol.
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label font-weight-medium">Current Password <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="password" name="current_password" 
                                                   class="form-control @error('current_password') is-invalid @enderror" 
                                                   required placeholder="Enter current password" id="currentPassword">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="currentPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('current_password') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label font-weight-medium">New Password <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="password" name="password" 
                                                   class="form-control @error('password') is-invalid @enderror" 
                                                   required placeholder="Enter new password" id="newPassword" minlength="8">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="newPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        @error('password') <span class="invalid-feedback d-block">{{ $message }}</span> @enderror
                                        
                                        <!-- Password Strength Meter -->
                                        <div class="mt-2">
                                            <div class="d-flex justify-content-between mb-1">
                                                <small class="text-muted">Strength:</small>
                                                <small id="strengthLabel" class="text-muted">Enter password</small>
                                            </div>
                                            <div class="progress" style="height: 4px;">
                                                <div id="strengthBar" class="progress-bar" role="progressbar" style="width: 0%"></div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row">
                                    <label class="col-sm-4 col-form-label font-weight-medium">Confirm New Password <span class="text-danger">*</span></label>
                                    <div class="col-sm-8">
                                        <div class="input-group">
                                            <input type="password" name="password_confirmation" 
                                                   class="form-control" required placeholder="Confirm new password" id="confirmPassword">
                                            <div class="input-group-append">
                                                <button class="btn btn-outline-secondary toggle-password" type="button" data-target="confirmPassword">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <small class="text-muted">Re-enter your new password to confirm</small>
                                    </div>
                                </div>

                                <div class="form-group row mb-0">
                                    <div class="offset-sm-4 col-sm-8">
                                        <button type="submit" class="btn btn-warning px-4">
                                            <i class="fas fa-key mr-1"></i> Update Password
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                        <!-- Notifications Tab -->
                        <div class="tab-pane fade" id="notifications" role="tabpanel" aria-labelledby="notifications-tab">
                            <form action="{{ route('profile.notifications.update') }}" method="POST" class="form-horizontal">
                                @csrf
                                @method('PUT')
                                
                                <h6 class="text-muted mb-3 pb-2 border-bottom">
                                    <i class="fas fa-bell mr-2"></i>Notification Channels
                                </h6>
                                
                                <!-- Email Notifications -->
                                <div class="form-group row py-2">
                                    <label class="col-sm-4 col-form-label font-weight-medium">
                                        <i class="fas fa-envelope text-primary mr-2"></i>Email Notifications
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="email_notif" name="email_notifications" value="1"
                                                   {{ ($user->preferences['email_notifications'] ?? true) ? 'checked' : '' }}>
                                            <label for="email_notif" class="font-weight-normal">
                                                Receive campaign reports, alerts & system updates via email
                                            </label>
                                        </div>
                                        <p class="text-muted small mb-0 mt-1">Sent to: <strong>{{ $user->email }}</strong></p>
                                    </div>
                                </div>

                                <!-- SMS Notifications -->
                                <div class="form-group row py-2">
                                    <label class="col-sm-4 col-form-label font-weight-medium">
                                        <i class="fas fa-sms text-success mr-2"></i>SMS Notifications
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="sms_notif" name="sms_notifications" value="1"
                                                   {{ ($user->preferences['sms_notifications'] ?? false) ? 'checked' : '' }}
                                                   {{ !$user->phone ? 'disabled' : '' }}>
                                            <label for="sms_notif" class="font-weight-normal">
                                                Get SMS alerts for critical events & campaign status
                                            </label>
                                        </div>
                                        @if(!$user->phone)
                                            <p class="text-warning small mb-0 mt-1">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                <a href="#edit" data-toggle="tab">Add phone number</a> to enable SMS notifications
                                            </p>
                                        @else
                                            <p class="text-muted small mb-0 mt-1">Sent to: <strong>{{ $user->phone }}</strong></p>
                                        @endif
                                    </div>
                                </div>

                                <!-- WhatsApp Notifications -->
                                <div class="form-group row py-2">
                                    <label class="col-sm-4 col-form-label font-weight-medium">
                                        <i class="fab fa-whatsapp text-success mr-2"></i>WhatsApp Notifications
                                    </label>
                                    <div class="col-sm-8">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="wa_notif" name="whatsapp_notifications" value="1"
                                                   {{ ($user->preferences['whatsapp_notifications'] ?? false) ? 'checked' : '' }}
                                                   {{ !$user->phone ? 'disabled' : '' }}>
                                            <label for="wa_notif" class="font-weight-normal">
                                                Receive notifications via WhatsApp Business API
                                            </label>
                                        </div>
                                        @if(!$user->phone)
                                            <p class="text-warning small mb-0 mt-1">
                                                <i class="fas fa-exclamation-triangle mr-1"></i>
                                                <a href="#edit" data-toggle="tab">Add phone number</a> to enable WhatsApp
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <hr class="my-4">

                                <h6 class="text-muted mb-3 pb-2 border-bottom">
                                    <i class="fas fa-cog mr-2"></i>Alert Preferences
                                </h6>

                                <!-- Campaign Alerts -->
                                <div class="form-group row py-2">
                                    <label class="col-sm-4 col-form-label font-weight-medium">Campaign Alerts</label>
                                    <div class="col-sm-8">
                                        <div class="icheck-primary d-inline mr-4">
                                            <input type="checkbox" id="campaign_start" name="campaign_alerts" value="1"
                                                   {{ ($user->preferences['campaign_alerts'] ?? true) ? 'checked' : '' }}>
                                            <label for="campaign_start" class="font-weight-normal">
                                                Campaign start, completion & error alerts
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bulk Report Frequency -->
                                <div class="form-group row py-2">
                                    <label class="col-sm-4 col-form-label font-weight-medium">Bulk Report Frequency</label>
                                    <div class="col-sm-8">
                                        <select name="bulk_report_frequency" class="form-control form-control-sm w-auto d-inline-block" style="max-width: 200px;">
                                            <option value="daily" {{ ($user->preferences['bulk_report_frequency'] ?? 'daily') == 'daily' ? 'selected' : '' }}>Daily</option>
                                            <option value="weekly" {{ ($user->preferences['bulk_report_frequency'] ?? 'daily') == 'weekly' ? 'selected' : '' }}>Weekly</option>
                                            <option value="monthly" {{ ($user->preferences['bulk_report_frequency'] ?? 'daily') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                                            <option value="never" {{ ($user->preferences['bulk_report_frequency'] ?? 'daily') == 'never' ? 'selected' : '' }}>Never</option>
                                        </select>
                                        <small class="text-muted ml-2">How often to receive bulk messaging reports</small>
                                    </div>
                                </div>

                                <!-- System Updates -->
                                <div class="form-group row py-2">
                                    <label class="col-sm-4 col-form-label font-weight-medium">System Updates</label>
                                    <div class="col-sm-8">
                                        <div class="icheck-primary d-inline">
                                            <input type="checkbox" id="system_updates" name="system_updates" value="1"
                                                   {{ ($user->preferences['system_updates'] ?? true) ? 'checked' : '' }}>
                                            <label for="system_updates" class="font-weight-normal">
                                                Product updates, maintenance notices & security alerts
                                            </label>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group row mb-0 mt-4">
                                    <div class="offset-sm-4 col-sm-8">
                                        <button type="submit" class="btn btn-success px-4">
                                            <i class="fas fa-bell mr-1"></i> Save Preferences
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
<!-- iCheck for beautiful checkboxes -->
<script src="{{ asset('vendor/icheck/icheck.min.js') }}"></script>

<script>
$(function() {
    // Initialize iCheck for checkboxes
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_minimal-blue',
        increaseArea: '20%'
    });

    // Avatar preview & auto-submit
    const avatarInput = document.getElementById('avatarInput');
    const avatarImg = document.querySelector('.profile-user-img');
    
    avatarInput?.addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const file = e.target.files[0];
            
            // Validate file type
            const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/webp'];
            if (!validTypes.includes(file.type)) {
                alert('Please select a valid image file (JPG, PNG, or WebP)');
                avatarInput.value = '';
                return;
            }
            
            // Validate file size (2MB max)
            if (file.size > 2 * 1024 * 1024) {
                alert('Image size must be less than 2MB');
                avatarInput.value = '';
                return;
            }
            
            // Preview image
            const reader = new FileReader();
            reader.onload = function(e) {
                avatarImg.src = e.target.result;
            }
            reader.readAsDataURL(file);
            
            // Auto-submit form
            avatarInput.closest('form').submit();
        }
    });

    // Password strength meter
    const newPassword = document.getElementById('newPassword');
    const strengthBar = document.getElementById('strengthBar');
    const strengthLabel = document.getElementById('strengthLabel');
    
    newPassword?.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        
        if (password.length >= 8) strength++;
        if (password.match(/[a-z]/)) strength++;
        if (password.match(/[A-Z]/)) strength++;
        if (password.match(/[0-9]/)) strength++;
        if (password.match(/[^a-zA-Z0-9]/)) strength++;
        
        const labels = ['Very Weak', 'Weak', 'Fair', 'Good', 'Strong'];
        const widths = ['20%', '40%', '60%', '80%', '100%'];
        
        if (password.length === 0) {
            strengthBar.style.width = '0%';
            strengthLabel.textContent = 'Enter password';
            strengthLabel.className = 'text-muted';
        } else {
            const index = Math.min(strength, 4);
            strengthBar.style.width = widths[index];
            strengthBar.className = `progress-bar strength-${labels[index].toLowerCase()}`;
            strengthLabel.textContent = labels[index];
            strengthLabel.className = `text-${index <= 1 ? 'danger' : index === 2 ? 'warning' : 'success'}`;
        }
    });

    // Toggle password visibility
    document.querySelectorAll('.toggle-password').forEach(button => {
        button.addEventListener('click', function() {
            const targetId = this.getAttribute('data-target');
            const input = document.getElementById(targetId);
            const icon = this.querySelector('i');
            
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                input.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        });
    });

    // Auto-hide alerts after 5 seconds
    setTimeout(() => {
        document.querySelectorAll('.alert').forEach(alert => {
            $(alert).fadeOut();
        });
    }, 5000);

    // Character counter for bio
    const bioInput = document.querySelector('textarea[name="bio"]');
    const bioCounter = bioInput?.closest('.form-group')?.querySelector('.text-right small');
    
    bioInput?.addEventListener('input', function() {
        if (bioCounter) {
            bioCounter.textContent = `${this.value.length}/500 characters`;
        }
    });
});
</script>
@endpush