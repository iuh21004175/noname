document.addEventListener('DOMContentLoaded', function (){
    const btnDangXuat = document.querySelector('#btn-dangXuat')

    btnDangXuat.onclick = async function (){
        const result = confirm('Bạn có chắc chắn không ?')
        if(result){
            try {
                const response = await fetch('./fetch/dang-xuat',{
                    method: 'POST'
                })
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                const data = await response.json()
                if(data.status === 'success'){
                    window.location.href = './'
                }
                else{
                    alert(data.message)
                }
            }
            catch (error){
                console.log('Fetch error: ',error)
            }
        }

    }
})
window.addEventListener('beforeunload', function () {
    // Gửi yêu cầu Fetch API trước khi đóng trình duyệt
    fetch('./fetch/dang-xuat', {
        method: 'POST',
        keepalive: true, // Giữ kết nối sống để đảm bảo yêu cầu hoàn thành
        headers: { 'Content-Type': 'application/json' }, // Nếu cần định dạng JSON
        body: JSON.stringify({ message: 'User logging out' }) // Gửi dữ liệu nếu cần thiết
    })
    .catch((err) => {
        console.error("Fetch request failed: ", err);
    });
});