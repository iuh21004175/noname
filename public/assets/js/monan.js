document.addEventListener('DOMContentLoaded', async function (){
    let listMonAnGoc = []
    const tableMonAn = document.querySelector('#table-monAn tbody')
    const btnThem = document.querySelector('#btn-them')
    const btnXacNhanXoa = document.querySelector('#btn-xacNhanXoa')
    const btnXacNhanCapNhat = document.querySelector('#btn-xacNhanCapNhat')

    const messageMonAn = document.querySelector('#message-monAn')
    const messageXoa = document.querySelector('#message-xoa')
    const messageErrorThemTen = document.querySelector('#message-errorThemTen')
    const messageErrorThemGia = document.querySelector('#message-errorThemGia')
    const messageErrorCapNhatTen = document.querySelector('#message-errorCapNhatTen')
    const messageErrorCapNhatGia = document.querySelector('#message-errorCapNhatGia')

    const txtTimKiem = document.querySelector('#txt-timKiem')
    const txtThemTen = document.querySelector('#txt-ThemTen')
    const txtThemGia = document.querySelector('#txt-ThemGia')

    const txtCapNhatTen = document.querySelector('#txt-CapNhatTen')
    const txtCapNhatGia = document.querySelector('#txt-CapNhatGia')
    const txtCapNhatMoTa = document.querySelector('#txt-CapNhatMoTa')

    const comboboxCapNhatLoai = document.querySelector('#combobox-CapNhatLoaiMonAn')
    const comboboxThemLoai = document.querySelector('#combobox-ThemLoaiMonAn')

    let hopLeThemTen = false
    let hopLeThemGia = false
    let hopLeCapNhatTen = false
    let hopLeCapNhatGia = false

    function renderMonAn(list){
        tableMonAn.innerHTML = ''
        if(list.length > 0){
            messageMonAn.classList.add('d-none')
            list.forEach(function (monAn, index){
                let newRow = document.createElement('tr')
                newRow.innerHTML = `
                <td >${index + 1}</td>
                <td>${monAn.TenMonAn}</td>
                <td>${monAn.Gia}</td>
                <td>${monAn.TenLoaiMonAn}</td>
                <td>
                    <a href="./mon-an-chi-tiet-${monAn.MaMonAn}" class="btn btn-light">Xem</a>
                    <button class="btn btn-outline-danger btn-xoa" data-bs-toggle="modal" data-bs-target="#message-xoa" value="${monAn.MaMonAn}">Xóa</button>
                    <button class="btn btn-outline-primary btn-capNhat" data-bs-toggle="modal" data-bs-target="#form-capNhat" value="${monAn.MaMonAn}">Cập nhật</button>
                </td>
            `
                tableMonAn.appendChild(newRow)
            })


        }
        else{
            messageMonAn.classList.remove('d-none')
        }

        const btnXoaS = document.querySelectorAll('.btn-xoa')
        btnXoaS.forEach(function (btn, index){
            btn.onclick = function (){
                btnXacNhanXoa.value = this.value

                messageXoa.querySelector('.modal-body').innerHTML = `Bạn có muốn xóa món ăn có mã là ${this.value} không ?`
            }
        })
        btnXacNhanXoa.onclick = async function (){
            try {
                const response = await fetch('./fetch/xoa-mon-an', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json'
                    },
                    body:JSON.stringify({'MaMonAn':this.value})
                })
                if (!response.ok) {
                    throw new Error('Network response was not ok ' + response.statusText);
                }
                const data = await response.json()
                if(data.status === 'success'){
                    window.location.href = './mon-an'
                }
            }
            catch (error){
                console.error('Fetch error: ', error)
            }

        }
        const btnCapNhatS = document.querySelectorAll('.btn-capNhat')
        btnCapNhatS.forEach(function (btn, index){
            btn.onclick = function (){
                const monAn = listMonAnGoc.find(ma => ma.MaMonAn === parseInt(this.value))
                txtCapNhatTen.value = monAn.TenMonAn
                txtCapNhatGia.value = monAn.Gia
                txtCapNhatMoTa.value = monAn.MoTa
                comboboxCapNhatLoai.value = monAn.MaLoaiMonAn
                btnXacNhanCapNhat.value = monAn.MaMonAn

            }
        })
    }
    function kiemTraThemTenMonAn(){
        if(txtThemTen.value === ''){
            hopLeThemTen = false
            messageErrorThemTen.innerHTML = 'Không được để trống'
        }
        else{
            hopLeThemTen = true
            messageErrorThemTen.innerHTML = ''
        }
    }
    function kiemTraThemGiaMonAn(){
        if(txtThemGia.value === ''){
            hopLeThemGia = false
            messageErrorThemGia.innerHTML = 'Không được để trống'
        }
        else{
            if(parseInt(txtThemGia.value) % 1000 === 0){
                hopLeThemGia = true
                messageErrorThemGia.innerHTML = ''
            }
            else{
                hopLeThemGia = false
                messageErrorThemGia.innerHTML = 'Giá món ăn phải tròn nghìn'
            }
        }
    }
    function kiemTraCapNhatTenMonAn(){
        if(txtCapNhatTen.value === ''){
            hopLeCapNhatTen = false
            messageErrorCapNhatTen.innerHTML = 'Không được để trống'
        }
        else{
            hopLeCapNhatTen = true
            messageErrorCapNhatTen.innerHTML = ''
        }
    }
    function kiemTraCapNhatGiaMonAn(){
        if(txtCapNhatGia.value === ''){
            hopLeCapNhatGia = false
            messageErrorCapNhatGia.innerHTML = 'Không được để trống'
        }
        else{
            if(parseInt(txtCapNhatGia.value) % 1000 === 0){
                hopLeCapNhatGia = true
                messageErrorCapNhatGia.innerHTML = ''
            }
            else{
                hopLeCapNhatGia = false
                messageErrorCapNhatGia.innerHTML = 'Giá món ăn phải tròn nghìn'
            }
        }
    }
    function timKiemMonAn(){
        if(txtTimKiem.value === ''){
            renderMonAn(listMonAnGoc)
        }
        else{
            let ds = []
            listMonAnGoc.forEach(function (monAn, index) {
                let tenMonAn = monAn.TenMonAn + ''
                if (txtTimKiem.value.length <= tenMonAn.length && tenMonAn.includes(txtTimKiem.value)) {
                    ds.push(monAn)
                }
            })
            renderMonAn(ds)
        }
    }
    async function themMonAn(obj){
        try {
            const response = await fetch('./fetch/them-mon-an',{
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
                window.location.href = './mon-an'
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }
    async function capNhatMonAn(obj){
        try {
            const response = await fetch('./fetch/cap-nhat-mon-an',{
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
                window.location.href = './mon-an'
            }
        }
        catch (error){
            console.error('Fetch error: ', error)
        }
    }
    btnThem.onclick = function (){
        kiemTraThemTenMonAn()
        kiemTraThemGiaMonAn()
        if(hopLeThemTen === true && hopLeThemGia === true){
            let newMonAn = {
                'TenMonAn': txtThemTen.value,
                'Gia': txtThemGia.value,
                'MaLoaiMonAn': comboboxThemLoai.value
            }
            themMonAn(newMonAn)
        }
    }
    btnXacNhanCapNhat.onclick = function (){
        kiemTraCapNhatTenMonAn()
        kiemTraCapNhatGiaMonAn()
        if(hopLeCapNhatTen === true && hopLeCapNhatGia === true){
            let monAn = {
                'MaMonAn': btnXacNhanCapNhat.value,
                'TenMonAn': txtCapNhatTen.value,
                'Gia': txtCapNhatGia.value,
                'MoTa': txtCapNhatMoTa.value,
                'MaLoaiMonAn': comboboxCapNhatLoai.value
            }
            capNhatMonAn(monAn)
        }
    }
    txtThemGia.oninput = function (){
        let start = this.selectionStart;
        let end = this.selectionEnd;

        // Loại bỏ các ký tự không phải là số
        let inputValue = this.value.replace(/[^0-9]/g, '');
        this.value = inputValue || 1
        this.setSelectionRange(start, end);
    }
    txtTimKiem.oninput = function (){
        timKiemMonAn()
    }
    try{
        const response = await fetch('./fetch/danh-sach-mon-an')
        if (!response.ok) {
            throw new Error('Network response was not ok ' + response.statusText);
        }
        const data = await response.json()

        listMonAnGoc = Array.from(data)
        renderMonAn(listMonAnGoc)
    }
    catch (error){
        console.log('Fetch error: ',error)
    }

})