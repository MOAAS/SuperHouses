let signUpForm = document.querySelector('#signup form');
let signUpFormButton = signUpForm.querySelector('input[type="submit"]');
let buttonText = signUpFormButton.textContent;
let usernameInput = signUpForm.querySelector('#username');

signUpForm.addEventListener('submit', event => {
    event.preventDefault();
    clearInvalidInput(usernameInput);
    let validForm = true;

    if (usernameInput.value.length < 0) {
        validForm = false;
        setInvalidInput(usernameInput, "Username must be at least 8 characters long!");
        usernameInput.value = "";
    }
    else clearInvalidInput(usernameInput);

    if (validForm)
        sendGetRequest('../api/get_userExists.php', { username: usernameInput.value }, validateUser)
    else addButtonAnimation(signUpFormButton, "red", "Invalid input", buttonText);
});

function validateUser() {
    if(JSON.parse(this.responseText)) {
        setInvalidInput(usernameInput, "Username already exists!");
        usernameInput.value = "";
    }
    else {
        clearInvalidInput(usernameInput);
        signUpForm.submit();
    }
}