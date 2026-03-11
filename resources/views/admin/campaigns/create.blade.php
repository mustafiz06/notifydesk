@extends('adminlte::page')

@section('title', 'Create Campaign')

@section('content_header')
<h1><i class="fas fa-plus-circle mr-2 text-success"></i>Create Campaign</h1>
@stop

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <form action="{{ route('campaigns.store') }}" method="POST">
                    @csrf
                    <div class="card-body">
                        <!-- Campaign Name -->
                        <div class="form-group">
                            <label>Campaign Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control @error('name') is-invalid @enderror" 
                                   value="{{ old('name') }}" placeholder="e.g., Summer Sale 2026" required>
                            @error('name') <span class="invalid-feedback">{{ $message }}</span> @enderror
                        </div>

                        <!-- Channel Selection -->
                        <div class="form-group">
                            <label>Channel <span class="text-danger">*</span></label>
                            <div class="row">
                                <div class="col-md-4">
                                    <label class="d-block">
                                        <input type="radio" name="channel" value="email" {{ old('channel') === 'email' ? 'checked' : '' }} required>
                                        <i class="fas fa-envelope text-primary mr-1"></i> Email
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="d-block">
                                        <input type="radio" name="channel" value="sms" {{ old('channel') === 'sms' ? 'checked' : '' }}>
                                        <i class="fas fa-sms text-warning mr-1"></i> SMS
                                    </label>
                                </div>
                                <div class="col-md-4">
                                    <label class="d-block">
                                        <input type="radio" name="channel" value="whatsapp" {{ old('channel') === 'whatsapp' ? 'checked' : '' }}>
                                        <i class="fab fa-whatsapp text-success mr-1"></i> WhatsApp
                                    </label>
                                </div>
                            </div>
                            @error('channel') <span class="text-danger small">{{ $message }}</span> @enderror
                        </div>

                        <!-- Subject (Email Only) -->
                        <div class="form-group" id="subjectField">
                            <label>Email Subject</label>
                            <input type="text" name="subject" class="form-control" value="{{ old('subject') }}" placeholder="Email subject line">
                        </div>

                        <!-- Message -->
                        <div class="form-group">
                            <label>Message <span class="text-danger">*</span></label>
                            <textarea name="message" class="form-control @error('message') is-invalid @enderror" 
                                      rows="5" placeholder="Write your message here..." required>{{ old('message') }}</textarea>
                            @error('message') <span class="invalid-feedback">{{ $message }}</span> @enderror
                            <small class="text-muted">Use {'{'}name{'}'} to personalize with contact name</small>
                        </div>

                        <!-- Target Audience -->
                        <div class="form-group">
                            <label>Send To <span class="text-danger">*</span></label>
                            <select name="contact_type" id="contactType" class="form-control" required>
                                <option value="all">All Contacts</option>
                                <option value="group">Specific Group</option>
                                <option value="specific">Specific Contacts</option>
                            </select>
                        </div>

                        <!-- Group Selection -->
                        <div class="form-group" id="groupField" style="display: none;">
                            <label>Select Group</label>
                            <select name="group" class="form-control">
                                <option value="">Choose group...</option>
                                @foreach($groups as $group)
                                    <option value="{{ $group }}">{{ $group }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Contacts Selection -->
                        <div class="form-group" id="contactsField" style="display: none;">
                            <label>Select Contacts</label>
                            <select name="contacts[]" class="form-control" multiple size="5">
                                @foreach($contacts as $contact)
                                    <option value="{{ $contact->id }}">{{ $contact->name }} ({{ $contact->phone ?? $contact->email }})</option>
                                @endforeach
                            </select>
                            <small class="text-muted">Hold Ctrl/Cmd to select multiple</small>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save mr-1"></i> Create Campaign
                        </button>
                        <a href="{{ route('campaigns.index') }}" class="btn btn-secondary">Cancel</a>
                    </div>
                </form>
            </div>
        </div>

        <!-- Preview Card -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header bg-info">
                    <h5 class="mb-0"><i class="fas fa-eye mr-2"></i>Preview</h5>
                </div>
                <div class="card-body">
                    <div class="alert alert-light border">
                        <strong>Subject:</strong> <span id="previewSubject">-</span>
                    </div>
                    <div class="alert alert-light border">
                        <strong>Message:</strong>
                        <p id="previewMessage" class="mt-2 text-muted">Your message will appear here...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@stop

@push('js')
<script>
$(function() {
    // Show/hide fields based on contact type
    $('#contactType').change(function() {
        $('#groupField, #contactsField').hide();
        if ($(this).val() === 'group') $('#groupField').show();
        if ($(this).val() === 'specific') $('#contactsField').show();
    });

    // Live preview
    $('input[name="subject"], textarea[name="message"]').on('input', function() {
        $('#previewSubject').text($('input[name="subject"]').val() || '-');
        $('#previewMessage').text($('textarea[name="message"]').val() || 'Your message will appear here...');
    });
});
</script>
@endpush