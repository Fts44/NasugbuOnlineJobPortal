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
                        <th scope="col">Resume</th>
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
                            <a href="{{ route('ViewResume', ['id'=>$a->ja_id]) }}" target="_blank">ViewResume</a>
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
                                {{ date_format(date_create($a->ja_datetime), 'F d, Y h:i a') }}
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
                            @if($a->ja_status == '1')
                                <a class="btn btn-sm btn-primary" target="_blank" href="{{ route('InterviewPrint', ['id'=>$a->ja_id]) }}"> Print Interview</a>
                            @endif

                            @if($a->ja_result == '1')
                                <a class="btn btn-sm btn-primary" target="_blank" href="{{ route('ResultPrint', ['id'=>$a->ja_id]) }}">Print Result</a>
                            @endif 

                            @if($a->ja_result==0)
                                <button class="btn btn-sm btn-danger" onclick="cancel_application('{{ $a->ja_id }}','{{ $a->ja_id }}')">Cancel</button>
                            @endif
                        </td>
                    </tr>
                    @endforeach 
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</main>
@endsection

@push('script')
<script src="{{ asset('js/datatable.js') }}"></script>
<script>
    datatable_no_btn_class('#datatable');

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
                var url = "{{ route('JobPostApplicantCancel', ['id'=>'id']) }}";
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


