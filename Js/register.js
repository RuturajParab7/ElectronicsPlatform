function getCredentials() {
    var username = document.getElementById("username").value;
    var email = document.getElementById("email").value;
    var pass = document.getElementById("pass").value;
    var confirmPass = document.getElementById("confirm_password").value;

    if (username && email !=null) {
        if (pass === confirmPass) {
            sendData(username, email, pass);
        }
         else
          {
            alert("Passwords do not match!");
            }
    } 
    else 
    {
        alert("Please fill in all fields!");
    }
}

function sendData(username, email, pass) {
    var fdata = new FormData();
    fdata.append("username", username);
    fdata.append("email", email);
    fdata.append("password", pass); // Ensure this key matches PHP script's expected key

    const sendinfo = new XMLHttpRequest();
    sendinfo.open("POST", "../PHP/register.php", true); // Make sure the URL is correct
    alert("connection open ");
    sendinfo.setRequestHeader("X-Requested-With", "XMLHttpRequest"); // Optionally set header

    sendinfo.onreadystatechange = function() {
        if (sendinfo.readyState === XMLHttpRequest.DONE) {
            if (sendinfo.status === 200) {
                alert("Data sent successfully");
                // Optionally clear the form fields here
            } else {
                alert("Error: " + sendinfo.status + " - " + sendinfo.statusText);
            }
        }
    };

    sendinfo.onerror = function() {
        alert("Request failed. Please try again.");
    };

    sendinfo.send(fdata);
}
