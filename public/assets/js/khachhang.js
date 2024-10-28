document.addEventListener('DOMContentLoaded', async function (){
    let listKhachHangGoc = []
    const tableKhachHang = document.querySelector('#table-khachHang tbody')
    const btnThem = document.querySelector('#btn-them')
    const btnXacNhanXoa = document.querySelector('#btn-xacNhanXoa')
    const btnXacNhanCapNhat = document.querySelector('#btn-xacNhanCapNhat')
    const messageErrorTen = document.querySelector('#message-errorTen')
    const messageErrorSDT = document.querySelector('#message-errorSoDienThoai')
    const messageKhachHang = document.querySelector('#message-khachHang')
    const messageErrorTenU = document.querySelector('#message-errorTenU')
    const messageErrorSDTU = document.querySelector('#message-errorSoDienThoaiU')

    const messageXoa = document.querySelector('#message-xoa')

    const txtSoDienThoai = document.querySelector('#txt-soDienThoai')
    const txtHoVaTen = document.querySelector('#txt-hoVaTen')
    const txtSoDienThoaiU = document.querySelector('#txt-soDienThoaiU')
    const txtHoVaTenU = document.querySelector('#txt-hoVaTenU')
    const txtTimKiem = document.querySelector('#txt-timKiem')
    const txtDiaChi = document.querySelector('#txt-diaChiU')
    const combobox = document.querySelector('#combobox-timKiem')
    const comboboxCapNhatTrangThai = document.querySelector('#combobox-CapNhatTrangThai')
    const comboboxDanhSachTuTrangThai = document.querySelector('#combobox-danhSachTuTrangThai')
    let hopLeHoVaTen = false
    let hopLeSoDienThoai = false
    let hopLeHoVaTenU = false
    let hopLeSoDienThoaiU = false
    let maKhachU = null
    function renderKhachHang(list){
        tableKhachHang.innerHTML = ''
        if(list.length > 0){
            messageKhachHang.classList.add('d-none')
            list.forEach(function (khachHang, index){
                let newRow = document.createElement('tr')
                newRow.innerHTML = `
                <td class="align-middle text-center">${index + 1}</td>
                <td class="align-middle">${khachHang.TenKhachHang}</td>
                <td class="align-middle">${khachHang.SoDienThoai}</td>
                <td class="align-middle">${khachHang.TichDiem}</td>
                <td>
                    <a href="./khach-hang-chi-tiet-${khachHang.MaKhachHang}" class="btn btn-light">Xem</a>
                    <button class="btn btn-outline-danger btn-xoa" data-bs-toggle="modal" data-bs-target="#message-xoa" value="${khachHang.MaKhachHang}">Xóa</button>
                    <button class="btn btn-outline-primary btn-capNhat" data-bs-toggle="modal" data-bs-target="#form-capNhat" value="${khachHang.MaKhachHang}">Cập nhật</button>
                </td>
            `
                tableKhachHang.appendChild(newRow)
            })

        }
        else{
            messageKhachHang.classList.remove('d-none')
        }

        const btnXoaS = document.querySelectorAll('.btn-xoa')
        btnXoaS.forEach(function (btn, index){
            btn.onclick = function (){
                btnXacNhanXoa.value = this.value

                let khachHang = list.find(kh => kh.MaKhachHang === this.value)
                messageXoa.querySelector('.modal-body').innerHTML = `Bạn có muốn xóa khách hàng ${khachHang.TenKhachHang} không ?`
            }
        })
        btnXacNhanXoa.onclick = async function (){
            try {
                const response = await fetch('./fetch/xoa-khach-hang', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body:JSON.stringify({'MaKhachHang':this.value})
                })
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                const data = await response.json()
                if(data.status === 'success'){
                    window.location.href = './khach-hang'
                }
                else {
                    alert(data.message)
                }
            }
            catch (error){
                console.error('Fetch error: ', error)
            }

        }
        const btnCapNhatS = document.querySelectorAll('.btn-capNhat')
        let radioGioiTinh = document.querySelectorAll('input[name="radio-gioiTinhU"]')
        btnCapNhatS.forEach(function (btn, index){
            btn.onclick = function (){
                btnXacNhanCapNhat.value = this.value
                maKhachU = this.value
                let khachHang = list.find(kh => kh.MaKhachHang === this.value)
                txtHoVaTenU.value = khachHang.TenKhachHang
                txtSoDienThoaiU.value = khachHang.SoDienThoai


                radioGioiTinh.forEach(function (radio, index){
                    if(radio.value === khachHang.GioiTinh){
                        radio.setAttribute('checked', true)
                    }
                })
                txtDiaChi.value = khachHang.DiaChi
                comboboxCapNhatTrangThai.value = khachHang.TrangThai
            }
        })
    }
    function kiemTraHoVaTen(){


        if(txtHoVaTen.value === ''){
            messageErrorTen.innerHTML = 'Không được để trống'
            hopLeHoVaTen = false
        }
        else{
            messageErrorTen.innerHTML = ''
            hopLeHoVaTen = true
        }
    }
    function kiemTraSoDienThoai(){


        if(txtSoDienThoai.value === ''){
            messageErrorSDT.innerHTML = 'Không được để trống'
            hopLeSoDienThoai = false
        }
        else{
            if(txtSoDienThoai.value.length < 10){
                messageErrorSDT.innerHTML = 'Phải đủ 10 ký tự'
                hopLeSoDienThoai = false
            }
            else {
                if(listKhachHangGoc.find(kh => kh.SoDienThoai === txtSoDienThoai.value)){
                    messageErrorSDT.innerHTML = 'Số điện thoại này đã được sử dụng'
                    hopLeSoDienThoai = false
                }
                else{
                    messageErrorSDT.innerHTML = ''
                    hopLeSoDienThoai = true
                }
            }

        }
    }
    function kiemTraHoVaTenU(){


        if(txtHoVaTenU.value === ''){
            messageErrorTenU.innerHTML = 'Không được để trống'
            hopLeHoVaTenU = false
        }
        else{
            messageErrorTenU.innerHTML = ''
            hopLeHoVaTenU = true
        }
    }
    function kiemTraSoDienThoaiU(){


        if(txtSoDienThoaiU.value === ''){
            messageErrorSDTU.innerHTML = 'Không được để trống'
            hopLeSoDienThoaiU = false
        }
        else{
            if(txtSoDienThoaiU.value.length < 10){
                messageErrorSDTU.innerHTML = 'Phải đủ 10 ký tự'
                hopLeSoDienThoaiU = false
            }
            else {
                let khachHangU = listKhachHangGoc.find(kh => kh.MaKhachHang === maKhachU)
                if(listKhachHangGoc.find(kh => kh.SoDienThoai === txtSoDienThoaiU.value) && khachHangU.SoDienThoai !== txtSoDienThoaiU.value){
                    messageErrorSDTU.innerHTML = 'Số điện thoại này đã được sử dụng'
                    hopLeSoDienThoaiU = false
                }
                else{
                    messageErrorSDTU.innerHTML = ''
                    hopLeSoDienThoaiU = true
                }
            }

        }
    }
    async function themKhachHang(obj){
        try {
            const response = await fetch('./fetch/them-khach-hang',{
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
                window.location.href = './khach-hang'
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }
    async function capNhatKhachHang(obj){
        try {
            const response = await fetch('./fetch/cap-nhat-khach-hang',{
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
                window.location.href = './khach-hang'
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }
    function timKiemKhachHang(){
        if(txtTimKiem.value === ''){
            renderKhachHang(listKhachHangGoc)
        }
        else {
            let ds = []
            if(parseInt(combobox.value) === 1){

                listKhachHangGoc.forEach(function (khachHang, index){
                    let tenKhachHang = khachHang.TenKhachHang + ''
                    if(txtTimKiem.value.length <= tenKhachHang.length && tenKhachHang.includes(txtTimKiem.value)){
                        ds.push(khachHang)
                    }
                })
            }
            else {
                listKhachHangGoc.forEach(function (khachHang, index){
                    let soDienThoai = khachHang.SoDienThoai + ''
                    if(txtTimKiem.value.length <= soDienThoai.length && soDienThoai.includes(txtTimKiem.value)){
                        ds.push(khachHang)
                    }
                })
            }
            renderKhachHang(ds)

        }
    }
    txtTimKiem.oninput = function (){
        timKiemKhachHang()
    }
    combobox.onchange = function (){
        timKiemKhachHang()
    }
    txtSoDienThoai.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        this.value = this.value.replace(/[^0-9]/g, '');
        this.setSelectionRange(start, end);
        kiemTraSoDienThoai()
    }
    txtHoVaTen.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        this.value = this.value.replace(/[^\p{L}\s]/gu, '')
        this.setSelectionRange(start, end);
        kiemTraHoVaTen()
    }
    txtSoDienThoaiU.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        this.value = this.value.replace(/[^0-9]/g, '');
        this.setSelectionRange(start, end);
        kiemTraSoDienThoaiU()
    }
    txtHoVaTenU.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        this.value = this.value.replace(/[^\p{L}\s]/gu, '')
        this.setSelectionRange(start, end);
        kiemTraHoVaTenU()
    }
    btnThem.onclick =  function (){
        kiemTraHoVaTen()
        kiemTraSoDienThoai()
        
        if(hopLeHoVaTen === true && hopLeSoDienThoai === true){
            let radioGioiTinh = document.querySelector('input[name="radio-gioiTinh"]:checked')
            let newKhachHang = {
                'TenKhachHang': txtHoVaTen.value,
                'SoDienThoai': txtSoDienThoai.value,
                'GioiTinh':radioGioiTinh.value
            }
            themKhachHang(newKhachHang)
        }
    }
    btnXacNhanCapNhat.onclick=  function (){
        
        kiemTraHoVaTenU()
        kiemTraSoDienThoaiU()

        if(hopLeHoVaTenU === true && hopLeSoDienThoaiU === true){
            let radioGioiTinhU = document.querySelector('input[name="radio-gioiTinhU"]:checked')
            let khachHang = {
                'MaKhachHang': this.value,
                'TenKhachHang': txtHoVaTenU.value,
                'SoDienThoai': txtSoDienThoaiU.value,
                'GioiTinh':radioGioiTinhU.value,
                'DiaChi': txtDiaChi.value !== '' ? txtDiaChi.value : null
            }
            capNhatKhachHang(khachHang)
        }
    }
    comboboxDanhSachTuTrangThai.onchange = async function (){
        try{
            const response = await fetch(`./fetch/danh-sach-khach-hang-theo-trang-thai-${this.value}`)
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            const data = await response.json()
            listKhachHangGoc = []
            if(data != null){
                listKhachHangGoc = Array.from(data)
                renderKhachHang(listKhachHangGoc)
            }
        }
        catch (error){
            console.log('Fetch error: ',error)
        }
    }
    try{
        const response = await fetch(`./fetch/danh-sach-khach-hang-theo-trang-thai-${comboboxDanhSachTuTrangThai.value}`)
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const data = await response.json()
        listKhachHangGoc = []
        if(data != null){
            listKhachHangGoc = Array.from(data)
            renderKhachHang(listKhachHangGoc)
        }
    }
    catch (error){
        console.log('Fetch error: ',error)
    }
})