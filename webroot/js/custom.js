(function () {
    if (window.AOS) {
        window.AOS.init({ duration: 700, once: true, offset: 80 });
    }

    const root = document.body;
    const themeKey = 'theme';
    const savedTheme = localStorage.getItem(themeKey);
    const applyTheme = function (theme) {
        const nextTheme = theme === 'light' ? 'light' : 'dark';
        root.setAttribute('data-theme', nextTheme);
        localStorage.setItem(themeKey, nextTheme);
        document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
            const icon = button.querySelector('i');
            const label = button.querySelector('span');
            if (icon) {
                icon.className = nextTheme === 'light' ? 'bi bi-sun' : 'bi bi-moon-stars';
            }
            if (label) {
                label.textContent = nextTheme === 'light' ? 'Light Mode' : 'Dark Mode';
            }
        });
    };

    applyTheme(savedTheme || root.getAttribute('data-theme') || 'dark');

    document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            applyTheme(root.getAttribute('data-theme') === 'light' ? 'dark' : 'light');
        });
    });

    const dashboardCharts = [];
    const chartThemeColors = function () {
        const light = root.getAttribute('data-theme') === 'light';
        return {
            text: light ? '#0F172A' : '#CBD5E1',
            muted: light ? '#475569' : '#94A3B8',
            grid: light ? 'rgba(148, 163, 184, 0.28)' : 'rgba(148, 163, 184, 0.12)',
            fill: light ? 'rgba(59, 130, 246, 0.16)' : 'rgba(59, 130, 246, 0.22)',
            border: light ? '#2563EB' : '#06B6D4'
        };
    };
    const refreshChartTheme = function () {
        const colors = chartThemeColors();
        dashboardCharts.forEach(function (chart) {
            chart.data.datasets.forEach(function (dataset) {
                if (!Array.isArray(dataset.backgroundColor)) {
                    dataset.backgroundColor = colors.fill;
                }
                dataset.borderColor = colors.border;
            });
            if (chart.options.plugins?.legend?.labels) {
                chart.options.plugins.legend.labels.color = colors.text;
            }
            if (chart.options.scales?.x) {
                chart.options.scales.x.ticks.color = colors.muted;
                chart.options.scales.x.grid.color = colors.grid;
            }
            if (chart.options.scales?.y) {
                chart.options.scales.y.ticks.color = colors.muted;
                chart.options.scales.y.grid.color = colors.grid;
            }
            chart.update('none');
        });
    };

    document.querySelectorAll('[data-theme-toggle]').forEach(function (button) {
        button.addEventListener('click', refreshChartTheme);
    });

    const sidebar = document.getElementById('appSidebar');
    const sidebarToggle = document.getElementById('sidebarToggle');
    let sidebarOverlay = document.querySelector('.sidebar-overlay');
    if (sidebar && !sidebarOverlay) {
        sidebarOverlay = document.createElement('div');
        sidebarOverlay.className = 'sidebar-overlay';
        sidebarOverlay.setAttribute('aria-hidden', 'true');
        document.body.appendChild(sidebarOverlay);
    }
    const isMobileSidebar = function () {
        return window.matchMedia('(max-width: 920px)').matches;
    };
    const openMobileSidebar = function () {
        sidebar?.classList.add('open');
        sidebarOverlay?.classList.add('active');
        root.classList.add('mobile-sidebar-open');
    };
    const closeMobileSidebar = function () {
        sidebar?.classList.remove('open');
        sidebarOverlay?.classList.remove('active');
        root.classList.remove('mobile-sidebar-open');
    };
    const collapsedKey = 'smartInventorySidebarCollapsed';
    if (localStorage.getItem(collapsedKey) === 'true') {
        root.classList.add('sidebar-collapsed');
    }

    sidebarToggle?.addEventListener('click', function () {
        if (isMobileSidebar()) {
            if (sidebar?.classList.contains('open')) {
                closeMobileSidebar();
            } else {
                openMobileSidebar();
            }
            return;
        }

        root.classList.toggle('sidebar-collapsed');
        localStorage.setItem(collapsedKey, root.classList.contains('sidebar-collapsed') ? 'true' : 'false');
    });

    sidebarOverlay?.addEventListener('click', closeMobileSidebar);

    window.addEventListener('keydown', function (event) {
        if (event.key === 'Escape') {
            closeMobileSidebar();
        }
    });

    window.addEventListener('resize', function () {
        if (!isMobileSidebar()) {
            closeMobileSidebar();
        }
    });

    document.querySelectorAll('.sidebar-link').forEach(function (link) {
        link.addEventListener('click', function () {
            if (isMobileSidebar()) {
                closeMobileSidebar();
            }
        });
    });

    sidebar?.addEventListener('contextmenu', function (event) {
        if (event.target.closest('a')) {
            event.preventDefault();
        }
    }, true);

    requestAnimationFrame(function () {
        const activeSidebarLink = sidebar?.querySelector('.sidebar-link.active');
        activeSidebarLink?.scrollIntoView({
            block: 'center',
            inline: 'nearest',
            behavior: 'auto'
        });
    });

    const notificationToggle = document.querySelector('[data-notification-toggle]');
    const notificationPanel = document.querySelector('[data-notification-panel]');
    notificationToggle?.addEventListener('click', function () {
        notificationPanel?.classList.toggle('show');
    });

    document.querySelectorAll('[data-table-search]').forEach(function (searchInput) {
        searchInput.addEventListener('input', function () {
            const term = this.value.toLowerCase();
            document.querySelectorAll('tbody tr').forEach(function (row) {
                const searchable = (row.dataset.search || row.textContent).toLowerCase();
                row.style.display = searchable.includes(term) ? '' : 'none';
            });
        });
    });

    document.querySelectorAll('input[type="file"][accept*="image"]').forEach(function (input) {
        input.addEventListener('change', function () {
            const file = input.files && input.files[0];
            if (!file) return;
            let preview = input.closest('form')?.querySelector('.live-image-preview');
            if (!preview) {
                preview = document.createElement('img');
                preview.className = 'live-image-preview';
                input.insertAdjacentElement('afterend', preview);
            }
            preview.src = URL.createObjectURL(file);
        });
    });

    const typingTarget = document.querySelector('[data-typing]');
    if (typingTarget) {
        const words = (typingTarget.dataset.words || 'Inventory Tracking,Requisition Management,Vendor Management,Stock Monitoring,Smart Reporting').split(',');
        let wordIndex = 0;
        let charIndex = 0;
        let deleting = false;
        setInterval(function () {
            const word = words[wordIndex];
            typingTarget.textContent = deleting ? word.slice(0, charIndex--) : word.slice(0, charIndex++);
            if (!deleting && charIndex > word.length + 4) deleting = true;
            if (deleting && charIndex < 0) {
                deleting = false;
                wordIndex = (wordIndex + 1) % words.length;
            }
        }, 90);
    }

    const aosItems = document.querySelectorAll('[data-aos]');
    if ('IntersectionObserver' in window) {
        const aosObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    entry.target.classList.add('aos-animate');
                    aosObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.16 });
        aosItems.forEach(function (item) { aosObserver.observe(item); });
    } else {
        aosItems.forEach(function (item) { item.classList.add('aos-animate'); });
    }

    const animateCounter = function (counter) {
        const target = Number(counter.dataset.counter || 0);
        const duration = 1300;
        const start = performance.now();
        const step = function (now) {
            const progress = Math.min((now - start) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3);
            counter.textContent = Math.floor(target * eased).toLocaleString();
            if (progress < 1) requestAnimationFrame(step);
        };
        requestAnimationFrame(step);
    };

    const counters = document.querySelectorAll('[data-counter]');
    if ('IntersectionObserver' in window) {
        const counterObserver = new IntersectionObserver(function (entries) {
            entries.forEach(function (entry) {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    counterObserver.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });
        counters.forEach(function (counter) { counterObserver.observe(counter); });
    } else {
        counters.forEach(animateCounter);
    }

    document.querySelectorAll('[data-password-toggle]').forEach(function (button) {
        button.addEventListener('click', function () {
            const input = document.getElementById(button.datasetPasswordToggle || button.dataset.passwordToggle);
            if (!input) return;
            const show = input.type === 'password';
            input.type = show ? 'text' : 'password';
            button.innerHTML = show ? '<i class="bi bi-eye-slash"></i>' : '<i class="bi bi-eye"></i>';
        });
    });

    document.querySelectorAll('[data-loading-form]').forEach(function (form) {
        form.addEventListener('submit', function () {
            const button = form.querySelector('button[type="submit"]');
            button?.classList.add('is-loading');
            const toast = document.createElement('div');
            toast.className = 'toast-notice';
            toast.textContent = 'Signing in securely...';
            document.body.appendChild(toast);
            setTimeout(function () { toast.remove(); }, 2200);
        });
    });

    const renumberRequestRows = function (tbody) {
        tbody.querySelectorAll('tr').forEach(function (row, index) {
            const number = row.querySelector('.row-number');
            if (number) number.textContent = String(index + 1);
        });
    };

    const resetRequestRow = function (row) {
        row.querySelectorAll('select').forEach(function (select) {
            select.selectedIndex = 0;
        });
        row.querySelectorAll('input[type="number"]').forEach(function (input) {
            input.value = input.min || '1';
        });
    };

    document.addEventListener('click', function (event) {
        const addButton = event.target.closest('#add-item-btn, .add-item-btn, [data-add-request-row]');
        if (addButton) {
            event.preventDefault();
            const section = addButton.closest('.requisition-section-card');
            const tbody = section?.querySelector('[data-request-items-body]');
            const firstRow = tbody?.querySelector('tr');
            if (!tbody || !firstRow) return;

            const clone = firstRow.cloneNode(true);
            clone.querySelectorAll('[id]').forEach(function (node) {
                node.removeAttribute('id');
            });
            resetRequestRow(clone);
            tbody.appendChild(clone);
            renumberRequestRows(tbody);
            return;
        }

        const removeButton = event.target.closest('.remove-item-btn, .delete-item-btn, .remove-row-btn');
        if (!removeButton) return;
        event.preventDefault();
        const row = removeButton.closest('tr, .requested-item-row');
        const tbody = row?.closest('[data-request-items-body]');
        if (!row || !tbody) return;

        const rows = tbody.querySelectorAll('tr');
        if (rows.length > 1) {
            row.remove();
        } else {
            resetRequestRow(row);
        }
        renumberRequestRows(tbody);
    });

    document.querySelectorAll('.table-scroll-wrapper').forEach(function (slider) {
        if (slider.dataset.dragScrollReady === 'true') return;
        slider.dataset.dragScrollReady = 'true';

        let isDown = false;
        let startX = 0;
        let scrollLeft = 0;

        slider.addEventListener('mousedown', function (event) {
            if (event.target.closest('a, button, input, select, textarea, label')) return;
            isDown = true;
            slider.classList.add('is-dragging');
            startX = event.pageX - slider.offsetLeft;
            scrollLeft = slider.scrollLeft;
        });

        slider.addEventListener('mouseleave', function () {
            isDown = false;
            slider.classList.remove('is-dragging');
        });

        slider.addEventListener('mouseup', function () {
            isDown = false;
            slider.classList.remove('is-dragging');
        });

        slider.addEventListener('mousemove', function (event) {
            if (!isDown) return;
            event.preventDefault();
            const x = event.pageX - slider.offsetLeft;
            const walk = (x - startX) * 1.4;
            slider.scrollLeft = scrollLeft - walk;
        });
    });

    if (window.Chart) {
        document.querySelectorAll('[data-dashboard-chart]').forEach(function (canvas) {
            const type = canvas.dataset.chartType || 'line';
            const labels = (canvas.dataset.labels || 'Jan,Feb,Mar,Apr,May,Jun').split(',');
            const values = (canvas.dataset.values || '12,19,10,25,18,30').split(',').map(Number);
            const colors = chartThemeColors();
            const chart = new Chart(canvas, {
                type: type,
                data: {
                    labels: labels,
                    datasets: [{
                        label: canvas.dataset.label || 'Activity',
                        data: values,
                        borderColor: colors.border,
                        backgroundColor: type === 'doughnut' ? ['#F59E0B', '#22C55E', '#EF4444', '#3B82F6'] : colors.fill,
                        fill: true,
                        tension: 0.42
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { labels: { color: colors.text } } },
                    scales: type === 'doughnut' ? {} : {
                        x: { ticks: { color: colors.muted }, grid: { color: colors.grid } },
                        y: { ticks: { color: colors.muted }, grid: { color: colors.grid } }
                    }
                }
            });
            dashboardCharts.push(chart);
        });
        refreshChartTheme();
    }
})();

