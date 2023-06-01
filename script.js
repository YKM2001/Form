const tab_controller = document.querySelectorAll('.tab-controller')

if(tab_controller) {
    tab_controller.forEach((controller, index) => {
        controller.addEventListener('click', () => {
            const tab_content = document.querySelectorAll('.tab-content')
            if(controller.innerHTML == 'Авторизация') {
                tab_content.forEach((content) => {
                    content.classList.remove('active')
                })
                tab_content[index].classList.add('active')
            } else {
                tab_content.forEach((content) => {
                    content.classList.remove('active')
                })
                tab_content[index].classList.add('active')
            }
        })
    })
}



// ? небольшой скриптик для чтения загруженной картинки :) 
const file = document.getElementById('file')

file.addEventListener('change', (e) => {
    const files = e.target.files;
    const countFiles = files.length 
        if(!countFiles) {
            alert('Не выбран файл!');
        }
    const selectedFile = files[0]

    const reader = new FileReader();

    reader.readAsDataURL(selectedFile)

    reader.addEventListener('load', (e) => {
    const img = document.getElementById('myimg');
    img.src = e.target.result
    })
})


const reg = document.querySelector('.reg')

// ? проверка подтвержденния пароля

reg.addEventListener('click', (e) => {
    const password = document.querySelector('.password').value
    const password_confirm = document.querySelector('.password_confirm').value
    if(password != password_confirm) {
        e.preventDefault()
        alert('Пароль не подтвержден!')
    } else {
        return true;
    }
})




