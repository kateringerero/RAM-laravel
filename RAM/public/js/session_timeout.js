// Set the session timeout (in seconds)
const sessionTimeout = 900; // 15 minutes

let timer;

function startSessionTimer() {
  clearTimeout(timer);
  timer = setTimeout(function() {
    // Trigger the modal when the session timeout is reached
    showModal();
  }, sessionTimeout * 1000);
}

function showModal() {
  alert('Your session has timed out. Please log in again.');
  window.location.href = 'index.php'; // Redirect to index page
}

startSessionTimer();

// Reset timer on any user interaction
document.addEventListener('mousemove', startSessionTimer);
document.addEventListener('keypress', startSessionTimer);
