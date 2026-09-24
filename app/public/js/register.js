const form = document.querySelector("form");

const errorPopup = document.getElementById("error-popup");
const errorPopupMessage = document.getElementById("error-popup-message");
const errorPopupClose = document.getElementById("error-popup-close");

const errorMessages = {
  required: "This field is required.",
  email_format: "Please enter a valid email address.",
  min_length: "Password must contain at least 8 characters.",
  password_mismatch: "Passwords do not match.",
  email_exists: "This email is already registered.",
  fraud_detected: "Registration cannot be completed.",
  server_error: "A server error occurred. Please try again.",
  invalid_csrf_token:
    "Your session has expired. Please refresh the page and try again.",
};

form.addEventListener("submit", async (event) => {
  event.preventDefault();

  clearErrors();

  const formData = new FormData(form);

  try {
    const response = await fetch(form.action, {
      method: "POST",
      body: formData,
    });

    const contentType = response.headers.get("content-type") ?? "";

    if (!contentType.includes("application/json")) {
      throw new Error("Server returned a non-JSON response.");
    }

    const result = await response.json();

    if (!response.ok) {
      if (result.field && result.code) {
        showError(result.field, result.code);
      } else {
        showGeneralError(result.code);
      }

      return;
    }

    window.location.href = "/registration/success";
  } catch (error) {
    console.error("Registration error", error);

    showGeneralError();
  }
});

function showError(field, code) {
  const input = document.getElementById(field);
  const errorElement = document.getElementById(`${field}-error`);

  if (!input || !errorElement) {
    showGeneralError();
    return;
  }

  input.classList.add("input-error");

  errorElement.textContent = errorMessages[code] ?? "Invalid value.";
}

function showGeneralError(code = "server_error") {
  errorPopupMessage.textContent =
    errorMessages[code] ?? errorMessages.server_error;

  errorPopup.classList.add("show");
}

function clearErrors() {
  document.querySelectorAll(".input-error").forEach((input) => {
    input.classList.remove("input-error");
  });

  document.querySelectorAll(".error").forEach((error) => {
    error.textContent = "";
  });

  errorPopup.classList.remove("show");
}

errorPopupClose.addEventListener("click", () => {
  errorPopup.classList.remove("show");
});
