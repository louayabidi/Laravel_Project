<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<audio id="victory-sound" src="{{ asset('sounds/victory.mp3') }}"></audio>

<script>
    import Echo from "laravel-echo";

    window.Echo.channel("user-badges.{{ auth()->id() }}")
        .listen(".badge.unlocked", (e) => {
            const sound = document.getElementById('victory-sound');
            sound.play();

            Swal.fire({
                title: '🎉 New Badge Unlocked!',
                text: `${e.badge.name} 🏅`,
                icon: 'success',
                confirmButtonText: 'Nice!',
                timer: 4000,
                showClass: {
                    popup: 'animate__animated animate__bounceIn'
                },
                hideClass: {
                    popup: 'animate__animated animate__fadeOut'
                }
            });
        });
</script>
