@extends('Layout.EmployerMain')

@push('title')
    <title></title>
@endpush

@section('header')
    @include('Component.Header')
@endsection 

@section('content')
<main id="main" class="main">

    <div class="pagetitle mb-3">
        <h1>Employer Profile</h1>
        <!-- <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                <li class="breadcrumb-item">Components</li>
                <li class="breadcrumb-item active">Accordion</li>
            </ol>
        </nav> -->
    </div>

    <section class="section profile">
        <div class="card">
            <div class="card-body pt-3">
                <form id="profile-form">
                    @method('PUT')
                    @csrf

                    <div class="row mb-3">
                        <h6 class="fw-bold text-center">--- BUSINESS DETAILS ---</h6>
                        <div class="col-lg-3 d-flex flex-column align-items-center mt-1">
                            <img id="business_logo_preview" class="form-control p-1" src="{{ asset('storage/profile_picture/'.$acc->acc_biz_logo) }}" alt="Bussiness Logo" style="height: 200px; width: 200px;">     
                        </div>

                        <div class="col-lg-3 d-inline-flex align-items-center mt-1">
                            <label class="form-control border-0 p-0 d-block align-items-center">
                                Business Logo
                                <input type="hidden" name="bussiness_logo_prev" value="{{ $acc->acc_biz_logo }}">
                                <div class="input-group">
                                    <input type="file" class="form-control" name="business_logo" id="business_logo" value="{{ $acc->acc_biz_logo }}">
                                    <button type="button" class="input-group-text" id="business_logo_reset" style="cursor: pointer;"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reset Logo">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </div>
                                <span class="text-danger profile-error" id="business_logo-error"></span>
                            </label>
                        </div>

                        <div class="col-lg-4 d-inline-flex align-items-center mt-1">
                            <label class="form-control border-0 p-0 d-block align-items-center">
                                Business Name
                                <input type="text" class="form-control" name="business_name" id="business_name" value="{{ $acc->acc_biz_name }}">
                                <span class="text-danger profile-error" id="business_name-error"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Province
                                <select name="business_province" id="business_province" class="form-select">
                                    <!-- <option value="">--- choose ---</option> -->
                                    @foreach($province as $p)
                                        <option value="{{ $p->prov_code }}" {{ ($p->prov_code=='0410') ? 'selected' : 'hidden' }}>{{ $p->prov_name }}</option>
                                    @endforeach 
                                </select>
                                <span class="text-danger profile-error" id="business_province-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Municipality
                                <select name="business_municipality" id="business_municipality" class="form-select">
                                    <!-- <option value="">--- choose ---</option> -->
                                    @foreach($municipality as $m)
                                        <option value="{{ $m->mun_code }}" {{ ($m->mun_code=='041019') ? 'selected' : 'hidden' }}>{{ $m->mun_name }}</option>
                                    @endforeach 
                                </select>
                                <span class="text-danger profile-error" id="business_municipality-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Barangay
                                <select name="business_barangay" id="business_barangay" class="form-select">
                                    <option value="">--- choose ---</option>
                                    @foreach($barangay as $b)
                                        <option value="{{ $b->brgy_code }}" {{ ($b->brgy_code==$acc->ab) ? 'selected' : '' }}>{{ $b->brgy_name }}</option>
                                    @endforeach 
                                </select>
                                <span class="text-danger profile-error" id="business_barangay-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Landmark
                                <input type="text" name="business_landmark" id="business_landmark" class="form-control" value="{{ $acc->al }}">
                                <span class="text-danger profile-error" id="business_landmark-error"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Tel (Optional)
                                <input type="text" name="business_tel" id="business_tel" class="form-control" value="{{ $acc->acc_biz_tel }}">
                                <span class="text-danger profile-error" id="business_tel-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Phone
                                <input type="text" name="business_phone" id="business_phone" class="form-control" value="{{ $acc->acc_biz_phone }}">
                                <span class="text-danger profile-error" id="business_phone-error"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3 mt-5">
                        <label class="col-lg-12 fw-bold text-center mb-3">--- EMPLOYER DETAILS ---</label>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Firstname
                                <input type="text" class="form-control" name="employer_firstname" id="employer_firstname" value="{{ $acc->acc_firstname }}">
                                <span class="text-danger profile-error" id="employer_firstname-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Middlename
                                <input type="text" class="form-control" name="employer_middlename" id="employer_middlename" value="{{ $acc->acc_middlename }}">
                                <span class="text-danger profile-error" id="employer_middlename-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Lastname
                                <input type="text" class="form-control" name="employer_lastname" id="employer_lastname" value="{{ $acc->acc_lastname }}">
                                <span class="text-danger profile-error" id="employer_lastname-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Suffixname
                                <input type="text" class="form-control" name="employer_suffixname" id="employer_suffixname" value="{{ $acc->acc_suffixname }}">
                                <span class="text-danger profile-error" id="employer_suffixname-error"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Email
                                <input type="text" name="employer_email" id="employer_email" class="form-control" value="{{ $acc->acc_email }}" readonly>
                                <span class="text-danger profile-error" id="employer_email-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Phone
                                <input type="text" name="employer_phone" id="employer_phone" class="form-control" value="{{ $acc->acc_phone }}">
                                <span class="text-danger profile-error" id="employer_phone-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Birthdate
                                <input type="date" name="employer_birthdate" id="employer_birthdate" class="form-control" value="{{ $acc->acc_birthdate }}">
                                <span class="text-danger profile-error" id="employer_birthdate-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Sex
                                <select name="employer_sex" id="employer_sex" class="form-select">
                                    <option value="">--- choose ---</option>
                                    <option value="1" {{ ($acc->acc_sex=='1') ? 'selected' : '' }}>Male</option>
                                    <option value="0" {{ ($acc->acc_sex=='0') ? 'selected' : '' }}>Female</option>
                                </select>
                                <span class="text-danger profile-error" id="employer_sex-error"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Province
                                <select name="employer_province" id="employer_province" class="form-select">
                                    <option value="">--- choose ---</option>
                                    @foreach($province as $p)
                                        <option value="{{ $p->prov_code }}" {{ ($p->prov_code==$acc->ep) ? 'selected' : '' }}>{{ $p->prov_name }}</option>
                                    @endforeach 
                                </select>
                                <span class="text-danger profile-error" id="employer_province-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Municipality
                                <select name="employer_municipality" id="employer_municipality" class="form-select">
                                    <option value="">--- choose ---</option>
                                    @foreach($emun as $m)
                                        <option value="{{ $m->mun_code }}" {{ ($m->mun_code==$acc->em) ? 'selected' : '' }}>{{ $m->mun_name }}</option>
                                    @endforeach 
                                </select>
                                <span class="text-danger profile-error" id="employer_municipality-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Barangay
                                <select name="employer_barangay" id="employer_barangay" class="form-select">
                                    <option value="">--- choose ---</option>
                                    @foreach($ebrgy as $b)
                                        <option value="{{ $b->brgy_code }}" {{ ($b->brgy_code==$acc->eb) ? 'selected' : '' }}>{{ $b->brgy_name }}</option>
                                    @endforeach 
                                </select>
                                <span class="text-danger profile-error" id="employer_barangay-error"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row mt-5">
                        <div class="col-lg-3">
                            <button type="button" id="submit-profile-form" class="btn btn-primary">Save Changes</button>
                        </div>
                        
                    </div>
                </form>
            </div>
        </div>
    </section>
