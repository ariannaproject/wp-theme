import * as THREE from 'https://cdn.skypack.dev/three@0.130.0/build/three.module.js';
import { GLTFLoader } from 'https://cdn.skypack.dev/three@0.130.0/examples/jsm/loaders/GLTFLoader.js';
import { gsap } from 'https://cdn.skypack.dev/gsap';


// Scena, camera e renderer
const scene = new THREE.Scene();

const camera = new THREE.PerspectiveCamera(
    10, // FOV originale
    window.innerWidth / window.innerHeight,
    0.1,
    1300
);
camera.position.z = 1100;
camera.position.y = 40;

const renderer = new THREE.WebGLRenderer({ antialias: true, alpha: true });
renderer.setSize(window.innerWidth, window.innerHeight);
document.getElementById('container3D').appendChild(renderer.domElement);


// Luci
const ambientLight = new THREE.AmbientLight(0xffffff, 2);
scene.add(ambientLight);

const mainLight = new THREE.DirectionalLight(0xffffff, 1);
mainLight.position.set(5, 10, 7.5);
scene.add(mainLight);

const fillLight = new THREE.DirectionalLight(0xffffff, 0.5);
fillLight.position.set(-5, 0, -5);
scene.add(fillLight);

renderer.shadowMap.enabled = true;
renderer.shadowMap.type = THREE.PCFSoftShadowMap;
renderer.physicallyCorrectLights = true;
renderer.toneMapping = THREE.ACESFilmicToneMapping;
renderer.toneMappingExposure = 2;

// -------------------------
// Calcolo della larghezza visibile a z=0 e posizionamento del cubo
// -------------------------
const halfFovRad = THREE.MathUtils.degToRad(camera.fov / 2);
const distance = camera.position.z;
const heightAtZ0 = 2 * distance * Math.tan(halfFovRad);
const widthAtZ0 = heightAtZ0 * camera.aspect;

// Converte 100px in coordinate world space
const pixelToWorldRatio = widthAtZ0 / window.innerWidth;
const adjustedWidth = widthAtZ0 - (100 * pixelToWorldRatio);

// Suddivide la larghezza in 4 sezioni e calcola il centro della 4a sezione
const sectionWidth = adjustedWidth / 4;
const centerOfFourthSection = (-adjustedWidth / 2) + (sectionWidth * 3.5);

// -------------------------
// Caricamento del modello
// -------------------------
let cube, mixer;
const loader = new GLTFLoader();
loader.load(
    '/wp-content/themes/arianna/assets/3d/renderCubo.glb',
    function (gltf) {
    cube = gltf.scene;
    console.log('Modello caricato:', cube);

    // Imposta la scala del modello
    cube.scale.set(1, 1, 1);

    // Applica un materiale standard e aggiungi il bordo per ogni mesh
    cube.traverse((node) => {
        if (node.isMesh) {
        // Setta il materiale del mesh
        node.material = new THREE.MeshStandardMaterial({
            color: 0xffffff,
            roughness: 0.5,
            metalness: 0.4,
        });
        
        // Crea un bordo (outline) usando EdgesGeometry
        const edges = new THREE.EdgesGeometry(node.geometry);
        const lineMaterial = new THREE.LineBasicMaterial({ color: 0x303031, linewidth: 1 });
        const edgeLines = new THREE.LineSegments(edges, lineMaterial);
        
        // Aggiunge i bordi al nodo
        node.add(edgeLines);
        }
    });

    // Posizionamento del modello in base alla larghezza dello schermo
    if (window.innerWidth < 1200) {
        console.log('Posizionamento per schermo < 1200');
        cube.position.set(0, -10, 0);
        camera.position.z = 1200;
    } else {
        console.log('Posizionamento per schermo >= 1200');
        cube.position.set(centerOfFourthSection, -10, 0);
    }

    scene.add(cube);

    // Avvia eventuali animazioni del modello
    mixer = new THREE.AnimationMixer(cube);
    if (gltf.animations.length > 0) {
        mixer.clipAction(gltf.animations[0]).play();
    }
    },
    undefined,
    function (error) {
    console.error('Errore nel caricamento del modello:', error);
    }
);


let rotationSpeed = 0.005; // VelocitÃ  base di rotazione ridotta

// -------------------------
// Loop di rendering
// -------------------------
const reRender3D = () => {
    requestAnimationFrame(reRender3D);
    if (cube) {
    // La rotazione attorno all'asse Y viene data dalla velocitÃ  base
    cube.rotation.y += rotationSpeed;
    cube.rotation.x =  0.4;
    }
    renderer.render(scene, camera);
    if (mixer) mixer.update(0.02);
};
reRender3D();

window.addEventListener('scroll', () => {
    if (!cube) return;
    
    const scrollY = window.scrollY;
    
    // --- Aggiornamento della posizione X (come giÃ  impostato) ---
    if (window.innerWidth >= 1200) {
    let targetX;
    if (scrollY < window.innerHeight * 0.85) {
        targetX = centerOfFourthSection;
    } else if (scrollY > window.innerHeight * 1.0) {
        targetX = 0;
    } else {
        const t = (scrollY - window.innerHeight * 0.85) / (window.innerHeight * 0.20);
        targetX = THREE.MathUtils.lerp(centerOfFourthSection, 0, t);
    }
    gsap.to(cube.position, { x: targetX, duration: 0.2, ease: "power1.out" });
    }
    
    // --- Gestione della posizione Y ---
    const descrizione = document.getElementById("descrizione");
    // Calcola lo scrollY in cui il centro del div "descrizione" Ã¨ esattamente al centro della viewport
    const freezeScroll = descrizione.offsetTop + (descrizione.offsetHeight / 2) - (window.innerHeight / 2);
    
    
    // Valori di partenza e target per Y (modifica se necessario)
    const initialY = -10;  // posizione iniziale del cubo
    const freezeY = 10;     // posizione target in cui il cubo arriva quando il div Ã¨ centrato
    
    // Assicurati che pixelToWorldRatio sia stato calcolato in precedenza:
    // const pixelToWorldRatio = widthAtZ0 / window.innerWidth;
    
    if (scrollY < freezeScroll) {
    // Fino a freezeScroll, interpoliamo la Y con animazione GSAP
    const tY = scrollY / freezeScroll;
    const targetY = initialY + (freezeY - initialY) * tY;
    gsap.to(cube.position, { y: targetY, duration: 0.2, ease: "power1.out" });
    } else {
    // Dopo freezeScroll, il cubo deve seguire istantaneamente il movimento dei contenuti
    // Calcoliamo il centro del div "descrizione" in pixel rispetto alla viewport
    const descrizioneRect = descrizione.getBoundingClientRect();
    const descrizioneCenterPixel = descrizioneRect.top + (descrizioneRect.height / 2);
    // La differenza tra il centro della viewport e il centro del div (in pixel)
    const offsetPixels = (window.innerHeight / 2) - descrizioneCenterPixel;
    // Converto questa differenza in world units
    const offsetWorld = offsetPixels * pixelToWorldRatio;
    // Imposto direttamente la Y del cubo in modo che segua il movimento dei contenuti
    cube.position.y = freezeY + offsetWorld;
    }
});


window.addEventListener('resize', () => {
    camera.aspect = window.innerWidth / window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});


if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
    navigator.serviceWorker.register('/service-worker.js')
        .then(reg => console.log('Service Worker registrato:', reg))
        .catch(err => console.error('Errore registrazione:', err));
    });
}