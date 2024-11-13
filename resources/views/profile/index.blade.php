@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="page-header min-height-300 border-radius-xl mt-4"
            style="background-image: url('../assets/img/curved-images/curved0.jpg'); background-position-y: 50%;">
            <span class="mask bg-gradient-primary opacity-6"></span>
        </div>
        <div class="card card-body blur shadow-blur mx-4 mt-n6 overflow-hidden">
            <div class="row gx-4">
                <div class="col-auto">
                    <div class="avatar avatar-xl position-relative">
                        <img src="{{ asset('assets/img/default-user.png') }}" alt="profile_image" class="w-100">
                    </div>
                </div>
                <div class="col-auto my-auto">
                    <div class="h-100">
                        <h5 class="mb-1">
                            {{ $user->customers->FName . ' ' . $user->customers->LName }}
                        </h5>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid py-4">
        <div class="row">
            <div class="nav-wrapper position-relative end-0 mt-3">
                <ul class="nav nav-tabs nav-fill p-1" id="myTab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link mb-0 px-0 py-2 active" id="home-tab" data-bs-toggle="tab"
                            data-bs-target="#profile" role="tab" type="button" aria-controls="home"
                            aria-selected="true" style="color: #495057;">
                            <i class="ni ni-badge text-sm me-2"></i> My Profile
                        </button>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link mb-0 px-0 py-2" data-bs-toggle="tab" href="#alamat" role="tab"
                            aria-controls="code" aria-selected="false" style="color: #495057;">
                            <i class="ni ni-laptop text-sm me-2"></i> Alamat
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                    <div class="col-12 col-xl-12">
                        <div class="card h-100">
                            <div class="card-header pb-0 p-3">
                                <h6 class="mb-0">Ubah Biodata Diri</h6>
                            </div>
                            <div class="card-body p-3">
                                <form action="{{ route('profile.update', $user->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h6 class="text-uppercase text-body text-xs font-weight-bolder">Username
                                                </h6>
                                                <input type="text"
                                                    class="form-control @error('name') is-invalid @enderror" id="username"
                                                    name="name" placeholder="Username"
                                                    value="{{ old('name', $user->name) }}">
                                                @error('name')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h6 class="text-uppercase text-body text-xs font-weight-bolder">Email</h6>
                                                <input type="email" placeholder="Email" readonly class="form-control"
                                                    value="{{ $user->email }}" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h6 class="text-uppercase text-body text-xs font-weight-bolder">First Name
                                                </h6>
                                                <input type="text"
                                                    class="form-control @error('FName') is-invalid @enderror" name="FName"
                                                    placeholder="First Name"
                                                    value="{{ old('FName', $user->customers->FName) }}">
                                                @error('FName')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h6 class="text-uppercase text-body text-xs font-weight-bolder">Last Name
                                                </h6>
                                                <input type="text"
                                                    class="form-control @error('LName') is-invalid @enderror"
                                                    placeholder="Last Name" name="LName"
                                                    value="{{ old('LName', $user->customers->LName) }}">
                                                @error('LName')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h6 class="text-uppercase text-body text-xs font-weight-bolder">No Telepon
                                                </h6>
                                                <input type="tel"
                                                    class="form-control @error('phone') is-invalid @enderror" name="phone"
                                                    placeholder="No Telepon"
                                                    value="{{ old('phone', $user->customers->phone) }}">
                                                @error('phone')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <h6 class="text-uppercase text-body text-xs font-weight-bolder">Jenis
                                                    Kelamin</h6>
                                                <div class="row">
                                                    <div class="col">
                                                        <div class="form-check mb-3">
                                                            <input
                                                                class="form-check-input @error('gender') is-invalid @enderror"
                                                                type="radio" name="gender" value="Laki-laki"
                                                                {{ old('gender', $user->customers->gender) == 'Laki-laki' ? 'checked' : '' }}>
                                                            <label class="custom-control-label">Laki-Laki</label>
                                                        </div>
                                                    </div>
                                                    <div class="col">
                                                        <div class="form-check">
                                                            <input
                                                                class="form-check-input @error('gender') is-invalid @enderror"
                                                                type="radio" name="gender" value="Perempuan"
                                                                {{ old('gender', $user->customers->gender) == 'Perempuan' ? 'checked' : '' }}>
                                                            <label class="custom-control-label">Perempuan</label>
                                                        </div>
                                                    </div>
                                                    @error('gender')
                                                        <div class="invalid-feedback d-block">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <h6 class="text-uppercase text-body text-xs font-weight-bolder">Tanggal
                                                    Lahir</h6>
                                                <input class="form-control @error('date_of_birth') is-invalid @enderror"
                                                    type="date" name="date_of_birth"
                                                    value="{{ old('date_of_birth', $user->customers->date_of_birth) }}">
                                                @error('date_of_birth')
                                                    <div class="invalid-feedback">{{ $message }}</div>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-12">
                                            <button type="submit" class="btn btn-outline-primary">Simpan</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="alamat" role="tabpanel" aria-labelledby="alamat-tab">
                    <div class="col-12 col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0 px-3 d-flex justify-content-between align-items-center">
                                <h6 class="mb-0">Alamat</h6>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#tambahAlamat">Tambah</button>
                            </div>
                            <div class="card-body pt-4 p-3">
                                <ul class="list-group">

                                    @foreach ($user->customers->cusAddress as $address)
                                        <li
                                            class="list-group-item border-0 d-flex p-4 pb-1 mb-2 bg-gray-100 border-radius-lg">
                                            <div class="d-flex flex-column">
                                                <h6 class="mb-0 text-sm">{{ $address->fullName }}</h6>
                                                <span class="mb-3 text-xs">{{ $address->phone }}</span>
                                                <span class="mb-2 text-xs">{{ $address->address_detail }}, Kel.
                                                    {{ $address->address->kelurahan }},
                                                    Kec.{{ $address->address->kecamatan }}, Kota/Kab
                                                    {{ $address->address->kabupaten }},
                                                    {{ $address->address->kodepos }}</span>
                                                <span class="mb-2">
                                                    <form
                                                        action="{{ route('address.destroy', $address->customer_address_id) }}"
                                                        method="POST" class="d-inline">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="btn btn-link text-danger text-gradient px-0 mb-0"><i
                                                                class="far fa-trash-alt me-2"
                                                                aria-hidden="true"></i>Delete</button>
                                                    </form>
                                                    <button type="button" class="btn btn-link text-dark px-3 mb-0"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#editAlamat{{ $address->customer_address_id }}"><i
                                                            class="fas fa-pencil-alt text-dark me-2"
                                                            aria-hidden="true"></i>Edit</button>
                                                </span>
                                            </div>
                                            <div class="ms-auto text-end">
                                                <strong class="text-primary text-xs">{{ $address->mark_as }}</strong>
                                            </div>
                                        </li>
                                        <div class="modal fade" id="editAlamat{{ $address->customer_address_id }}"
                                            tabindex="-1" role="dialog" aria-labelledby="editAlamatLabel"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="editAlamatLabel">Edit Alamat</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <form
                                                        action="{{ route('address.update', $address->customer_address_id) }}"
                                                        method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nama Lengkap</label>
                                                                        <input type="text" class="form-control"
                                                                            name="name"
                                                                            value="{{ $address->fullName }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="mb-3">
                                                                        <label class="form-label">Nomor Telepon</label>
                                                                        <input type="text" class="form-control"
                                                                            name="phone" value="{{ $address->phone }}"
                                                                            required>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <label class="form-label">Provinsi, Kota, Kecamatan,
                                                                    Kelurahan, Kode Pos</label>
                                                                <div class="col">
                                                                    <div class="mb-3">
                                                                        <select class="form-select edit-provinsi"
                                                                            name="provinsi"
                                                                            data-modal-id="{{ $address->customer_address_id }}">
                                                                            <option value="">Pilih Provinsi</option>
                                                                            @foreach ($provinces as $province)
                                                                                <option value="{{ $province->provinsi }}"
                                                                                    {{ $address->address->provinsi == $province->provinsi ? 'selected' : '' }}>
                                                                                    {{ $province->provinsi }}
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="mb-3">
                                                                        <select name="kabupaten"
                                                                            class="form-control edit-kabupaten"
                                                                            data-modal-id="{{ $address->customer_address_id }}">
                                                                            <option
                                                                                value="{{ $address->address->kabupaten }}">
                                                                                {{ $address->address->kabupaten }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="mb-3">
                                                                        <select name="kecamatan"
                                                                            class="form-control edit-kecamatan"
                                                                            data-modal-id="{{ $address->customer_address_id }}">
                                                                            <option
                                                                                value="{{ $address->address->kecamatan }}">
                                                                                {{ $address->address->kecamatan }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col">
                                                                    <div class="mb-3">
                                                                        <select name="kelurahan"
                                                                            class="form-control edit-kelurahan"
                                                                            data-modal-id="{{ $address->customer_address_id }}">
                                                                            <option
                                                                                value="{{ $address->address->kelurahan }}">
                                                                                {{ $address->address->kelurahan }}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <div class="mb-3">
                                                                        <select name="kodepos"
                                                                            class="form-select edit-kodepos"
                                                                            data-modal-id="{{ $address->customer_address_id }}">
                                                                            <option
                                                                                value="{{ $address->address->kodepos }}">
                                                                                {{ $address->address->kodepos }}
                                                                            </option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Detail Lainnya (Nama Jalan,
                                                                    Gedung, No. Rumah)</label>
                                                                <textarea class="form-control" name="street_address" required>{{ $address->address_detail }}</textarea>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label class="form-label">Tandai Sebagai:</label>
                                                                <div class="row">
                                                                    <div class="col">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="type" value="Rumah"
                                                                                {{ $address->mark_as == 'Rumah' ? 'checked' : '' }}>
                                                                            <label class="form-check-label">Rumah</label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col">
                                                                        <div class="form-check">
                                                                            <input class="form-check-input" type="radio"
                                                                                name="type" value="Kantor"
                                                                                {{ $address->mark_as == 'Kantor' ? 'checked' : '' }}>
                                                                            <label class="form-check-label">Kantor</label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-bs-dismiss="modal">Batal</button>
                                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah Alamat -->
    <div class="modal fade" id="tambahAlamat" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="tambahAlamatLabel">Alamat Baru</h5>
                    <button type="button" class="btn-close" data-bs-toggle="modal" data-bs-target="#tambahAlamat"
                        aria-label="Tambah Alamat"></button>
                </div>
                <form action="{{ route('address.store') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Nama Lengkap</label>
                                    <input type="text" class="form-control" name="name" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label class="form-label">Nomor Telepon</label>
                                    <input type="text" class="form-control" name="phone" required>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <label class="form-label">Provinsi, Kota, Kecamatan, ,Kelurahan, Kode Pos</label>
                            <div class="col">
                                <div class="mb-3">
                                    <select class="form-select" id="provinsi" name="provinsi">
                                        <option value="">Pilih Provinsi</option>
                                        @foreach ($provinces as $province)
                                            <option value="{{ $province->provinsi }}">{{ $province->provinsi }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <select id="kabupaten" name="kabupaten" class="form-control" disabled>
                                        <option value="">Pilih Kabupaten</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <select id="kecamatan" name="kecamatan" class="form-control" disabled>
                                        <option value="">Pilih Kecamatan</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <div class="mb-3">
                                    <select id="kelurahan" name="kelurahan" class="form-control" disabled>
                                        <option value="">Pilih Kelurahan</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col">
                                <div class="mb-3">
                                    <select id="kodepos" name="kodepos" class="form-select" disabled>
                                        <option value="">Pilih Kode Pos</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Detail Lainnya (Nama Jalan, Gedung, No. Rumah)</label>
                            <textarea class="form-control" name="street_address" required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Tandai Sebagai:</label>
                            <div class="row">
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" value="Rumah"
                                            checked>
                                        <label class="form-check-label">Rumah</label>
                                    </div>
                                </div>
                                <div class="col">
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="type" value="Kantor">
                                        <label class="form-check-label">Kantor</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Nanti Saja</button>
                        <button type="submit" class="btn btn-primary">OK</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Handler untuk provinsi di modal edit
            document.querySelectorAll('.edit-provinsi').forEach(select => {

                select.addEventListener('change', function() {
                    const modalId = this.dataset.modalId;
                    const kabupatenSelect = document.querySelector(
                        `.edit-kabupaten`);
                    const provinsi = this.value;

                    resetEditDropdowns('kabupaten');

                    if (provinsi) {
                        fetch(`/api/kabupaten/${encodeURIComponent(provinsi)}`)
                            .then(response => response.json())
                            .then(data => {
                                populateEditSelect(kabupatenSelect, data.map(item => item
                                    .kabupaten), 'Pilih Kabupaten');
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Gagal mengambil data kabupaten');
                            });
                    }
                });
            });

            // Handler untuk kabupaten di modal edit
            document.querySelectorAll('.edit-kabupaten').forEach(select => {
                select.addEventListener('change', function() {
                    const modalId = this.dataset.modalId;
                    const kecamatanSelect = document.querySelector(
                        `.edit-kecamatan[data-modal-id="${modalId}"]`);
                    const kabupaten = this.value;

                    resetEditDropdowns(modalId, 'kecamatan');

                    if (kabupaten) {
                        fetch(`/api/kecamatan/${encodeURIComponent(kabupaten)}`)
                            .then(response => response.json())
                            .then(data => {
                                populateEditSelect(kecamatanSelect, data.map(item => item
                                    .kecamatan), 'Pilih Kecamatan');
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Gagal mengambil data kecamatan');
                            });
                    }
                });
            });

            // Handler untuk kecamatan di modal edit
            document.querySelectorAll('.edit-kecamatan').forEach(select => {
                select.addEventListener('change', function() {
                    const modalId = this.dataset.modalId;
                    const kelurahanSelect = document.querySelector(
                        `.edit-kelurahan[data-modal-id="${modalId}"]`);
                    const kecamatan = this.value;

                    resetEditDropdowns(modalId, 'kelurahan');

                    if (kecamatan) {
                        fetch(`/api/kelurahan/${encodeURIComponent(kecamatan)}`)
                            .then(response => response.json())
                            .then(data => {
                                populateEditSelect(kelurahanSelect, data.map(item => item
                                    .kelurahan), 'Pilih Kelurahan');
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Gagal mengambil data kelurahan');
                            });
                    }
                });
            });

            // Handler untuk kelurahan di modal edit
            document.querySelectorAll('.edit-kelurahan').forEach(select => {
                select.addEventListener('change', function() {
                    const modalId = this.dataset.modalId;
                    const kodeposSelect = document.querySelector(
                        `.edit-kodepos[data-modal-id="${modalId}"]`);
                    const kelurahan = this.value;

                    resetEditDropdowns(modalId, 'kodepos');

                    if (kelurahan) {
                        fetch(`/api/kodepos/${encodeURIComponent(kelurahan)}`)
                            .then(response => response.json())
                            .then(data => {
                                populateEditSelect(kodeposSelect, data.map(item => item
                                    .kodepos), 'Pilih Kode Pos');
                            })
                            .catch(error => {
                                console.error('Error:', error);
                                alert('Gagal mengambil data kode pos');
                            });
                    }
                });
            });

            // Helper function untuk mengisi select di modal edit
            function populateEditSelect(selectElement, options, defaultText) {
                selectElement.innerHTML = `<option value="">${defaultText}</option>`;
                options.forEach(option => {
                    const optionElement = new Option(option, option);
                    selectElement.add(optionElement);
                });
            }

            // Helper function untuk reset dropdown di modal edit
            function resetEditDropdowns(modalId, startFrom) {
                const fields = {
                    'kabupaten': {
                        element: `.edit-kabupaten[data-modal-id="${modalId}"]`,
                        text: 'Pilih Kabupaten'
                    },
                    'kecamatan': {
                        element: `.edit-kecamatan[data-modal-id="${modalId}"]`,
                        text: 'Pilih Kecamatan'
                    },
                    'kelurahan': {
                        element: `.edit-kelurahan[data-modal-id="${modalId}"]`,
                        text: 'Pilih Kelurahan'
                    },
                    'kodepos': {
                        element: `.edit-kodepos[data-modal-id="${modalId}"]`,
                        text: 'Pilih Kode Pos'
                    }
                };

                let shouldReset = false;
                for (const [field, config] of Object.entries(fields)) {
                    if (field === startFrom) {
                        shouldReset = true;
                    }
                    if (shouldReset) {
                        const element = document.querySelector(config.element);
                        if (element) {
                            element.innerHTML = `<option value="">${config.text}</option>`;
                        }
                    }
                }
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const provinsiSelect = document.getElementById('provinsi');
            const kabupatenSelect = document.getElementById('kabupaten');
            const kecamatanSelect = document.getElementById('kecamatan');
            const kelurahanSelect = document.getElementById('kelurahan');
            const kodeposSelect = document.getElementById('kodepos');

            // Event Listener untuk Provinsi
            provinsiSelect.addEventListener('change', function() {
                const provinsi = this.value;
                resetDropdowns('kabupaten');

                if (provinsi) {
                    kabupatenSelect.disabled = false;
                    fetch(`/api/kabupaten/${encodeURIComponent(provinsi)}`)
                        .then(response => response.json())
                        .then(data => {
                            populateSelect(kabupatenSelect, data.map(item => item.kabupaten),
                                'Pilih Kabupaten');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal mengambil data kabupaten');
                        });
                }
            });

            // Event Listener untuk Kabupaten
            kabupatenSelect.addEventListener('change', function() {
                const kabupaten = this.value;
                resetDropdowns('kecamatan');

                if (kabupaten) {
                    kecamatanSelect.disabled = false;
                    fetch(`/api/kecamatan/${encodeURIComponent(kabupaten)}`)
                        .then(response => response.json())
                        .then(data => {
                            populateSelect(kecamatanSelect, data.map(item => item.kecamatan),
                                'Pilih Kecamatan');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal mengambil data kecamatan');
                        });
                }
            });

            // Event Listener untuk Kecamatan
            kecamatanSelect.addEventListener('change', function() {
                const kecamatan = this.value;
                resetDropdowns('kelurahan');

                if (kecamatan) {
                    kelurahanSelect.disabled = false;
                    fetch(`/api/kelurahan/${encodeURIComponent(kecamatan)}`)
                        .then(response => response.json())
                        .then(data => {
                            populateSelect(kelurahanSelect, data.map(item => item.kelurahan),
                                'Pilih Kelurahan');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal mengambil data kelurahan');
                        });
                }
            });

            // Event Listener untuk Kelurahan
            kelurahanSelect.addEventListener('change', function() {
                const kelurahan = this.value;
                resetDropdowns('kodepos');

                if (kelurahan) {
                    kodeposSelect.disabled = false;
                    fetch(`/api/kodepos/${encodeURIComponent(kelurahan)}`)
                        .then(response => response.json())
                        .then(data => {
                            populateSelect(kodeposSelect, data.map(item => item.kodepos),
                                'Pilih Kode Pos');
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal mengambil kode pos');
                        });
                }
            });

            // Helper function untuk mengisi select
            function populateSelect(selectElement, options, defaultText) {
                selectElement.innerHTML = `<option value="">${defaultText}</option>`;
                options.forEach(option => {
                    const optionElement = new Option(option, option);
                    selectElement.add(optionElement);
                });
            }

            // Helper function untuk reset dropdown
            function resetDropdowns(startFrom) {
                const fields = {
                    'kabupaten': {
                        element: kabupatenSelect,
                        text: 'Pilih Kabupaten'
                    },
                    'kecamatan': {
                        element: kecamatanSelect,
                        text: 'Pilih Kecamatan'
                    },
                    'kelurahan': {
                        element: kelurahanSelect,
                        text: 'Pilih Kelurahan'
                    },
                    'kodepos': {
                        element: kodeposSelect,
                        text: 'Pilih Kode Pos'
                    }
                };

                let shouldReset = false;
                for (const [field, config] of Object.entries(fields)) {
                    if (field === startFrom) {
                        shouldReset = true;
                    }
                    if (shouldReset) {
                        config.element.innerHTML = `<option value="">${config.text}</option>`;
                        config.element.disabled = true;
                    }
                }
            }

            // Reset form ketika modal ditutup
            const modal = document.getElementById('tambahAlamat');
            modal.addEventListener('hidden.bs.modal', function() {
                const form = modal.querySelector('form');
                form.reset();
                resetDropdowns('kabupaten');
            });
        });
    </script>
@endsection
