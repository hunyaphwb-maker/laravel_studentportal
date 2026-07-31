import './bootstrap';

document.addEventListener('DOMContentLoaded', () => {
    document.querySelectorAll('[data-delete-confirm]').forEach((form) => {
        form.addEventListener('submit', (event) => {
            const message = form.getAttribute('data-delete-confirm') || 'Are you sure?';

            if (! window.confirm(message)) {
                event.preventDefault();
            }
        });
    });

    document.querySelectorAll('[data-password-match-form]').forEach((form) => {
        const password = form.querySelector('input[name="password"]');
        const confirmation = form.querySelector('[data-confirm-password-target]');
        const message = form.querySelector('[data-password-match-message]');

        if (! password || ! confirmation || ! message) {
            return;
        }

        const validateMatch = () => {
            const matches = confirmation.value === '' || password.value === confirmation.value;

            confirmation.setCustomValidity(matches ? '' : 'Passwords do not match.');
            message.classList.toggle('hidden', matches);
        };

        password.addEventListener('input', validateMatch);
        confirmation.addEventListener('input', validateMatch);
        form.addEventListener('submit', validateMatch);
    });
});
