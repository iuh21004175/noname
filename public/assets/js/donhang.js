document.addEventListener('DOMContentLoaded', async function (){
    const combobox = document.querySelector('#combobox-timKiem')
    const messageXoa = document.querySelector('#message-xoa')
    const messageDonHang = document.querySelector('#message-donHang')
    const tableDonHang = document.querySelector('#table-donHang tbody')
    const txtTimKiem = document.querySelector('#txt-timKiem')
    let listDonHangGoc = []

    // Lấy ngày hiện tại
    const today = new Date();
    // Lấy ngày đầu tiên của tháng hiện tại
    const firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);
    // Lấy ngày cuối cùng của tháng hiện tại
    const lastDayOfMonth = new Date(today.getFullYear(), today.getMonth() + 1, 0);
    const txtMocBatDau = document.querySelector('#txt-MocNgayBatDau')
    const txtMocKetThuc = document.querySelector('#txt-MocNgayKetThuc')
    txtMocBatDau.value = firstDayOfMonth.toISOString().split('T')[0];
    txtMocKetThuc.value = lastDayOfMonth.toISOString().split('T')[0];

    function renderDonHang(list){
        tableDonHang.innerHTML = ''
        if(list.length > 0){
            messageDonHang.classList.add('d-none')
            list.forEach(function (donHang, index){
                let row = document.createElement('tr')
                let xoaButton = ''
                if(donHang.TrangThai !==1){
                    xoaButton = ` <button class="btn btn-outline-danger btn-xoa" data-bs-toggle="modal" data-bs-target="#message-xoa" value="${donHang.MaDonHang}">Xóa</button>`
                }
                row.innerHTML = `<td class="align-middle text-center">${index + 1}</td>
                            <td class="align-middle">${donHang.MaDonHang}</td>
                            <td class="align-middle">${donHang.SoDienThoai}</td>
                            <td class="align-middle">${donHang.NgayLap}</td>
                            <td class="align-middle">${parseInt(donHang.TongTien).toLocaleString('de-DE')} <i class="fa-solid fa-dong-sign"></i></td>
                            <td >
                                <a class="btn btn-light" href="./don-hang-chi-tiet-${donHang.MaDonHang}">Xem</a>
                               ${xoaButton}
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
                else {
                    alert(data.message)
                }
            }
            catch (error){
                console.error('Fetch error: ', error)
            }

        }
    }
    async function getDonHangTheoThoiGian(){
        try{
            const response = await fetch(`./fetch/danh-sach-don-hang-theo-thoi-gian-tu-${txtMocBatDau.value}-den-${txtMocKetThuc.value}`)
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
    }
    function adjustDates() {
        let startDate = new Date(txtMocBatDau.value);
        let endDate = new Date(txtMocKetThuc.value);

        // Kiểm tra nếu ngày bắt đầu sau ngày kết thúc
        if (startDate > endDate) {
            // Sửa lại ngày bắt đầu trước ngày kết thúc 1 ngày
            startDate.setDate(endDate.getDate() - 1);
            txtMocBatDau.value = startDate.toISOString().split('T')[0];
        }

        // Kiểm tra nếu ngày kết thúc trước hoặc bằng ngày bắt đầu
        if (endDate <= startDate) {
            // Sửa lại ngày kết thúc sau ngày bắt đầu 1 ngày
            endDate.setDate(startDate.getDate() + 1);
            txtMocKetThuc.value = endDate.toISOString().split('T')[0];
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
    txtMocBatDau.oninput = async function () {
        adjustDates();
        await getDonHangTheoThoiGian()
    };

    txtMocKetThuc.oninput = async function () {
        adjustDates();
        await getDonHangTheoThoiGian()
    };


    await getDonHangTheoThoiGian()
})