</main>
@endsection
@push('script')
<script src="{{ asset('js/populate.js') }}"></script>
<script>
    // upload picture 
    $('#business_logo').change(function(){
        $('#business_logo-error').html("");
        let file = $("input[type=file]").get(0).files[0];
        let MAX_FILE_SIZE = 5 * 1024 * 1024;
        let fileSize = this.files[0].size;

        if (fileSize > MAX_FILE_SIZE) {
            $('#business_logo-error').html("File must no be greater than 5mb!");
            $(this).val('');
        } 
        else {
            var allowed_extensions = new Array("jpg","png");
            var fileName = this.files[0].name;
            var file_extension = fileName.split('.').pop().toLowerCase(); 

            console.log(file_extension);
            if((allowed_extensions.includes(file_extension))==true){
                $('#business_logo').html("");
                var reader = new FileReader();
                reader.onload = function(){
                    $("#business_logo_preview").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
            else{
                $('#business_logo-error').html("Invalid file type!");
                $(this).val('');
            }
        }
    });

    // reset picture
    $('#business_logo_reset').click(function(){
        $('#business_logo_preview').attr("src", "");
        $('#business_logo').val('');
    });

    // submit form 
    $('#submit-profile-form').click(function(){
        $('.profile-error').html('');
        var formData = new FormData($('#profile-form')[0]);
        $.ajax({
            type: "POST",
            url: "{{ route('EmployerProfileUpdate') }}",
            contentType: false,
            processData: false,
            data: formData,
            success: function(response){
                swal(response.title, response.message, response.icon);
                if(response.status == 400){
                    $.each(response.errors, function(key, err_values){
                        $('#'+key+'-error').html(err_values);
                    });
                }
                else{
                    swal(response.title, response.message, response.icon)
                    .then(function(){
                        location.reload();
                    });           
                }  
            },
            error: function(response){
                console.log(response);
            }
        })
    });

    //populate select field
        $('#employer_province').change(function(){
            set_municipality('#employer_municipality', '', $(this).val(), '#employer_barangay');
        });
        $('#employer_municipality').change(function(){
            set_barangay('#employer_barangay', '', $(this).val());
        });
    //populate select field
</script>
@endpush


