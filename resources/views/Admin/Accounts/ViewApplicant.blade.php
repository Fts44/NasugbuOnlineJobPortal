@extends('Layout.AdminMain')

@push('title')
    <title></title>
@endpush

@section('header')
    @include('Component.Header')
@endsection 

@section('content')
<main id="main" class="main">
    <div class="pagetitle mb-2">
        <h1>Accounts</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Employer</li>
                <li class="breadcrumb-item">View</li>
            </ol>
        </nav>
    </div>
    <section class="section profile">
        <div class="card">
            <div class="card-body pt-3">
                <form id="profile-form">
                    @method('PUT')
                    @csrf
                    <div class="row mb-3">
                        <div class="col-lg-12 d-flex flex-column align-items-center mt-1">
                            <img id="business_logo_preview" class="form-control p-1" src="{{ asset('storage/profile_picture/'.$acc->acc_biz_logo) }}" alt="Bussiness Logo" style="height: 200px; width: 200px;">     
                        </div>
                    </div>

                    <div class="row mb-3 mt-5">
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Firstname
                                <input type="text" class="form-control" name="employer_firstname" id="employer_firstname" value="{{ $acc->acc_firstname }}" disabled>
                                <span class="text-danger profile-error" id="employer_firstname-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Middlename
                                <input type="text" class="form-control" name="employer_middlename" id="employer_middlename" value="{{ $acc->acc_middlename }}" disabled>
                                <span class="text-danger profile-error" id="employer_middlename-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Lastname
                                <input type="text" class="form-control" name="employer_lastname" id="employer_lastname" value="{{ $acc->acc_lastname }}" disabled>
                                <span class="text-danger profile-error" id="employer_lastname-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control border-0 p-0">
                                Suffixname
                                <input type="text" class="form-control" name="employer_suffixname" id="employer_suffixname" value="{{ $acc->acc_suffixname }}" disabled>
                                <span class="text-danger profile-error" id="employer_suffixname-error"></span>
                            </label>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Email
                                <input type="text" name="employer_email" id="employer_email" class="form-control" value="{{ $acc->acc_email }}" disabled>
                                <span class="text-danger profile-error" id="employer_email-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Phone
                                <input type="text" name="employer_phone" id="employer_phone" class="form-control" value="{{ $acc->acc_phone }}" disabled>
                                <span class="text-danger profile-error" id="employer_phone-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Birthdate
                                <input type="date" name="employer_birthdate" id="employer_birthdate" class="form-control" value="{{ $acc->acc_birthdate }}" disabled>
                                <span class="text-danger profile-error" id="employer_birthdate-error"></span>
                            </label>
                        </div>
                        <div class="col-lg-3">
                            <label class="form-control p-0 border-0">
                                Sex
                                <select name="employer_sex" id="employer_sex" class="form-select" disabled>
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
                                <select name="employer_province" id="employer_province" class="form-select" disabled>
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
                                <select name="employer_municipality" id="employer_municipality" class="form-select" disabled>
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
                                <select name="employer_barangay" id="employer_barangay" class="form-select" disabled>
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
                            <a href="{{ route('AccountsApplicant') }}" class="btn btn-sm btn-primary">Back</a>
                            @if(!$acc->acc_banned_status)
                                <button type="button" class="btn btn-sm btn-danger" onclick="disable('{{ $acc->acc_id }}')">Disable Account</button>
                            @else
                                <button type="button" class="btn btn-sm btn-secondary" onclick="enable('{{ $acc->acc_id }}')">Enable Account</button>
                            @endif
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
    function disable($id){
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Your about to block this account!",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then(function(value){
            if(value){
                var url = "{{ route('BanAccounts', ['id'=>'id']) }}";
                url = url.replace('id', $id);
                $.ajax({
                    type: "PUT",
                    url: url,
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "_token": "{{csrf_token()}}",
                    }),
                    success: function(response){
                        swal(response.title, response.message, response.icon)
                        .then(function(){
                            location.reload();
                        }); 
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            }
        });   
    }

    function enable($id){
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Your about to unblock this account!",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then(function(value){
            if(value){
                var url = "{{ route('UnbanAccounts', ['id'=>'id']) }}";
                url = url.replace('id', $id);
                $.ajax({
                    type: "PUT",
                    url: url,
                    contentType: 'application/json',
                    data: JSON.stringify({
                        "_token": "{{csrf_token()}}",
                    }),
                    success: function(response){
                        swal(response.title, response.message, response.icon)
                        .then(function(){
                            location.reload();
                        }); 
                    },
                    error: function(response){
                        console.log(response);
                    }
                });
            }
        });   
    }
</script>
@endpush


