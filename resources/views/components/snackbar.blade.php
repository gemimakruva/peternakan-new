@if(session('error'))
<div id="snackbar" class="snackbar {{ session('success') ? 'snackbar-success' : 'snackbar-error' }}">
    <span class="snackbar-icon">
            ⚠️
    </span>
    <span class="snackbar-message">
        {{ session('success') ?? session('error') }}
    </span>
</div>
@endif

<style>
    #snackbar {
        display: flex;
        align-items: center;
        gap: 10px;
        visibility: visible;
        min-width: 280px;
        max-width: 400px;
        background-color: #333;
        color: #fff;
        border-radius: 8px;
        padding: 14px 20px;
        position: fixed;
        right: 20px;       /* pojok kanan */
        bottom: 30px; 
        z-index: 999999;
        opacity: 0;
        transform: translateY(20px);
        transition: opacity 0.4s ease, transform 0.4s ease;
        font-weight: 600;
        font-size: 14px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.2);
    }

    .snackbar-success {
        background-color: #28a745 !important;
    }

    .snackbar-error {
        background-color: #dc3545 !important;
    }

    #snackbar.show {
        opacity: 1;
        transform: translateY(0);
        visibility: visible;
    }

    .snackbar-icon {
        font-size: 18px;
    }

    .snackbar-message {
        flex: 1;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const snackbar = document.getElementById("snackbar");
        if (snackbar) {
            snackbar.classList.add("show");
            setTimeout(() => {
                snackbar.classList.remove("show");
            }, 4000); // hide after 4s
        }
    });
</script>
