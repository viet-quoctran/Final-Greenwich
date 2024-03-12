@extends('admin.master.master')
@section('content')
<div id="layoutSidenav_content">
    <main>
        <div class="container-fluid px-4">
            <h1 class="mt-4">Dashboard</h1>
            <ol class="breadcrumb mb-4">
                <li class="breadcrumb-item active">Dashboard</li>
            </ol>
            <div class="row">
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-area me-1"></i>
                            Area Chart Example
                        </div>
                        <div class="card-body"><canvas id="myAreaChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="card mb-4">
                        <div class="card-header">
                            <i class="fas fa-chart-bar me-1"></i>
                            Bar Chart Example
                        </div>
                        <div class="card-body"><canvas id="myBarChart" width="100%" height="40"></canvas></div>
                    </div>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Users
                </div>
                <div class="card-body">
                    <table id="datatablesSimple">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($dataUsers as $guest)
                                <tr>
                                    <td>{{ $guest->name }}</td>
                                    <td>{{ $guest->email }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-table me-1"></i>
                    Data Guests
                </div>
                <div class="card-body">
                    <table id="datatablesSimple2">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Create at</th>
                            </tr>
                        </thead>
                        <tfoot>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Message</th>
                                <th>Status</th>
                                <th>Create at</th>
                            </tr>
                        </tfoot>
                        <tbody>
                            @foreach($dataGuests as $guest)
                                <tr>
                                    <td>{{ $guest->fullname }}</td>
                                    <td>{{ $guest->email }}</td>
                                    <td>{{ $guest->phone }}</td>
                                    <td>{{ $guest->message }}</td>
                                    <td>
                                        <input type="checkbox" class="guest-status" data-guest-id="{{ $guest->id }}" style="transform: scale(1.5);" {{ $guest->status ? 'checked' : '' }}>
                                    </td>
                                    <td>{{ $guest->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </main>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('.guest-status').change(function() {
            var checkbox = $(this); // Lưu trữ đối tượng checkbox trong một biến
            var id = checkbox.data('guest-id');
            var status = checkbox.is(':checked') ? 1 : 0;

            // Hiển thị alert confirm trước khi gửi yêu cầu AJAX
            if (confirm('Are you sure you want to update this guest?')) {
                $.ajax({
                    url: '/admin/guests/status/' + id,
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    data: {
                        guest_id: id,
                        status: status
                    },
                    success: function(response) {
                        console.log(response.message);
                        console.log(response.guest); // Log dữ liệu của guest
                        // Load lại trang sau khi cập nhật thành công
                        location.reload();
                    },
                    error: function(xhr, status, error) {
                        console.error('Error:', error);
                        checkbox.prop('checked', !checkbox.prop('checked'));
                    }
                });
            } else {
                // Nếu người dùng không xác nhận, đảo ngược trạng thái của checkbox
                checkbox.prop('checked', !checkbox.prop('checked'));
            }
        });
    });
</script>
@endsection