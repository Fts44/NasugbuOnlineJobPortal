@extends('Layout.ApplicantMain')

@push('title')
    <title></title>
@endpush

@section('header')
    @include('Component.Header')
@endsection

@section('content')
<main id="main" class="main">

    <div class="pagetitle mb-3">
        <h1>Applicant Profile</h1>
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
                    <div class="row mb-3 mt-2">
                        <div class="col-lg-3 d-flex flex-column align-items-center mt-1">
                            <img id="applicant_profile_picture_preview" class="form-control p-1" src="{{ asset('storage/profile_picture/'.$acc->acc_biz_logo) }}" alt="Profile Picture" style="height: 200px; width: 200px;">     
                        </div>

                        <div class="col-lg-3 d-inline-flex align-items-center mt-1">
                            <label class="form-control border-0 p-0 d-block align-items-center">
                                Profile Picture
                                <input type="hidden" name="applicant_profile_picture_prev" value="{{ $acc->acc_biz_logo }}">
                                <div class="input-group">
                                    <input type="file" class="form-control" name="applicant_profile_picture" id="applicant_profile_picture" value="{{ $acc->acc_biz_logo }}">
                                    <button type="button" class="input-group-text" id="applicant_profile_picture_reset" style="cursor: pointer;"
                                    data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Reset Logo">
                                        <i class="bi bi-arrow-clockwise"></i>
                                    </button>
                                </div>
                                <span class="text-danger profile-error" id="applicant_profile_picture-error"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3 mt-2">
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Firstname
                                <input type="text" class="form-control" name="applicant_firstname" id="applicant_firstname" value="{{ $acc->acc_firstname }}">
                                <span class="text-danger profile-error" id="applicant_firstname-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Middlename
                                <input type="text" class="form-control" name="applicant_middlename" id="applicant_middlename" value="{{ $acc->acc_middlename }}">
                                <span class="text-danger profile-error" id="applicant_middlename-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Lastname
                                <input type="text" class="form-control" name="applicant_lastname" id="applicant_lastname" value="{{ $acc->acc_lastname }}">
                                <span class="text-danger profile-error" id="applicant_lastname-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Suffixname
                                <input type="text" class="form-control" name="applicant_suffixname" id="applicant_suffixname" value="{{ $acc->acc_suffixname }}">
                                <span class="text-danger profile-error" id="applicant_suffixname-error"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Email
                                <input type="text" name="applicant_email" id="applicant_email" class="form-control" value="{{ $acc->acc_email }}" readonly>
                                <span class="text-danger profile-error" id="applicant_email-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Phone
                                <input type="text" name="applicant_phone" id="applicant_phone" class="form-control" value="{{ $acc->acc_phone }}">
                                <span class="text-danger profile-error" id="applicant_phone-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Birthdate
                                <input type="date" name="applicant_birthdate" id="applicant_birthdate" class="form-control" value="{{ $acc->acc_birthdate }}">
                                <span class="text-danger profile-error" id="applicant_birthdate-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Sex
                                <select name="applicant_sex" id="applicant_sex" class="form-select">
                                    <option value="">--- choose ---</option>
                                    <option value="1" {{ ($acc->acc_sex=='1') ? 'selected' : '' }}>Male</option>
                                    <option value="0" {{ ($acc->acc_sex=='0') ? 'selected' : '' }}>Female</option>
                                </select>
                                <span class="text-danger profile-error" id="applicant_sex-error"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Province
                                <select name="applicant_province" id="applicant_province" class="form-select">
                                    @foreach($province as $p)
                                        <option value="{{ $p->prov_code }}" {{ ($p->prov_code=='0410') ? 'selected' : 'hidden' }}>{{ $p->prov_name }}</option>
                                    @endforeach 
                                </select>
                                <span class="text-danger profile-error" id="applicant_province-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Municipality
                                <select name="applicant_municipality" id="applicant_municipality" class="form-select">
                                    @foreach($municipality as $m)
                                        <option value="{{ $m->mun_code }}" {{ ($m->mun_code=='041019') ? 'selected' : 'hidden' }}>{{ $m->mun_name }}</option>
                                    @endforeach 
                                </select>
                                <span class="text-danger profile-error" id="applicant_municipality-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Barangay
                                <select name="applicant_barangay" id="applicant_barangay" class="form-select">
                                    <option value="">--- choose ---</option>
                                    @foreach($barangay as $b)
                                        <option value="{{ $b->brgy_code }}" {{ ($b->brgy_code==$acc->eb) ? 'selected' : '' }}>{{ $b->brgy_name }}</option>
                                    @endforeach 
                                </select>
                                <span class="text-danger profile-error" id="applicant_barangay-error"></span>
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
    
    $('#applicant_profile_picture').change(function(){
        $('#business_logo-error').html("");
        let file = $("input[type=file]").get(0).files[0];
        let MAX_FILE_SIZE = 5 * 1024 * 1024;
        let fileSize = this.files[0].size;

        if (fileSize > MAX_FILE_SIZE) {
            $('#applicant_profile_picture-error').html("File must no be greater than 1.9mb!");
            $(this).val('');
        } 
        else {
            var allowed_extensions = new Array("jpg","png");
            var fileName = this.files[0].name;
            var file_extension = fileName.split('.').pop().toLowerCase(); 

            console.log(file_extension);
            if((allowed_extensions.includes(file_extension))==true){
                $('#applicant_profile_picture').html("");
                $('#applicant_profile_picture-error').html("");
                var reader = new FileReader();
                reader.onload = function(){
                    $("#applicant_profile_picture_preview").attr("src", reader.result);
                }
                reader.readAsDataURL(file);
            }
            else{
                $('#applicant_profile_picture-error').html("Invalid file type only accepts(jpg, png)!");
                $(this).val('');
            }
        }
    });

    // reset picture
    $('#applicant_profile_picture_reset').click(function(){
        $('#applicant_profile_picture_preview').attr("src", "{{ asset('storage/profile_picture/'.$acc->acc_biz_logo) }}");
        $('#applicant_profile_picture').val('');
    });

    // submit form 
    $('#submit-profile-form').click(function(){
        $('.profile-error').html('');
        var formData = new FormData($('#profile-form')[0]);
        $.ajax({
            type: "POST",
            url: "{{ route('ApplicantProfileUpdate') }}",
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
</script>
@endpush


