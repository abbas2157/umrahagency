import './bootstrap';

document.addEventListener('click', (event) => {
    const toggle = event.target.closest('[data-toggle-password]');
    if (!toggle) return;

    const input = toggle.previousElementSibling;
    const showing = input.type === 'text';

    input.type = showing ? 'password' : 'text';
    toggle.querySelector('[data-icon="eye"]').classList.toggle('hidden', !showing);
    toggle.querySelector('[data-icon="eye-off"]').classList.toggle('hidden', showing);
    toggle.setAttribute('aria-label', showing ? 'Show password' : 'Hide password');
});

function activateTab(container, target) {
    container.querySelectorAll('[data-tab-target]').forEach((btn) => {
        btn.classList.toggle('active', btn.dataset.tabTarget === target);
    });

    container.querySelectorAll('[data-tab-panel]').forEach((panel) => {
        panel.classList.toggle('hidden', panel.dataset.tabPanel !== target);
    });
}

document.addEventListener('click', (event) => {
    const tabButton = event.target.closest('[data-tab-target]');
    if (!tabButton) return;

    activateTab(tabButton.closest('[data-tabs]'), tabButton.dataset.tabTarget);
});

document.querySelectorAll('[data-tabs]').forEach((container) => {
    // If validation failed on a field inside a non-default tab, land the
    // user on that tab instead of the first one — otherwise the error is
    // invisible until they happen to click through to it.
    const errorMessage = container.querySelector('.text-red-600');
    const panelWithError = errorMessage?.closest('[data-tab-panel]');

    if (panelWithError) {
        activateTab(container, panelWithError.dataset.tabPanel);
    }
});
