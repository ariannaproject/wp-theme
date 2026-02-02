<?php
    $components = "";
    $kit_id = get_the_ID();

    $kit_components = arianna_kits_components_get($kit_id);

    foreach($kit_components as $component) {
        $category = get_the_terms($component->ID, 'component_category')[0]->slug;
        $icon = '';

        $image = get_the_post_thumbnail_url($component->ID, 'medium');

        switch($category) {
            case 'meccanica':
                $icon = '📦';
                break;
            case 'hardware':
                $icon = '📟';
                break;
            case 'software':
                $icon = '🖥️';
                break;
            default:
                $icon = '❓';
        }

        $components .= '{id:' . $component->ID . ', name:"' . get_the_title($component->ID) . '", description: "' . get_the_excerpt($component->ID) . '", icon:"' . $icon . '", category:"' . $category . '", image:"' . $image . '"},';
    }

    get_header();
?>
    <div class="content">
        <div class="hero">
            <div class="heroImage">
                <?php if(has_post_thumbnail()) : ?>
                    <img src="<?php the_post_thumbnail_url('large'); ?>" alt="<?php the_title(); ?>">
                <?php else: ?>
                    <h1 style="color: white; font-size: 100px;">Arianna</h1>
                <?php endif; ?>
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
                </div>
            </div>
        </div>

        <div class="filterSection">
            <div style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 20px;">
                <h3>Componenti del Kit</h3>
                <div class="filterButtons">
                    <button class="filterBtn active" data-filter="all">Tutti (<span id="countAll"></span>)</button>
                    <button class="filterBtn" data-filter="meccanica">Meccanica (<span id="countMeccanica"></span>)</button>
                    <button class="filterBtn" data-filter="hardware">Hardware (<span id="countHardware"></span>)</button>
                    <button class="filterBtn" data-filter="software">Software (<span id="countSoftware"></span>)</button>
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
        const components = [<?= $components ?>];

        // Genera le card dei componenti
        function renderComponents(filter = 'all') {
            const grid = document.getElementById('componentsGrid');
            grid.innerHTML = '';

            // Aggiorna i contatori
            document.getElementById('countAll').innerText = components.length;
            document.getElementById('countMeccanica').innerText = components.filter(c => c.category === 'meccanica').length;
            document.getElementById('countHardware').innerText = components.filter(c => c.category === 'hardware').length;
            document.getElementById('countSoftware').innerText = components.filter(c => c.category === 'software').length;

            components.forEach(component => {
                if (filter === 'all' || component.category === filter) {
                    const card = document.createElement('div');
                    card.className = 'componentCard';
                    card.innerHTML = `
                        <div class="componentHeader">
                            <h3>${component.name}</h3>
                            <span class="componentType ${component.category}">${component.category.charAt(0).toUpperCase() + component.category.slice(1)}</span>
                        </div>
                        <div class="componentIcon"><img src="${component.image}" alt="${component.icon}"></div>
                        <p>${component.description}</p>
                        <div class="componentActions">
                            <button class="downloadBtn authenticated" onclick="downloadComponent(${component.id})" style="display: none;">
                                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="margin-right: 5px;">
                                    <path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4M7 10l5 5 5-5M12 15V3"/>
                                </svg>
                                Scarica
                            </button>
                            <button class="downloadBtn unauthenticated" onclick="window.location.href='<?= arianna_get_login_url_with_redirect() ?>'">
                                Accedi per scaricare
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
            if(!getUserData()) {
                window.location.href = "<?= arianna_get_login_url_with_redirect() ?>";
                return;
            }
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