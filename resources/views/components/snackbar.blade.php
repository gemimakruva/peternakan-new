@if(session('success') || session('error'))
    <div id="snackbar"
        class="snackbar {{ session('success') ? 'snackbar-success' : 'snackbar-error' }}">
        {{ session('success') ?? session('error') }}
    </div>
@endif

<style>
    #snackbar {
        visibility: visible;
        min-width: 280px;
        max-width: 400px;
        background-color: #333;
        color: #fff;
        text-align: center;
        border-radius: 8px;
        padding: 14px 20px;
        position: fixed;
        left: 50%;
        bottom: 30px;
        transform: translateX(-50%);
        z-index: 999999;
        opacity: 0;
        transition: opacity 0.4s, bottom 0.4s;
        font-weight: 600;
        font-size: 14px;
    }

    .snackbar-success {
        background-color: #28a745 !important;
    }

    .snackbar-error {
        background-color: #dc3545 !important;
    }

    #snackbar.show {
        opacity: 1;
        bottom: 50px;
        visibility: visible;
    }
</style>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const snackbar = document.getElementById("snackbar");
        if (snackbar) {
            snackbar.classList.add("show");
            setTimeout(() => {
                snackbar.classList.remove("show");
            }, 4000); // Hide after 4s
        }
    });
</script>
