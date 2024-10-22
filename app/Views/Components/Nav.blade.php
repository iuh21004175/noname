@php
    $uri = $_SERVER['REQUEST_URI'];
    $basePath = '/cp';
    $uri = str_replace($basePath, '', $uri);

@endphp
<nav class="row justify-content-between sticky-top bg-light pb-2" id="nav">
    <ul id="navigation" class="nav w-auto">
        <li class="nav-item"><a href="./" class="nav-link {{$uri == '/' ? 'active' : ''}}">Trang chủ</a></li>
        <li class="nav-item"><a href="./don-hang" class="nav-link {{$uri == '/don-hang' ? 'active' : ''}}">Đơn hàng</a></li>
        <li class="nav-item"><a href="./khach-hang" class="nav-link {{$uri == '/khach-hang' ? 'active' : ''}}">Khách hàng</a></li>
        <li class="nav-item"><a href="./khuyen-mai" class="nav-link {{$uri == '/khuyen-mai' ? 'active' : ''}}">Khuyến mãi</a></li>
        <li class="nav-item"><a href="./thuc-don" class="nav-link {{$uri == '/thuc-don' ? 'active' : ''}}">Thực đơn</a></li>
        @if($_SESSION['role'] == 'LNV0000001')
         <li class="nav-item"><a href="./nhan-vien" class="nav-link {{$uri == '/nhan-vien' ? 'active' : ''}}">Nhân viên</a></li>
        @endif
    </ul>
    <ul class="nav w-auto">
        <li class="nav-item dropdown d-flex align-items-center">
            <a class="navbar-brand btn btn-light dropdown-toggle" href="#"  role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="./public/assets/image/{{$_SESSION['image_user'] != null ? $_SESSION['image_user'] : 'staff_default.png'}}" alt="Bootstrap" width="30">
                {{$_SESSION['username']}}
            </a>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="./thong-tin-ca-nhan">Thông tin cá nhân</a></li>
                <li><button class="dropdown-item" id="btn-dangXuat">Đăng xuất</button></li>
            </ul>
        </li>
    </ul>
</nav>
