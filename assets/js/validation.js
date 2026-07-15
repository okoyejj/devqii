document.addEventListener('DOMContentLoaded', () => {
  const form = document.querySelector('form[data-validate="true"]');
  if (!form) return;

  form.addEventListener('submit', (event) => {
    const requiredFields = form.querySelectorAll('[required]');
    let valid = true;

    requiredFields.forEach((field) => {
      const empty = field.type === 'checkbox' ? !field.checked : !field.value.trim();
      if (empty) {
        valid = false;
        field.setAttribute('aria-invalid', 'true');
      } else {
        field.removeAttribute('aria-invalid');
      }
    });

    const emailField = form.querySelector('input[name="email"]');
    if (emailField?.value && !/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(emailField.value)) {
      valid = false;
      emailField.setAttribute('aria-invalid', 'true');
    }

    if (!valid) {
      event.preventDefault();
      const errorBox = document.querySelector('[data-form-error]');
      if (errorBox) {
        errorBox.textContent = 'Please complete the highlighted required fields and provide a valid email address.';
      }
    }
  });
});
