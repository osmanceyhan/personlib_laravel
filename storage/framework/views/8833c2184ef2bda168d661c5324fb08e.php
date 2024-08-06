<?php $__env->startSection('title'); ?>
    Yeni Çalışan Ekle
<?php $__env->stopSection(); ?>

<?php $__env->startSection('css'); ?>
<link href="<?php echo e(asset('/assets/libs/dropzone/dropzone.min.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/assets/libs/dropify/dropify.css')); ?>" rel="stylesheet" type="text/css" />
    <link href="<?php echo e(asset('/assets/libs/select2/select2.min.css')); ?>" rel="stylesheet" type="text/css" />

<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
    <?php $__env->startComponent('common-components.breadcrumb'); ?>
        <?php $__env->slot('pagetitle'); ?> Yeni Çalışan Ekle <?php $__env->endSlot(); ?>
        <?php $__env->slot('title'); ?> <?php echo e($user->getCompany->name); ?> - Yeni Çalışan Ekle <?php $__env->endSlot(); ?>
    <?php echo $__env->renderComponent(); ?>

    <div class="row">
        <div class="col-12">

            <?php if(session()->has('alert')): ?>
                <div class="alert alert-<?php echo e(session()->get('alert')['status']); ?> alert-dismissible fade show" role="alert">
                    <h5 class="text-success"> <?php echo e(session()->get('alert')['title']); ?></h5>
                    <p>  <?php echo e(session()->get('alert')['message']); ?></p>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close">
                    </button>
                </div>
            <?php endif; ?>
            <div class="card">
                <div class="card-body">
                    <div class="profile_contents">
                        <div class="row">
                            <div class="col-lg-12">
                                <form action="<?php echo e(route('employees.store')); ?>" method="post" enctype="multipart/form-data">
                                    <?php echo csrf_field(); ?>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_name" class="form-label">Çalışan Rolü <span class="text-danger">*</span></label>
                                                <div class="select2-full w-full">
                                                    <select class="form-control select2" name="user_role" >
                                                        <?php $__currentLoopData = $userRoles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $role): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($key); ?>" <?php if($key == "EMPLOYEE"): ?> selected <?php endif; ?>><?php echo e($role); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_gender" class="form-label">Cinsiyet <span class="text-danger">*</span></label>
                                                <div class="select2-full w-full">
                                                    <select class="form-select select2" id="input_gender" name="gender" >
                                                        <option value="MAN" selected>Erkek</option>
                                                        <option value="WOMAN">Kadın</option>
                                                        <option value="EMPTY">Diğer</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3 form-group">
                                                <label for="name" class="form-label">Ad <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="name" name="name" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_surname" class="form-label">Soyad <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="input_surname" name="surname" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_title" class="form-label">Unvan <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="input_title" name="title" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_email" class="form-label">E-Posta <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="input_email" name="email" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_phone" class="form-label">Telefon <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="input_phone" name="phone" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_birthdate" class="form-label ">Doğum Tarihi <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="input_birthdate" name="birthdate" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_password" class="form-label">Parola <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="input_password" name="password" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_tc_number" class="form-label ">T.C. Numarası <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="input_tc_number" name="tc_number" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="military_status" class="form-label">Askerlik Durumu</label>
                                                <div class="select2-full w-full">
                                                    <select class="form-control select2" name="military_status" id="military_status">
                                                        <?php $__currentLoopData = \App\Enumerations\MilitaryStatusEnum::allStatus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($data['key']); ?>"><?php echo e($data['value']); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="military_done_date" class="form-label ">Askerlik Tamamlama Tarihi</label>
                                                <input type="date" class="form-control" id="military_done_date" name="military_done_date" >
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="military_postponement_date" class="form-label ">Askerlik Tecil Tarihi</label>
                                                <input type="date" class="form-control" id="military_postponement_date" name="military_postponement_date" >
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="educational_status" class="form-label">Eğitim Durumu <span class="text-danger">*</span></label>
                                                <div class="select2-full w-full">
                                                    <select class="form-control select2" name="educational_status" required id="educational_status">
                                                        <?php $__currentLoopData = \App\Enumerations\EducationStatusEnum::allStatus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($data['key']); ?>"><?php echo e($data['value']); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="education_complete_status" class="form-label">Eğitim Tamamlama Durumu <span class="text-danger">*</span></label>
                                                <div class="select2-full w-full">
                                                    <select class="form-control select2" name="education_complete_status" id="education_complete_status" required>
                                                        <?php $__currentLoopData = \App\Enumerations\EducationCompleteStatusEnum::allStatus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($data['key']); ?>"><?php echo e($data['value']); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="marital_status" class="form-label">Medeni Durum <span class="text-danger">*</span></label>
                                                <div class="select2-full w-full">
                                                    <select class="form-control select2" name="marital_status" id="marital_status" required>
                                                        <?php $__currentLoopData = \App\Enumerations\MaritalStatusEnum::allStatus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($data['key']); ?>"><?php echo e($data['value']); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="children_count" class="form-label ">Çocuk Sayısı <span class="text-danger">*</span></label>
                                                <input type="number" min="0" value="0" class="form-control" id="children_count" name="children_count" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="adress" class="form-label ">Adres</label>
                                                <textarea   class="form-control" id="adress" name="adress"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="adress_two" class="form-label ">Adres (devam)</label>
                                                <textarea   class="form-control" id="adress_two" name="adress_two"></textarea>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="country" class="form-label ">Ülke <span class="text-danger">*</span></label>
                                                <input type="text" value="Türkiye" class="form-control" required id="country" name="country">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="city" class="form-label ">Şehir</label>
                                                <input type="text"  class="form-control" id="city" name="city">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="zip_code" class="form-label ">Posta Kodu</label>
                                                <input type="text"  class="form-control" id="zip_code" name="zip_code">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="address_phone" class="form-label ">Ev Telefonu</label>
                                                <input type="text"  class="form-control" id="address_phone" name="address_phone">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="bank_name" class="form-label ">Banka Adı</label>
                                                <input type="text"  class="form-control" id="bank_name" name="bank_name">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="bank_type" class="form-label ">Banka Hesabı Türü</label>
                                                <input type="text"  class="form-control" id="bank_type" name="bank_type">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="bank_iban" class="form-label ">IBAN Adresi</label>
                                                <input type="text"  class="form-control" id="bank_iban" name="bank_iban">
                                            </div>
                                        </div>

                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="bank_number" class="form-label ">Hesap Numarası</label>
                                                <input type="text"  class="form-control" id="bank_number" name="bank_number">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="emergency_fullname" class="form-label ">Acil Kişi Ad Soyad</label>
                                                <input type="text"  class="form-control" id="emergency_fullname" name="emergency_fullname">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="emergency_phone" class="form-label ">Acil Kişi Telefon</label>
                                                <input type="text"  class="form-control" id="emergency_phone" name="emergency_phone">
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="emergency_proximity_degree" class="form-label ">Acil Kişi Yakınlık Derecesi</label>
                                                <input type="text"  class="form-control" id="emergency_proximity_degree" name="emergency_proximity_degree">
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <label for="input_surname" class="form-label">Profil Fotoğrafı <span class="text-danger">*</span></label>
                                                <div class="mb-3 dropzone">
                                                    <input type="file" class="dropify" id="avatar"  name="avatar" required
                                                           data-file-size-error="<?php echo e(__('Dosya boyutu çok büyük (:max) maksimum.',['max' => ':value'])); ?>"
                                                           data-min-width-error="<?php echo e(__('Resim genişliği çok küçük (:min piksel minimum).',['min' => ':value'])); ?>"
                                                           data-max-width-error="<?php echo e(__('Resim genişliği çok büyük (:max piksel maksimum).',['max' => ':value'])); ?>"
                                                           data-min-height-error="<?php echo e(__('Resim yüksekliği çok küçük (:min piksel minimum).',['min' => ':value'])); ?>"
                                                           data-max-height-error="<?php echo e(__('Resim yüksekliği çok büyük (:max piksel maksimum).',['max' => ':value'])); ?>"
                                                           data-image-format-error="<?php echo e(__('Sadece :formats formatındaki resim dosyaları desteklenmektedir.', ['formats' => ':value'])); ?>"  />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_name" class="form-label">Sözleşme Türü <span class="text-danger">*</span></label>
                                                <div class="select2-full w-full">
                                                    <select class="form-control select2" name="contract_type" required>
                                                        <?php $__currentLoopData = \App\Enumerations\ContractTypeEnum::allStatus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($data['key']); ?>"><?php echo e($data['value']); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_name" class="form-label">Çalışma Türü <span class="text-danger">*</span></label>
                                                <div class="select2-full w-full">
                                                    <select class="form-control select2" name="work_type" required>
                                                        <?php $__currentLoopData = \App\Enumerations\WorkTypeEnum::allStatus(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $data): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <option value="<?php echo e($data['key']); ?>"><?php echo e($data['value']); ?></option>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="mb-3">
                                                <label for="input_start_date" class="form-label ">Başlangıç Tarihi <span class="text-danger">*</span></label>
                                                <input type="date" class="form-control" id="input_start_date" name="start_date" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-12">
                                            <div class="mb-3">
                                                <button type="submit" class="btn btn-success">Ekle</button>
                                            </div>
                                        </div>
                                </div>
                            </form>
                    </div>


                </div>
            </div>
        </div> <!-- end col -->
    </div>
    <!-- end row -->



