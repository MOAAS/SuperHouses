let signUpForm = document.querySelector('#signup form');
let signUpFormButton = signUpForm.querySelector('button[type="submit"]');
let buttonText = signUpFormButton.textContent;

signUpForm.addEventListener('submit', event => {
    event.preventDefault();
    let usernameInput = signUpForm.querySelector('#username');
    clearInvalidInput(usernameInput);
    let validForm = true;

    let validateUserInput = (input) => {
        if (input.value.length < 8) {
            validForm = false;
            setInvalidInput(input, "Username must be at least 8 characters long!");
            input.value = "";
        } else if (!input.value.match(/^[a-zA-Z0-9]+$/)) {
            validForm = false;
            setInvalidInput(input, "Username may only contain letters and numbers!");
            input.value = "";
        }
        else clearInvalidInput(input);
    }

    let validatePasswordInput = (input1, input2) => {
        if (input1.value != input2.value) {
            validForm = false;
            setInvalidInput(input1, "Passwords don't match!");
            setInvalidInput(input2, "Passwords don't match!");
            input1.value = "";
            input2.value = "";
        } else {
            clearInvalidInput(input1);
            clearInvalidInput(input2);
        }
    }

    validateUserInput(usernameInput);
    validatePasswordInput(signUpForm.querySelector('#password'), signUpForm.querySelector('#confirmPassword'));

    sendGetRequest('../api/get_userExists.php', { username: usernameInput.value }, function() {return validateUser(this.responseText, validForm)})
});

function validateUser(responseText, validForm) {
    let usernameInput = signUpForm.querySelector('#username');
    if(JSON.parse(responseText)) {
        validForm = false;
        setInvalidInput(usernameInput, "Username already exists!");
        usernameInput.value = "";
    }

    if(validForm)
        signUpForm.submit();
    else addButtonAnimation(signUpFormButton, "red", "Invalid input", buttonText);
}