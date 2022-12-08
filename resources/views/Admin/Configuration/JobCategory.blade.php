@extends('Layout.AdminMain')

@section('header')
    @include('Component.Header')
@endsection 

@section('content')
<main id="main" class="main">

    <div class="pagetitle mb-2">
        <h1>Configuration</h1>
        <nav>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="">Job Category</a></li>
                <!-- <li class="breadcrumb-item">Components</li>
                <li class="breadcrumb-item active">Accordion</li> -->
            </ol>
        </nav>
    </div>

    <section class="section">

        <div class="card" id="card-table">

            <div class="card-body px-4">

                <h5 class="card-title">Job Category</h5>
            
                <div class="col-lg-12 text-end mb-1">
                    <button class="btn btn-secondary btn-sm" onclick="add_category()">
                        <i class="bi bi-plus-lg"></i>          
                    </button>
                </div>
                
                <table id="datatable" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">ID</th>
                        <th scope="col">Job Category</th>
                        <th scope="col">Status</th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                    @foreach($jc as $c)
                    <tr>
                        <td>{{ $c->jc_id }}</td>
                        <td>{{ $c->jc_category }}</td>
                        <td>
                            @if($c->jc_status)
                                <span class="badge bg-success">Active</span>
                            @else 
                                <span class="badge bg-secondary">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <button class="btn btn-sm btn-primary" onclick="edit_category('{{ $c->jc_id }}','{{ $c->jc_category }}','{{ $c->jc_status }}')">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="delete_category('{{ $c->jc_id }}','{{ $c->jc_category }}')">Delete</button>
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

<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modal_label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modal_label">Job Category</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="" id="form_job_category">
                    @csrf 
                    @method('PUT')
                    <input type="hidden" name="jc_id" id="jc_id">
                    <label class="form-control border-0 p-0 mb-3">
                        Job Category:
                        <input type="text" name="job_category" id="job_category" class="form-control">
                        <span class="text-danger job_category-error" id="job_category-error"></span>
                    </label>
                    <label class="form-control border-0 p-0 mb-3">
                        Status:
                        <select name="category_status" id="category_status" class="form-select">
                            <option value="0">Inactive</option>
                            <option value="1">Active</option>
                        </select>
                    </label>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="form_job_category_submit">Add</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="{{ asset('js/datatable.js') }}"></script>
<script>
    datatable_no_btn_class('#datatable');
    function clear(){
        $('#form_job_category_submit').html('Add');
        $('#jc_id').val('');
        $('#job_cateogry').val('');
        $('#category_status').val('0');
    }

    function add_category(){
        clear();
        $('#modal').modal('show');
    }

    function edit_category(id, category, status){
        $('#form_job_category_submit').html('Update');
        $('#jc_id').val(id);
        $('#job_category').val(category);
        $('#category_status').val(status);
        $('#modal').modal('show');
    }

    function delete_category($id, $category){
        event.preventDefault();
        swal({
            title: "Are you sure?",
            text: "Your about to delete "+$category+"!",
            icon: "warning",
            buttons: ["Cancel", "Yes"],
            dangerMode: true,
        }).then(function(value){
            if(value){
                var url = "{{ route('AdminConfigurationJCDelete', ['id'=>'id']) }}";
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
    $('#form_job_category_submit').click(function(){
        $('.job_category-error').html('');
        var formData = new FormData($('#form_job_category')[0]);
        if($(this).html()=='Add'){
            $.ajax({
                type: "POST",
                url: "{{ route('AdminConfigurationJCInsert') }}",
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
        }
        else{
            var url = "{{ route('AdminConfigurationJCUpdate', ['id'=>'id']) }}";
            url = url.replace('id', $('#jc_id').val());
            $.ajax({
                type: "POST",
                url: url,
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
        }
    });
</script>
@endpush 