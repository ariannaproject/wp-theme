<?php
    get_header();
?>
    <div class="content">
        <div class="hero">
            <div class="heroImage">
                <h1 style="color: white; font-size: 100px;">Arianna</h1>
            </div>
            <div class="heroText">
                <div class="heroTitle">
                    <h2><?php the_title(); ?></h2>
                    <p><?php the_content(); ?></p>
                </div>
                <div class="downloadSection">
                    <button onclick="downloadAll()">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                            <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                        </svg>
                        Scarica Kit Completo
                    </button>
                    <button style="background-color: transparent; border: 1px solid var(--bordi); color: var(--testo);">
                        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                            <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/>
                            <polyline points="14 2 14 8 20 8"/>
                        </svg>
                        Guida Assemblaggio
                    </button>
                </div>
            </div>
        </div>

        <div class="filterSection">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <h3>Componenti del Kit</h3>
                <div class="filterButtons">
                    <button class="filterBtn active" data-filter="all">Tutti (12)</button>
                    <button class="filterBtn" data-filter="meccanica">Meccanica (5)</button>
                    <button class="filterBtn" data-filter="hardware">Hardware (4)</button>
                    <button class="filterBtn" data-filter="software">Software (3)</button>
                </div>
            </div>
        </div>

        <div class="componentsGrid" id="componentsGrid">
            <!-- I componenti verranno generati da JavaScript -->
        </div>
    </div>

    <div class="righette">
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
    </div>

    <script>
        // Dati dei componenti
        const components = [
            {
                id: 1,
                name: "Base modulare",
                type: "meccanica",
                description: "Unità base con sistema di incastro e scanalature a coda di rondine",
                icon: "🔲"
            },
            {
                id: 2,
                name: "Modulo nastro trasportatore",
                type: "meccanica",
                description: "Nastro trasportatore modulare compatibile con motori DC",
                icon: "📦"
            },
            {
                id: 3,
                name: "Modulo spintore pneumatico",
                type: "meccanica",
                description: "Sistema di spinta con attuatore pneumatico integrato",
                icon: "⚡"
            },
            {
                id: 4,
                name: "Supporto sensori",
                type: "meccanica",
                description: "Supporto universale per sensori di prossimità e fotoelettrici",
                icon: "📏"
            },
            {
                id: 5,
                name: "Giunto di connessione",
                type: "meccanica",
                description: "Set di 10 giunti per collegamento tra moduli",
                icon: "🔗"
            },
            {
                id: 6,
                name: "Scheda controllo motori",
                type: "hardware",
                description: "Driver per 4 motori DC con interfaccia PLC",
                icon: "🎛️"
            },
            {
                id: 7,
                name: "Sensore di prossimità",
                type: "hardware",
                description: "Set di 3 sensori induttivi NPN, range 4mm",
                icon: "📡"
            },
            {
                id: 8,
                name: "Modulo I/O digitale",
                type: "hardware",
                description: "16 ingressi / 16 uscite digitali, 24V DC",
                icon: "🔌"
            },
            {
                id: 9,
                name: "Alimentatore switching",
                type: "hardware",
                description: "24V DC, 5A, con protezione da sovraccarico",
                icon: "🔋"
            },
            {
                id: 10,
                name: "Libreria PLC Siemens",
                type: "software",
                description: "Blocchi funzione per TIA Portal (S7-1200/1500)",
                icon: "💾"
            },
            {
                id: 11,
                name: "Software HMI",
                type: "software",
                description: "Interfaccia grafica per controllo e monitoraggio",
                icon: "🖥️"
            },
            {
                id: 12,
                name: "Esempi di programmazione",
                type: "software",
                description: "10 progetti esempio con documentazione completa",
                icon: "📝"
            }
        ];

        // Genera le card dei componenti
        function renderComponents(filter = 'all') {
            const grid = document.getElementById('componentsGrid');
            grid.innerHTML = '';

            components.forEach(component => {
                if (filter === 'all' || component.type === filter) {
                    const card = document.createElement('div');
                    card.className = 'componentCard';
                    card.innerHTML = `
                        <div class="componentHeader">
                            <h3>${component.name}</h3>
                            <span class="componentType ${component.type}">${component.type.charAt(0).toUpperCase() + component.type.slice(1)}</span>
                        </div>
                        <div class="componentIcon">${component.icon}</div>
                        <p>${component.description}</p>
                        <div class="componentActions">
                            <button class="downloadBtn" onclick="downloadComponent(${component.id})">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 5px;">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                                </svg>
                                Scarica
                            </button>
                        </div>
                    `;
                    grid.appendChild(card);
                }
            });
        }

        // Gestione filtri
        document.querySelectorAll('.filterBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filterBtn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                const filter = this.getAttribute('data-filter');
                renderComponents(filter);
            });
        });

        // Funzioni di download (placeholder)
        function downloadComponent(id) {
            const component = components.find(c => c.id === id);
            alert(`Download di "${component.name}" avviato!`);
        }

        function downloadAll() {
            alert('Download del kit completo avviato! (12 componenti)');
        }

        // Inizializza
        renderComponents();
    </script>

<?php
    get_footer();
?>