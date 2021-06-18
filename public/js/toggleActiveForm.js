//Class toggling code LOGIN/REGISTER
let formButtons = document.querySelectorAll('.formBtn');
let forms = [document.querySelector('#formRegister'),document.querySelector('#formLogin')];
formButtons.forEach(item => { item.addEventListener('click',() =>{
        if(!item.classList.contains('formBtn-active')){
            formButtons.forEach(item => { item.classList.toggle('formBtn-active')});
            forms.forEach(item => { item.classList.toggle('form-active')});
        }
    })
});