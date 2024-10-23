async function checkToken(){
    try {
        // Gọi fetch API để kiểm tra phiên đăng nhập
        const response = await fetch('./fetch/kiem-tra-phien-dang-nhap', {
            method: 'POST'
        });

        // Kiểm tra kết quả trả về
        const result = await response.json();
        if (result.status==='success') {
            // Nếu người dùng đã đăng nhập, chuyển hướng đến dashboard
            window.location.href = './';
        } else {
            if(result.message !== undefined){
                alert(result.message)
            }
            // Nếu chưa đăng nhập, hiển thị form đăng nhập
            document.getElementById('spinner').style.display = 'none';
            document.getElementById('login-form').style.display = 'block';
        }
    } catch (error) {
        console.error('Lỗi khi kiểm tra phiên:', error);
        document.getElementById('spinner').style.display = 'none';
        document.getElementById('login-form').style.display = 'block';
    }
}

// Gọi hàm checkSession khi trang tải
window.onload = async function() {
    await checkToken();
}
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
                console.log(data)
                // Xử lý phản hồi (data) tùy theo logic của bạn
                if (data.status === 'success') {
                    window.location.href='./'
                } else {
                    alert(data.message);
                }
            } catch (error) {
                console.error('There has been a problem with your fetch operation:', error);
            }
        }
    });
})