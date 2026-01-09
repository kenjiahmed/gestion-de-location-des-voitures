// Chat bubble script — adapted to new #aiChatBubble UI
console.log('[chatbot] script loaded (bubble mode)');

document.addEventListener('DOMContentLoaded', function() {
    console.log('[chatbot] DOMContentLoaded');
    const floatBtn = document.getElementById('ai-chat-btn');
    const bubble = document.getElementById('aiChatBubble');

    if (!bubble) { console.warn('[chatbot] aiChatBubble not found'); return; }

    const messagesEl = bubble.querySelector('.chat-messages');
    const form = bubble.querySelector('.chat-form');
    const input = form ? form.querySelector('input[type="text"]') : null;
    const closeBtn = bubble.querySelector('.chat-close');

    let ignoreClicksUntil = 0;
    let built = false;
    let isLoading = false;

    function escapeHtml(unsafe) {
        return String(unsafe)
            .replace(/&/g, "&amp;")
            .replace(/</g, "&lt;")
            .replace(/>/g, "&gt;")
            .replace(/\"/g, "&quot;")
            .replace(/'/g, "&#039;");
    }

    function appendMessage(text, from = 'bot'){
        if (!messagesEl) return;
        // ignore empty
        if (text === null || typeof text === 'undefined') return;
        text = String(text);

        const wrapper = document.createElement('div');
        wrapper.className = 'mb-2 d-flex';
        if (from === 'user') {
            wrapper.style.justifyContent = 'flex-end';
            const inner = document.createElement('div'); inner.className = 'message-user'; inner.innerHTML = escapeHtml(text);
            wrapper.appendChild(inner);
        } else {
            wrapper.style.justifyContent = 'flex-start';
            const inner = document.createElement('div'); inner.className = 'message-bot'; inner.innerHTML = escapeHtml(text);
            wrapper.appendChild(inner);
        }
        messagesEl.appendChild(wrapper);
        // scroll to bottom
        messagesEl.scrollTop = messagesEl.scrollHeight;
        return wrapper;
    }

    function buildOnce(){
        if (built) return;
        built = true;
        // initial greeting
        setTimeout(() => appendMessage("Salut ! Je suis l'assistant. Tape ta question.", 'bot'), 250);

        // attach form handler only once (guard with data attribute)
        try {
            if (form && input && !form.dataset.chatInitialized) {
                form.addEventListener('submit', function(e){
                    e.preventDefault();
                    if (isLoading) return; // prevent double send

                    const text = input.value.trim();
                    if (!text) return;
                    appendMessage(text, 'user');
                    input.value = '';

                    // show typing indicator
                    isLoading = true;
                    form.querySelector('button[type="submit"]').disabled = true;
                    input.disabled = true;
                    const typingEl = appendMessage('...', 'bot');
                    typingEl.classList.add('chat-typing');

                    fetch('/chat/message', {
                        method: 'POST',
                        headers: { 'Content-Type': 'application/json' },
                        body: JSON.stringify({ message: text })
                    }).then(res => {
                        if (!res.ok) throw new Error('HTTP ' + res.status);
                        return res.json();
                    }).then(data => {
                        // remove typing indicator
                        if (typingEl && typingEl.parentNode) typingEl.parentNode.removeChild(typingEl);
                        if (data && data.reply) appendMessage(data.reply, 'bot');
                        else if (data && data.error) appendMessage(data.error || 'Erreur', 'bot');
                    }).catch(err => {
                        console.error('[chatbot] fetch error', err);
                        if (typingEl && typingEl.parentNode) typingEl.parentNode.removeChild(typingEl);
                        appendMessage('Erreur serveur — réessaye plus tard.', 'bot');
                    }).finally(() => {
                        isLoading = false;
                        if (form) form.querySelector('button[type="submit"]').disabled = false;
                        if (input) input.disabled = false;
                        if (input) input.focus();
                    });
                });
                form.dataset.chatInitialized = '1';
            }
        } catch (err) {
            console.warn('[chatbot] form init failed', err);
        }

        // attach close button
        if (closeBtn && !closeBtn.dataset.closeInit) {
            closeBtn.addEventListener('click', function(e){ e.preventDefault(); e.stopPropagation(); hideBubble(); });
            closeBtn.dataset.closeInit = '1';
        }
    }

    function showBubble(){
        buildOnce();
        ignoreClicksUntil = Date.now() + 300; // ignore outside clicks shortly after open
        bubble.classList.add('chat-visible');
        bubble.setAttribute('aria-hidden', 'false');
        // focus input if available
        setTimeout(() => { if (input) input.focus(); }, 220);
    }

    function hideBubble(){
        bubble.classList.remove('chat-visible');
        bubble.setAttribute('aria-hidden', 'true');
    }

    function toggleBubble(){
        if (bubble.classList.contains('chat-visible')) hideBubble();
        else showBubble();
    }

    // float button toggles the bubble
    if (floatBtn) {
        floatBtn.addEventListener('click', function(e){
            e.preventDefault();
            e.stopPropagation();
            console.log('[chatbot] floatBtn clicked — toggle');
            toggleBubble();
        });
    }

    // click outside closes the bubble (after ignore period)
    document.addEventListener('click', function(e){
        try {
            if (Date.now() < ignoreClicksUntil) return;
            const target = e.target;
            if (!target) return;
            if (bubble.classList.contains('chat-visible')){
                if (target.closest && (target.closest('#aiChatBubble') || target.closest('#ai-chat-btn'))) return;
                hideBubble();
            }
        } catch (err) { /* ignore errors from weird targets */ }
    });

    // ESC closes
    document.addEventListener('keydown', function(e){
        if (e.key === 'Escape' && bubble.classList.contains('chat-visible')) hideBubble();
    });

    // initialize but keep hidden
    buildOnce();

    console.log('[chatbot] bubble script initialized');
});
