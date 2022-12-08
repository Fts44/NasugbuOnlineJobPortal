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
        <h1>Application</h1>
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
                <label class="fw-bold text-center form-control p-0 border-0">Job Application</label>
                
                <table id="datatable" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">ID</th>
                        <th scope="col">Applicant Name</th>
                        <th scope="col">Job Post Description</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Interview Date</th>
                        <th scope="col">Result</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($ja as $a)
                    <tr>
                        <td>{{ $a->ja_id }}</td>
                        <td>
                            {{ (($a->acc_sex) ? 'Mr. ' : 'Ms. ').$a->acc_firstname.' '.$a->acc_lastname }}
                        </td>
                        <td>
                            <b>Title:</b> {{ $a->jp_title }} <br>
                            <b>Salary:</b> {{ number_format($a->jp_salary) }} <br>
                            <b> Category:</b> {{ $a->jc_category }} <br>
                        </td>
                        <td>
                            {{ date_format(date_create($a->ja_date), 'F d, Y') }}
                        </td>
                        <td>
                            @if($a->ja_status=='0')
                                <span class="badge bg-secondary">No Response Yet</span>
                            @elseif($a->ja_status=='1')
                                <span class="badge bg-success">For Interview</span>
                            @else 
                                <span class="badge bg-danger">Rejected</span>
                            @endif
                        </td>
                        <td>
                            @if($a->ja_datetime)
                                {{ date_format(date_create($a->ja_datetime), 'M d, Y h:i a') }} 
                            @else 
                                N/A
                            @endif 
                        </td>
                        <td>
                            @if($a->ja_result == 1)
                               <span class="badge bg-success">Pass</span> 
                            @elseif($a->ja_result == 2)
                                <span class="badge bg-danger">Fail</span>
                            @else 
                                N/A
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-secondary" onclick="respond('{{ $a->ja_id }}')">Respond</button>
                        </td>
                    </tr>
                    @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>

<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="staticBackdropLabel">Application Details</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <label class="form-control text-center border-0 p-0 fw-bold">--- JOB DESCRIPTION ---</label>
                <label class="form-control border-0 p-0">
                    Title
                    <div id="title"></div>
                </label>
                <label class="form-control border-0 p-0 mt-2">
                    Category
                    <div id="category"></div>
                </label>
                <label class="form-control border-0 p-0 mt-2">
                    Salary
                    <div id="salary"></div>
                </label>
                <label class="form-control border-0 p-0 mt-2">
                    Description
                    <div id="description"></div>
                </label>
                <label class="form-control border-0 p-0 mt-2">
                    Qualification
                    <div id="qualification"></div>
                </label>
                <label class="form-control border-0 p-0 mt-2">
                    Resume
                    <div id="resume">
                        <a href="" id="resume-link" target="_blank">ViewResume</a>
                    </div>
                </label>
                <label class="form-control text-center border-0 p-0 fw-bold">--- RESPOND ---</label>

                <form action="" id="respond_form">
                    @csrf 
                    @method('PUT')
                    <label class="form-control border-0 p-0 mt-2">
                        <input type="hidden" name="ja_id" id="ja_id" class="form-control">
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Status
                        <select name="status" id="status" class="form-select">
                            <option value="0">--- choose ---</option>
                            <option value="2">Rejected</option>
                            <option value="1">For Interview</option>
                        </select>
                        <span class="text-danger respond-error" id="status-error"></span>
                    </label>
                    <label class="form-control border-0 p-0 mt-2 d-none interview_date-label">
                        Interview Date
                        <input type="datetime-local" name="interview_date" id="interview_date" class="form-control">
                        <span class="text-danger respond-error" id="interview_date-error"></span>
                    </label>
                    <label class="form-control border-0 p-0 mt-2 d-none result-label">
                        Result
                        <select name="result" id="result" class="form-select">
                            <option value="">--- choose ---</option>
                            <option value="2">Fail</option>
                            <option value="1">Pass</option>
                        </select>
                        <span class="text-danger respond-error" id="result-error"></span>
                    </label>
                </form>
                
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="respond_save">Save</button>
            </div>
        </div>
    </div>
</div>
Scrollin
@endsection
@push('script')
<script src="{{ asset('js/datatable.js') }}"></script>
<script>
    datatable_no_btn_class('#datatable');

    $('#status').change(function(){
        event.preventDefault();
        if($(this).val()==1){
            $('.interview_date-label').removeClass('d-none');
        }
        else{
            $('.interview_date-label').addClass('d-none');
        }
    });

    function respond($id){
        $('#ja_id').val($id);

        var url = "{{ route('JobPostApplicationEmployerDetails', ['id'=>'id']) }}";
        url = url.replace('id', $id);
        $.ajax({
            type: "GET",
            url: url,
            success: function(response){
                data = JSON.parse(response);
                $('#category').val(data.jp_category);
                $('#title').html(data.jp_title);
                $('#description').html(data.jp_description);
                $('#qualification').html(data.jp_qualification);
                $('#salary').html((data.jp_salary).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                var resume_link = "{{ route('ViewResume', ['id'=>'id']) }}";
                resume_link = resume_link.replace('id', $id);
                $('#resume-link').attr("href", resume_link);
                $('#status').val(data.ja_status);
                if(data.ja_status==1){
                    $('.interview_date-label').removeClass('d-none');
                    $('.result-label').removeClass('d-none');
                }
                else{
                    $('.interview_date-label').addClass('d-none');
                    $('.result-label').addClass('d-none');
                }
                $('#interview_date').val(data.ja_datetime);
                $('#status').val(data.ja_status);
                $('#result').val(data.ja_result);
                $('#jp_id').val(data.jp_id);
                $('#modal').modal('show');
            },
            error: function(response){
                console.log(response);
            }
        })
    }

    $('#respond_save').click(function(){
        // respond_form
        var formData = new FormData($('#respond_form')[0]);
        $.ajax({
            type: "POST",
            url: "{{ route('JobPostApplicationEmployerRespond') }}",
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


