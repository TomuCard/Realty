import * as THREE from 'three'
import { OrbitControls } from 'three/addons/controls/OrbitControls.js';

function create3dView (apartment_id)
{
    fetch(`http://localhost:4000/get/image/${apartment_id}`)
      .then(response => {
        // Vérifier si la requête a réussi (code de statut HTTP 200-299)
        if (response.ok) {
          return response.json()
        } else {
          // Renvoie une promesse rejetée avec un message d'erreur
          throw new Error('Erreur lors de la requête. Code de statut : ' + response.status);
        }
      })
      .then(data => {
                console.log(data)
                // Canvas
                const canvas = document.querySelector('canvas.webgl')
                const textureLoader = new THREE.TextureLoader();
                
                const image = data.apartment_360_picture;

                const texture = textureLoader.load(image);
                texture.mapping = THREE.UVMapping;
          
                const scene = new THREE.Scene();
                scene.background = texture;
          
                const geometry = new THREE.SphereGeometry(2, 32, 16);
                const material = new THREE.MeshBasicMaterial({ map: texture, side: THREE.DoubleSide });
                const sphere = new THREE.Mesh(geometry, material);
                scene.add(sphere);

                
                /**
                 * Sizes
                 */
                const sizes = {
                    width: window.innerWidth /1.75,
                    height: window.innerHeight /1.5
                }
        
                window.addEventListener('resize', () =>
                {
                  const width = window.innerWidth /1.75
                  const height = window.innerHeight /1.5

                  // update camera aspect
                    camera.aspect = width / height
                    camera.updateProjectionMatrix()
                    // update renderer
                    renderer.setSize(width, height)
                    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2))
                    renderer.render(scene, camera)
                })
        
                /**
                 * Camera
                 */
                // Base camera
                const camera = new THREE.PerspectiveCamera(75, sizes.width / sizes.height, 0.1, 100)
                camera.position.set(0,0,0.2)
                console.log(camera.position.z)
                scene.add(camera)
        
                // Controls
                const controls = new OrbitControls(camera, canvas)
                controls.enableDamping = true
                controls.enableZoom = false
        
                /**
                 * Renderer
                 */
                const renderer = new THREE.WebGLRenderer({
                    canvas: canvas
                })
                renderer.setSize(sizes.width, sizes.height)
                renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2))
        
                /**
                 * Animation
                 */
                const clock = new THREE.Clock()
                
        
                const tick = () =>
                {
                    const elapsedTime = clock.getElapsedTime()
        
                    controls.update()
        
                    // Render
                    renderer.render(scene, camera)
        
                    window.requestAnimationFrame(tick)
                }
        
                tick()
      })
      .catch(error => {
        console.error(error);
      });
}
const apartement_id = document.querySelector('#apartment_id').value;
console.log(apartement_id);
create3dView(apartement_id);