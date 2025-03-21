<?php
if (!defined('ABSPATH')) {
    exit;
}

$options = get_option('construction_mode_settings');
$title = isset($options['title']) ? $options['title'] : 'Under Construction';
$description = isset($options['description']) ? $options['description'] : 'We are currently working on improving our website. Please check back soon!';
$logo = isset($options['logo']) ? $options['logo'] : '';
$bg_color = isset($options['background_color']) ? $options['background_color'] : '#000000';
$text_color = isset($options['text_color']) ? $options['text_color'] : '#ffffff';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo esc_html($title); ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r128/three.min.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen-Sans, Ubuntu, Cantarell, 'Helvetica Neue', sans-serif;
            background-color: <?php echo esc_attr($bg_color); ?>;
            color: <?php echo esc_attr($text_color); ?>;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            position: relative;
            overflow: hidden;
        }
        #particle-canvas {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: 1;
        }
        .content {
            position: relative;
            z-index: 2;
            text-align: center;
            padding: 20px;
            max-width: 800px;
            margin: 0 auto;
        }
        .logo {
            max-width: 200px;
            height: auto;
            margin-bottom: 30px;
        }
        h1 {
            font-size: 3em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }
        p {
            font-size: 1.2em;
            line-height: 1.6;
            margin-bottom: 30px;
            text-shadow: 1px 1px 2px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <canvas id="particle-canvas"></canvas>
    <div class="content">
        <?php if (!empty($logo)) : ?>
            <img src="<?php echo esc_url($logo); ?>" alt="Logo" class="logo">
        <?php endif; ?>
        <h1><?php echo esc_html($title); ?></h1>
        <p><?php echo esc_html($description); ?></p>
    </div>

    <script>
        // Three.js Particle Animation
        const scene = new THREE.Scene();
        const camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        const renderer = new THREE.WebGLRenderer({
            canvas: document.getElementById('particle-canvas'),
            alpha: true
        });

        renderer.setSize(window.innerWidth, window.innerHeight);
        camera.position.z = 5;

        // Create particles
        const particlesGeometry = new THREE.BufferGeometry();
        const particlesCount = 1500;
        const posArray = new Float32Array(particlesCount * 3);

        for(let i = 0; i < particlesCount * 3; i++) {
            posArray[i] = (Math.random() - 0.5) * 10;
        }

        particlesGeometry.setAttribute('position', new THREE.BufferAttribute(posArray, 3));

        const particlesMaterial = new THREE.PointsMaterial({
            size: 0.005,
            color: '<?php echo esc_js($text_color); ?>'
        });

        const particlesMesh = new THREE.Points(particlesGeometry, particlesMaterial);
        scene.add(particlesMesh);

        // Animation
        function animate() {
            requestAnimationFrame(animate);
            particlesMesh.rotation.x += 0.0005;
            particlesMesh.rotation.y += 0.0005;
            renderer.render(scene, camera);
        }

        // Handle window resize
        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        animate();
    </script>
</body>
</html>
