@extends('layouts.master')

@section('title', 'تفاصيل طلب التقديم')

@section('content')
<div class="container-fluid">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h1 class="h4 fw-bold mb-1">تفاصيل طلب التقديم</h1>
            <p class="text-muted mb-0">
                {{ $job->getTranslation('title', 'ar') }}
            </p>
        </div>

        <div class="d-flex gap-2">
            <a href="{{ route('dashboard.jobs.applications.index', $job->id) }}" class="btn btn-light">
                <i class="fas fa-arrow-right me-1"></i>
                رجوع
            </a>
            <a href="{{ route('dashboard.jobs.index') }}" class="btn btn-outline-secondary">
                <i class="fas fa-briefcase me-1"></i>
                الوظائف
            </a>
        </div>
    </div>

    <div class="row">
        {{-- معلومات المتقدم --}}
        <div class="col-md-8">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-user-circle me-2"></i>
                        معلومات المتقدم
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">الاسم الكامل</label>
                            <p class="fw-bold h5 mb-0">{{ $application->name }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">رقم الهاتف</label>
                            <p class="fw-bold h5 mb-0">{{ $application->phone }}</p>
                        </div>

                        <div class="col-md-6 mb-3">
                            <label class="form-label text-muted small">تاريخ التقديم</label>
                            <p class="fw-bold h6 mb-0">
                                {{ $application->created_at->format('Y-m-d') }}
                                <span class="text-muted ms-2">
                                    {{ $application->created_at->format('H:i') }}
                                </span>
                            </p>
                        </div>
                    </div>

                    {{-- Summary --}}
                    @if(!empty($application->summary))
                        <div class="mt-4 pt-3 border-top">
                            <label class="form-label text-muted small mb-2">
                                <i class="fas fa-file-alt me-1"></i>
                                ملخص المتقدم
                            </label>
                            <div class="bg-light p-4 rounded-3">
                                <p class="mb-0" style="line-height: 1.9; white-space: pre-line;">
                                    {{ $application->summary }}
                                </p>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="col-md-4">

            {{-- الوظيفة --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-briefcase me-2"></i>
                        الوظيفة
                    </h5>
                </div>
                <div class="card-body">
                    <p class="fw-bold mb-1">
                        {{ $job->getTranslation('title', 'ar') }}
                    </p>
                    <p class="text-muted small mb-0">
                        رقم الوظيفة: #{{ $job->id }}
                    </p>
                </div>
            </div>

            {{-- السيرة الذاتية --}}
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-header bg-light py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-file-pdf me-2"></i>
                        السيرة الذاتية
                    </h5>
                </div>
                <div class="card-body">
                    @if($application->cv_path)
                        <div class="text-center mb-3">
                            <i class="fas fa-file-pdf fa-3x text-danger mb-2"></i>
                            <p class="text-muted small mb-0">CV</p>
                        </div>

                        <div class="d-grid gap-2">
                            <a href="{{ asset('storage/'.$application->cv_path) }}"
                               target="_blank"
                               class="btn btn-primary">
                                <i class="fas fa-eye me-1"></i>
                                عرض السيرة الذاتية
                            </a>

                            <a href="{{ asset('storage/'.$application->cv_path) }}"
                               download="CV_{{ $application->name }}.pdf"
                               class="btn btn-outline-primary">
                                <i class="fas fa-download me-1"></i>
                                تحميل
                            </a>
                        </div>
                    @else
                        <p class="text-muted text-center mb-0">
                            لا يوجد ملف مرفق
                        </p>
                    @endif
                </div>
            </div>
            <div class="card shadow-sm border-0">
                <div class="card-header bg-light py-3">
                    <h5 class="fw-bold mb-0">
                        <i class="fas fa-cog me-2"></i>
                        الإجراءات
                    </h5>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="tel:{{ $application->phone }}" class="btn btn-outline-success">
                            <i class="fas fa-phone me-1"></i>
                            اتصال
                        </a>

                        <button type="button"
                        class="btn btn-outline-danger"
                        data-toggle="modal"
                        data-target="#deleteModal">
                    <i class="fas fa-trash me-1"></i>
                    حذف الطلب
                </button>
                
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>

{{-- Delete Modal --}}
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <form method="POST"
              action="{{ route('dashboard.jobs.applications.destroy', [$job->id, $application->id]) }}"
              class="modal-content">
            @csrf
            @method('DELETE')

            <div class="modal-header">
                <h5 class="modal-title">حذف طلب التقديم</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>

            <div class="modal-body">
                هل أنت متأكد من حذف طلب
                <strong>{{ $application->name }}</strong>؟
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                    إلغاء
                </button>
                <button type="submit" class="btn btn-danger">
                    حذف
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('styles')
<style>
    .card { border-radius: 14px; }
    .btn { border-radius: 10px; }
</style>
@endsection
