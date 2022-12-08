@extends('Layout.EmployerMain')

@push('title')
    <title>Your Postings</title>
@endpush

@section('header')
    @include('Component.Employer.HeaderYJP')
@endsection 

@section('content')
<main id="main" class="main">

    <section class="section profile container-fluid">
        @if($yjp->isEmpty())
            <label class="form-control border-0 p-0 text-center bg-transparent fw-bold">No result found!</label>
        @endif 
        <div class="row mt-3">
            @foreach($yjp as $p)
            <div class="col-lg-4 d-flex justify-content-around">
                <div class="card" style="min-height: 425px; width: 300px;">
                    <div class="card-body d-flex flex-column p-4">
                        <label class="form-control p-0 border-0 text-center">
                            <img src="{{ asset('storage/profile_picture/'.$p->acc_biz_logo) }}" alt="test" style="height: 150px;">
                        </label>
                        
                        <h6 class="fw-bold mt-4">
                            <i class="bi bi-bookmark-plus-fill"></i>{{ $p->jp_title }}
                        </h6>
                        <label>
                            <i class="bi bi-tags"></i> {{ $p->jc_category }}
                        </label>
                        <label>
                            <i class="bi bi-shop"></i> {{$p->acc_biz_name}}
                        </label>
                        <label class="bg-transparent form-control border-0 p-0 mt-3">
                            <i class="bi bi-geo-alt"></i> {{ $p->prov_name.', '.$p->mun_name.', '.$p->brgy_name }}
                        </label>
                        <label class="bg-transparent form-control border-0 p-0 mt-3">
                            <i class="bi bi-cash-stack"></i> {{ number_format($p->jp_salary) }}
                        </label>

                        <label class="bg-transparent form-control border-0 p-0 mt-auto align-self-end card-footer">
                            <button class="btn btn-sm btn-primary" onclick="retrieve_job_post('{{ $p->jp_id }}')"> Edit</button>
                            <button class="btn btn-sm btn-danger" onclick='delete_job_post("{{ $p->jp_id }}","{{ $p->jp_title }}")'> Remove</button>
                        </label>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $yjp->links() }}
    </section>
</main>

