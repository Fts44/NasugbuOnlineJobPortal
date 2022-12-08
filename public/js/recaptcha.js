function recaptchaCallback(){
    const btn = document.querySelector('#btn_proceed');
    btn.removeAttribute('disabled');
}
//Disable button if recaptcha is expired
function recaptchaExpired(){
    const btn = document.querySelector('#btn_proceed');
    btn.setAttribute('disabled', '');
}