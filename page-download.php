<?php get_header(); ?>

<div class="bg-rows container">
	<div class="bg-row bg-row-1"></div>
	<div class="bg-row bg-row-3"></div>
	<div class="bg-row bg-row-5"></div>
</div>

<div class="container">
	<div class="page-header">
		<h1>Download</h1>
		<p>Scegli se scaricare un kit completo oppure singoli componenti dalla libreria.</p>
	</div>

	<div class="download-choices d-flex gap-4" style="justify-content:center; margin-top:30px; flex-wrap:wrap;">
		<div class="card cliccable-card" style="width: 30rem;" onclick="window.location.href='<?= esc_url( get_post_type_archive_link('kit') ) ?>'">
			<div class="card-body text-center">
				<div class="card-illustration" style="margin-bottom:18px;">
					<svg width="96" height="96" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<rect x="2" y="7" width="20" height="12" rx="2" stroke="currentColor" stroke-width="1.25" fill="rgba(255,255,255,0.02)"></rect>
						<path d="M7 7V5a2 2 0 012-2h6a2 2 0 012 2v2" stroke="currentColor" stroke-width="1.25" stroke-linecap="round" stroke-linejoin="round"></path>
						<path d="M9 12h6" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"></path>
					</svg>
				</div>
				<h3 class="card-title">Kit Disponibili</h3>
				<p class="card-text">Esplora i nostri kit preconfigurati: pacchetti completi con tutti i componenti necessari.</p>
				<a class="btn btn-primary" href="<?= esc_url( get_post_type_archive_link('kit') ) ?>">Vai ai Kit</a>
			</div>
		</div>

		<div class="card cliccable-card" style="width: 30rem;" onclick="window.location.href='<?= esc_url( get_post_type_archive_link('component') ) ?>'">
			<div class="card-body text-center">
				<div class="card-illustration" style="margin-bottom:18px;">
					<svg width="96" height="96" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
						<path d="M12 2v4" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"></path>
						<path d="M12 18v4" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"></path>
						<path d="M4.93 4.93l2.83 2.83" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"></path>
						<path d="M16.24 16.24l2.83 2.83" stroke="currentColor" stroke-width="1.25" stroke-linecap="round"></path>
						<circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.25" fill="rgba(255,255,255,0.02)"></circle>
					</svg>
				</div>
				<h3 class="card-title">Libreria Componenti</h3>
				<p class="card-text">Scarica singoli componenti dalla libreria per costruire la tua soluzione personalizzata.</p>
				<a class="btn btn-primary" href="<?= esc_url( get_post_type_archive_link('component') ) ?>">Vai ai Componenti</a>
			</div>
		</div>
	</div>

</div>

<?php get_footer(); ?>

