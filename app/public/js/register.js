const form = document.querySelector("form");

const errorMessages = {
  required: "This field is required.",
  email_format: "Please enter a valid email address.",
  min_length: "Password must contain at least 8 characters.",
  password_mismatch: "Passwords do not match.",
  email_exists: "This email is already registered.",
  fraud_detected: "Registration cannot be completed.",
  server_error: "A server error occurred. Please try again.",
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
        showGeneralError();
      }

      return;
    }

    window.location.href = "/registration/success";
  } catch (error) {
    console.error("Registration error:", error);

    showGeneralError();
  }
});

function showError(field, error) {
  const input = document.getElementById(field);
  const errorElement = document.getElementById(`${field}-error`);

  if (!input || !errorElement) {
    showGeneralError();
    return;
  }

  input.classList.add("input-error");

  errorElement.textContent = errorMessages[error] ?? "Invalid value.";
}

function showGeneralError() {
  alert("A server error occurred. Please try again.");
}

function clearErrors() {
  document.querySelectorAll(".input-error").forEach((input) => {
    input.classList.remove("input-error");
  });

  document.querySelectorAll(".error").forEach((error) => {
    error.textContent = "";
  });
}
