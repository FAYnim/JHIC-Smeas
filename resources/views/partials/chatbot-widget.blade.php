<style>
    #smeas-ai-root {
        position: fixed !important;
        bottom: 24px !important;
        right: 24px !important;
        z-index: 99999 !important;
        display: flex !important;
        flex-direction: column !important;
        align-items: flex-end !important;
        gap: 12px !important;
        pointer-events: none !important;
        font-family: 'Plus Jakarta Sans', system-ui, -apple-system, sans-serif;
    }

    #smeas-ai-root * {
        box-sizing: border-box;
    }

    #smeas-ai-launcher,
    #smeas-ai-window {
        pointer-events: auto !important;
    }

    #smeas-ai-window {
        width: 380px;
        max-width: calc(100vw - 32px);
        height: 540px;
        max-height: calc(100vh - 110px);
        box-shadow: 0 20px 40px -10px rgba(2, 64, 137, 0.35), 0 0 0 1px rgba(2, 64, 137, 0.1);
        border-radius: 1.25rem;
        background: #ffffff;
        overflow: hidden;
        flex-direction: column;
        transition: transform 0.25s ease, opacity 0.25s ease;
    }

    #smeas-ai-window.hidden {
        display: none !important;
    }

    #smeas-ai-window:not(.hidden) {
        display: flex !important;
    }

    .smeas-typing-dot {
        width: 6px;
        height: 6px;
        border-radius: 9999px;
        background-color: #ffffff;
        display: inline-block;
        animation: smeasBounce 1.2s infinite ease-in-out both;
    }

    .smeas-typing-dot:nth-child(1) { animation-delay: -0.32s; }
    .smeas-typing-dot:nth-child(2) { animation-delay: -0.16s; }

    @keyframes smeasBounce {
        0%, 80%, 100% { transform: scale(0); }
        40% { transform: scale(1); }
    }
</style>

