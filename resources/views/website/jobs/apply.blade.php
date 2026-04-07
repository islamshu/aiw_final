@extends('layouts.frontend')

@section('title', app()->getLocale() === 'ar' ? 'الوظائف' : 'Jobs')

@section('style')
    <style>
        :root {
            --bg-color: {{ get_general_value('bg_color') ?? '#0a192f' }};
            --text-color: {{ get_general_value('text_color') ?? '#e6f1ff' }};
            --primary-color: {{ get_general_value('prime_color') ?? '#00b4d8' }};
            --secondary-color: {{ get_general_value('second_color') ?? '#ff5d8f' }};
        }

        body {
            background: var(--bg-color);
            color: var(--text-color);
        }

        .fade-in {
            opacity: 0;
            transform: translateY(25px);
            animation: fadeIn .8s ease forwards;
        }

        .share-btn img.share-icon {
            height: 103px;
            width: 80px;
            object-fit: contain;
            display: block;
        }

        .share-btn img {
            max-width: 75px;
        }

        @keyframes fadeIn {
            to {
                opacity: 1;
                transform: none;
            }
        }

        .card-box {
            border-radius: 22px;
            padding: 32px;
            border: 1px solid color-mix(in srgb, var(--primary-color) 25%, transparent);
            transition: .3s;
        }

        .card-box:hover {
            transform: translateY(-6px);
        }

        .form-input {
            background: transparent;
            color: var(--text-color);
            border: 2px solid color-mix(in srgb, var(--primary-color) 30%, transparent);
            transition: .3s;
        }

        .form-input:focus {
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px color-mix(in srgb, var(--primary-color) 30%, transparent);
            outline: none;
        }

        .submit-btn {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #fff;
            transition: .3s;
        }

        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px color-mix(in srgb, var(--primary-color) 40%, transparent);
        }

        .submit-btn:disabled {
            opacity: .6;
            cursor: not-allowed;
        }

        .loader-overlay {
            position: fixed;
            inset: 0;
            background: rgba(0, 0, 0, .7);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
            opacity: 0;
            visibility: hidden;
            transition: .3s;
        }

        .loader-overlay.active {
            opacity: 1;
            visibility: visible;
        }

        .loader {
            width: 60px;
            height: 60px;
            border: 5px solid rgba(255, 255, 255, .2);
            border-top-color: var(--primary-color);
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            to {
                transform: rotate(360deg);
            }
        }

        .share-btn {
            width: 44px;
            height: 44px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            transition: .3s;
            cursor: pointer;
        }

        .share-btn:hover {
            transform: translateY(-3px) scale(1.08);
            box-shadow: 0 10px 20px rgba(0, 0, 0, .25);
        }

        .alert-message {
            padding: 16px 20px;
            border-radius: 14px;
            margin-bottom: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .alert-success {
            background: color-mix(in srgb, var(--primary-color) 20%, transparent);
            border: 1px solid var(--primary-color);
        }

        .alert-error {
            background: color-mix(in srgb, #be0e0e, transparent);
            border: 1px solid #ff0404;
        }

        /* ================= TOAST ALERT ================= */
        .toast-container {
            position: fixed;
            top: 24px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 99999;
            display: flex;
            flex-direction: column;
            gap: 12px;
            pointer-events: none;
        }

        .toast {
            min-width: 320px;
            max-width: 520px;
            padding: 16px 20px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-weight: 600;
            box-shadow: 0 20px 40px rgba(0, 0, 0, .35);
            animation: toastIn .4s ease forwards;
        }

        .toast-success {
            background: linear-gradient(135deg, #00b4d8, #3dd5f3);
            color: #fff;
        }

        .toast-error {
            background: linear-gradient(135deg, #dc2626, #ef4444);
            color: #fff;
        }

        @keyframes toastIn {
            from {
                opacity: 0;
                transform: translateY(-20px) scale(.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        @keyframes toastOut {
            to {
                opacity: 0;
                transform: translateY(-20px) scale(.95);
            }
        }
    </style>
@endsection

@section('content')
    <section class="pt-32 pb-24">
        <div id="loaderOverlay" class="loader-overlay">
            <div class="loader"></div>
        </div>
        <div id="toastContainer" class="toast-container"></div>

        <div class="container mx-auto px-4 max-w-5xl">

            {{-- HEADER --}}
            <div class="text-center mb-16 fade-in">
                <h1 class="text-3xl md:text-4xl font-extrabold mb-4" id="pageTitle">
                    {{ app()->getLocale() === 'ar' ? 'التقديم على الوظائف المتاحة' : 'Apply for Available Jobs' }}
                </h1>
                <p class="opacity-80 max-w-2xl mx-auto" id="pageSubtitle">
                    {{ app()->getLocale() === 'ar'
                        ? 'اختر المجال الوظيفي ثم الوظيفة المناسبة واطّلع على المتطلبات وقدّم طلبك بكل سهولة'
                        : 'Choose a job category, review the requirements, and apply easily' }}
                </p>
            </div>

            {{-- GROUP --}}
            <div class="mb-8 fade-in">
                <label class="block mb-2 font-semibold">
                    {{ app()->getLocale() === 'ar' ? 'المجال الوظيفي' : 'Job Category' }}
                </label>
                <select id="groupSelect" class="w-full rounded-xl px-4 py-3 form-input">
                    {{-- fallback initial (optional) --}}
                    @foreach ($groups as $group)
                        <option value="{{ $group->id }}">{{ $group->getTranslation('title', app()->getLocale()) }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- JOB --}}
            <div class="mb-12 fade-in">
                <label class="block mb-2 font-semibold">
                    {{ app()->getLocale() === 'ar' ? 'الوظائف المتاحة' : 'Available Jobs' }}
                </label>
                <select id="jobSelect" class="w-full rounded-xl px-4 py-3 form-input"></select>
            </div>

            {{-- REQUIREMENTS --}}
            <div class="mb-14 fade-in">
                <div class="card-box">
                    <h2 class="text-lg font-bold mb-4">
                        {{ app()->getLocale() === 'ar' ? 'المتطلبات الوظيفية' : 'Job Requirements' }}
                    </h2>
                    <div id="requirementsBox" class="leading-relaxed opacity-90"></div>
                </div>
            </div>

            {{-- SHARE --}}
            <div class="flex flex-wrap items-center gap-4 mb-16 fade-in">
                <span class="font-semibold">
                    {{ app()->getLocale() === 'ar' ? 'مشاركة الوظيفة:' : 'Share this job:' }}
                </span>

                <a id="shareLinkedIn" target="_blank" class="share-btn bg-[#0A66C2]">
                    <i class="fab fa-linkedin-in"></i>
                </a>

                <a id="shareX" target="_blank" class="share-btn ">
                    <img src="https://cdn.iconscout.com/icon/free/png-256/free-twitter-x-icon-svg-download-png-7740647.png"
                        width="55" alt="X" class="share-icon">
                </a>


                <a id="shareWhatsApp" target="_blank" class="share-btn bg-green-500">
                    <i class="fab fa-whatsapp"></i>
                </a>

                <a id="shareLink" href="#" class="share-btn" style="background: var(--secondary-color)">
                    <i class="fas fa-link"></i>
                </a>
            </div>

            {{-- FORM --}}
            <div id="alertContainer"></div>

            <div class="fade-in">
                <div class="card-box">
                    <h2 class="text-xl font-bold mb-8">
                        {{ app()->getLocale() === 'ar' ? 'نموذج التقديم' : 'Application Form' }}
                    </h2>

                    <form id="applyForm" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="job_id" id="jobId">

                        <input type="text" name="name" required
                            placeholder="{{ app()->getLocale() === 'ar' ? 'الاسم الكامل' : 'Full Name' }}"
                            class="form-input p-3 rounded-xl">

                        <input type="text" name="phone" required
                            placeholder="{{ app()->getLocale() === 'ar' ? 'رقم الهاتف' : 'Phone Number' }}"
                            class="form-input p-3 rounded-xl">

                        <textarea name="summary" rows="4"
                            placeholder="{{ app()->getLocale() === 'ar'
                                ? 'نبذة مختصرة عنك ولماذا أنت مناسب لهذه الوظيفة'
                                : 'Brief summary about you and why you fit this role' }}"
                            class="md:col-span-2 form-input p-3 rounded-xl"></textarea>

                           {{ app()->getLocale() === 'ar'
                                ? 'السيرة الذاتية'
                                : 'CV' }}
                        <input type="file" name="cv" required class="md:col-span-2 form-input p-3 rounded-xl">

                        <div class="md:col-span-2 text-right mt-6">
                            <button id="submitBtn" type="submit" class="submit-btn px-12 py-3 rounded-full font-bold">
                                {{ app()->getLocale() === 'ar' ? 'إرسال الطلب' : 'Submit Application' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </section>
@endsection


@section('script')
    <script>
        const locale = "{{ app()->getLocale() }}";
        const siteNameAr = "{{ get_general_value('website_name_ar') }}";
        const siteNameEn = "{{ get_general_value('website_name_en') ?? get_general_value('website_name_ar') }}";

        const routes = {
            groups: "{{ route('jobs.ajax.groups') }}",
            groupJobs: (id) => "{{ url('/jobs/ajax/group') }}/" + id,
            job: (id) => "{{ url('/jobs/ajax/job') }}/" + id,
            apply: "{{ route('jobs.apply') }}",
        };

        const groupSelect = document.getElementById('groupSelect');
        const jobSelect = document.getElementById('jobSelect');
        const requirementsBox = document.getElementById('requirementsBox');
        const jobIdInput = document.getElementById('jobId');
        const loaderOverlay = document.getElementById('loaderOverlay');
        const alertContainer = document.getElementById('alertContainer');
        const applyForm = document.getElementById('applyForm');
        const submitBtn = document.getElementById('submitBtn');

        const shareLinkedIn = document.getElementById('shareLinkedIn');
        const shareX = document.getElementById('shareX');
        const shareWhatsApp = document.getElementById('shareWhatsApp');
        const shareLink = document.getElementById('shareLink');

        let currentJobs = []; // jobs for selected group
        let currentJob = null;

        function showLoader(show = true) {
            loaderOverlay.classList.toggle('active', show);
        }

        const toastContainer = document.getElementById('toastContainer');

        function showAlert(message, type = 'success') {
            if (!toastContainer) return;

            const toast = document.createElement('div');
            toast.className = `toast toast-${type}`;
            toast.innerHTML = `
        <i class="fas ${type === 'success' ? 'fa-check-circle' : 'fa-times-circle'} text-xl"></i>
        <span>${message}</span>
    `;

            toastContainer.appendChild(toast);

            // اختفاء تلقائي
            setTimeout(() => {
                toast.style.animation = 'toastOut .4s ease forwards';
                setTimeout(() => toast.remove(), 400);
            }, 3500);
        }




        function stripHtml(html) {
            const div = document.createElement('div');
            div.innerHTML = html || '';
            return (div.innerText || '').trim();
        }

        function buildShareMessage(job) {
            const jobTitle = job.title;
            const requirementsText = stripHtml(job.requirements);
            const applyUrl = job.share_url;

            if (locale === 'ar') {
                return `
 قدم الآن على وظيفة جديدة في ${siteNameAr}

 الوظيفة:
${jobTitle}

 المؤهلات المطلوبة:
${requirementsText}

 رابط التقديم:
${applyUrl}
            `.trim();
            }

            return `
 Apply now for a new position at ${siteNameEn}

 Job Title:
${jobTitle}

 Requirements:
${requirementsText}

 Apply here:
${applyUrl}
        `.trim();
        }

        function updateShareLinks(job) {
            const message = buildShareMessage(job);
            const encodedMessage = encodeURIComponent(message);
            const encodedUrl = encodeURIComponent(job.share_url);

            // LinkedIn: URL only
            shareLinkedIn.href = `https://www.linkedin.com/sharing/share-offsite/?url=${encodedUrl}`;

            // X
            shareX.href = `https://twitter.com/intent/tweet?text=${encodedMessage}`;

            // WhatsApp
            shareWhatsApp.href = `https://wa.me/?text=${encodedMessage}`;

            // Copy: copy message includes url
            shareLink.setAttribute('data-message', message);
            shareLink.href = job.share_url;
        }

        function renderJob(job) {
            requirementsBox.innerHTML = job.requirements;
            jobIdInput.value = job.id;

            updateShareLinks(job);
            updateMetaForJob(job); // 🔥 هنا السحر

            history.replaceState(null, null, `#job-${job.id}`);
        }


        async function fetchJson(url) {
            const res = await fetch(url, {
                headers: {
                    'Accept': 'application/json'
                }
            });
            if (!res.ok) {
                throw new Error('Request failed: ' + res.status);
            }
            return await res.json();
        }

        async function loadGroupsIfNeeded() {
            // اختياري: لو بدك تعتمد فقط على ajax (حتى لو الصفحة مبدئياً فيها options)
            // إذا بدك دائماً ajax: امسح options الموجودة واعملها من هنا.
            try {
                const data = await fetchJson(routes.groups);
                if (!data.success) return;

                // إعادة بناء القائمة لضمان فقط مجموعات فيها وظائف منشورة
                groupSelect.innerHTML = '';
                data.groups.forEach(g => {
                    const opt = document.createElement('option');
                    opt.value = g.id;
                    opt.textContent = g.title;
                    groupSelect.appendChild(opt);
                });
            } catch (e) {
                // خلّي fallback options اللي في blade
            }
        }

        async function loadJobsByGroup(groupId, selectedJobId = null) {
            showLoader(true);
            try {
                const data = await fetchJson(routes.groupJobs(groupId));
                currentJobs = data.jobs || [];

                jobSelect.innerHTML = '';
                currentJobs.forEach(job => {
                    const opt = document.createElement('option');
                    opt.value = job.id;
                    opt.textContent = job.title;
                    jobSelect.appendChild(opt);
                });

                if (!currentJobs.length) {
                    requirementsBox.innerHTML = locale === 'ar' ?
                        'لا توجد وظائف متاحة حالياً في هذا المجال.' :
                        'No jobs available in this category.';
                    jobIdInput.value = '';
                    currentJob = null;
                    return;
                }

                const job = selectedJobId ?
                    currentJobs.find(j => String(j.id) === String(selectedJobId)) :
                    currentJobs[0];

                jobSelect.value = job.id;
                renderJob(job, true);

            } catch (e) {
                showAlert(locale === 'ar' ? 'حدث خطأ أثناء جلب الوظائف' : 'Failed to load jobs', 'error');
            } finally {
                showLoader(false);
            }
        }

        async function loadFromHash() {
            const raw = (location.hash || '').trim();
            if (!raw.startsWith('#job-')) return false;

            const jobId = raw.replace('#job-', '').trim();
            if (!jobId) return false;

            showLoader(true);
            try {
                const data = await fetchJson(routes.job(jobId));
                const job = data.job;

                // حدّد المجموعة + حمّل وظائفها ثم اختار الوظيفة
                groupSelect.value = job.group_id;
                await loadJobsByGroup(job.group_id, job.id);
                return true;
            } catch (e) {
                // إذا hash غلط: رجع للأول
                return false;
            } finally {
                showLoader(false);
            }
        }

        // Events
        groupSelect.addEventListener('change', (e) => {
            loadJobsByGroup(e.target.value);
        });

        jobSelect.addEventListener('change', (e) => {
            const job = currentJobs.find(j => String(j.id) === String(e.target.value));
            if (job) renderJob(job, true);
        });

        // Copy share message
        shareLink.addEventListener('click', function(e) {
            e.preventDefault();
            const message = this.getAttribute('data-message') || (currentJob ? buildShareMessage(currentJob) : '');
            if (!message) return;

            navigator.clipboard.writeText(message).then(() => {
                showAlert(
                    locale === 'ar' ?
                    'تم نسخ رسالة المشاركة ورابط التقديم' :
                    'Share message and apply link copied',
                    'success'
                );
            });
        });

        // Apply form
        applyForm.addEventListener('submit', async (e) => {
            e.preventDefault();

            if (!jobIdInput.value) {
                showAlert(locale === 'ar' ? 'اختر وظيفة أولاً' : 'Please select a job first', 'error');
                return;
            }

            showLoader(true);
            submitBtn.disabled = true;

            const formData = new FormData(applyForm);

            try {
                const res = await fetch(routes.apply, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json'
                    }
                });

                const data = await res.json();

                if (data.success) {
                    showAlert(data.message, 'success');
                    applyForm.reset();

                    // رجّع job_id للوظيفة الحالية بعد reset
                    if (currentJob) jobIdInput.value = currentJob.id;

                } else {
                    showAlert(data.message, 'error');
                    applyForm.classList.add('shake');
                    setTimeout(() => applyForm.classList.remove('shake'), 450);
                }
            } catch (err) {
                showAlert(locale === 'ar' ? 'خطأ بالخادم' : 'Server error', 'error');
            } finally {
                showLoader(false);
                submitBtn.disabled = false;
            }
        });

        // Init
        document.addEventListener('DOMContentLoaded', async () => {
            await loadGroupsIfNeeded();

            // إذا في hash لjob معين
            const ok = await loadFromHash();
            if (!ok) {
                // أول مجموعة -> أول وظيفة
                if (groupSelect.value) {
                    await loadJobsByGroup(groupSelect.value);
                }
            }
        });

        // لو المستخدم يغير الـ hash يدوي
        window.addEventListener('hashchange', () => {
            loadFromHash();
        });
    </script>
    <script>
        function updateMeta(name, content) {
            const el = document.getElementById(name);
            if (el) {
                el.setAttribute('content', content);
            }
        }

        function updatePageTitle(title) {
            const titleEl = document.getElementById('page-title');
            if (titleEl) {
                titleEl.innerText = title;
            }
            document.title = title;
        }

        function updateMetaForJob(job) {
            const siteName = locale === 'ar' ?
                "{{ get_general_value('website_name_ar') }}" :
                "{{ get_general_value('website_name_en') ?? get_general_value('website_name_ar') }}";

            const description = stripHtml(job.requirements).substring(0, 160);

            updateMeta('og-title', job.title + ' | ' + siteName);
            updateMeta('og-description', description);
            updateMeta('og-url', job.share_url);
            updateMeta('og-image', "{{ asset('storage/' . get_general_value('website_logo')) }}");

            updatePageTitle(job.title + ' | ' + siteName);
        }

        function scrollToAlerts() {
            const container = document.getElementById('alertContainer');
            if (!container) return;

            const topOffset = container.getBoundingClientRect().top + window.scrollY - 120;

            window.scrollTo({
                top: topOffset,
                behavior: 'smooth'
            });
        }

        function clearAlerts() {
            if (!alertContainer) return;
            alertContainer.innerHTML = '';
        }
    </script>

@endsection
