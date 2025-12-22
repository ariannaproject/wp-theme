<?php
    get_header();
?>

    <div class="righette">
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
        <div class="righettaInterna"></div>
    </div>

    <div class="content">
        <header>
            <span></span>
            <div class="subtitleContainer">
                <h2>Kit Disponibili</h2>
                <p>
                    Scegli il kit che meglio si adatta alle tue esigenze.
                    Ogni kit include tutti i componenti necessari per costruire una specifica linea di montaggio automatizzata.
                    <br><br>
                    Puoi anche consultare la <a href="<?= get_post_type_archive_link('component') ?>" style="color: var(--accent);"><b>libreria componenti</b></a> per creare configurazioni personalizzate.
                </p>
            </div>
        </header>

        <div class="statsBar">
            <div class="statItem">
                <span class="statNumber"><?= wp_count_posts('kit')->publish; ?></span>
                <small>Kit Disponibili</small>
            </div>
            <div class="statItem">
                <span class="statNumber"><?= wp_count_posts('component')->publish; ?></span>
                <small>Componenti Totali</small>
            </div>
            <div class="statItem">
                <span class="statNumber">125+</span>
                <small>Download</small>
            </div>
        </div>

        <div class="kitsGrid" id="kitsGrid">
            <!-- Kits will be rendered here by JavaScript -->
        </div>
    </div>

    <script>
        const kits = [
            {
                id: 1,
                name: "Linea di Montaggio Compatta",
                description: "Kit base ideale per iniziare con l'automazione. Include nastro trasportatore, sensori e scheda di controllo.",
                difficulty: "base",
                components: 12,
                meccanica: 5,
                hardware: 4,
                software: 3
            },
            {
                id: 2,
                name: "Sistema di Smistamento",
                description: "Linea completa con sistema di smistamento a 3 vie. Include spintori pneumatici e sensori di colore.",
                difficulty: "intermedio",
                components: 18,
                meccanica: 7,
                hardware: 7,
                software: 4
            },
            {
                id: 3,
                name: "Cella Robotizzata",
                description: "Sistema avanzato con braccio robotico pick-and-place. Richiede PLC S7-1500 e conoscenze di robotica.",
                difficulty: "avanzato",
                components: 24,
                meccanica: 9,
                hardware: 10,
                software: 5
            },
            {
                id: 4,
                name: "Magazzino Automatico",
                description: "Sistema di stoccaggio con trasloelevatore. Include gestione RFID e software di warehouse management.",
                difficulty: "avanzato",
                components: 21,
                meccanica: 8,
                hardware: 8,
                software: 5
            },
            {
                id: 5,
                name: "Controllo Qualità",
                description: "Stazione di ispezione con sistema di visione. Include telecamera industriale e software di image processing.",
                difficulty: "intermedio",
                components: 15,
                meccanica: 4,
                hardware: 7,
                software: 4
            },
            {
                id: 6,
                name: "Linea Didattica Base",
                description: "Kit educativo completo per scuole. Modulare e facile da assemblare, con materiale didattico incluso.",
                difficulty: "base",
                components: 10,
                meccanica: 4,
                hardware: 3,
                software: 3
            }
        ];

        function renderKits() {
            const grid = document.getElementById('kitsGrid');
            grid.innerHTML = '';

            kits.forEach(kit => {
                const card = document.createElement('div');
                card.className = 'kitCard';
                card.onclick = () => window.location.href = `linea-di-montaggio-compatta`;
                
                card.innerHTML = `
                    <div class="kitImage">
                        <span class="kitNumber">KIT ${String(kit.id).padStart(2, '0')}</span>
                    </div>
                    <div class="kitContent">
                        <div class="kitHeader">
                            <h3>${kit.name}</h3>
                            <span class="kitDifficulty ${kit.difficulty}">
                                ${kit.difficulty.charAt(0).toUpperCase() + kit.difficulty.slice(1)}
                            </span>
                        </div>
                        <p>${kit.description}</p>
                        <div class="kitStats">
                            <div class="kitStat">
                                <span>📦</span>
                                <span>${kit.components} componenti</span>
                            </div>
                        </div>
                        <div class="kitStats" style="border-top: none; padding-top: 0;">
                            <div class="kitStat">
                                <span style="color: #4A90E2;">●</span>
                                <span>${kit.meccanica} Mec.</span>
                            </div>
                            <div class="kitStat">
                                <span style="color: #E24A4A;">●</span>
                                <span>${kit.hardware} Hard.</span>
                            </div>
                            <div class="kitStat">
                                <span style="color: #4AE290;">●</span>
                                <span>${kit.software} Soft.</span>
                            </div>
                        </div>
                        <div class="kitActions">
                            <button class="viewBtn" onclick="event.stopPropagation(); window.location.href='linea-di-montaggio-compatta'">
                                Visualizza Kit
                            </button>
                            <button class="downloadBtn" onclick="event.stopPropagation(); downloadKit(${kit.id})">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                                </svg>
                            </button>
                        </div>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        function downloadKit(id) {
            const kit = kits.find(k => k.id === id);
            alert(`Download di "${kit.name}" avviato!`);
        }

        // Cursore personalizzato
        const cursor = document.querySelector('[data-cursor-dot]');
        if (cursor) {
            window.addEventListener('mousemove', e => {
                cursor.style.left = e.clientX + 'px';
                cursor.style.top = e.clientY + 'px';
            });
        }

        renderKits();
    </script>

<?php
    get_footer();
?>