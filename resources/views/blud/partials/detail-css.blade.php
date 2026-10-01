<style>
    body {
        font-family: 'Plus Jakarta Sans', sans-serif;
    }

    .nav-hover-link {
        position: relative;
    }

    .nav-hover-link::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 100%;
        height: 4px;
        background-color: #fbbf24;
        border-radius: 9999px;
        transform: scaleX(0);
        transform-origin: left;
        transition: transform 0.3s ease;
    }

    .nav-hover-link:hover::after {
        transform: scaleX(1);
    }

    .detail-card {
        background: #fff;
        border: 1px solid #e2e8f0;
        border-radius: 0.85rem;
        overflow: hidden;
    }

    .detail-main-img {
        width: 100%;
        aspect-ratio: 4 / 3;
        object-fit: cover;
        background: #e2e8f0;
        border-radius: 0.65rem;
        border: 1px solid #e2e8f0;
    }

    .detail-thumb {
        width: 4.25rem;
        height: 4.25rem;
        object-fit: cover;
        border-radius: 0.45rem;
        border: 2px solid #e2e8f0;
        cursor: pointer;
        transition: border-color 0.15s ease;
        background: #e2e8f0;
    }

    .detail-thumb:hover,
    .detail-thumb.is-active {
        border-color: #023775;
    }

    .detail-laporkan {
        display: inline-flex;
        align-items: center;
        gap: 0.35rem;
        color: #64748b;
        font-size: 0.82rem;
        font-weight: 600;
        transition: color 0.15s ease;
    }

    .detail-laporkan:hover {
        color: #334155;
    }

    .detail-stars {
        display: inline-flex;
        gap: 0.15rem;
    }

    .detail-price {
        color: #1d4ed8;
        font-weight: 800;
        font-size: clamp(1.25rem, 2.5vw, 1.75rem);
        letter-spacing: -0.02em;
    }

    .detail-jurusan-avatar {
        width: 3.5rem;
        height: 3.5rem;
        border-radius: 9999px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: #fff;
        font-weight: 800;
        font-size: 1.15rem;
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(2, 55, 117, 0.2);
    }

    .detail-stats-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 0.75rem 1.25rem;
    }

    .detail-stats-label {
        font-size: 0.72rem;
        color: #64748b;
        font-weight: 600;
        line-height: 1.35;
    }

    .detail-stats-value {
        font-size: 1rem;
        font-weight: 800;
        color: #0f172a;
        margin-top: 0.15rem;
    }

    .detail-section-header {
        background: #1e3a8a;
        color: #fff;
        padding: 0.65rem 1rem;
        border-radius: 0.5rem;
        font-weight: 700;
        font-size: 0.95rem;
    }

    .detail-spec-row {
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: 1rem;
        padding: 0.75rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .detail-spec-row:last-child {
        border-bottom: 0;
    }

    .detail-spec-label {
        font-weight: 700;
        color: #0f172a;
        font-size: 0.88rem;
    }

    .detail-spec-value {
        color: #334155;
        font-size: 0.88rem;
        text-align: right;
    }

    .detail-chip {
        display: inline-flex;
        align-items: center;
        padding: 0.35rem 0.75rem;
        border-radius: 9999px;
        font-size: 0.78rem;
        font-weight: 600;
        border: 1px solid #cbd5e1;
        background: #fff;
        color: #475569;
        cursor: pointer;
        transition: background 0.15s ease, color 0.15s ease, border-color 0.15s ease;
    }

    .detail-chip:hover {
        border-color: #93c5fd;
        color: #1e3a8a;
    }

    .detail-chip.is-active {
        background: #1e40af;
        border-color: #1e40af;
        color: #fff;
    }

    .detail-comment-item {
        padding: 0.9rem 0;
        border-bottom: 1px solid #e2e8f0;
    }

    .detail-comment-item:last-child {
        border-bottom: 0;
    }

    .detail-badge-name {
        display: inline-flex;
        align-items: center;
        background: #fbbf24;
        color: #1c1917;
        font-weight: 800;
        font-size: 0.8rem;
        padding: 0.3rem 0.8rem;
        border-radius: 9999px;
    }

    .detail-btn-primary {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 0.85rem 1rem;
        border-radius: 0.5rem;
        background: #1d4ed8;
        color: #fff;
        font-weight: 700;
        font-size: 0.92rem;
        transition: background 0.15s ease, transform 0.15s ease;
    }

    .detail-btn-primary:hover {
        background: #1e40af;
    }

    .detail-btn-amber {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        padding: 0.85rem 1rem;
        border-radius: 0.5rem;
        background: #fbbf24;
        color: #1c1917;
        font-weight: 800;
        font-size: 0.92rem;
        transition: background 0.15s ease, transform 0.15s ease;
    }

    .detail-btn-amber:hover {
        background: #fcd34d;
    }

    .detail-btn-sm {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        padding: 0.45rem 0.85rem;
        border-radius: 0.4rem;
        font-size: 0.78rem;
        font-weight: 700;
        transition: background 0.15s ease;
    }

    .detail-btn-blue-sm {
        background: #1e3a8a;
        color: #fff;
    }

    .detail-btn-blue-sm:hover {
        background: #1e40af;
    }

    .detail-btn-amber-sm {
        background: #fbbf24;
        color: #1c1917;
    }

    .detail-btn-amber-sm:hover {
        background: #fcd34d;
    }

    .detail-yellow-bar {
        background: #fbbf24;
        color: #1c1917;
        font-weight: 800;
        padding: 0.65rem 0.9rem;
        border-radius: 0.5rem 0.5rem 0 0;
        font-size: 0.9rem;
    }

    .detail-related-link {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.65rem 0;
        border-bottom: 1px solid #e2e8f0;
        transition: color 0.15s ease;
    }

    .detail-related-link:hover .detail-related-title {
        color: #1e40af;
    }

    .detail-related-title {
        font-weight: 600;
        color: #1e3a8a;
        font-size: 0.88rem;
        line-height: 1.35;
    }

    .detail-related-thumb {
        width: 3.25rem;
        height: 3.25rem;
        border-radius: 0.4rem;
        object-fit: cover;
        background: #e2e8f0;
        flex-shrink: 0;
        border: 1px solid #e2e8f0;
    }

    .detail-team-box {
        border: 2px solid #1e3a8a;
        border-radius: 0.65rem;
        padding: 1rem;
        background: #f8fafc;
    }

    .detail-team-box ul {
        list-style: disc;
        padding-left: 1.25rem;
        margin-top: 0.35rem;
    }

    .detail-rating-input-stars {
        display: flex;
        gap: 0.35rem;
    }

    .detail-star-btn {
        background: transparent;
        border: 0;
        cursor: pointer;
        padding: 0;
        color: #cbd5e1;
        line-height: 1;
        transition: color 0.12s ease, transform 0.12s ease;
    }

    .detail-star-btn:hover,
    .detail-star-btn.is-active {
        color: #fbbf24;
    }

    .detail-star-btn:hover {
        transform: scale(1.1);
    }

    .detail-breadcrumb a:hover {
        color: #1e40af;
    }

    .detail-form-input,
    .detail-form-textarea {
        width: 100%;
        border: 1px solid #cbd5e1;
        border-radius: 0.5rem;
        padding: 0.65rem 0.85rem;
        font-size: 0.9rem;
        font-family: inherit;
        color: #0f172a;
        background: #fff;
        outline: none;
        transition: border-color 0.15s ease, box-shadow 0.15s ease;
    }

    .detail-form-input:focus,
    .detail-form-textarea:focus {
        border-color: #93c5fd;
        box-shadow: 0 0 0 4px rgba(59, 130, 246, 0.12);
    }

    .detail-galeri-grid img {
        width: 100%;
        aspect-ratio: 4 / 3;
        object-fit: cover;
        border-radius: 0.65rem;
        border: 1px solid #e2e8f0;
        background: #e2e8f0;
    }

    .detail-success-banner {
        background: #dcfce7;
        border: 1px solid #86efac;
        color: #166534;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        font-weight: 600;
        font-size: 0.9rem;
    }
</style>
