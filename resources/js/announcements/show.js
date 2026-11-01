function initializeAboutDisclosure() {
    document.querySelectorAll('[data-about-section]').forEach((section) => {
        const copy = section.querySelector('[data-about-copy]');
        const toggle = section.querySelector('[data-about-toggle]');

        if (!copy || !toggle) {
            return;
        }

        copy.classList.add('is-clamped');

        if (copy.scrollHeight <= copy.clientHeight + 1) {
            copy.classList.remove('is-clamped');
            return;
        }

        toggle.hidden = false;
        toggle.addEventListener('click', () => {
            const expanded = toggle.getAttribute('aria-expanded') === 'true';

            copy.classList.toggle('is-clamped', expanded);
            toggle.setAttribute('aria-expanded', String(!expanded));
            toggle.textContent = expanded
                ? toggle.dataset.readMore
                : toggle.dataset.readLess;
        });
    });
}

function initializeSharing() {
    document.querySelectorAll('[data-share]').forEach((button) => {
        const status = document.querySelector('[data-share-status]');
        const canShare = typeof navigator.share === 'function';
        const canCopy = typeof navigator.clipboard?.writeText === 'function';

        if (!canShare && !canCopy) {
            return;
        }

        button.hidden = false;
        button.addEventListener('click', async () => {
            try {
                if (canShare) {
                    await navigator.share({
                        title: button.dataset.shareTitle,
                        url: window.location.href,
                    });
                } else {
                    await navigator.clipboard.writeText(window.location.href);
                }

                status.textContent = button.dataset.shareSuccess;
            } catch (error) {
                if (error instanceof DOMException && error.name === 'AbortError') {
                    return;
                }

                status.textContent = button.dataset.shareError;
            }
        });
    });
}

initializeAboutDisclosure();
initializeSharing();
