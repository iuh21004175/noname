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




