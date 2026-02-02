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
                <h2>Libreria Componenti</h2>
                <p>
                    Tutti i componenti disponibili per costruire la tua linea di montaggio personalizzata.
                    Puoi cercare, filtrare e scaricare singolarmente ogni elemento.
                    <br><br>
                    Preferisci una soluzione pronta? Scopri i nostri <a href="<?= get_post_type_archive_link('kits') ?>" style="color: var(--accent);"><b>kit preconfigurati</b></a>.
                </p>
            </div>
        </header>

        <div class="searchBar">
            <input type="text" class="searchInput" id="searchInput" placeholder="Cerca componenti per nome o descrizione...">
            <button onclick="clearSearch()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
                Pulisci
            </button>
        </div>

        <div class="filterSection">
            <div class="filterRow">
                <div class="filterButtons">
                    <button class="filterBtn active" data-filter="all">Tutti (<span id="countAll">0</span>)</button>
                    <button class="filterBtn" data-filter="meccanica">Meccanica (<span id="countMeccanica">0</span>)</button>
                    <button class="filterBtn" data-filter="hardware">Hardware (<span id="countHardware">0</span>)</button>
                    <button class="filterBtn" data-filter="software">Software (<span id="countSoftware">0</span>)</button>
                </div>
                <select class="sortSelect" id="sortSelect">
                    <option value="name">Ordina per Nome</option>
                    <option value="type">Ordina per Tipologia</option>
                    <option value="recent">Più Recenti</option>
                </select>
            </div>
        </div>

        <div class="componentsGrid" id="componentsGrid">
            <!-- I componenti verranno generati da JavaScript -->
        </div>

        <div class="noResults" id="noResults" style="display: none;">
            <h3>Nessun componente trovato</h3>
            <p>Prova a modificare i filtri o la ricerca</p>
        </div>
    </div>

    <script>
        const components = [
            { id: 1, name: "Base modulare", type: "meccanica", description: "Unità base con sistema di incastro", version: "v2.1", downloads: 245, icon: "🔲" },
            { id: 2, name: "Nastro trasportatore", type: "meccanica", description: "Nastro modulare per materiali leggeri", version: "v1.8", downloads: 189, icon: "📦" },
            { id: 3, name: "Spintore pneumatico", type: "meccanica", description: "Sistema di spinta con attuatore", version: "v1.5", downloads: 156, icon: "⚡" },
            { id: 4, name: "Supporto sensori", type: "meccanica", description: "Supporto universale regolabile", version: "v1.3", downloads: 198, icon: "📏" },
            { id: 5, name: "Giunto di connessione", type: "meccanica", description: "Set di 10 giunti a coda di rondine", version: "v2.0", downloads: 312, icon: "🔗" },
            { id: 6, name: "Modulo elevatore", type: "meccanica", description: "Sistema verticale a cremagliera", version: "v1.2", downloads: 87, icon: "⬆️" },
            { id: 7, name: "Pinza pneumatica", type: "meccanica", description: "Gripper a 2 dita con sensore", version: "v1.6", downloads: 134, icon: "🤏" },
            { id: 8, name: "Tavola rotante", type: "meccanica", description: "Piatto rotante motorizzato 360°", version: "v1.4", downloads: 102, icon: "🔄" },
            
            { id: 9, name: "Driver motori DC", type: "hardware", description: "Controller per 4 motori, 24V 3A", version: "v3.1", downloads: 267, icon: "🎛️" },
            { id: 10, name: "Sensore induttivo", type: "hardware", description: "NPN, range 4mm, M12", version: "v2.0", downloads: 198, icon: "📡" },
            { id: 11, name: "Modulo I/O digitale", type: "hardware", description: "16 IN / 16 OUT, 24V DC", version: "v2.5", downloads: 221, icon: "🔌" },
            { id: 12, name: "Alimentatore switching", type: "hardware", description: "24V DC, 5A con protezioni", version: "v1.9", downloads: 289, icon: "🔋" },
            { id: 13, name: "Sensore fotoelettrico", type: "hardware", description: "Barriera ottica, range 2m", version: "v1.7", downloads: 145, icon: "👁️" },
            { id: 14, name: "Encoder rotativo", type: "hardware", description: "1024 PPR, uscita AB incrementale", version: "v1.5", downloads: 98, icon: "⚙️" },
            { id: 15, name: "Valvola pneumatica", type: "hardware", description: "5/2 vie, 24V DC, G1/8", version: "v2.2", downloads: 167, icon: "💨" },
            { id: 16, name: "Telecamera visione", type: "hardware", description: "2MP, USB, con lente 6mm", version: "v1.0", downloads: 76, icon: "📷" },
            
            { id: 17, name: "Libreria Siemens TIA", type: "software", description: "FB per S7-1200/1500", version: "v4.2", downloads: 334, icon: "💾" },
            { id: 18, name: "Software HMI", type: "software", description: "Interfaccia grafica WinCC", version: "v3.5", downloads: 198, icon: "🖥️" },
            { id: 19, name: "Esempi programmazione", type: "software", description: "10 progetti completi documentati", version: "v2.8", downloads: 445, icon: "📝" },
            { id: 20, name: "Libreria Arduino", type: "software", description: "Controllo motori e sensori", version: "v2.1", downloads: 289, icon: "🔧" },
            { id: 21, name: "Driver MODBUS RTU", type: "software", description: "Comunicazione seriale RS485", version: "v1.6", downloads: 156, icon: "📊" },
            { id: 22, name: "Software visione", type: "software", description: "Image processing con OpenCV", version: "v1.2", downloads: 89, icon: "🎯" }
        ];

        let currentFilter = 'all';
        let currentSort = 'name';
        let searchTerm = '';

        function updateCounts() {
            const counts = {
                all: components.length,
                meccanica: components.filter(c => c.type === 'meccanica').length,
                hardware: components.filter(c => c.type === 'hardware').length,
                software: components.filter(c => c.type === 'software').length
            };
            
            document.getElementById('countAll').textContent = counts.all;
            document.getElementById('countMeccanica').textContent = counts.meccanica;
            document.getElementById('countHardware').textContent = counts.hardware;
            document.getElementById('countSoftware').textContent = counts.software;
        }

        function sortComponents(comps) {
            const sorted = [...comps];
            switch(currentSort) {
                case 'name':
                    return sorted.sort((a, b) => a.name.localeCompare(b.name));
                case 'type':
                    return sorted.sort((a, b) => a.type.localeCompare(b.type));
                case 'recent':
                    return sorted.sort((a, b) => b.id - a.id);
                default:
                    return sorted;
            }
        }

        function filterComponents() {
            let filtered = components;
            
            if (currentFilter !== 'all') {
                filtered = filtered.filter(c => c.type === currentFilter);
            }
            
            if (searchTerm) {
                filtered = filtered.filter(c => 
                    c.name.toLowerCase().includes(searchTerm.toLowerCase()) ||
                    c.description.toLowerCase().includes(searchTerm.toLowerCase())
                );
            }
            
            return sortComponents(filtered);
        }

        function renderComponents() {
            const grid = document.getElementById('componentsGrid');
            const noResults = document.getElementById('noResults');
            const filtered = filterComponents();
            
            grid.innerHTML = '';
            
            if (filtered.length === 0) {
                noResults.style.display = 'block';
                return;
            }
            
            noResults.style.display = 'none';
            
            filtered.forEach(component => {
                const card = document.createElement('div');
                card.className = 'componentCard';
                card.innerHTML = `
                    <div class="componentHeader">
                        <h3>${component.name}</h3>
                        <span class="componentType ${component.type}">
                            ${component.type.charAt(0).toUpperCase() + component.type.slice(1)}
                        </span>
                    </div>
                    <div class="componentIcon">${component.icon}</div>
                    <p>${component.description}</p>
                    <div class="componentInfo">
                        <div class="infoRow">
                            <span class="infoLabel">Versione:</span>
                            <span>${component.version}</span>
                        </div>
                        <div class="infoRow">
                            <span class="infoLabel">Download:</span>
                            <span>${component.downloads}</span>
                        </div>
                    </div>
                    <div class="componentActions">
                        <button class="downloadBtn" onclick="downloadComponent(${component.id})">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 5px;">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                            </svg>
                            Scarica
                        </button>
                        <button class="viewBtn" onclick="viewComponent(${component.id})">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                                <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                                <circle cx="12" cy="12" r="3"></circle>
                            </svg>
                        </button>
                    </div>
                `;
                grid.appendChild(card);
            });
        }

        // Event listeners
        document.querySelectorAll('.filterBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filterBtn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.getAttribute('data-filter');
                renderComponents();
            });
        });

        document.getElementById('sortSelect').addEventListener('change', function() {
            currentSort = this.value;
            renderComponents();
        });

        document.getElementById('searchInput').addEventListener('input', function() {
            searchTerm = this.value;
            renderComponents();
        });

        function clearSearch() {
            document.getElementById('searchInput').value = '';
            searchTerm = '';
            renderComponents();
        }

        function downloadComponent(id) {
            const component = components.find(c => c.id === id);
            alert(`Download di "${component.name}" ${component.version} avviato!`);
        }

        function viewComponent(id) {
            const component = components.find(c => c.id === id);
            alert(`Visualizzazione dettagli: ${component.name}`);
        }

        updateCounts();
        renderComponents();
    </script>

<?php
    get_footer();
?>