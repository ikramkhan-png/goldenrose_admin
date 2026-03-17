@extends('admin.layouts.app')

@section('content')
@php $isAr = app()->getLocale() === 'ar'; @endphp
<div dir="{{ $isAr ? 'rtl' : 'ltr' }}">

    <div class="d-flex justify-content-between align-items-start mb-4">
        <div>
            <h4 class="page-title">{{ __('admin.my_profile') }}</h4>
            <p class="page-subtitle">{{ __('admin.profile_subtitle') }}</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-cancel">
            <i class="fas fa-arrow-left me-1"></i>{{ __('admin.back_to_dashboard') }}
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card mb-4">
                <div class="card-body p-0">
                    {{-- Profile Banner --}}
                    <div style="background: #1a2535; padding: 28px 28px 20px; border-radius: 11px 11px 0 0;">
                        <div class="d-flex align-items-center gap-4">
                            <div style="width:72px;height:72px;border-radius:50%;background:#4f46e5;display:flex;align-items:center;justify-content:center;font-size:28px;color:white;font-weight:700;flex-shrink:0;">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div style="font-size:20px;font-weight:700;color:#f1f5f9;">{{ $user->name }}</div>
                                <div style="font-size:13px;color:#94a3b8;">{{ $user->email }}</div>
                                <div class="mt-1">
                                    <span class="badge" style="background: rgba(79,70,229,0.2); color: #a78bfa; font-size: 11px; padding: 3px 10px; border-radius: 20px;">
                                        {{ ucfirst($user->type ?? 'user') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Profile Details --}}
                    <div class="p-4">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('admin.full_name') }}</label>
                                <div style="font-size: 15px; font-weight: 600; color: #1e293b;">{{ $user->name }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('admin.email_address') }}</label>
                                <div style="font-size: 15px; font-weight: 600; color: #1e293b;">{{ $user->email }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('admin.user_type') }}</label>
                                <div style="font-size: 15px; font-weight: 600; color: #1e293b;">{{ ucfirst($user->type ?? 'user') }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('admin.member_since') }}</label>
                                <div style="font-size: 15px; font-weight: 600; color: #1e293b;">{{ $user->created_at->format('M d, Y') }}</div>
                            </div>
                        </div>

                        @if ($user->roles && $user->roles->count() > 0)
                            <div class="mb-3">
                                <label class="form-label" style="color: #94a3b8; font-size: 11px; text-transform: uppercase; letter-spacing: 0.5px;">{{ __('admin.assigned_roles') }}</label>
                                <div class="d-flex flex-wrap gap-2 mt-1">
                                    @foreach ($user->roles as $role)
                                        <span class="badge" style="background: #f5f3ff; color: #4f46e5; font-size: 12px; padding: 5px 12px; border-radius: 20px; font-weight: 600;">
                                            <i class="fas fa-shield-alt me-1"></i>{{ ucfirst($role->name) }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="info-box mt-2">
                            <i class="fas fa-info-circle me-2"></i>
                            <strong>{{ __('admin.note') }}:</strong>
                            {{ __('admin.profile_update_note') }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card mb-3">
                <div class="card-body p-4">
                    <div style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fas fa-circle-check me-2" style="color: #4f46e5;"></i>{{ __('admin.account_status') }}
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <span class="td-muted" style="font-size: 13px;">{{ __('admin.status') }}</span>
                        <span class="badge" style="background: #dcfce7; color: #166534; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">
                            <i class="fas fa-circle me-1" style="font-size: 7px;"></i>{{ __('admin.active') }}
                        </span>
                    </div>
                    <div class="mb-3 d-flex justify-content-between align-items-center">
                        <span class="td-muted" style="font-size: 13px;">{{ __('admin.email_status') }}</span>
                        @if ($user->email_verified_at)
                            <span class="badge" style="background: #dcfce7; color: #166534; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">{{ __('admin.verified') }}</span>
                        @else
                            <span class="badge" style="background: #fef3c7; color: #92400e; font-size: 11px; padding: 4px 10px; border-radius: 20px; font-weight: 600;">{{ __('admin.not_verified') }}</span>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span class="td-muted" style="font-size: 13px;">{{ __('admin.last_active') }}</span>
                        <span style="font-size: 12px; color: #64748b;">{{ $user->updated_at ? $user->updated_at->diffForHumans() : 'N/A' }}</span>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body p-4">
                    <div style="font-size: 13px; font-weight: 700; color: #1e293b; margin-bottom: 16px; text-transform: uppercase; letter-spacing: 0.5px;">
                        <i class="fas fa-bolt me-2" style="color: #4f46e5;"></i>{{ __('admin.quick_actions') }}
                    </div>
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-primary w-100 mb-2">
                        <i class="fas fa-tachometer-alt me-1"></i>{{ __('admin.go_to_dashboard') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-danger w-100">
                            <i class="fas fa-sign-out-alt me-1"></i>{{ __('admin.logout') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
