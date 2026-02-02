<?php
    $posts = "";

    foreach(get_posts() as $post) {
        $category = get_the_terms($post->ID, 'category')[0]->slug;
        $image = get_the_post_thumbnail_url($post->ID, 'large');
        if(!$image) {
            $image = 'linear-gradient(135deg, #4AE290 0%, #4AE2C0 100%)';
        } else {
            $image = 'url(' . $image . ') center/cover no-repeat';
        }

        $tags = get_the_terms($post->ID, 'post_tag');
        $tagSlugs = [];
        if($tags && !is_wp_error($tags)) {
            foreach($tags as $tag) {
                $tagSlugs[] = $tag->slug;
            }
        }

        $posts .= 
        '{id:' . $post->ID . ',' . 'date:"' . get_the_date('', $post->ID) . '", category:"' . $category . '", title:"' . get_the_title($post->ID) . '", excerpt:"' . get_the_excerpt($post->ID) . '", tags: [' . implode(',', array_map(function($tag) { return '"' . $tag . '"'; }, $tagSlugs)) . '], image:"' . $image . '", link:"' . get_permalink($post->ID) . '"},';
    }

    foreach(get_terms(array('taxonomy' => 'category', 'hide_empty' => true)) as $term) {
        $categories .= '{slug: "' . $term->slug . '", name: "' . $term->name . '"},';
    }

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
            <h2>Aggiornamenti</h2>
            <p>Resta aggiornato sulle ultime novità del progetto Arianna. Nuove release, aggiornamenti software, eventi della community e molto altro.</p>
        </div>
    </header>

    <div class="filterBar">
        <div class="filterButtons" id="filterButtons">
        </div>
        <span class="resultsCount" id="resultsCount">Mostrando</span>
    </div>

    <div class="newsGrid" id="newsGrid">
        <!-- Le news verranno generate da JavaScript -->
    </div>
</div>

<script>
    const news = [
        <?= $posts ?>
    ];

    let currentFilter = 'all';

    const categories = [
        <?= $categories ?>
    ];

    function filterNews() {
        const filtered = currentFilter === 'all' 
            ? news 
            : news.filter(n => n.category === currentFilter);
        
        renderNews(filtered);
        updateResultsCount(filtered.length);
    }

    function updateResultsCount(count) {
        const resultsCount = document.getElementById('resultsCount');
        resultsCount.textContent = `Mostrando ${count} ${count === 1 ? 'notizia' : 'notizie'}`;
    }

    function renderCategories() {
        const filter = document.getElementById('filterButtons');
        filter.innerHTML = '<button class="filterBtn active" data-filter="all">Tutti</button>';

        categories.forEach(cat => {
            const btn = document.createElement('button');
            btn.className = 'filterBtn';
            btn.setAttribute('data-filter', cat.slug);
            btn.innerText = cat.name;
            filter.appendChild(btn);
        });

        document.querySelectorAll('.filterBtn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.filterBtn').forEach(b => b.classList.remove('active'));
                this.classList.add('active');
                currentFilter = this.getAttribute('data-filter');
                filterNews();
            });
        });
    }

    function renderNews(newsToRender) {
        const grid = document.getElementById('newsGrid');
        grid.innerHTML = '';

        newsToRender.forEach(item => {
            const card = document.createElement('div');
            card.className = 'newsCard';
            card.setAttribute('data-category', item.category);
            
            card.innerHTML = `
                <div class="newsImageContainer">
                    <div class="newsImage" style="background: ${item.image}"></div>
                    <div class="newsBadge ${item.category}">${categories.find(cat => cat.slug === item.category).name}</div>
                </div>
                <div class="newsContent">
                    <div class="newsDate">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <rect x="3" y="4" width="18" height="18" rx="2" ry="2"></rect>
                            <line x1="16" y1="2" x2="16" y2="6"></line>
                            <line x1="8" y1="2" x2="8" y2="6"></line>
                            <line x1="3" y1="10" x2="21" y2="10"></line>
                        </svg>
                        ${item.date}
                    </div>
                    <h3 class="newsTitle">${item.title}</h3>
                    <p class="newsExcerpt">${item.excerpt}</p>
                </div>
                <div class="newsFooter">
                    <div class="newsTags">
                        ${item.tags.slice(0, 2).map(tag => `<span class="tag">${tag}</span>`).join('')}
                    </div>
                    <a href="${item.link}" class="readMore">
                        Leggi
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14M12 5l7 7-7 7"/>
                        </svg>
                    </a>
                </div>
            `;
            
            grid.appendChild(card);
        });
    }

    // Inizializza
    renderCategories();
    renderNews(news);
    updateResultsCount(news.length);
</script>

<?php
get_footer();
?>