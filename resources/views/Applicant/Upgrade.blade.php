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

    <h1>Upgrade</h1>
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
                <label class="fw-bold text-center form-control p-0 border-0">--- Your Application ---</label>
                <div class="col-lg-12 text-end mb-1">
                    <button class="btn btn-secondary btn-sm" onclick="add_application()">
                        <i class="bi bi-plus-lg"></i>          
                    </button>
                </div>
                
                <table id="datatable" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">ID</th>
                        <th scope="col">Barangay Residency</th>
                        <th scope="col">Date</th>
                        <th scope="col">Validity</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($application as $a)
                        @php $fid = 'AP-'.str_pad($a->pa_id, 5, 0, STR_PAD_LEFT); @endphp
                    <tr>
                        <td>{{ $fid }}</td>
                        <td>{{ $a->pa_file }}</td>
                        <td>{{ date_format(date_create($a->pa_date), 'F d, Y') }}</td>
                        <td>{{ ($a->pa_validity) ? date_format(date_create($a->pa_validity), 'F d, Y') : 'N/A' }}</td>
                        <td>{{ ($a->pa_status) ? ($a->pa_status=='1') ? 'Validated' : 'Rejected' : 'For-Validation' }}</td>
                        <td>
                            <a class="btn btn-sm btn-secondary" target="_blank" href="{{ route('ViewDocument', ['id'=>$a->pa_id]) }}">View</a>
                            <button class="btn btn-sm btn-danger" {{ ($a->pa_status) ? 'disabled' : ''  }} onclick="cancel_application('{{ $a->pa_id }}', '{{ $fid }}')">Cancel</button>
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
                <h1 class="modal-title fs-5" id="modal_label">Upgrade your account</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="business_permit_form">
                    @method('PUT')
                    @csrf

                    <label class="form-control p-0 border-0 mb-3">
                        Date
                        <input type="date" name="date" id="date" class="form-control" value="{{ date('Y-m-d') }}" readonly>
                        <span class="text-danger upgrade-error"></span>
                    </label>
                    <label class="form-control p-0 border-0 mb-3">
                        Barangay Residency 
                        <input type="file" name="business_permit" id="business_permit" class="form-control">
                        <span class="text-danger upgrade-error" id="business_permit-error"></span>
                    </label>
                </form>
                <div class="col-lg-12 p-2" style="font-size: 15px; border: 1px solid black;">
                    <label class="fw-bold text-danger">Note:</label>
                    <label class="d-flex text-justify">
                        &emsp;&emsp;The validity of your account will depends on the date of your barangay residency.
                    </label>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="business_permit_form_submit">Send</button>
            </div>
        </div>
    </div>
</div>
@endsection
@push('script')
<script src="{{ asset('js/datatable.js') }}"></script>
<script>
    datatable_no_btn_class('#datatable');

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
            url: "{{ route('ApplicantUpgradeSend') }}",
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
        var lpa_status = "{{ ($latest_pa) ? $latest_pa->pa_status : '0' }}";
        var lpa_date = "{{ ($latest_pa) ? ($latest_pa->pa_validity >= date('Y-m-d')) ? '1' : '0' : '0' }}";
        if(lpa_status==1 && lpa_date==1){
            swal('Warning', 'Your account is currently upgraded!', 'warning');
        }
        else{
            $('#modal').modal('show');
        }
    }
</script>
@endpush


