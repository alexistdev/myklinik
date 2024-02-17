<x-admint.admin-template :title="$title" :first-menu="$firstMenu" :second-menu="$secondMenu">
    @push('customCss')
        <!--datatable css-->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
        <!--datatable responsive css-->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>

        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
    @endpush
    <div class="page-content">
        <div class="container-fluid">
            <div class="row">
                <x-admint.error-message-component/>
            </div>
            <!-- start page title -->
            <div class="row">
                <div class="col-12">
                    <div class="page-title-box d-sm-flex align-items-center justify-content-between bg-transparent">
                        <h4 class="mb-sm-0">Data Karyawan</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('adm.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Data Karyawan</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-header">
                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                                ADD
                            </button>
                        </div>
                        <div class="card-body">
                            <table id="tableKaryawan"
                                   class="table table-bordered dt-responsive nowrap table-striped align-middle"
                                   style="width:100%">
                                <thead>
                                <tr>
                                    <th data-ordering="false" class="text-center">No.</th>
                                    <th data-ordering="false" class="text-center">NIP</th>
                                    <th data-ordering="false" class="text-center">NAME</th>
                                    <th data-ordering="false" class="text-center">SEX</th>
                                    <th data-ordering="false" class="text-center">POSISI</th>
                                    <th data-ordering="false" class="text-center">EMAIL</th>
                                    <th data-ordering="false" class="text-center">PHONE</th>
                                    <th data-ordering="false" class="text-center">ADDRESS</th>
                                    <th data-ordering="false" class="text-center">CREATED AT</th>
                                    <th class="text-center">ACTION</th>
                                </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->

        </div>
        <!-- container-fluid -->
    </div>

    @push('customJs')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!--datatable js-->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>

            setTimeout(function () {
                    $('.alert').fadeOut('slow');
                }, 2000
            );

            $(document).on("click", ".open-hapus", function (e) {
                e.preventDefault();
                let fid = $(this).data('id');
                $('#golongan_id_delete').val(fid);
            })

            $('.modal').on('hidden.bs.modal', function (e) {
                e.preventDefault();
                let errorInput = $('.errorInput');
                let errorLabel = $('.errorLabel');
                errorInput.removeClass('is-invalid');
                errorLabel.removeClass('text-danger');
            });

            $(document).ready(function () {
                let base_url = "{{route('adm.karyawan')}}";
                $('#tableKaryawan').DataTable({
                    responsive: true,
                    processing: true,
                    serverSide: true,
                    ajax: {
                        type: 'GET',
                        url: base_url,
                        async: true,
                        dataType: 'json',
                    },
                    columns: [
                        {
                            data: 'index',
                            class: 'text-center',
                            defaultContent: '',
                            orderable: false,
                            searchable: false,
                            width: '5%',
                            render: function (data, type, row, meta) {
                                return meta.row + meta.settings._iDisplayStart + 1; //auto increment
                            }
                        },
                        {data: 'nip', class: 'text-left',width: '10%'},
                        {data: 'name', class: 'text-left'},
                        {data: 'sex', class: 'text-center',width: '5%'},
                        {data: 'role', class: 'text-left',width: '10%'},
                        {data: 'email', class: 'text-left',width: '15%'},
                        {data: 'phone', class: 'text-center',width: '10%'},
                        {data: 'alamat', class: 'text-center',width: '15%'},
                        {data: 'created_at', class: 'text-center', width: '10%'},
                        {data: 'action', class: 'text-center', width: '10%', orderable: false},
                    ],
                    "bDestroy": true
                });
            });

        </script>
    @endpush
</x-admint.admin-template>
