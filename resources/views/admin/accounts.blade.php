@extends('layout.main')

@section('content')
<main id="main" class="main">

    <section class="section">

        <div class="card" id="card-table">

            <div class="card-body px-4">

                <h5 class="card-title">Employers</h5>

                <table id="datatable" class="table table-bordered" style="width: 100%;">
                    <thead class="table-light">
                        <th scope="col">AccID</th>
                        <th scope="col">Name</th>
                        <th scope="col">Address</th>
                        <th scope="col">Company</th>
                        <th scope="col"></th>
                        <th scope="col">Action</th>
                    </thead>
                    <tbody>
                        <tr>
                            <td>1</td>
                            <td>Joseph E. Calma</td>
                            <td>Lumbangan, Tuy, Batangas</td>
                            <td>Straive</td>
                            <td>
                                <button class="btn btn-primary btn-sm">
                                    <i class="bi-pencil"></i>
                                </button>
                                <button class="btn btn-danger btn-sm">
                                    <i class="bi-eraser"></i>
                                </button>
                            </td>
                        </tr>
                    </tbody>
                </table>

            </div>

        </div>

    </section>

</main>
<!-- main -->
@endsection