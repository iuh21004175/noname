document.addEventListener('DOMContentLoaded', function (){
    const btnXacNhanCapNhat = document.querySelector('#btn-CapNhat')
    const txtCapNhatNgaySinh = document.querySelector('#txt-CapNhatNgaySinh')
    const txtCapNhatDiaChi = document.querySelector('#txt-CapNhatDiaChi')
    const txtCapNhatEmail = document.querySelector('#txt-CapNhatEmail')
    const txtCapNhatGhiChu = document.querySelector('#txt-CapNhatGhiChu')

    const messageErrorCapNhatNgaySinh = document.querySelector('#message-errorCapNhatNgaySinh')
    const messageErrorCapNhatEmail = document.querySelector('#message-errorCapNhatEmail')

    let hopLeCapNhatNgaySinh = false
    let hopLeCapNhatEmail = false
    async function capNhatThongTinCaNhan(obj){
        try {
            const response = await fetch('./fetch/cap-nhat-thong-tin-ca-nhan',{
                method: 'POST',
                headers:{
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(obj)
            })
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            const data = await response.json()
            if(data.status === 'success'){
                window.location.href = './thong-tin-ca-nhan'
            }
            else{
                alert(data.message)
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }
    function kiemTraCapNhatNgaySinh(){
        if(txtCapNhatNgaySinh.value.trim() === ''){
            messageErrorCapNhatNgaySinh.innerHTML = 'Không được để trống'
            hopLeCapNhatNgaySinh = false
        }
        else{
            messageErrorCapNhatNgaySinh.innerHTML = ''
            hopLeCapNhatNgaySinh = true
        }
    }
    function kiemTraCapNhatEmail(){
        if(txtCapNhatEmail.value.trim() === ''){
            messageErrorCapNhatEmail.innerHTML = 'Không được để trống'
            hopLeCapNhatEmail = false
        }
        else{
            const emailPattern = /^[^\s@]+@gmail\.com$/;
            if (!emailPattern.test(txtCapNhatEmail.value)) {
                messageErrorCapNhatEmail.innerHTML = 'Email không hợp lệ, chỉ chấp nhận email @gmail.com';
                hopLeCapNhatEmail = false;
            }
            else{
                messageErrorCapNhatEmail.innerHTML = ''
                hopLeCapNhatEmail = true
            }

        }
    }
    btnXacNhanCapNhat.onclick = async function (){
        kiemTraCapNhatNgaySinh()
        kiemTraCapNhatEmail()
        let caNhan = {
            'NgaySinh': txtCapNhatNgaySinh.value,
            'Email': txtCapNhatEmail.value,
            'DiaChi': txtCapNhatDiaChi.value,
            'GhiChu': txtCapNhatGhiChu.value
        }
        await capNhatThongTinCaNhan(caNhan)
    }
})