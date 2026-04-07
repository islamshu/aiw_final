
<?php $__env->startSection('title', 'إدارة الأخبار'); ?>

<?php $__env->startSection('style'); ?>
    <style>
        .page-wrapper {
            padding: 24px;
        }

        /* Header */
        .page-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
        }

        .page-header h3 {
            font-weight: 800;
            margin-bottom: 4px;
        }

        .page-header small {
            color: #6c757d;
        }

        .news-thumb {
            width: 56px;
            height: 56px;
            border-radius: 10px;
            object-fit: cover;
            border: 1px solid #eaecef;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .12);
        }

        /* Card */
        .table-card {
            background: #fff;
            border-radius: 18px;
            border: 1px solid #eaecef;
            overflow: hidden;
        }

        /* Table */
        .table thead {
            background: #f8f9fa;
        }

        .table th {
            font-weight: 700;
            font-size: 14px;
        }

        .table td {
            vertical-align: middle;
            font-size: 14px;
        }

        /* Title */
        .news-title {
            font-weight: 700;
        }

        .news-title small {
            display: block;
            color: #6c757d;
            font-weight: 400;
        }

        /* SWITCH */
        .switch {
            position: relative;
            display: inline-block;
            width: 42px;
            height: 22px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            inset: 0;
            cursor: pointer;
            background-color: #dee2e6;
            border-radius: 999px;
            transition: .3s ease;
        }

        .slider::before {
            content: "";
            position: absolute;
            height: 16px;
            width: 16px;
            left: 3px;
            top: 3px;
            background-color: #fff;
            border-radius: 50%;
            box-shadow: 0 2px 6px rgba(0, 0, 0, .25);
            transition: .3s ease;
        }

        .switch input:checked+.slider {
            background-color: #198754;
        }

        .switch input:checked+.slider::before {
            transform: translateX(20px);
        }

        /* Actions */
        .btn-group .btn {
            border-radius: 10px !important;
        }
    </style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <div class="page-wrapper">

        
        <div class="page-header">
            <div>
                <h3>إدارة الأخبار</h3>
                <small>إضافة وتحرير الأخبار المعروضة في الموقع</small>
            </div>

            <a href="<?php echo e(route('dashboard.news.create')); ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> خبر جديد
            </a>
        </div>

        
        <div class="table-card">
            <div class="table-responsive">
                <?php echo $__env->make('dashboard.inc.alerts', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

                <table class="table table-hover mb-0">
                    <thead>
                        <tr>
                            <th width="80">الصورة</th>
                            <th>العنوان</th>
                            <th width="140">تاريخ النشر</th>
                            <th width="120" class="text-center">الحالة</th>
                            <th width="140" class="text-center">إجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $__empty_1 = true; $__currentLoopData = $news; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr>
                                
                                <td>
                                    <?php if($item->image): ?>
                                        <img src="<?php echo e(asset('storage/' . $item->image)); ?>" alt="news image"
                                            class="news-thumb">
                                    <?php else: ?>
                                        <span>لا يوجد صورة</span>
                                    <?php endif; ?>
                                </td>

                                
                                <td>
                                    <div class="news-title">
                                        <?php echo e($item->title); ?>

                                    </div>
                                </td>

                                
                                <td>
                                    <?php echo e(optional($item->published_at)->format('Y-m-d') ?? '-'); ?>

                                </td>

                                
                                <td class="text-center">
                                    <label class="switch">
                                        <input type="checkbox" class="js-toggle-news" data-id="<?php echo e($item->id); ?>"
                                            <?php echo e($item->is_active ? 'checked' : ''); ?>>
                                        <span class="slider"></span>
                                    </label>
                                </td>

                                
                                <td class="text-center">
                                    <div class="btn-group btn-group-sm">
                                          <a href="<?php echo e(route('dashboard.news.edit', $item)); ?>"
           class="btn btn-sm btn-info">تعديل</a>
                                       <form method="POST"
              action="<?php echo e(route('dashboard.news.destroy', $item)); ?>"
              class="d-inline">
            <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
            <button class="btn btn-sm btn-danger"
                    onclick="return confirm('حذف؟')">
                حذف
            </button>
        </form>

                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="4" class="text-center text-muted py-5">
                                    لا توجد أخبار حالياً
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('script'); ?>
    <script>
        const toggleUrlTemplate = "<?php echo e(route('dashboard.news.toggle', ':id')); ?>";

        document.querySelectorAll('.js-toggle-news').forEach(sw => {
            sw.addEventListener('change', function() {

                const url = toggleUrlTemplate.replace(':id', this.dataset.id);

                fetch(url, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': "<?php echo e(csrf_token()); ?>",
                            'Accept': 'application/json'
                        }
                    })
                    .then(res => {
                        if (!res.ok) throw new Error();
                        return res.json();
                    })
                    .then(() => {
                        showToast('تم تغيير الحالة', 'success');
                    })
                    .catch(() => {
                        showToast('حدث خطأ أثناء التحديث', 'error');
                        this.checked = !this.checked;
                    });
            });
        });
    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\aiw_rtl\resources\views/dashboard/news/index.blade.php ENDPATH**/ ?>