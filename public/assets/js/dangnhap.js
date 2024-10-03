document.addEventListener('DOMContentLoaded',  function (){
    document.getElementById('form-dn').addEventListener('submit', async function (event) {
        event.preventDefault(); // Ngăn form gửi đi để xử lý

        // Lấy giá trị tên đăng nhập và mật khẩu
        const username = document.getElementById('username').value.trim();
        const password = document.getElementById('password').value.trim();

        // Lấy các phần tử để hiển thị lỗi
        const usernameError = document.querySelector('.user-error');
        const passwordError = document.querySelector('.password-error');

        // Xóa thông báo lỗi cũ
        usernameError.textContent = '';
        passwordError.textContent = '';

        let isValid = true;

        // Kiểm tra tên đăng nhập trống
        if (username === '') {
            usernameError.textContent = 'Tên đăng nhập không được để trống.';
            isValid = false;
        }

        // Kiểm tra mật khẩu trống
        if (password === '') {
            passwordError.textContent = 'Mật khẩu không được để trống.';
            isValid = false;
        }

        // Nếu cả hai trường đều hợp lệ, kiểm tra thông tin đăng nhập
        if (isValid) {
            try {
                let response = await fetch('fetch/dang-nhap', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json', // Đặt header để gửi dữ liệu JSON
                    },
                    body: JSON.stringify({ username: username, password: password }) // Chuyển đổi dữ liệu thành JSON
                });

                // Kiểm tra mã trạng thái HTTP
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }

                // Lấy dữ liệu phản hồi từ server
                let data = await response.json();

                // Xử lý phản hồi (data) tùy theo logic của bạn
                if (data.status === 'success') {
                    window.location.href='./'
                } else {
                    alert('Sai tên đăng nhập hoặc mật khẩu.');
                }
            } catch (error) {
                console.error('There has been a problem with your fetch operation:', error);
            }
        }
    });
})