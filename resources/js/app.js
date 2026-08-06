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
    const steps = Array.from(container.querySelectorAll('[data-tab-target]'));
    const index = steps.findIndex((btn) => btn.dataset.tabTarget === target);

    // "done" reflects actual profile-field completeness (rendered server-side
    // per section) — navigation only ever toggles which step is "active".
    steps.forEach((btn, i) => {
        btn.classList.toggle('active', i === index);
    });

    container.querySelectorAll('[data-tab-panel]').forEach((panel) => {
        panel.classList.toggle('hidden', panel.dataset.tabPanel !== target);
    });

    container.dataset.activeStep = target;

    if (index < 0) return;

    const stepHeading = container.querySelector('[data-step-heading]');
    const backButton = container.querySelector('[data-step-nav="back"]');
    const nextButton = container.querySelector('[data-step-nav="next"]');

    if (stepHeading) {
        stepHeading.textContent = `Step ${index + 1} of ${steps.length} — ${steps[index].dataset.stepLabel}`;
    }
    if (backButton) {
        backButton.classList.toggle('invisible', index === 0);
    }
    if (nextButton) {
        nextButton.classList.toggle('invisible', index === steps.length - 1);
    }
}

document.addEventListener('click', (event) => {
    const tabButton = event.target.closest('[data-tab-target]');
    if (tabButton) {
        activateTab(tabButton.closest('[data-tabs]'), tabButton.dataset.tabTarget);
        return;
    }

    const stepNav = event.target.closest('[data-step-nav]');
    if (stepNav) {
        const container = stepNav.closest('[data-tabs]');
        const steps = Array.from(container.querySelectorAll('[data-tab-target]'));
        const currentIndex = steps.findIndex((btn) => btn.dataset.tabTarget === container.dataset.activeStep);
        const nextIndex = currentIndex + (stepNav.dataset.stepNav === 'next' ? 1 : -1);

        if (steps[nextIndex]) {
            activateTab(container, steps[nextIndex].dataset.tabTarget);
            container.scrollIntoView({ behavior: 'smooth', block: 'start' });
        }
    }
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
