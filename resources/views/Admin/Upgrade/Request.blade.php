@extends('Layout.AdminMain')

@section('header')
    @include('Component.Header')
@endsection 

@section('content')
<main id="main" class="main">

    <div class="pagetitle mb-2">
        <h1>Upgrade</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Request</a></li>
                <!-- <li class="breadcrumb-item">Components</li>
                <li class="breadcrumb-item active">Accordion</li> -->
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="card" id="card-table">

            <div class="card-body px-4">

                <h5 class="card-title">Application</h5>
             
                <table id="datatable" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">ID</th>
                        <th scope="col">Picture</th>
                        <th scope="col">Name</th>
                        <th scope="col">Type</th>
                        <th scope="col">File</th>
                        <th scope="col">Date</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($request as $r)
                    <tr>
                        @php $fid = str_pad($r->pa_id, 6, 0, STR_PAD_LEFT); @endphp
                        <td>{{ $fid }}</td>
                        <td class="text-center">
                            <img src="{{ asset('storage/profile_picture/'.$r->acc_biz_logo) }}" alt="" style="width: 50px;">
                        </td>
                        <td>
                            @php 
                                if($r->acc_classification=='employer'){
                                    $name = $r->acc_firstname.' '.(($r->acc_middlename) ? $r->acc_middlename[0].'. ' : ' ').' '.$r->acc_lastname.' ('.$r->acc_biz_name.')';
                                }
                                else{
                                    $name = $r->acc_firstname.' '.(($r->acc_middlename) ? $r->acc_middlename[0].'. ' : ' ').' '.$r->acc_lastname;
                                }
                            @endphp 
                            {{ $name }}
                        </td>
                        <td>{{ ucwords($r->acc_classification) }}</td>
                        <td>{{ $r->pa_file }}</td>
                        <td>{{ date_format(date_create($r->pa_date), 'F d, Y') }}</td>
                        <td>
                            <span class="badge bg-secondary">Unvalidated</span>
                        </td>
                        <td>
                        <a class="btn btn-sm btn-secondary" target="_blank" href="{{ route('ViewDocument', ['id'=>$r->pa_id]) }}">View</a>
                            <button class="btn btn-sm btn-primary" onclick="respond('{{ $fid }}','{{ $name }}','{{ ucwords($r->acc_classification) }}','{{ $r->pa_date }}','{{ $r->pa_id }}')">Respond</button>
                        </td>
                    </tr>
                    @endforeach 
                    </tbody>
                </table>

            </div>

        </div>

    </section>

</main>
<!-- main -->

<div class="modal fade" id="modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal_label">Respond</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="respond_form">
                    @method('PUT')
                    @csrf

                    <label class="form-control border-0 p-0">
                        ID
                        <input type="text" name="id" id="id" class="form-control" readonly>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Account Name
                        <input type="text" name="an" id="an" class="form-control" readonly>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Type
                        <input type="text" name="typ" id="typ" class="form-control" readonly>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Application Date
                        <input type="date" name="ad" id="ad" class="form-control" readonly>
                    </label>
                    <label class="form-control border-0 p-0 mt-2">
                        Respond
                        <select name="respond" id="respond" class="form-select">
                            <option value="">--- choose ---</option>
                            <option value="1">Accept</option>
                            <option value="0">Reject</option>
                        </select>
                        <span class="text-danger respond-error" id="respond-error"></span>
                    </label>
                    <label class="form-control border-0 p-0 mt-2 accepted-label d-none">
                        Validity
                        <input type="date" name="validity_date" id="validity_date" class="form-control">
                        <span class="text-danger respond-error" id="validity_date-error"></span>
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
@endsection

@push('script')
<script src="{{ asset('js/datatable.js') }}"></script>
<script>
    datatable_no_btn_class('#datatable');
    var rspn_id = '';
    function respond(fid, an, t, ad, id){
        rspn_id = id;
        $('#id').val(fid);
        $('#an').val(an);
        $('#typ').val(t);
        $('#ad').val(ad);
        $('#modal').modal('show');
    }

    $('#respond').change(function(){
        if($(this).val()==1){
            $('.accepted-label').removeClass('d-none');
        }
        else{
            $('.accepted-label').addClass('d-none');
        }
    });

    respond_form

    $('#respond_save').click(function(){
        var url = "{{ route('UpgradeRequestRespond', ['id'=>'id']) }}";
        url = url.replace('id', rspn_id);
        var formData = new FormData($('#respond_form')[0]);
        $.ajax({
            type: "POST",
            url: url,
            contentType: false,
            processData: false,
            data: formData,
            enctype: 'multipart/form-data',
            success: function(response){
                $('.respond-error').html("");
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
                // response = JSON.parse(response);
                console.log(response);
            }
        })
    });
</script>
@endpush 