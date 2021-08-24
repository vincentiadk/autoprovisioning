<!-- Content Wrapper. Contains page content -->
<div class="container-fluid dashboard-content">
    <!-- Main content -->
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
            <div class="page-header">
                <h2 class="pageheader-title">{{ $data['title'] }} </h2>
                <div class="page-breadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#" onclick="goToPage('panel/dashboard')" class="breadcrumb-link">Dashboard</a></li>
                            <li class="breadcrumb-item"><a href="#" onclick="goToPage('panel/user')" class="breadcrumb-link">User</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Detail User</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <form action="{{ url('panel/user/store') }}" method="post" enctype="multipart/form-data" id="form_data">
                {{ csrf_field() }}
                <!-- Default box -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ $data['title'] }}</h3>
                    </div>
                    <div class="card-body">
                        @php
                        $id = 0;
                        if($data['user']->id != '') {
                        $id = $data['user']->id;
                        }
                        @endphp
                        <input type="hidden" value="{{ $id }}" name="id" id="id_user">
                        <input type="hidden" value="{{ $data['type'] }}" name="type">
                        <div class="alert alert-danger" id="validasi_element" style="display:none;">
                            <ul id="validasi_content"></ul>
                        </div>
                        <div class="form-group">
                            <label>Nama</label>
                            <input type="text" class="form-control" value="{{ $data['user']->name }}" name="name">
                        </div>
                        <div class="form-group">
                            <label>Email</label>
                            <input type="email" class="form-control" value="{{ $data['user']->email }}" name="email">
                        </div>
                        <div class="form-group">
                            <label>No Telp / HP</label>
                            <input type="number" class="form-control" value="{{ $data['user']->phone_number }}"
                                name="phone_number">
                        </div>
                        <div class="form-group">
                            <label>NIK</label>
                            <input type="number" class="form-control" value="{{ $data['user']->nik }}" name="nik">
                        </div>
                        @if($data['type'] != 'setting')
                        <div class="form-group">
                            <label>Regional</label>
                            <select class="form-control" name="regional">
                                <option value=""> Pilih Regional </option>
                                <option value="1" @if($data['user']->regional == 1) selected @endif>Regional 1</option>
                                <option value="2" @if($data['user']->regional == 2) selected @endif>Regional 2</option>
                                <option value="3" @if($data['user']->regional == 3) selected @endif>Regional 3</option>
                                <option value="4" @if($data['user']->regional == 4) selected @endif>Regional 4</option>
                                <option value="5" @if($data['user']->regional == 5) selected @endif>Regional 5</option>
                                <option value="6" @if($data['user']->regional == 6) selected @endif>Regional 6</option>
                                <option value="7" @if($data['user']->regional == 7) selected @endif>Regional 7</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Activation / Deactive</label>
                            <select class="form-control" name="active">
                                <option value="1" @if($data['user']->active == 1) selected @endif>Enable
                                </option>
                                <option value="0" @if($data['user']->active == 0) selected @endif>Disable
                                </option>
                            </select>
                        </div>
                        @endif
                        @if($data['type'] == 'setting')
                        <div class="form-group">
                            <label>Password Lama *)</label>
                            <input type="password" class="form-control" name="password" id="password">
                        </div>
                        <div class="form-group">
                            <label>Password Baru *)</label>
                            <input type="password" class="form-control" name="password_new" id="password_new">
                        </div>
                        <div class="form-group">
                            <label>Konfirmasi Password Baru *)</label>
                            <input type="password" class="form-control" name="password_confirm" id="password_confirm">
                        </div>
                        *) Diisi hanya saat Anda ingin mengganti password
                        @endif
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary btn-block col-4"
                                onclick="simpan()">Simpan</button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- /.card -->
        </div>
    </div>
</div>
<script>
function simpan() {
    event.preventDefault();
    var id_ = $('#id_user').val();
    var formData = new FormData($('#form_data')[0]);
    $.ajax({
        url: '{{ url("panel/user/store") }}',
        type: 'POST',
        dataType: 'JSON',
        data: formData,
        cache: false,
        contentType: false,
        processData: false,
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        beforeSend: function() {
            loadingOpen('.content');
            $('#validasi_element').hide();
            $('#validasi_content').html('');
        },
        success: function(response) {
            loadingClose('.content');
            if (response.status == 200) {
                if (id_ > 0) {
                    Toast.fire({
                        icon: 'success',
                        title: response.message
                    });
                    if ($('#password').val() != '') {
                        $('#password').val('');
                        $('#password_new').val('');
                        $('#password_confirm').val('');
                    }
                } else {
                    window.open("panel/user/view/" + response.id, "_self");
                }
            } else if (response.status == 422) {
                $('#validasi_element').show();
                Toast.fire({
                    icon: 'info',
                    title: 'Validasi'
                });

                $.each(response.error, function(i, val) {
                    $('#validasi_content').append('<li>' + val + '</li>');
                })
            } else {
                Toast.fire({
                    icon: 'warning',
                    title: response.message
                });
            }
        },
        error: function() {
            loadingClose('.content');
            Toast.fire({
                icon: 'error',
                title: 'Server Error!'
            });
        }

    });
}
</script>