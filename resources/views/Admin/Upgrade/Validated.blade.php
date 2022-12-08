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
                <li class="breadcrumb-item"><a href="">Validated</a></li>
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
                        <th scope="col">Validity</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($validated as $r)
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
                        <td>{{ date_format(date_create($r->pa_validity), 'F d, Y') }}</td>
                        <td>
                            @if($r->pa_status=='1')
                                <span class="badge bg-success">Accepted</span>
                            @else if($r->pa_status=='2')
                                <span class="badge bg-secondary">Rejected</span>
                            @endif
                        </td>
                        <td>
                            <a class="btn btn-sm btn-secondary" target="_blank" href="{{ route('ViewDocument', ['id'=>$r->pa_id]) }}">View</a>
                            <button class="btn btn-sm btn-danger" onclick="cancel_application('{{ $fid }}')">Cancel</button>
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
@endsection

@push('script')
<script src="{{ asset('js/datatable.js') }}"></script>
<script>
    datatable_no_btn_class('#datatable');

    function cancel_application($fid){
        swal({
            title: "Are you sure?",
            text: "Your about to cancel application "+$fid+"!",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then(function(value){
            if(value){
                var url = "{{ route('UpgradeValidatedCancel', ['id'=>'fid']) }}";
                url = url.replace('fid', $fid);
                $.ajax({
                    type: "GET",
                    url: url,
                    success: function(response){
                        swal(response.title, response.message, response.icon)
                        .then(function(){
                            location.reload();
                        });  
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