<?php $__env->stopSection(); ?>
<?php $__env->startSection('script'); ?>


    <script src="<?php echo e(URL::asset('/assets/libs/dropify/dropify.min.js')); ?>"></script>


    <!-- lazyload.js CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.lazy/1.7.11/jquery.lazy.plugins.min.js"></script>
    <script src="<?php echo e(URL::asset('/assets/libs/select2/select2.min.js')); ?>"></script>
                    <script>
                        $(document).ready(function () {
                            // Select2 ve Dropify başlatma
                            $(".select2").select2();

                            $('.dropify').dropify({
                                messages: {
                                    'default': 'Dosyanızı buraya sürükleyin veya tıklayın',
                                    'replace': 'Değiştirmek için sürükleyin veya tıklayın',
                                    'remove': 'Kaldır',
                                    'error': 'Üzgünüz, bir hata oluştu.'
                                }
                            });

                            // Lazy loading etkinleştirme
                            $('img.lazyload').lazy();

                            // Form submit eventini kontrol etme
                            $('form').on('submit', function(event) {
                                // Formun geçerli olup olmadığını kontrol et
                                if (!this.checkValidity()) {
                                    event.preventDefault();
                                    $(this).addClass('was-validated');
                                    return false;
                                }
                            });
                        });
                    </script>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.master', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /Applications/XAMPP/xamppfiles/htdocs/yesevi/proje/resources/views/employees/create.blade.php ENDPATH**/ ?>