<div class="modal fade" id="job_post_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="job_post_modal_label">Job Post</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="job_post_form">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="jp_id" id="jp_id">
                    <label class="form-control border-0 p-0 mb-3">
                        Available Post for today:
                        <input type="text" class="form-control" name="available_post" id="available_post" value="{{ (session('account_status')) ? ((session('account_status')->pa_status=='1') ? 'Unlimited' : ((session('jc_count_today')>0) ? '0' : '1')) : (session('jc_count_today')) ? 0 : 1 }}" readonly>
                        <span class="text-danger job_post-error" id="available_post-error"></span>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        Category:
                        <select name="category" id="category" class="form-select">
                            <option value="">--- choose ---</option>
                            @foreach($jc as $c)
                                <option value="{{ $c->jc_id }}">{{ $c->jc_category }}</option>
                            @endforeach 
                        </select>
                        <span class="text-danger job_post-error" id="category-error"></span>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        Title:
                        <input type="text" name="title" id="title" class="form-control">
                        <span class="text-danger job_post-error" id="title-error"></span>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        Description:
                        <textarea name="description" id="description"></textarea>
                        <span class="text-danger job_post-error" id="description-error"></span>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        Qualification:
                        <textarea name="qualification" id="qualification"></textarea>
                        <span class="text-danger job_post-error" id="qualification-error"></span>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        Salary:
                        <input type="number" name="salary" id="salary" class="form-control">
                        <span class="text-danger job_post-error" id="salary-error"></span>
                    </label>
                </form>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="job-post-save">Add</button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="jop_post_search" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="jop_post_search_label">Filter</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{ route('EmployerYourJobPosting') }}" method="GET">
                    <label class="form-control border-0 p-0">
                        Job Title 
                        <input type="text" name="af_title" id="af_title" class="form-control" value="{{ $title }}">
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Category
                        <select name="af_category" id="af_category" class="form-select">
                            <option value="">All</option>
                            @foreach($jc as $c)
                                <option value="{{ $c->jc_id }}" {{ ($c->jc_id==$category) ? 'selected' : '' }}>{{ $c->jc_category }}</option>
                            @endforeach 
                        </select>
                    </label>
                    <div class="row mt-2">
                        <label class="col-lg-12">
                            Salary
                        </label>
                        <div class="col-lg-6">
                            <input type="number" name="af_salary_min" id="af_salary_min" value="{{ $salary_min }}" class="form-control" placeholder="Min">
                        </div>
                        <div class="col-lg-6">
                            <input type="number" name="af_salary_max" id="af_salary_max" value="{{ $salary_max }}" class="form-control" placeholder="Max">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Search</button>
                    </div>
                </form>
            </div>
            
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('js/datatable.js') }}"></script>
<script>
    datatable_no_btn_class('#datatable');

    const textArea = tinymce.init({
        selector: "textarea#description, textarea#qualification",
        height: 150,
        plugins: [
            'lists'
        ],
        menubar:false,
        statusbar: false,
        toolbar: 'undo redo | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist',
        spellchecker_dialog: true,
        skin: 'jam',
        icons: 'jam',
    });


    $('#business_permit').change(function(){
        $('#business_permit-error').html("");
        let file = $("input[type=file]").get(0).files[0];
        let MAX_FILE_SIZE = 5 * 1024 * 1024;
        let fileSize = this.files[0].size;

        if (fileSize > MAX_FILE_SIZE) {
            $('#business_permit-error').html("File must no be greater than 5mb!");
            $(this).val('');
        } 
        else {
            var allowed_extensions = new Array("pdf", "jpg", "png");
            var fileName = this.files[0].name;
            var file_extension = fileName.split('.').pop().toLowerCase(); 

            if((allowed_extensions.includes(file_extension))==true){
                var reader = new FileReader();
                reader.readAsDataURL(file);
            }
            else{
                $('#business_permit-error').html("Invalid file type!");
                $(this).val('');
            }
        }
    });

    $('#business_permit_form_submit').click(function(){
        $('.profile-error').html('');
        var formData = new FormData($('#business_permit_form')[0]);
        $.ajax({
            type: "POST",
            url: "{{ route('EmployerUpgradeSend') }}",
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

    function cancel_application($id, $fid){
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Your about to cancel "+$fid+"!",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then(function(value){
            if(value){
                var url = "{{ route('EmployerUpgradeCancel', ['id'=>'id']) }}";
                url = url.replace('id', $id);
                $.ajax({
                    type: "GET",
                    url: url,
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
            }
        });
    }

    function add_application(){
        if(lpa_status==1 && lpa_date==1){
            swal('Warning', 'Your account is currently valid!', 'warning');
        }
        else{
            $('#modal').modal('show');
        }
    }

    $('#add-job-post').click(function(){
        $('#job_post_modal').modal('show');
    });

    $('#search-job-post').click(function(){
        alert('test');
    });

    $('#filter-job-post').click(function(){
        $('#jop_post_search').modal('show');
    });


    $('#job-post-save').click(function(){
        $('.job_post-error').html('');
        var formData = new FormData($('#job_post_form')[0]);
        formData.append('description', tinymce.get("description").getContent());
            formData.append('qualification', tinymce.get("qualification").getContent());

        if($(this).html()=='Add'){
            $.ajax({
                type: "POST",
                url: "{{ route('EmployerYourJobPostingInsert') }}",
                contentType: false,
                processData: false,
                data: formData,
                success: function(response){
                    console.log(response);
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
        }
        else{
            var url = "{{ route('EmployerYourJobPostingUpdate', ['id'=>'id']) }}";
            url = url.replace('id', $('#jp_id').val());
            $.ajax({
                type: "POST",
                url: url,
                contentType: false,
                processData: false,
                data: formData,
                success: function(response){
                    console.log(response);
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
        }
    });

    function retrieve_job_post($id){
        var url = "{{ route('EmployerYourJobPostingRetrieve', ['id'=>'id']) }}";
        url = url.replace('id', $id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(response){
                data = JSON.parse(response);
                $('#category').val(data.jp_category);
                $('#title').val(data.jp_title);
                tinymce.get('qualification').setContent(data.jp_qualification);
                tinymce.get('description').setContent(data.jp_description);
                $('#salary').val(data.jp_salary);
                $('#jp_id').val(data.jp_id);
                $('#job-post-save').html('Update');
                $('#job_post_modal').modal('show');
            },
            error: function(response){
                // response = JSON.parse(response);
                console.log(response);
            }
        })
    }

    function delete_job_post($id, $title){
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Your about to delete "+$title+"!",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then(function(value){
            if(value){
                var url = "{{ route('EmployerYourJobPostingDelete', ['id'=>'id']) }}";
                url = url.replace('id', $id);
                $.ajax({
                    type: "GET",
                    url: url,
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
            }
        });
    }
</script>
@endpush


