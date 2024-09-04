document.addEventListener('DOMContentLoaded', function() {
    document.getElementById('first_name').focus();
});

function validateForm() {
    const firstName = document.getElementById('first_name').value;
    const lastName = document.getElementById('last_name').value;
    const email = document.getElementById('email').value;
    const telephone = document.getElementById('telephone').value;
    const password = document.getElementById('password').value;

    if (!/^[A-Za-z]+$/.test(firstName)) {
        alert("First name should be alphabetic characters without space");
        return false;
    }
    if (!/^[A-Za-z]+$/.test(lastName)) {
        alert("Last name should be alphabetic characters without space");
        return false;
    }
    if (!/@/.test(email) || !/.com$/.test(email)) {
        alert("Email should include @ and end with .com");
        return false;
    }
    if (!/^\+\d{12}$/.test(telephone)) {
        alert("Telephone should start with + followed by country code and then 9 numeric characters");
        return false;
    }
    if (!firstName || !lastName || !email || !telephone || !password) {
        alert("All fields must be filled out");
        return false;
    }

    const xhr = new XMLHttpRequest();
    xhr.open("POST", "register_new_user.php", true);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.onload = function() {
        if (this.status == 200) {
            if (this.responseText.includes("User record has been recorded")) {
                alert("User record has been recorded");
            } else {
                alert(this.responseText);
            }
        } else {
            alert("There was a problem with the request.");
        }
    };
    xhr.send(`first_name=${firstName}&last_name=${lastName}&user_type_id=${document.getElementById('user_type_id').value}&email=${email}&telephone=${telephone}&password=${password}`);
    
    return false;
}
