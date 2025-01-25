let timeoutDuration = 3600000

function setupSessionTimeout(duration) {
    timeoutDuration = duration || timeoutDuration;
    setTimeout(() => {
        alert("Your session has expired.");
        window.location.href = "../html/errorPages/sessionExpired.html";}, timeoutDuration);
}