<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng Nhập</title>
    <link rel="stylesheet" href="./public/assets/css/bootstrap.min.css">
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4">
            <h2 class="text-center my-4">Đăng Nhập</h2>
            <form id="form-dn">
                <div class="mb-3">
                    <label for="username" class="form-label">Tên Đăng Nhập <span class="user-error text-danger"></span></label>
                    <input type="text" class="form-control" id="username" placeholder="Nhập tên đăng nhập">
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Mật Khẩu <span class="password-error text-danger"></span></label>
                    <input type="password" class="form-control" id="password" placeholder="Nhập mật khẩu">
                </div>
                <div class="d-grid">
                    <input type="submit" class="btn btn-primary" value="Đăng Nhập">
                </div>
            </form>
        </div>
    </div>
</div>
<script src="./public/assets/js/popper.min.js"></script>
<script src="./public/assets/js/bootstrap.min.js"></script>
<script src="./public/assets/js/dangnhap.js"></script>
</body>
</html>
