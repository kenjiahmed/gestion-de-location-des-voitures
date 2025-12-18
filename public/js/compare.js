document.addEventListener('click', function (e) {
    // Chatbot floating button (open an offcanvas or simple prompt)
    if (e.target && (e.target.id === 'ai-chat-btn' || e.target.closest && e.target.closest('#ai-chat-btn'))) {
        // Try to toggle offcanvas if exists
        const off = document.getElementById('aiChatOffcanvas');
        if (off) {
            const bsOff = bootstrap.Offcanvas.getOrCreateInstance(off);
            bsOff.toggle();
        } else {
            // fallback: simple prompt
            alert('Assistant conversation (prototype) — fonctionnalité à implémenter');
        }
        return;
    }

    // Toggle compare button
    const btn = e.target.closest('.btn-compare');
    if (btn) {
        const id = btn.dataset.id;
        fetch('/compare/add', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'id=' + encodeURIComponent(id)
        }).then(r => r.json()).then(json => {
            if (!json.success) {
                alert(json.message || 'Erreur');
                return;
            }
            const countEl = document.getElementById('compare-count');
            if (countEl) countEl.textContent = json.count;

            // toggle label
            const label = btn.querySelector('.compare-label');
            const wrap = btn.closest('.compare-button-wrap');
            if (json.action === 'added') {
                if (label) label.textContent = 'Retirer';
                if (wrap && !wrap.querySelector('.compare-badge')) {
                    const badge = document.createElement('span');
                    badge.className = 'compare-badge';
                    badge.textContent = 'Comparé';
                    wrap.insertBefore(badge, wrap.firstChild);
                }
            }
            if (json.action === 'removed') {
                if (label) label.textContent = 'Comparer';
                if (wrap && wrap.querySelector('.compare-badge')) {
                    wrap.querySelector('.compare-badge').remove();
                }
            }
        }).catch(() => alert('Erreur réseau'));
    }

    // Clear compare (bottom bar)
    if (e.target && (e.target.id === 'compare-clear' || e.target.id === 'compare-clear-top')) {
        fetch('/compare/clear', {method: 'POST'}).then(r => r.json()).then(() => {
            const countEl = document.getElementById('compare-count');
            if (countEl) countEl.textContent = '0';
            document.querySelectorAll('.btn-compare .compare-label').forEach(l => l.textContent = 'Comparer');
            document.querySelectorAll('.compare-badge').forEach(b => b.remove());
        });
    }
});
