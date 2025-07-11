window.addEventListener("scroll", () => {
    if (window.scrollY > 100) {
        document.querySelector("header").classList.add("scrolled");
    } else {
        document.querySelector("header").classList.remove("scrolled");
    }
});

// if size is phone, remove on click from the logo
if (window.innerWidth <= 768) {
    document.querySelector(".logo").removeAttribute("onclick");
}


const loggedinData = localStorage.getItem("loggedin");
var login = false;

if (loggedinData) {
    const user = JSON.parse(loggedinData);
    console.log("✅ User is logged in:", user);
    login = true;
} else {
    console.log("🚫 User is not logged in");
}


const logins  = document.querySelectorAll('.logins');
const logouts = document.querySelectorAll('.logouts');

if (login) {
    // المستخدم مسجل دخول
    logins.forEach(el => el.remove());    // إخفاء تسجيل الدخول
} else {
    // المستخدم غير مسجل
    logouts.forEach(el => el.remove());   // إخفاء تسجيل الخروج
}



function togglePassword(fieldId, icon) {
    const field = document.getElementById(fieldId);
    if (field.type === 'password') {
        field.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        field.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}