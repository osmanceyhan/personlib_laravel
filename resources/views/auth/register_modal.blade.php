
<!-- Modal -->
<div class="modal fade center_modal register_modal" id="registerModal" tabindex="-1" aria-labelledby="registerModalTitle" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('register') }}" method="post">
                @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="registerModalTitle">Demo Üyelik Oluşturun</h5>
                        <p>
                            Personlib'in tüm özelliklerini deneyimlemek için demo üyelik oluşturun. Ücretsiz demo üyelik ile 15 gün Personlib'i test edebilirsiniz.
                        </p>
                        @if(session()->has('modalAlert'))
                            <div class="alert alert-{{ session()->get('modalAlert')['status'] }} alert-dismissible fade show" role="alert">
                                <p>  {{ session()->get('modalAlert')['message'] }}</p>
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-times"></i></button>
                            </div>
                        @endif
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="register_form">
                            <div class="form-content row">
                                <div class="col-md-6">
                                    <div class="form-label-group {{old('name') ? 'focused' : ''}}">
                                        <label for="name">Adınız <span class="text-danger">*</span></label>
                                        <input type="text" value="{{old('name')}}" name="name" required class="form-control" id="name" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group {{old('surname') ? 'focused' : ''}}">
                                        <label for="surname">Soyadınız <span class="text-danger">*</span></label>
                                        <input type="text" value="{{old('surname')}}" name="surname" required class="form-control" id="surname">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group {{old('gender') ? 'focused' : ''}}">
                                        <label for="surname">Cinsiyet <span class="text-danger">*</span></label>
                                        <div class="select2-full w-full">
                                            <select class="form-control select2">
                                                <option value="MAN" @if(old('gender') == 'MAN') selected @endif>Erkek</option>
                                                <option value="WOMAN" @if(old('gender') == 'MAN') selected @endif>Kadın</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group {{old('email') ? 'focused' : ''}}">
                                        <label for="email">E-Posta <span class="text-danger">*</span></label>
                                        <input type="email" value="{{old('email')}}" name="email" required class="form-control" id="email">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group {{old('phone') ? 'focused' : ''}}">
                                        <label for="phone">Telefon <span class="text-danger">*</span></label>
                                        <input type="text"  value="{{old('phone')}}" name="phone"  required class="form-control" id="phone" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group {{old('company_name') ? 'focused' : ''}}">
                                        <label for="company_name">Şirket Adı <span class="text-danger">*</span></label>
                                        <input type="text" value="{{old('company_name')}}" name="company_name"  required class="form-control" id="company_name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group {{old('company_title') ? 'focused' : ''}}">
                                        <label for="company_title">Ünvan <span class="text-danger">*</span></label>
                                        <input type="text" value="{{old('company_title')}}" name="company_title" required class="form-control" id="company_title" >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-label-group {{old('employees_count') ? 'focused' : ''}}">
                                        <label for="employees_count">Çalışan Sayısı <span class="text-danger">*</span> </label>
                                        <input type="text" required value="{{old('employees_count')}}" name="employees_count" class="form-control" id="employees_count">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <input type="checkbox" @if(old('kvkk') ?? 'checked') @endif  required class="form-check-input" name="kvkk" id="kvkk">
                                    <label for="kvkk"><a href="#" target="_blank">Aydınlatma Metni</a> uyarınca kişisel verilerimin Personlib tarafından işlenmesine rıza veriyorum.</label>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Ücretsiz Deneyin</button>
                    </div>
            </form>
        </div>
    </div>
</div>

