<main id="home-page">
    <section class="hero-section home-section">
        <div class="container">
            <div class="hero-section-info">
                <h1 class="delay-small">Marinhos Barbearia</h1>
                <p class="phrase delay-medium">Elevando seu estilo e sua autoconfiança a novos patamares!</p>

                <?php if (!$isAdm) : ?>
                    <div class="interval-small">
                        <a class="btn-primary" href="<?= BASE_URL . "schedule" ?>" role="button">Agendar horário</a>
                    </div>
                <?php endif; ?>
            </div>

            <div class="hero-section-images">               
            <img class="interval-medium" src="<?= BASE_URL . "public/images/marinhosalao.jpg" ?>" 
            alt="Um homem cortando seu cabelo" width="500" style="border: 3px solid yellow;">
            </div>
        </div>
    </section>

    <section class="about-section">
        <div class="container">
            <img class="delay-small" src="<?= BASE_URL . "public/images/Marinhologo.jpeg" ?>" alt="Dois homens cortando seus cabelos" width="500" loading="lazy">

            <div class="about-text">
                <h2 class="delay-small text-detail">Sobre nós</h2>
                <p class="interval-medium">
                Marinho’s Barbearia – Estilo e Tradição para o Seu Visual ✂️🔥
                Se você busca um corte de cabelo impecável, um bom papo e um ambiente acolhedor, a Marinho’s Barbearia é o lugar certo para você! Aqui, tradição e modernidade se encontram para proporcionar um atendimento de qualidade, sempre focado no seu estilo e bem-estar.
                </p>
                <p class="interval-medium">
                    Em um ambiente acolhedor e descontraído, oferecemos serviços de alta qualidade para homens que buscam confiança e estilo.
                    Seja qual for seu estilo, estamos aqui para ajudar você a encontrar seu melhor visual, um corte de cada vez.
                   <BR> 📅 Funcionamento: Segunda a sábado.
                   <BR>📍 Localização: EQNM 20/22
                </p>

                <nav class="social interval-medium">
                    <a href="https://www.instagram.com/marinhosbarbearia.df/" target="_blank" rel="noreferrer noopener"><i class="bi bi-instagram"></i></a>
                    <a href="https://www.tiktok.com/@marinhosbarbearia" target="_blank" rel="noreferrer noopener"><i class="bi bi-tiktok"></i></a>
                </nav>
            </div>
        </div>
    </section>

    <section class="rates-section">
        <div class="container">
            <h2 class="delay-small text-detail--secondary">Nossos serviços</h2>
            <p class="delay-medium">Abaixo, uma lista de nossos serviços prestados. Todos focados na melhor qualidade, com os melhores equipamentos.</p>

            <div class="rates-container">
                <?php foreach ($services as $service) : ?>
                    <div class="service interval-medium">
                        <h3><?= $service["name"] ?></h3>
                        <span class="divider"></span>
                        <p>R$<?= str_replace('.', ',', $service["price"]) ?></p>
                    </div>
                <?php endforeach ?>
            </div>
        </div>
    </section>

    <section class="gallery-section">
        <div class="container">
            <h2 class="delay-small text-detail">Galeria de imagens</h2>

            <div class="swiper interval-small">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <img src="<?= BASE_URL . "public/images/corte1.jpg" ?>" alt="Gallery image">
                    </div>
                    <div class="swiper-slide">
                        <img src="<?= BASE_URL . "public/images/corte2.jpg" ?>" alt="Gallery image">
                    </div>
                    <div class="swiper-slide">
                        <img src="<?= BASE_URL . "public/images/corte3.jpg" ?>" alt="Gallery image">
                    </div>
                    <div class="swiper-slide">
                        <img src="<?= BASE_URL . "public/images/corte4.jpg" ?>" alt="Gallery image">
                    </div>
                
           
                    
                </div>

                <div class="swiper-pagination"></div>
            </div>


        </div>
    </section>

    <section class="localization-section">
        <div class="container">
            <h2 class="delay-small text-detail--secondary">Nossa localização</h2>

            <iframe
                width="100%"
                height="600"
                frameborder="0"
                scrolling="no"
                marginheight="0"
                marginwidth="0"
                style="border:0"
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3838.91990077118!2d-48.1066697!3d-15.808176999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x935bcd5b92246f79%3A0xe878ba1e0aa66aaa!2sMARINHOS%20BARBEARIA!5e0!3m2!1spt-BR!2sbr!4v1740402892782!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
                <a href="https://www.gps.ie/">gps tracker sport</a>
            </iframe>
        </div>
    </section>
</main>

<button class="btn-float" title="Acessar Whatsapp">
    <img class="delay-small" src="<?= BASE_URL . "public/images/whatsapp-symbol.svg" ?>" alt="Whatsapp logo" width="56">
</button>
