const resend = document.querySelector("#resend"); //resend "link"
const forgot = document.querySelector("#forgot"); //forgot password "link"
const modalResend = document.querySelector("#modalResend");
const modalForgot = document.querySelector("#modalForgot");
const close = document.querySelectorAll(".iconClose");
const modalCards = document.querySelectorAll(".modalCard");


//Prevent from exiting if clicked on card (RESEND OR FORGOT MODAL)
modalCards.forEach(item => {
    item.addEventListener("click", (e) => {
        e.stopPropagation();
    });
});


function formResets(){

    //Reseting forms
    document.querySelector("#resendForm").reset();
    document.querySelector("#forgotForm").reset();

    //Removing inputs class "is-invalid"
    let inputResend = document.querySelector("#resendEmail");
    let inputForgot = document.querySelector("#forgotEmail");
    if(inputResend.classList.contains("is-invalid")){
        inputResend.classList.remove("is-invalid");
    }
    if(inputForgot.classList.contains("is-invalid")){
        inputForgot.classList.remove("is-invalid");
    }

}

//(SHOW) add activeModal class to modal (resed or forgot)
resend.addEventListener("click", () => {
    modalResend.classList.add("activeModal");
});
forgot.addEventListener("click", () => {
    modalForgot.classList.add("activeModal");
});

//==============
// REMOVING MODAL (activeModal)
//==============

//  on 'x' icon both cards
close.forEach(item => {
    item.addEventListener("click", (e) => {
        e.target.parentElement.parentElement.classList.remove("activeModal");
        formResets();
    });
});

// on side click
function removeModalActiveSide(e){
    e.target.classList.remove("activeModal");
    formResets();
}
modalResend.addEventListener("click", removeModalActiveSide);
modalForgot.addEventListener("click", removeModalActiveSide);






