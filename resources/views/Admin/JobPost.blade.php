@extends('Layout.AdminMain')

@push('title')
    <title>Job Post</title>
@endpush

@section('header')
    @include('Component.Employer.HeaderAJP')
@endsection 

@section('content')
<main id="main" class="main">

<div class="pagetitle mb-3">

    <section class="section profile container-fluid">
        @if($ajp->isEmpty())
            <label class="form-control border-0 p-0 text-center bg-transparent fw-bold">No result found!</label>
        @endif 
        <div class="row mt-3">
            @foreach($ajp as $p)
            <div class="col-lg-4 d-flex justify-content-around">
                <div class="card" style="min-height: 425px; width: 300px;">
                    <div class="card-body d-flex flex-column p-4">
                        <label class="form-control p-0 border-0 text-center">
                            <img src="{{ asset('storage/profile_picture/'.$p->acc_biz_logo) }}" alt="test" style="height: 150px;">
                        </label>
                        
                        <h6 class="fw-bold mt-4">
                            <i class="bi bi-bookmark-plus-fill"></i> {{ $p->jp_title }}
                        </h6>
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
                            <button class="btn btn-sm btn-primary" onclick="retrieve_job_post('{{ $p->jp_id }}')"> View</button>
                        </label>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        {{ $ajp->links() }}
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
                        <b>Posted By:</b>
                        <div class="ps-2">
                            <a href="" id="posted_by">

                            </a>
                        </div>
                    </label>
                    <label class="form-control border-0 p-0 mb-3">
                        <b>Category</b>
                        <select name="category" id="category" class="form-select border-0" readonly disabled style="background-color: #ffffff;">
                            <option value="">--- choose ---</option>
                            @foreach($jc as $c)
                                <option value="{{ $c->jc_id }}">{{ $c->jc_category }}</option>
                            @endforeach 
                        </select>
                        <span class="text-danger job_post-error" id="category-error"></span>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        <b>Title</b>
                        <div class="ps-2" id="title"></div>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        <b>Description</b>
                        <div class="ps-2"  id="description"></div>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        <b>Qualification</b>
                        <div class="ps-2" id="qualification"></div>
                    </label>

                    <label class="form-control border-0 p-0 mb-3">
                        <b>Salary</b>
                        <div class="ps-2" id="salary"></div>
                    </label>
                </form>  
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Close</button>
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
                <form action="{{ route('JobPostApplicant') }}" method="GET">
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

    $('#filter-job-post').click(function(){
        $('#jop_post_search').modal('show');
    });

    function retrieve_job_post($id){
        var url = "{{ route('EmployerYourJobPostingRetrieve', ['id'=>'id']) }}";
        url = url.replace('id', $id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(response){
                data = JSON.parse(response);
                var posted_by = "{{ route('AdminAccountsEmployer', ['id'=>'id']) }}";
                posted_by = posted_by.replace('id', data.jp_acc_id)
                $('#posted_by').attr('href', posted_by);
                $('#posted_by').html(data.acc_firstname+' '+((data.acc_middlename) ? (data.acc_middlename).slice(0, 1)+'. ' : '' )+' '+data.acc_lastname+' ('+data.acc_biz_name+')');
                $('#category').val(data.jp_category);
                $('#title').html(data.jp_title);
                // tinymce.get('qualification').setContent(data.jp_qualification);
                // tinymce.get('description').setContent(data.jp_description);
                $('#qualification').html(data.jp_qualification);
                $('#description').html(data.jp_description);
                $('#salary').html((data.jp_salary).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                $('#jp_id').val(data.jp_id);
                // $('#job-post-save').html('Update');
                $('#job_post_modal').modal('show');
            },
            error: function(response){
                console.log(response);
            }
        })
    }
</script>
@endpush


