document.addEventListener('DOMContentLoaded', async function (){
    const combobox = document.querySelector('#combobox-timKiem')
    const messageXoa = document.querySelector('#message-xoa')
    const messageDonHang = document.querySelector('#message-donHang')
    const tableDonHang = document.querySelector('#table-donHang tbody')
    const txtTimKiem = document.querySelector('#txt-timKiem')
    let listDonHangGoc = []

    function renderDonHang(list){
        tableDonHang.innerHTML = ''
        if(list.length > 0){
            messageDonHang.classList.add('d-none')
            list.forEach(function (donHang, index){
                let row = document.createElement('tr')
                row.innerHTML = `<td >${index + 1}</td>
                            <td >${donHang.MaDonHang}</td>
                            <td >${donHang.SoDienThoai}</td>
                            <td >${donHang.NgayLap}</td>
                            <td >${donHang.TongTien}</td>
                            <td >
                                <a class="btn btn-light" href="./don-hang-chi-tiet-${donHang.MaDonHang}">Xem</a>
                                <button class="btn btn-outline-danger btn-xoa" data-bs-toggle="modal" data-bs-target="#message-xoa" value="${donHang.MaDonHang}">Xóa</button>
                            </td>`
                tableDonHang.appendChild(row)
            })
        }
        else {
            messageDonHang.classList.remove('d-none')
        }
        const btnXacNhanXoa = document.querySelector('#btn-xacNhanXoa')
        const btnXoaS = document.querySelectorAll('.btn-xoa')
        btnXoaS.forEach(function (btn, index){
            btn.onclick = function (){
                btnXacNhanXoa.value = this.value
                messageXoa.querySelector('.modal-body').innerHTML = `Bạn có muốn xóa đơn hàng có mã ${this.value} không ?`
            }
        })
        btnXacNhanXoa.onclick = async function (){
            try {
                const response = await fetch('./fetch/xoa-don-hang', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body:JSON.stringify({'MaDonHang':this.value})
                })
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                const data = await response.json()
                if(data.status === 'success'){
                    window.location.href = './don-hang'
                }
            }
            catch (error){
                console.error('Fetch error: ', error)
            }

        }
    }
    function timKiemDonHang(){
        if(txtTimKiem.value === ''){
            renderDonHang(listDonHangGoc)
        }
        else {
            let ds = []
            if(parseInt(combobox.value) === 1){

                listDonHangGoc.forEach(function (donHang, index){
                    let maDonHang = donHang.MaDonHang + ''
                    if(txtTimKiem.value.length <= maDonHang.length && maDonHang.includes(txtTimKiem.value)){
                        ds.push(donHang)
                    }
                })
            }
            else {
                listDonHangGoc.forEach(function (donHang, index){
                    let soDienThoai = donHang.SoDienThoai + ''
                    if(txtTimKiem.value.length <= soDienThoai.length && soDienThoai.includes(txtTimKiem.value)){
                        ds.push(donHang)
                    }
                })
            }
            renderDonHang(ds)

        }
    }

    txtTimKiem.oninput = function (){
        timKiemDonHang()
    }
    combobox.onchange = function (){
        timKiemDonHang()
    }
    try{
        const response = await fetch('./fetch/danh-sach-don-hang')
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const data = await response.json()
        if(data !== null){
            listDonHangGoc = Array.from(data)
        }
        renderDonHang(listDonHangGoc)
    }
    catch (error){
        console.error('Fetch error: ',error)
    }
})