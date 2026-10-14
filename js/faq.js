document.addEventListener('DOMContentLoaded', function () {
    const faqList = document.querySelector('.dh-faq-list');

    if (!faqList) {
        return;
    }

    const items = Array.from(faqList.querySelectorAll('.dh-faq-item'));

    function setExpanded(item, expanded) {
        const trigger = item.querySelector('.dh-faq-trigger');
        const answer = item.querySelector('.dh-faq-answer');
        const icon = item.querySelector('.dh-faq-toggle');

        item.classList.toggle('is-open', expanded);
        trigger.setAttribute('aria-expanded', String(expanded));
        answer.setAttribute('aria-hidden', String(!expanded));
        answer.style.maxHeight = expanded ? answer.scrollHeight + 'px' : '0px';
        icon.textContent = expanded ? '−' : '+';
    }

    items.forEach(function (item) {
        const trigger = item.querySelector('.dh-faq-trigger');
        const initiallyExpanded = trigger.getAttribute('aria-expanded') === 'true';
        setExpanded(item, initiallyExpanded);

        trigger.addEventListener('click', function () {
            const shouldExpand = trigger.getAttribute('aria-expanded') !== 'true';

            items.forEach(function (otherItem) {
                if (otherItem !== item) {
                    setExpanded(otherItem, false);
                }
            });

            setExpanded(item, shouldExpand);
        });
    });

    window.addEventListener('resize', function () {
        const openItem = faqList.querySelector('.dh-faq-item.is-open');
        if (openItem) {
            const answer = openItem.querySelector('.dh-faq-answer');
            answer.style.maxHeight = answer.scrollHeight + 'px';
        }
    });
});
