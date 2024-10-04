document.addEventListener('DOMContentLoaded', async function (){
    let listDoAnUongGoc = []
    const tableDoAnUong = document.querySelector('#table-doAnUong tbody')
    const btnThemDoAn = document.querySelector('#btn-themDoAn')
    const btnThemDoUong = document.querySelector('#btn-themDoUong')
    const btnXacNhanXoa = document.querySelector('#btn-xacNhanXoa')
    const btnXacNhanCapNhatDoAn = document.querySelector('#btn-CapNhatDoAn')
    const btnXacNhanCapNhatDoUong = document.querySelector('#btn-CapNhatDoUong')

    const messageDoAnUong = document.querySelector('#message-doAnUong')
    const messageXoa = document.querySelector('#message-xoa')
    const messageErrorThemTenDoAn = document.querySelector('#message-errorThemTenDoAn')
    const messageErrorThemGiaDoAn = document.querySelector('#message-errorThemGiaDoAn')
    const messageErrorThemTenDoUong = document.querySelector('#message-errorThemTenDoUong')
    const messageErrorThemGiaDoUong = document.querySelector('#message-errorThemGiaDoUong')
    const messageErrorCapNhatTenDoAn = document.querySelector('#message-errorCapNhatTenDoAn')
    const messageErrorCapNhatGiaDoAn = document.querySelector('#message-errorCapNhatGiaDoAn')
    const messageErrorCapNhatTenDoUong = document.querySelector('#message-errorCapNhatTenDoUong')
    const messageErrorCapNhatGiaDoUong = document.querySelector('#message-errorCapNhatGiaDoUong')

    const txtTimKiem = document.querySelector('#txt-timKiem')
    const txtThemTenDoAn = document.querySelector('#txt-ThemTenDoAn')
    const txtThemGiaDoAn = document.querySelector('#txt-ThemGiaDoAn')
    const txtThemTenDoUong = document.querySelector('#txt-ThemTenDoUong')
    const txtThemGiaDoUong = document.querySelector('#txt-ThemGiaDoUong')

    const txtCapNhatTenDoAn = document.querySelector('#txt-CapNhatTenDoAn')
    const txtCapNhatGiaDoAn = document.querySelector('#txt-CapNhatGiaDoAn')
    const txtCapNhatMoTaDoAn = document.querySelector('#txt-CapNhatMoTaDoAn')
    const txtCapNhatTenDoUong = document.querySelector('#txt-CapNhatTenDoUong')
    const txtCapNhatGiaDoUong = document.querySelector('#txt-CapNhatGiaDoUong')
    const txtCapNhatMoTaDoUong = document.querySelector('#txt-CapNhatMoTaDoUong')

    const comboboxThemDonViDoAn = document.querySelector('#combobox-ThemDonViDoAn')
    const comboboxThemDonViDoUong = document.querySelector('#combobox-ThemDonViDoUong')
    const comboboxCapNhatDonViDoAn = document.querySelector('#combobox-CapNhatDonViDoAn')
    const comboboxCapNhatDonViDoUong = document.querySelector('#combobox-CapNhatDonViDoUong')
    const comboboxCapNhatTrangThaiDoAn = document.querySelector('#combobox-CapNhatTrangThaiDoAn')
    const comboboxCapNhatTrangThaiDoUong = document.querySelector('#combobox-CapNhatTrangThaiDoUong')
    const comboboxDanhSachTuTrangThai = document.querySelector('#combobox-danhSachTuTrangThai')

    let hopLeThemTenDoAn = false
    let hopLeThemGiaDoAn = false
    let hopLeThemTenDoUong = false
    let hopLeThemGiaDoUong = false
    let hopLeCapNhatTenDoAn = false
    let hopLeCapNhatGiaDoAn = false
    let hopLeCapNhatTenDoUong = false
    let hopLeCapNhatGiaDoUong = false

    function renderDoAnUong(list){
        tableDoAnUong.innerHTML = ''
        if(list.length > 0){
            messageDoAnUong.classList.add('d-none')
            list.forEach(function (doAnUong, index){
                let newRow = document.createElement('tr');
                let capNhatButton = '';
                let xoaButton = '';

                // Kiểm tra loại và chọn nút cập nhật phù hợp
                if (doAnUong.Loai === 'Đồ ăn') {
                    capNhatButton = `<button class="btn btn-outline-primary btn-capNhatDoAn" data-bs-toggle="modal" data-bs-target="#form-capNhatDoAn" value="${doAnUong.MaDoAnUong}">Cập nhật</button>`;
                } else if (doAnUong.Loai === 'Đồ uống') {
                    capNhatButton = `<button class="btn btn-outline-primary btn-capNhatDoUong" data-bs-toggle="modal" data-bs-target="#form-capNhatDoUong" value="${doAnUong.MaDoAnUong}">Cập nhật</button>`;
                }
                if(doAnUong.TrangThai !==1){
                    xoaButton = `<button class="btn btn-outline-danger btn-xoa" data-bs-toggle="modal" data-bs-target="#message-xoa" value="${doAnUong.MaDoAnUong}">Xóa</button>`;
                }
                newRow.innerHTML = `
                    <td>${index + 1}</td>
                    <td>${doAnUong.MaDoAnUong}</td>
                    <td>${doAnUong.Ten}</td>
                    <td>${doAnUong.Gia}</td>
                    <td>${doAnUong.Loai}</td>
                    <td>${doAnUong.DonVi}</td>
                    <td>
                        <a href="./thuc-don-chi-tiet-${doAnUong.MaDoAnUong}" class="btn btn-light">Xem</a>
                        ${xoaButton}
                        ${capNhatButton}
                    </td>
                `;

                tableDoAnUong.appendChild(newRow);
            })


        }
        else{
            messageDoAnUong.classList.remove('d-none')
        }

        const btnXoaS = document.querySelectorAll('.btn-xoa')
        btnXoaS.forEach(function (btn, index){
            btn.onclick = function (){
                let doAnUong = listDoAnUongGoc.find(au => au.MaDoAnUong === this.value)
                btnXacNhanXoa.value = this.value

                messageXoa.querySelector('.modal-body').innerHTML = `Bạn có muốn xóa ${doAnUong.Loai} có mã là ${this.value} không ?`
            }
        })
        btnXacNhanXoa.onclick = async function (){
            try {
                const response = await fetch('./fetch/xoa-do-an-uong', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body:JSON.stringify({'MaDoAnUong':this.value})
                })
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                const data = await response.json()
                if(data.status === 'success'){
                    window.location.href = './thuc-don'
                }
                else {
                    alert(data.message)
                }
            }
            catch (error){
                console.error('Fetch error: ', error)
            }

        }
        const btnCapNhatDoAn = document.querySelectorAll('.btn-capNhatDoAn')
        btnCapNhatDoAn.forEach(function (btn, index){
            btn.onclick = function (){
                const doAnUong = listDoAnUongGoc.find(au => au.MaDoAnUong === this.value)
                txtCapNhatTenDoAn.value = doAnUong.Ten
                if(doAnUong.TrangThai === 1){
                    txtCapNhatGiaDoAn.setAttribute('disabled', true)
                }
                else{
                    txtCapNhatGiaDoAn.removeAttribute('disabled')
                }
                txtCapNhatGiaDoAn.value = doAnUong.Gia
                txtCapNhatMoTaDoAn.value = doAnUong.MoTa
                comboboxCapNhatDonViDoAn.value = doAnUong.DonVi
                comboboxCapNhatTrangThaiDoAn.value = doAnUong.TrangThai
                btnXacNhanCapNhatDoAn.value = doAnUong.MaDoAnUong

            }
        })
        const btnCapNhatDoUong = document.querySelectorAll('.btn-capNhatDoUong')
        btnCapNhatDoUong.forEach(function (btn, index){
            btn.onclick = function (){
                const doAnUong = listDoAnUongGoc.find(au => au.MaDoAnUong === this.value)
                txtCapNhatTenDoUong.value = doAnUong.Ten
                if(doAnUong.TrangThai === 1){
                    txtCapNhatGiaDoUong.setAttribute('disabled', true)
                }
                else{
                    txtCapNhatGiaDoUong.removeAttribute('disabled')
                }
                txtCapNhatGiaDoUong.value = doAnUong.Gia
                txtCapNhatMoTaDoUong.value = doAnUong.MoTa
                comboboxCapNhatDonViDoUong.value = doAnUong.DonVi
                comboboxCapNhatTrangThaiDoUong.value = doAnUong.TrangThai
                btnXacNhanCapNhatDoUong.value = doAnUong.MaDoAnUong
        
            }
        })
    }
    function kiemTraThemTenDoAn(){
        if(txtThemTenDoAn.value === ''){
            hopLeThemTenDoAn = false
            messageErrorThemTenDoAn.innerHTML = 'Không được để trống'
        }
        else{
            hopLeThemTenDoAn = true
            messageErrorThemTenDoAn.innerHTML = ''
        }
    }
    function kiemTraThemGiaDoAn(){
        if(txtThemGiaDoAn.value === ''){
            hopLeThemGiaDoAn = false
            messageErrorThemGiaDoAn.innerHTML = 'Không được để trống'
        }
        else{
            if(parseInt(txtThemGiaDoAn.value) % 1000 === 0){
                hopLeThemGiaDoAn = true
                messageErrorThemGiaDoAn.innerHTML = ''
            }
            else{
                hopLeThemGiaDoAn = false
                messageErrorThemGiaDoAn.innerHTML = 'Giá đồ ăn phải tròn nghìn'
            }
        }
    }
    function kiemTraThemTenDoUong(){
        if(txtThemTenDoUong.value === ''){
            hopLeThemTenDoUong = false
            messageErrorThemTenDoUong.innerHTML = 'Không được để trống'
        }
        else{
            hopLeThemTenDoUong = true
            messageErrorThemTenDoUong.innerHTML = ''
        }
    }
    function kiemTraThemGiaDoUong(){
        if(txtThemGiaDoUong.value === ''){
            hopLeThemGiaDoUong = false
            messageErrorThemGiaDoUong.innerHTML = 'Không được để trống'
        }
        else{
            if(parseInt(txtThemGiaDoUong.value) % 1000 === 0){
                hopLeThemGiaDoUong = true
                messageErrorThemGiaDoUong.innerHTML = ''
            }
            else{
                hopLeThemGiaDoUong = false
                messageErrorThemGiaDoUong.innerHTML = 'Giá đồ uống phải tròn nghìn'
            }
        }
    }

    function kiemTraCapNhatTenDoAn(){
        if(txtCapNhatTenDoAn.value === ''){
            hopLeCapNhatTenDoAn = false
            messageErrorCapNhatTenDoAn.innerHTML = 'Không được để trống'
        }
        else{
            hopLeCapNhatTenDoAn = true
            messageErrorCapNhatTenDoAn.innerHTML = ''
        }
    }
    function kiemTraCapNhatGiaDoAn(){
        if(txtCapNhatGiaDoAn.value === ''){
            hopLeCapNhatGiaDoAn = false
            messageErrorCapNhatGiaDoAn.innerHTML = 'Không được để trống'
        }
        else{
            if(parseInt(txtCapNhatGiaDoAn.value) % 1000 === 0){
                hopLeCapNhatGiaDoAn = true
                messageErrorCapNhatGiaDoAn.innerHTML = ''
            }
            else{
                hopLeCapNhatGiaDoAn = false
                messageErrorCapNhatGiaDoAn.innerHTML = 'Giá đồ ăn phải tròn nghìn'
            }
        }
    }
    function kiemTraCapNhatTenDoUong(){
        if(txtCapNhatTenDoUong.value === ''){
            hopLeCapNhatTenDoUong = false
            messageErrorCapNhatTenDoUong.innerHTML = 'Không được để trống'
        }
        else{
            hopLeCapNhatTenDoUong = true
            messageErrorCapNhatTenDoUong.innerHTML = ''
        }
    }
    function kiemTraCapNhatGiaDoUong(){
        if(txtCapNhatGiaDoUong.value === ''){
            hopLeCapNhatGiaDoUong = false
            messageErrorCapNhatGiaDoUong.innerHTML = 'Không được để trống'
        }
        else{
            if(parseInt(txtCapNhatGiaDoUong.value) % 1000 === 0){
                hopLeCapNhatGiaDoUong = true
                messageErrorCapNhatGiaDoUong.innerHTML = ''
            }
            else{
                hopLeCapNhatGiaDoUong = false
                messageErrorCapNhatGiaDoUong.innerHTML = 'Giá đồ uống phải tròn nghìn'
            }
        }
    }
    function timKiemDoAnUong(){
        if(txtTimKiem.value === ''){
            renderDoAnUong(listDoAnUongGoc)
        }
        else{
            let ds = []
            listDoAnUongGoc.forEach(function (doAnUong, index) {
                let ten = doAnUong.Ten + ''
                if (txtTimKiem.value.length <= ten.length && ten.includes(txtTimKiem.value)) {
                    ds.push(doAnUong)
                }
            })
            renderDoAnUong(ds)
        }
    }
    async function themDoAnUong(obj){
        try {
            const response = await fetch('./fetch/them-do-an-uong',{
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
                window.location.href = './thuc-don'
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }
    async function capNhatDoAnUong(obj){
        try {
            const response = await fetch('./fetch/cap-nhat-do-an-uong',{
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
                if(data.message !== undefined){
                    alert(data.message)
                }
                window.location.href = './thuc-don'
            }
            else {
                alert(data.message)
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }
    btnThemDoAn.onclick = function (){
        kiemTraThemTenDoAn()
        kiemTraThemGiaDoAn()
        if(hopLeThemTenDoAn && hopLeThemGiaDoAn){
            let newDoAn = {
                'Ten': txtThemTenDoAn.value,
                'Gia': txtThemGiaDoAn.value,
                'DonVi': comboboxThemDonViDoAn.value,
                'Loai': 'Đồ ăn'
            }
            themDoAnUong(newDoAn)
        }
    }
    btnThemDoUong.onclick = function (){
        kiemTraThemTenDoUong()
        kiemTraThemGiaDoUong()
        if(hopLeThemTenDoUong && hopLeThemGiaDoUong){
            let newDoUong = {
                'Ten': txtThemTenDoUong.value,
                'Gia': txtThemGiaDoUong.value,
                'DonVi': comboboxThemDonViDoUong.value,
                'Loai': 'Đồ uống'
            }
            themDoAnUong(newDoUong)
        }
    }
    btnXacNhanCapNhatDoAn.onclick = function (){
        kiemTraCapNhatTenDoAn()
        kiemTraCapNhatGiaDoAn()
        if(hopLeCapNhatTenDoAn && hopLeCapNhatGiaDoAn){
            let doAn = {
                'MaDoAnUong': this.value,
                'Ten': txtCapNhatTenDoAn.value,
                'Gia': txtCapNhatGiaDoAn.value,
                'DonVi': comboboxCapNhatDonViDoAn.value,
                'MoTa': txtCapNhatMoTaDoAn.value,
                'TrangThai': comboboxCapNhatTrangThaiDoAn.value
            }
            capNhatDoAnUong(doAn)
        }
    }
    btnXacNhanCapNhatDoUong.onclick = function (){
        kiemTraCapNhatTenDoUong()
        kiemTraCapNhatGiaDoUong()
        if(hopLeCapNhatTenDoUong && hopLeCapNhatGiaDoUong){
            let doUong = {
                'MaDoAnUong': this.value,
                'Ten': txtCapNhatTenDoUong.value,
                'Gia': txtCapNhatGiaDoUong.value,
                'DonVi': comboboxCapNhatDonViDoUong.value,
                'MoTa': txtCapNhatMoTaDoUong.value,
                'TrangThai': comboboxCapNhatTrangThaiDoUong.value
            }
            capNhatDoAnUong(doUong)
        }
    }
    
    txtThemGiaDoAn.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;
    
        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || 1
        this.setSelectionRange(start, end);
    }
    txtCapNhatGiaDoAn.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;
    
        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || 1
        this.setSelectionRange(start, end);
    }
    txtThemGiaDoUong.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;
    
        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || 1
        this.setSelectionRange(start, end);
    }
    txtCapNhatGiaDoUong.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;
    
        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || 1
        this.setSelectionRange(start, end);
    }
    txtTimKiem.oninput = function (){
        timKiemDoAnUong()
    }
    comboboxDanhSachTuTrangThai.onchange = async function (){
        try{
            const response = await fetch(`./fetch/danh-sach-do-an-uong-theo-trang-thai-${this.value}`)
            if (!response.ok) {
                throw new Error('Network response was not ok ' + response.statusText);
            }
            const data = await response.json()
            listDoAnUongGoc = []
            if(data != null){
                listDoAnUongGoc = Array.from(data)
                renderDoAnUong(listDoAnUongGoc)
            }
        }
        catch (error){
            console.log('Fetch error: ',error)
        }
    }
    try{
        const response = await fetch(`./fetch/danh-sach-do-an-uong-theo-trang-thai-${comboboxDanhSachTuTrangThai.value}`)
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const data = await response.json()
        listDoAnUongGoc = []
        if(data != null){
            listDoAnUongGoc = Array.from(data)
            renderDoAnUong(listDoAnUongGoc)
        }
    }
    catch (error){
        console.log('Fetch error: ',error)
    }

})