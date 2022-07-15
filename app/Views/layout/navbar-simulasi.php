<header>
    <nav class="navbar  mb-3 navbar-expand-lg navbar-light fixed-top">
        <a unlink id="navbar-brand" class="navbar-brand">
            <img id="navbar-brand-img" src="<?= base_url('assets/img/schuler-logo.png'); ?>" alt="SCHULER.ID" width="135">
        </a>
        <div class="navbar-title-container">
            <div class="navbar-title">
                <div id="simulation__title" class="navbar__title"></div>
                <div id="simulation__subtitle" class="title_simulation_test">Test Kemampuan Akademik</div>
            </div>
            <div class="navbar-subtitle alert__box"><i class="fa-solid fa-circle-info"></i><span> Panduan</span></div>
        </div>
        <div class="ms-auto simulasi-header-container">
            <div class="timer__countdown"></div>
        </div>
    </nav>
</header>

<aside class="right-sidebar">
    <?= $this->include('layout/sidebar-simulasi'); ?>
</aside>

<script>
    class Timer {
        constructor(root) {
            root.innerHTML = Timer.getHTML();

            this.el = {
                minutes: root.querySelector(".timer__countdown__minute"),
                seconds: root.querySelector(".timer__countdown__second"),
            };

            let getCurrentTime = localStorage.getItem('timerValue');

            if (getCurrentTime == null) {
                this.setTimer = 190;
            } else {
                this.setTimer = getCurrentTime
            }

            // console.log(this.setTimer);
            this.interval = null;
            this.remainingSeconds = this.setTimer;
            this.updateInterfaceTime();

            if (this.interval === null) {
                this.start();
            } else {
                this.stop();
            }
        }

        updateInterfaceTime() {
            const minutes = Math.floor(this.remainingSeconds / 60);
            const seconds = this.remainingSeconds % 60;

            this.el.minutes.textContent = minutes.toString().padStart(2, "0");
            this.el.seconds.textContent = seconds.toString().padStart(2, "0");
        }

        start() {
            if (this.remainingSeconds === 0) return;

            this.interval = setInterval(() => {
                this.remainingSeconds--;
                this.updateInterfaceTime();

                let setCurrentTime = localStorage.setItem('timerValue', this.remainingSeconds);

                if (this.remainingSeconds === 0) {
                    this.stop();
                    localStorage.removeItem('timerValue');
                }
            }, 1000);

        }

        stop() {
            clearInterval(this.interval);

            this.interval = null;

            // console.log("selesai")
        }

        static getHTML() {
            return `
        	<i class="fa-solid fa-clock"></i>
            <span class="timer__countdown__minute">22</span>
            <span>:</span>
            <span class="timer__countdown__second">30</span>
        `;
        }
    }

    new Timer(
        document.querySelector(".timer__countdown")
    );
</script>