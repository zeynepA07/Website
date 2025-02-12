//store timout duration as 1 hour (in milliseconds)
let timeoutDuration = 3600000



//if the duration is equal to the timeout duration, display alert and redirect the user to the error page.
function setupSessionTimeout(duration) {
    timeoutDuration = duration || timeoutDuration;
    setTimeout(() => {
        alert("Your session has expired.");
        window.location.href = "../html/errorPages/sessionExpired.html";}, timeoutDuration);
}