<div id="smeas-ai-root" data-message-url="{{ route('chatbot.message') }}" data-reset-url="{{ route('chatbot.reset') }}" data-csrf="{{ csrf_token() }}">
    <!-- Chat Window Popup -->
    <section id="smeas-ai-window" class="hidden" role="dialog" aria-label="Smeas.Ai Chatbot">
        <!-- Header -->
        <header class="flex items-center gap-3 bg-gradient-to-r from-[#013572] to-[#024089] px-4 py-3.5 text-white shrink-0">
            <div class="relative w-10 h-10 rounded-full overflow-hidden ring-2 ring-white/30 shrink-0">
                <img src="{{ asset('images/smeas-ai-bot.svg') }}" alt="" class="w-full h-full object-cover">
                <span class="absolute bottom-0 right-0 w-3 h-3 rounded-full bg-emerald-400 ring-2 ring-[#013572]"></span>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-1.5">
                    <p class="text-sm font-bold leading-tight tracking-wide">Smeas.Ai</p>
                    <span class="bg-blue-400/30 text-[10px] font-semibold text-blue-100 px-1.5 py-0.5 rounded">Asisten</span>
                </div>
                <p class="flex items-center gap-1.5 text-xs text-emerald-300 mt-0.5">
                    <span class="h-2 w-2 rounded-full bg-emerald-400 animate-pulse"></span>
                    Online • Siap Membantu
                </p>
            </div>
            <div class="flex items-center gap-1">
                <button type="button" id="smeas-ai-reset" class="rounded-lg p-2 text-blue-100/80 hover:bg-white/10 hover:text-white transition-colors cursor-pointer" aria-label="Reset percakapan" title="Reset percakapan">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 12a9 9 0 1 0 3-6.7L3 8"/><path d="M3 3v5h5"/></svg>
                </button>
                <button type="button" id="smeas-ai-close" class="rounded-lg p-2 text-blue-100/80 hover:bg-white/10 hover:text-white transition-colors cursor-pointer" aria-label="Tutup chat" title="Tutup chat">
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"><path d="M18 6 6 18M6 6l12 12"/></svg>
                </button>
            </div>
        </header>

        <!-- Messages Area -->
        <div id="smeas-ai-messages" class="flex-1 space-y-3.5 overflow-y-auto bg-slate-50/90 p-4" aria-live="polite">
            <div class="flex items-start gap-2.5">
                <img src="{{ asset('images/smeas-ai-bot.svg') }}" alt="" class="h-7 w-7 rounded-full shrink-0 mt-0.5 shadow-sm">
                <div class="max-w-[85%] rounded-2xl rounded-tl-sm bg-[#024089] px-4 py-2.5 text-sm text-white shadow-sm leading-relaxed">
                    Halo! Saya <strong>Smeas.Ai</strong>, asisten virtual SMKN 1 Surabaya. Ada yang bisa saya bantu seputar jurusan, SPMB, magang, atau informasi sekolah?
                </div>
            </div>
        </div>

        <!-- Error Notification Banner -->
        <div id="smeas-ai-error" class="hidden bg-red-50 border-t border-red-100 px-4 py-2 text-xs font-medium text-red-700"></div>

        <!-- Quick Prompt Suggestion Chips -->
        <div class="flex flex-wrap gap-1.5 border-t border-slate-100 bg-white px-3.5 pt-2.5 pb-1 shrink-0">
            @foreach (['Tanya Jurusan', 'Tempat Magang', 'Info SPMB', 'Kontak Sekolah'] as $chip)
                <button type="button" data-smeas-chip="{{ $chip }}" class="rounded-full border border-blue-200 bg-blue-50/80 px-3 py-1 text-xs font-semibold text-blue-700 hover:bg-blue-100 hover:border-blue-300 transition-colors cursor-pointer">{{ $chip }}</button>
            @endforeach
        </div>

        <!-- Input Bar -->
        <form id="smeas-ai-form" class="flex items-center gap-2 bg-white p-3 border-t border-slate-100 shrink-0">
            <input id="smeas-ai-input" type="text" maxlength="500" autocomplete="off" placeholder="Tanya Smeas.Ai..." class="flex-1 rounded-full border border-slate-200 bg-slate-50 px-4 py-2 text-sm outline-none focus:border-blue-500 focus:bg-white focus:ring-2 focus:ring-blue-100 transition-all text-slate-800 placeholder:text-slate-400">
            <button type="submit" id="smeas-ai-send" class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-[#024089] text-white hover:bg-blue-700 shadow-md hover:shadow-blue-500/25 transition-all cursor-pointer disabled:opacity-50 disabled:cursor-not-allowed" aria-label="Kirim">
                <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor"><path d="M2 21 23 12 2 3v7l15 2-15 2z"/></svg>
            </button>
        </form>
    </section>

    <!-- Floating Trigger Launcher Button -->
    <button type="button" id="smeas-ai-launcher" 
        class="group flex items-center gap-3 bg-white text-slate-800 rounded-full pl-2 pr-5 py-2 shadow-2xl border border-blue-100 hover:shadow-blue-500/30 hover:border-blue-300 transition-all duration-300 transform hover:-translate-y-1 active:translate-y-0 cursor-pointer"
        aria-label="Buka Chat Smeas.Ai" aria-expanded="false" title="Tanya Smeas.Ai">
        <div class="relative w-12 h-12 rounded-full overflow-hidden ring-2 ring-blue-500/30 shadow-inner shrink-0">
            <img src="{{ asset('images/smeas-ai-bot.svg') }}" alt="Smeas.Ai" class="w-full h-full object-cover">
            <!-- Pulsing Online Badge -->
            <span class="absolute bottom-0 right-0 w-3.5 h-3.5 rounded-full bg-emerald-500 ring-2 ring-white"></span>
            <span class="absolute bottom-0 right-0 w-3.5 h-3.5 rounded-full bg-emerald-400 animate-ping opacity-75"></span>
        </div>
        <div class="text-left hidden sm:block select-none">
            <div class="text-xs font-bold text-slate-800 flex items-center gap-1.5">
                <span>Tanya Smeas.Ai</span>
                <span class="inline-block w-1.5 h-1.5 rounded-full bg-blue-600"></span>
            </div>
            <div class="text-[11px] text-slate-500 font-medium">Asisten Virtual SMKN 1</div>
        </div>
    </button>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        const root = document.getElementById('smeas-ai-root');
        if (!root) return;
        const win = document.getElementById('smeas-ai-window');
        const launcher = document.getElementById('smeas-ai-launcher');
        const list = document.getElementById('smeas-ai-messages');
        const form = document.getElementById('smeas-ai-form');
        const input = document.getElementById('smeas-ai-input');
        const send = document.getElementById('smeas-ai-send');
        const errBox = document.getElementById('smeas-ai-error');
        const avatar = @json(asset('images/smeas-ai-bot.svg'));
        const greeting = list.innerHTML;
        let busy = false;

        const toggle = (open) => {
            win.classList.toggle('hidden', !open);
            launcher.setAttribute('aria-expanded', String(open));
            if (open) {
                setTimeout(() => input.focus(), 100);
                scroll();
            }
        };
        launcher.addEventListener('click', () => toggle(win.classList.contains('hidden')));
        document.getElementById('smeas-ai-close').addEventListener('click', () => toggle(false));

        const escapeHtml = (s) => s.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
        const format = (text) => escapeHtml(text)
            .replace(/\[([^\]]+)\]\((\/[^)\s]*|https?:\/\/[^)\s]+)\)/g, '<a href="$2" class="underline font-semibold hover:text-blue-100">$1</a>')
            .replace(/\*\*([^*]+)\*\*/g, '<strong>$1</strong>')
            .replace(/\n/g, '<br>');

        const scroll = () => { list.scrollTop = list.scrollHeight; };
        const addUser = (text) => {
            const el = document.createElement('div');
            el.className = 'flex justify-end';
            el.innerHTML = '<div class="max-w-[85%] rounded-2xl rounded-tr-sm bg-blue-100 text-slate-800 px-4 py-2.5 text-sm shadow-sm leading-relaxed"></div>';
            el.firstChild.textContent = text;
            list.appendChild(el);
            scroll();
        };
        const addBot = (html, id) => {
            const el = document.createElement('div');
            el.className = 'flex items-start gap-2.5';
            if (id) el.id = id;
            el.innerHTML = '<img src="' + avatar + '" alt="" class="h-7 w-7 rounded-full shrink-0 mt-0.5 shadow-sm"><div class="max-w-[85%] rounded-2xl rounded-tl-sm bg-[#024089] px-4 py-2.5 text-sm text-white shadow-sm leading-relaxed [&_a]:text-white">' + html + '</div>';
            list.appendChild(el);
            scroll();
        };
        const showError = (msg) => {
            errBox.textContent = msg;
            errBox.classList.remove('hidden');
            setTimeout(() => errBox.classList.add('hidden'), 4000);
        };
        const post = (url, body) => fetch(url, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json', 'Accept': 'application/json', 'X-CSRF-TOKEN': root.dataset.csrf },
            body: JSON.stringify(body || {}),
        });

        const submit = async (text) => {
            text = text.trim();
            if (!text || busy) return;
            if (win.classList.contains('hidden')) toggle(true);
            busy = true;
            send.disabled = true;
            addUser(text);
            input.value = '';
            addBot('<span class="inline-flex items-center gap-1.5 py-1 px-1"><span class="smeas-typing-dot"></span><span class="smeas-typing-dot"></span><span class="smeas-typing-dot"></span></span>', 'smeas-ai-typing');
            try {
                const res = await post(root.dataset.messageUrl, { message: text });
                document.getElementById('smeas-ai-typing')?.remove();
                if (res.status === 429) { 
                    showError('Terlalu banyak pesan dikirim. Harap tunggu sebentar.'); 
                } else if (!res.ok) { 
                    showError('Pesan tidak dapat dikirim ke server.'); 
                } else { 
                    const data = await res.json();
                    addBot(format(data.reply || '')); 
                }
            } catch (e) {
                document.getElementById('smeas-ai-typing')?.remove();
                showError('Gagal terhubung ke server Smeas.Ai.');
            } finally {
                busy = false;
                send.disabled = false;
                input.focus();
            }
        };

        form.addEventListener('submit', (e) => { e.preventDefault(); submit(input.value); });
        document.querySelectorAll('[data-smeas-chip]').forEach((b) => b.addEventListener('click', () => submit(b.dataset.smeasChip)));
        document.getElementById('smeas-ai-reset').addEventListener('click', async () => {
            try { await post(root.dataset.resetUrl); } catch (e) {}
            list.innerHTML = greeting;
            showError('Percakapan telah direset.');
        });
    });
</script>
