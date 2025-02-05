document.addEventListener("DOMContentLoaded", () => {
    const registerForm = document.getElementById("registerForm");

    registerForm.addEventListener("submit", (event) => {
        const password = document.getElementById("password").value;
        const confirmPassword = document.getElementById("confirmPassword").value;

        // Verificar que las contraseñas coincidan
        if (password !== confirmPassword) {
            event.preventDefault(); // Evitar que se envíe el formulario
            alert("Las contraseñas no coinciden. Por favor, verifica e inténtalo de nuevo.");
        }
    });
});
