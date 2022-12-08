@extends('Layout.AdminMain')

@section('header')
    @include('Component.Header')
@endsection 

@section('content')
<main id="main" class="main">

    <div class="pagetitle mb-2">
        <h1>Accounts</h1>
        <nav style="--bs-breadcrumb-divider: '>';">
            <ol class="breadcrumb">
                <li class="breadcrumb-item">Applicant</li>
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="card" id="card-table">

            <div class="card-body px-4">

                <h5 class="card-title">Applicant</h5>

                <table id="datatable" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">ID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Contact</th>
                        <th scope="col">Address</th>
                        <th scope="col">Picture</th>
                        <th scope="col">Status</th>
                        <th scope="col">Disabled</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($app as $e)
                    <tr>
                        @php $fid = str_pad($e->acc_id, 6, 0, STR_PAD_LEFT); @endphp
                        <td>{{ $fid }}</td>
                        <td>{{ $e->acc_firstname." ".$e->acc_lastname }}</td>
                        <td>{{ $e->acc_email }}</td>
                        <td>{{ $e->acc_phone }}</td>
                        <td>{{ $e->eb.", ".$e->em.", ".$e->ep }}</td>
                        <td class="text-center">
                            <img src="{{ asset('storage/profile_picture/'.$e->acc_biz_logo) }}" alt="" style="width: 50px;">
                        </td>
                        <td>
                            @if($e->status=='1')
                                <span class="badge bg-success">Upgraded</span>
                            @else 
                                <span class="badge bg-secondary">Normal</span>
                            @endif 
                        </td>
                        <td>
                            @if($e->acc_banned_status)
                                <span class="badge bg-danger">Disabled</span>
                            @else 
                                <span class="badge bg-success">Enabled</span>
                            @endif 
                        </td>
                        <td>
                            <a href="{{ route('AdminAccountsApplicant', ['id'=>$e->acc_id]) }}" class="btn btn-sm btn-primary">View</a>
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

</script>
@endpush 