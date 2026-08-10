import Shepherd from 'shepherd.js';
import 'shepherd.js/dist/css/shepherd.css';

const tourDefinitions = {
    default: [
        {
            id: 'welcome',
            title: 'Selamat Datang!',
            text: 'Ini adalah SPMS Peternakan — sistem manajemen kandang, pakan, dan telur Anda. Mari kita lihat fitur-fitur utamanya.',
            buttons: [
                { text: 'Lewati', action: 'cancel', secondary: true },
                { text: 'Mulai →', action: 'next' },
            ],
        },
        {
            id: 'sidebar',
            attachTo: { element: '.main-sidebar', on: 'right' },
            title: 'Menu Navigasi',
            text: 'Gunakan menu di samping kiri untuk berpindah antar modul: Kandang, Gudang Pakan, dan Gudang Telur.',
            buttons: [
                { text: '← Kembali', action: 'back' },
                { text: 'Lanjut →', action: 'next' },
            ],
        },
        {
            id: 'content',
            attachTo: { element: '.content-wrapper', on: 'left' },
            title: 'Area Konten',
            text: 'Data dan form akan ditampilkan di area ini. Gunakan tombol di setiap halaman untuk menambah, edit, atau hapus data.',
            buttons: [
                { text: '← Kembali', action: 'back' },
                { text: 'Lanjut →', action: 'next' },
            ],
        },
        {
            id: 'navbar',
            attachTo: { element: '.navbar', on: 'bottom' },
            title: 'Bar Atas',
            text: 'Di sini Anda bisa melihat notifikasi, profil, dan logout. Pada layar kecil, ketuk ☰ untuk membuka menu.',
            buttons: [
                { text: '← Kembali', action: 'back' },
                { text: 'Selesai ✓', action: 'complete' },
            ],
        },
    ],
};

function createTour(tourId) {
    const steps = tourDefinitions[tourId];
    if (!steps) return null;

    const tour = new Shepherd.Tour({
        useModalOverlay: true,
        defaultStepOptions: {
            classes: 'spms-tour-step',
            scrollTo: { behavior: 'smooth', block: 'center' },
            cancelIcon: { enabled: true },
            modalOverlayOpeningPadding: 8,
            modalOverlayOpeningRadius: 8,
        },
    });

    steps.forEach((step) => {
        const buttons = step.buttons.map((btn) => ({
            text: btn.text,
            classes: btn.secondary ? 'btn btn-sm btn-outline-secondary' : 'btn btn-sm btn-primary',
            action: () => {
                if (btn.action === 'next') tour.next();
                else if (btn.action === 'back') tour.back();
                else if (btn.action === 'cancel') tour.cancel();
                else if (btn.action === 'complete') tour.complete();
            },
        }));

        tour.addStep({
            id: step.id,
            title: step.title,
            text: step.text,
            attachTo: step.attachTo,
            buttons,
        });
    });

    tour.on('complete', () => markTourSeen());
    tour.on('cancel', () => markTourSeen());

    return tour;
}

function markTourSeen() {
    const token = document.querySelector('meta[name="csrf-token"]')?.content;
    if (!token) return;

    fetch('/api/tour/seen', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': token,
            Accept: 'application/json',
        },
        credentials: 'same-origin',
    }).catch(() => {});
}

window.startTour = function (tourId = 'default') {
    const tour = createTour(tourId);
    if (tour) tour.start();
};

const style = document.createElement('style');
style.textContent = `
.shepherd-element {
    z-index: 10000 !important;
}
.spms-tour-step .shepherd-content {
    border-radius: 12px;
    box-shadow: 0 12px 40px rgba(0,0,0,0.15);
    border: none;
}
.spms-tour-step .shepherd-header {
    background: #FFF7ED;
    border-radius: 12px 12px 0 0;
    padding: 12px 16px;
}
.spms-tour-step .shepherd-title {
    font-weight: 600;
    font-size: 0.95rem;
    color: #2D3436;
}
.spms-tour-step .shepherd-text {
    padding: 12px 16px;
    font-size: 0.85rem;
    line-height: 1.5;
    color: #4A4A4A;
}
.spms-tour-step .shepherd-footer {
    padding: 8px 16px 12px;
    border-top: 1px solid #E8E4DF;
}
.spms-tour-step .shepherd-cancel-icon {
    color: #9E9E9E;
}
.shepherd-modal-overlay-container {
    z-index: 9999 !important;
}
`;
document.head.appendChild(style);
