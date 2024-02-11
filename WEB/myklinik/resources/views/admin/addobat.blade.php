<x-admint.admin-template :title="$title" :first-menu="$firstMenu" :second-menu="$secondMenu">
    @push('customCss')
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
                        <h4 class="mb-sm-0">Tambah Data Obat</h4>

                        <div class="page-title-right">
                            <ol class="breadcrumb m-0">
                                <li class="breadcrumb-item"><a href="{{route('adm.dashboard')}}">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="{{route('adm.obat')}}">Data Obat</a></li>
                                <li class="breadcrumb-item active">Add</li>
                            </ol>
                        </div>

                    </div>
                </div>
            </div>
            <!-- end page title -->

            <div class="row">
                <div class="col-lg-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div>
                                                <label for="namaObat" class="form-label">Nama Obat <span
                                                        class="text-danger">*</span></label>
                                                <input name="name" type="text" class="form-control" id="namaObat"
                                                       placeholder="Masukkan Nama Obat">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div>
                                                <label for="golonganObat" class="form-label">Golongan Obat</label>
                                                <select class="form-control select" id="golonganObat">
                                                    <option value="">Pilih Golongan</option>
                                                    @foreach($optionGolongan as $golongan)
                                                        <option value="{{$golongan->id}}">{{$golongan->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div>
                                                <label for="kategoriObat" class="form-label">Kategori Obat</label>
                                                <select class="form-control select" id="kategoriObat">
                                                    <option value="">Pilih Kategori</option>
                                                    @foreach($optionKategori as $kategori)
                                                        <option value="{{$kategori->id}}">{{$kategori->name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-lg-3">
                                            <div>
                                                <label for="tipeObat" class="form-label">Tipe Obat</label>
                                                <select class="form-control select" id="golonganObat">
                                                    <option value="">Pilih Tipe</option>
                                                    <option value="serbuk">Serbuk</option>
                                                    <option value="kapsul">Kapsul</option>

                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div>
                                                <label for="namaObat" class="form-label">Harga <span
                                                        class="text-danger">*</span></label>
                                                <input name="name" type="number" class="form-control" id="namaObat"
                                                       placeholder="0">
                                            </div>
                                        </div>
                                        <div class="col-lg-3">
                                            <div>
                                                <label for="namaObat" class="form-label">Stok </label>
                                                <input name="name" type="number" class="form-control" id="namaObat"
                                                       value="0">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4">
                                    <div class="card card-animate bg-primary">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <p class="fw-medium text-white-50 mb-0">Total Data Obat</p>
                                                    <h2 class="mt-4 ff-secondary fw-semibold text-white"><span class="counter-value" data-target="0">0</span> Item</h2>
                                                    <p class="mb-0 text-white-50"><span class="badge bg-white bg-opacity-25 text-white mb-0"><i class="ri-arrow-down-line align-middle"></i> 0 % </span> vs. previous month</p>
                                                </div>
                                                <div>
                                                    <div class="avatar-sm flex-shrink-0">
                                                <span class="avatar-title bg-white bg-opacity-25 rounded-circle fs-2">
                                                    <i data-feather="clock" class="text-white"></i>
                                                </span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- end card body -->
                                    </div> <!-- end card-->
                                </div>
                            </div>


                        </div>
                        <div class="card-footer">
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="button" class="btn btn-success btn-label waves-effect waves-light"><i class="ri-save-2-fill label-icon align-middle fs-16 me-2"></i> SIMPAN</button>
                                    <a href="{{route('adm.obat')}}"><button class="btn btn-danger m-1">BATAL</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--end col-->
            </div><!--end row-->
        </div>
        <!-- container-fluid -->
    </div>

    @push('customJs')
        <script>
            $(document).ready(function() {

            });
        </script>
    @endpush
</x-admint.admin-template>
