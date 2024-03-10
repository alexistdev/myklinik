<x-admint.admin-template :title="$title" :first-menu="$firstMenu" :second-menu="$secondMenu">
    @push('customCss')
        <!--datatable css-->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"/>
        <!--datatable responsive css-->
        <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css"/>

        <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
        <style>
            .select option {
                color: whitesmoke !important;
                background: #3b439d !important;
            }
        </style>
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
                        <h4 class="mb-sm-0">Pendaftaran Pasien</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('front.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item active">Pendaftaran Pasien</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->
            <form action="{{route('front.pendaftaran')}}" method="post">
                @csrf
                <div class="row">
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="col-xl-4 col-md-6">
                                    <div class="card card-animate">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p class="fw-medium text-muted mb-0">Pasien Mengantri</p>
                                                    <h2 class="mt-4 ff-secondary fw-semibold"><span
                                                            class="counter-value" data-target="0">0</span></h2>
                                                    <p class="mb-0 text-muted">Berikutnya No<span
                                                            class="badge bg-light text-success mb-0"><i
                                                                class="ri-arrow-up-line align-middle"></i> 0 </span></p>
                                                </div>
                                                <div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-info-subtle rounded-circle fs-2">
                                                    <i data-feather="users" class="text-info"></i>
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-4">
                                        <label for="kodePasien" class="form-label">KODE PASIEN <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <div class="input-group">
                                            <input type="text" name="kode_pasien" class="form-control"
                                                   aria-label="Check Pasien" id="kodePasien" placeholder="AUTO GENERATE"
                                                   readonly>
                                            <button class="btn btn-outline-success" type="button" id="check"
                                                    data-bs-toggle="modal" data-bs-target="#exampleModal"><i
                                                    class="ri-search-2-line"></i></button>
                                            <button class="btn btn-outline-primary" type="button" id="newPasien"><i
                                                    class="ri-add-box-fill"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-lg-8">
                                        <label for="hargaObat" class="form-label">NAMA LENGKAP <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <input type="text" class="form-control" placeholder="NAMA LENGKAP">
                                    </div>
                                </div>
                                <div class="row mt-4">
                                    <div class="col-lg-4">
                                        <label for="hargaObat" class="form-label">TEMPAT LAHIR <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <input type="text" class="form-control" placeholder="NAMA LENGKAP">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="hargaObat" class="form-label">TANGGAL LAHIR <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <input type="text" class="form-control" placeholder="NAMA LENGKAP">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="sex" class="form-label">JENIS KELAMIN </label>
                                        <select name="sex" id="sex" class="form-control select">
                                            <option value="{{\App\Enum\GenderEnum::PRIA}}"
                                                    @if(\App\Enum\GenderEnum::PRIA == old('sex')) selected @endif>Pria
                                            </option>
                                            <option value="{{\App\Enum\GenderEnum::WANITA}}"
                                                    @if(\App\Enum\GenderEnum::WANITA == old('sex')) selected @endif>
                                                Wanita
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-4">
                                        <label for="agama" class="form-label">AGAMA </label>
                                        <select name="agama" id="agama" class="form-control select">
                                            <option value="ISLAM" @if("ISLAM" == old('agama')) selected @endif>ISLAM
                                            </option>
                                            <option value="KATOLIK" @if("KATOLIK" == old('agama')) selected @endif>
                                                KATOLIK
                                            </option>
                                            <option value="KRISTEN" @if("KRISTEN" == old('agama')) selected @endif>
                                                KRISTEN
                                            </option>
                                            <option value="HINDU" @if("HINDU" == old('agama')) selected @endif>HINDU
                                            </option>
                                            <option value="BUDHA" @if("BUDHA" == old('agama')) selected @endif>BUDHA
                                            </option>
                                            <option value="KONGHUCU" @if("KONGHUCU" == old('agama')) selected @endif>
                                                KONGHUCU
                                            </option>
                                            <option value="KEPERCAYAAN"
                                                    @if("KEPERCAYAAN" == old('agama')) selected @endif>KEPERCAYAAN
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="pendidikan" class="form-label">PENDIDIKAN </label>
                                        <select name="pendidikan" id="pendidikan" class="form-control select">
                                            <option value="SD" @if("SD" == old('pendidikan')) selected @endif>SD
                                            </option>
                                            <option value="SMP" @if("SMP" == old('pendidikan')) selected @endif>SMP
                                            </option>
                                            <option value="SMA/SMK" @if("SMA/SMK" == old('pendidikan')) selected @endif>
                                                SMA/SMK
                                            </option>
                                            <option value="D1/D2/D3"
                                                    @if("D1/D2/D3" == old('pendidikan')) selected @endif>D1/D2/D3
                                            </option>
                                            <option value="S1" @if("S1" == old('pendidikan')) selected @endif>S1
                                            </option>
                                            <option value="S2" @if("S2" == old('pendidikan')) selected @endif>S2
                                            </option>
                                            <option value="S3" @if("S3" == old('pendidikan')) selected @endif>S3
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="golongan_darah" class="form-label">GOLONGAN DARAH </label>
                                        <select name="golongan_darah" id="golongan_darah" class="form-control select">
                                            <option value="A" @if("A" == old('golongan_darah')) selected @endif>A
                                            </option>
                                            <option value="B" @if("B" == old('golongan_darah')) selected @endif>B
                                            </option>
                                            <option value="AB" @if("AB" == old('golongan_darah')) selected @endif>AB
                                            </option>
                                            <option value="O" @if("O" == old('golongan_darah')) selected @endif>O
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-4">
                                        <label for="hargaObat" class="form-label">PHONE <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <input type="text" class="form-control" placeholder="PHONE">
                                    </div>
                                    <div class="col-lg-4">
                                        <label for="hargaObat" class="form-label">PEKERJAAN <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <input type="text" class="form-control" placeholder="PEKERJAAN">
                                    </div>
                                </div>

                                <div class="row mt-4">
                                    <div class="col-lg-12">
                                        <label for="hargaObat" class="form-label">ALAMAT <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <textarea name="" class="form-control" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div><!--end col-->
                    <div class="col-lg-4">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <label for="hargaObat" class="form-label">TEKANAN DARAH (TD) <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <input type="text" class="form-control" placeholder="mmHg">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <label for="hargaObat" class="form-label">N <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <input type="text" class="form-control" placeholder="x/min">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <label for="hargaObat" class="form-label">RATE <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <input type="text" class="form-control" placeholder="x/min">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <label for="hargaObat" class="form-label">SUHU <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <input type="text" class="form-control" placeholder="*C">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <label for="hargaObat" class="form-label">BERAT BADAN <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <input type="text" class="form-control" placeholder="kg">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <label for="hargaObat" class="form-label">TINGGI BADAN <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <input type="text" class="form-control" placeholder="cm">
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <label for="hargaObat" class="form-label">KELUHAN <span
                                                class="text-danger">*</span></label>
                                        <!-- Buttons Input -->
                                        <textarea name="" class="form-control" id="" cols="30" rows="3"></textarea>
                                    </div>
                                </div>
                                <div class="row mt-2">
                                    <div class="col-lg-12">
                                        <button class="btn btn-sm btn-success" type="submit">SIMPAN</button>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div><!--end row-->
            </form>
        </div>
        <!-- container-fluid -->
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Temukan Pasien</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table id="tablePasien"
                           class="table table-bordered dt-responsive nowrap table-striped align-middle"
                           style="width:100%">
                        <thead>
                        <tr>
                            <th data-ordering="false" class="text-center">No.</th>
                            <th data-ordering="false" class="text-center">KODE PASIEN</th>
                            <th data-ordering="false" class="text-center">NAMA</th>
                            <th data-ordering="false" class="text-center">ALAMAT</th>
                            <th data-ordering="false" class="text-center">PHONE</th>
                            <th class="text-center">ACTION</th>
                        </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Batal</button>
                    <button type="button" class="btn btn-success" data-bs-dismiss="modal">PASIEN BARU</button>
                </div>
            </div>
        </div>
    </div>
    @push('customJs')
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"
                integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
        <!--datatable js-->
        <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
        <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
        <script>

            let input = $('.inputForm');


            function generateNewCode() {
                let urlGenerateCode = '{{route('front.ajax.getCode')}}';
                let kodePasien = document.getElementById('kodePasien')

                $.ajax({
                    url : urlGenerateCode,
                    type : 'GET',
                    dataType:'json',
                    success : function(response) {
                        kodePasien.value = response;
                    },
                    error : function(request,error)
                    {
                        console.log(error);
                    }
                });
            }

            input.keyup(function () {
                let val = $(this).val().toLowerCase();
                $(this).val(val);
            })

            setTimeout(function () {
                    $('.alert').fadeOut('slow');
                }, 2000
            );

            $(document).on("click", ".open-edit", function (e) {
                e.preventDefault();
                let fid = $(this).data('id');
                let fname = $(this).data('name');
                $('#golongan_id').val(fid);
                $('#nameEdit').val(fname);
            })

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
                let base_url = "{{route('front.ajax.getdatapasien')}}";
                let buttonNew = document.getElementById('newPasien');
                buttonNew.addEventListener("click", generateNewCode);

                $('#tablePasien').DataTable({
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
                        {data: 'kode_pasien', class: 'text-left', width: '10%'},
                        {data: 'nama_lengkap', class: 'text-left'},
                        {data: 'alamat', class: 'text-left'},
                        {data: 'phone', class: 'text-center', width: '5%'},
                        // {data: 'poliklinik', class: 'text-center',width: '10%'},
                        // {data: 'email', class: 'text-left',width: '15%'},
                        // {data: 'phone', class: 'text-center',width: '10%'},
                        // {data: 'alamat', class: 'text-center',width: '15%'},
                        // {data: 'created_at', class: 'text-center', width: '10%'},
                        {data: 'action', class: 'text-center', width: '10%', orderable: false},
                    ],
                    "bDestroy": true
                });
            });
        </script>
    @endpush
</x-admint.admin-template>
