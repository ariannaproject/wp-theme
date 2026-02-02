<?php
    get_header();
?>
<div class="content">
    <div class="hero">
        <div class="heroImage">
            <div class="heroIcon">🔲</div>
        </div>
        <div class="heroInfo">
            <div class="componentHeader">
                <div class="titleRow">
                    <h1><?= the_title() ?></h1>
                    <span class="componentType <?= get_the_terms($component->ID, 'component_category')[0]->slug; ?>"><?= get_the_terms($component->ID, 'component_category')[0]->name; ?></span>
                </div>
                <div>
                    <span class="versionTag">Versione v2.1</span>
                    <p style="margin-top: 15px;"><?= the_content() ?></p>
                </div>
            </div>

            <div class="statsGrid">
                <div class="statItem">
                    <span class="statLabel">Download</span>
                    <span class="statValue">245</span>
                </div>
                <div class="statItem">
                    <span class="statLabel">Dimensioni</span>
                    <span class="statValue">2.4 MB</span>
                </div>
                <div class="statItem">
                    <span class="statLabel">Formato</span>
                    <span class="statValue">STL, STEP</span>
                </div>
            </div>

            <div class="actionButtons">
                <button onclick="downloadComponent()">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                        <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                    </svg>
                    Scarica Componente
                </button>
                <button class="secondaryBtn">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 8px;">
                        <circle cx="18" cy="5" r="3"></circle>
                        <circle cx="6" cy="12" r="3"></circle>
                        <circle cx="18" cy="19" r="3"></circle>
                        <line x1="8.59" y1="13.51" x2="15.42" y2="17.49"></line>
                        <line x1="15.41" y1="6.51" x2="8.59" y2="10.49"></line>
                    </svg>
                    Condividi
                </button>
            </div>
        </div>
    </div>

    <a id="tabs"></a>
    <div class="tabsSection">
        <div class="tabButtons">
            <button class="tabBtn active" onclick="switchTab('documentation')">Documentazione</button>
            <button class="tabBtn" onclick="switchTab('files')">File</button>
            <button class="tabBtn" onclick="switchTab('comments')">Commenti</button>
        </div>

        <div id="documentation" class="tabContent active">
            <div class="documentationContent">
                <div class="docSection">
                    <h3>Descrizione</h3>
                    <p>La base modulare è il componente fondamentale del sistema Arianna. Progettata per essere stampata in 3D con filamento PLA, questa base fornisce una piattaforma stabile e versatile per costruire linee di montaggio automatizzate.</p>
                    <p>Il sistema di incastro a coda di rondine permette un assemblaggio rapido e preciso tra moduli, garantendo stabilità strutturale e facilità di riconfigurazione del sistema. Le scanalature integrate sui quattro lati consentono il collegamento in qualsiasi direzione.</p>
                </div>

                <div class="docSection">
                    <h3>Caratteristiche Tecniche</h3>
                    <table class="specTable">
                        <tr>
                            <td>Dimensioni</td>
                            <td>150mm x 150mm x 40mm</td>
                        </tr>
                        <tr>
                            <td>Peso</td>
                            <td>~85g (PLA)</td>
                        </tr>
                        <tr>
                            <td>Materiale consigliato</td>
                            <td>PLA, PETG</td>
                        </tr>
                        <tr>
                            <td>Tempo di stampa</td>
                            <td>~4 ore (0.2mm layer height)</td>
                        </tr>
                        <tr>
                            <td>Supporti necessari</td>
                            <td>No</td>
                        </tr>
                        <tr>
                            <td>Infill consigliato</td>
                            <td>20-30%</td>
                        </tr>
                        <tr>
                            <td>Fissaggi inclusi</td>
                            <td>4x M4 fori filettati</td>
                        </tr>
                        <tr>
                            <td>Compatibilità</td>
                            <td>Tutti i moduli Arianna</td>
                        </tr>
                    </table>
                </div>

                <div class="docSection">
                    <h3>Istruzioni di Stampa</h3>
                    <ul>
                        <li><b>Layer Height:</b> 0.2mm per un buon compromesso tra qualità e velocità</li>
                        <li><b>Infill:</b> 20-30% con pattern gyroid o grid per massima resistenza</li>
                        <li><b>Velocità:</b> 50-60mm/s per garantire precisione sugli incastri</li>
                        <li><b>Temperatura:</b> 200-210°C (PLA) o seguire le indicazioni del produttore</li>
                        <li><b>Bed Temperature:</b> 60°C per PLA</li>
                        <li><b>Rafting:</b> Non necessario</li>
                        <li><b>Supporti:</b> Non richiesti, il pezzo è ottimizzato per stampa diretta</li>
                    </ul>
                </div>

                <div class="docSection">
                    <h3>Assemblaggio</h3>
                    <p>Una volta stampato il componente:</p>
                    <ul>
                        <li>Rimuovere eventuali residui di stampa dalle scanalature a coda di rondine</li>
                        <li>Verificare la pulizia dei fori M4 per il fissaggio di componenti aggiuntivi</li>
                        <li>Testare l'incastro con altri moduli prima dell'assemblaggio finale</li>
                        <li>Utilizzare i giunti di connessione per fissare permanentemente i moduli tra loro</li>
                    </ul>
                </div>

                <div class="docSection">
                    <h3>Note e Suggerimenti</h3>
                    <p>Per ottenere i migliori risultati:</p>
                    <ul>
                        <li>Calibrare accuratamente la stampante prima della stampa</li>
                        <li>Orientare il pezzo con la base maggiore sul piatto di stampa</li>
                        <li>Se gli incastri risultano troppo stretti, aumentare leggermente la tolleranza nello slicer (XY compensation +0.05mm)</li>
                        <li>Per applicazioni con carichi pesanti, considerare l'uso di PETG invece di PLA</li>
                    </ul>
                </div>
            </div>
        </div>

        <div id="files" class="tabContent">
            <div class="documentationContent">
                <div class="docSection">
                    <h3>File Disponibili</h3>
                    <p>Scarica i file necessari per la stampa 3D e l'assemblaggio. Tutti i file sono forniti in formati standard per la massima compatibilità.</p>
                </div>
                
                <div class="filesGrid">
                    <div class="fileCard">
                        <div class="fileIcon">📄</div>
                        <div class="fileInfo">
                            <div class="fileName">base_modulare_v2.1.stl</div>
                            <div class="fileSize">1.8 MB</div>
                        </div>
                        <button onclick="downloadFile('stl')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 5px;">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                            </svg>
                            Scarica STL
                        </button>
                    </div>

                    <div class="fileCard">
                        <div class="fileIcon">📐</div>
                        <div class="fileInfo">
                            <div class="fileName">base_modulare_v2.1.step</div>
                            <div class="fileSize">520 KB</div>
                        </div>
                        <button onclick="downloadFile('step')">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 5px;">
                                <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                            </svg>
                            Scarica STEP
                        </button>
                    </div>
                </div>
            </div>
        </div>
        <div id="comments" class="tabContent">
            <div class="documentationContent">
                <div class="docSection">
                    <h3>Commenti degli Utenti</h3>
                    <p>Leggi cosa dicono gli altri utenti sulla base modulare e lascia il tuo feedback!</p>
                </div>
                <div class="commentsSection">
                    <div class="comment">
                        <div class="commentHeader">
                            <span class="commentAuthor">LucaR</span>
                            <span class="commentDate">20 Gen 2025</span>
                        </div>
                        <div class="commentBody">
                            <p>Ho stampato questa base modulare la scorsa settimana e funziona alla grande! Gli incastri sono precisi e il design è molto solido. Consigliatissimo!</p>
                        </div>
                    </div>
                </div>
                <div class="commentForm">
                    <h4>Lascia un Commento</h4>
                    <textarea class="commentInput" placeholder="Scrivi il tuo commento qui..."></textarea>
                    <button>Invia Commento</button>
                </div>
            </div>
        </div>
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
    function switchTab(tabId) {
        const tabs = document.querySelectorAll('.tabContent');
        const buttons = document.querySelectorAll('.tabBtn');

        tabs.forEach(tab => {
            tab.classList.remove('active');
            if (tab.id === tabId) {
                tab.classList.add('active');
            }
        });

        buttons.forEach(btn => {
            btn.classList.remove('active');
            if (btn.getAttribute('onclick').includes(tabId)) {
                btn.classList.add('active');
            }
        });
    }

    function downloadComponent() {
        switchTab('files');
        location.hash = '#tabs';
    }

    function downloadFile(type) {
        alert("Download del file " + type + " avviato!");
    }
</script>
<?php
    get_footer();
?>